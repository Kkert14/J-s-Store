<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table      = 'appointments';
    protected $primaryKey = 'appointment_id';

    protected $allowedFields = [
        'patient_id',
        'user_id',
        'appointment_date',
        'status',
        'notes'
    ];

    public function getRecords($start, $length, $searchValue = '', $orderColumn = 'appointments.appointment_date', $orderDir = 'asc')
    {
        $builder = $this->db->table('appointments');

        $builder->select('
            appointments.*,
            patients.name as patient_name,
            patients.last_name as patient_last_name,
            users.name as user_name
        ');

        $builder->join('patients', 'patients.patient_id = appointments.patient_id', 'left');
        $builder->join('users',    'users.id = appointments.user_id', 'left');

        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('patients.name',              $searchValue)
                ->orLike('users.name',               $searchValue)
                ->orLike('appointments.status',      $searchValue)
                ->orLike('appointments.appointment_date', $searchValue)
                ->groupEnd();
        }

        $filteredBuilder = clone $builder;
        $filteredRecords = $filteredBuilder->countAllResults();

        $builder->orderBy($orderColumn, $orderDir);
        $builder->limit($length, $start);
        $data = $builder->get()->getResultArray();

        return [
            'data'     => $data,
            'filtered' => $filteredRecords
        ];
    }

    /**
     * Check for conflicts:
     * - Same doctor booked within 30 minutes of the requested time
     * - Same patient already has an appointment on the same day
     * Returns array of conflict messages, empty if none.
     */
    public function checkConflicts(string $datetime, int $userId, int $patientId, ?int $excludeId = null): array
    {
        $conflicts = [];
        $date      = date('Y-m-d', strtotime($datetime));
        $rangeStart = date('Y-m-d H:i:s', strtotime($datetime . ' -30 minutes'));
        $rangeEnd   = date('Y-m-d H:i:s', strtotime($datetime . ' +30 minutes'));

        // Same doctor within 30-minute window
        $doctorQ = $this->db->table('appointments')
            ->where('user_id', $userId)
            ->where('appointment_date >=', $rangeStart)
            ->where('appointment_date <=', $rangeEnd)
            ->whereNotIn('status', ['cancelled']);

        if ($excludeId) {
            $doctorQ->where('appointment_id !=', $excludeId);
        }

        if ($doctorQ->countAllResults() > 0) {
            $conflicts[] = 'Doctor/Nurse already has an appointment within 30 minutes of this time.';
        }

        // Same patient same day
        $patientQ = $this->db->table('appointments')
            ->where('patient_id', $patientId)
            ->where('DATE(appointment_date)', $date)
            ->whereNotIn('status', ['cancelled']);

        if ($excludeId) {
            $patientQ->where('appointment_id !=', $excludeId);
        }

        if ($patientQ->countAllResults() > 0) {
            $conflicts[] = 'Patient already has an appointment on this day.';
        }

        return $conflicts;
    }

    /**
     * Get all appointments for a given month for the calendar view.
     */
    public function getForMonth(string $year, string $month): array
    {
        return $this->db->table('appointments')
            ->select('appointments.*, patients.name as patient_name, patients.last_name as patient_last_name, users.name as user_name')
            ->join('patients', 'patients.patient_id = appointments.patient_id', 'left')
            ->join('users',    'users.id = appointments.user_id', 'left')
            ->where('YEAR(appointment_date)',  $year)
            ->where('MONTH(appointment_date)', $month)
            ->orderBy('appointment_date', 'ASC')
            ->get()
            ->getResultArray();
    }
}
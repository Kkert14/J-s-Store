<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicalRecordModel extends Model
{
    protected $table      = 'medical_records';
    protected $primaryKey = 'record_id';

    protected $allowedFields = [
        'patient_id',
        'user_id',
        'date_consulted',
        'chief_complaint',
        'diagnosis',
        'treatment',
        'remarks'
    ];


    // DATATABLE FETCH RECORDS

    public function getRecords($start, $length, $searchValue = '', $orderColumn = 'medical_records.date_consulted', $orderDir = 'desc')
    {
        $builder = $this->db->table('medical_records');

        $builder->select('medical_records.*, patients.name as patient_name, users.name as doctor_name');
        $builder->join('patients', 'patients.patient_id = medical_records.patient_id', 'left');
        $builder->join('users',    'users.id = medical_records.user_id',               'left');

        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('patients.name',                     $searchValue)
                ->orLike('users.name',                      $searchValue)
                ->orLike('medical_records.diagnosis',       $searchValue)
                ->orLike('medical_records.chief_complaint', $searchValue)
                ->groupEnd();
        }

        $filteredBuilder = clone $builder;
        $filteredRecords = $filteredBuilder->countAllResults();

        $builder->orderBy($orderColumn, $orderDir); // ← added
        $builder->limit($length, $start);
        $data = $builder->get()->getResultArray();

        return [
            'data'     => $data,
            'filtered' => $filteredRecords
        ];
    }

    public function countAllRecords()
    {
        return $this->countAll();
    }

    public function countToday()
    {
        return $this->where('date_consulted', date('Y-m-d'))->countAllResults();
    }

    public function countThisWeek()
    {
        return $this->where('date_consulted >=', date('Y-m-d', strtotime('-7 days')))
            ->countAllResults();
    }

    public function recentRecords($limit = 6)
    {
        return $this->select([
            'medical_records.record_id',
            'medical_records.date_consulted',
            'medical_records.chief_complaint',
            'medical_records.diagnosis',
            'medical_records.treatment',

            // Patient full name
            "CONCAT(patients.name, ' ', patients.last_name) AS patient_name",

            // Doctor/Nurse full name
            "CONCAT(users.name, ' ', users.last_name) AS staff_name"
        ])
            ->join('patients', 'patients.patient_id = medical_records.patient_id', 'left')
            ->join('users', 'users.id = medical_records.user_id', 'left')
            ->orderBy('medical_records.date_consulted', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function getDashboardStats()
    {
        $today = date('Y-m-d');
        $weekStart = date('Y-m-d', strtotime('-7 days'));

        return [
            'totalRecords' => $this->countAll(),

            'todayRecords' => $this->where('DATE(date_consulted)', $today)
                ->countAllResults(),

            'weekRecords' => $this->where('DATE(date_consulted) >=', $weekStart)
                ->countAllResults(),

            // 'recentRecords' => $this->orderBy('date_consulted', 'DESC')
            //     ->findAll(5),

            'recentRecords' => $this->todayRecords(),
        ];
    }

    public function todayRecords($limit = 50)
    {
        return $this->select([
            'medical_records.record_id',
            'medical_records.date_consulted',
            'medical_records.chief_complaint',
            'medical_records.diagnosis',
            'medical_records.treatment',
            'patients.name AS patient_name',
            'users.name AS staff_name'
        ])
            ->join('patients', 'patients.patient_id = medical_records.patient_id', 'left')
            ->join('users', 'users.id = medical_records.user_id', 'left')
            ->where('DATE(medical_records.date_consulted)', date('Y-m-d'))
            ->orderBy('medical_records.date_consulted', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function last7DaysRecords($limit = 50)
    {
        $weekStart = date('Y-m-d', strtotime('-7 days'));

        return $this->select([
            'medical_records.record_id',
            'medical_records.date_consulted',
            'medical_records.chief_complaint',
            'medical_records.diagnosis',
            'medical_records.treatment',
            'patients.name AS patient_name',
            'users.name AS staff_name'
        ])
            ->join('patients', 'patients.patient_id = medical_records.patient_id', 'left')
            ->join('users', 'users.id = medical_records.user_id', 'left')
            ->where('DATE(medical_records.date_consulted) >=', $weekStart)
            ->orderBy('medical_records.date_consulted', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}

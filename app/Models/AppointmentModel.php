<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'appointment_id';

    protected $allowedFields = [
        'patient_id',
        'user_id',
        'appointment_date',
        'status',
        'notes'
    ];

    // =========================
    // DATATABLE FETCH RECORDS
    // =========================
    public function getRecords($start, $length, $searchValue = '')
    {
        $builder = $this->db->table('appointments');

        // 🔥 JOIN (this is what you were missing)
        $builder->select('
            appointments.*,
            patients.name as patient_name,
            users.name as user_name
        ');

        $builder->join('patients', 'patients.patient_id = appointments.patient_id', 'left');
        $builder->join('users', 'users.id = appointments.user_id', 'left');

    
        // SEARCH (now by names)
  
        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('patients.name', $searchValue)
                ->orLike('users.name', $searchValue)
                ->orLike('appointments.status', $searchValue)
                ->orLike('appointments.appointment_date', $searchValue)
                ->groupEnd();
        }

    
        // COUNT (filtered)
    
        $filteredBuilder = clone $builder;
        $filteredRecords = $filteredBuilder->countAllResults();

   
        // PAGINATION
  
        $builder->limit($length, $start);
        $data = $builder->get()->getResultArray();

        return [
            'data' => $data,
            'filtered' => $filteredRecords
        ];
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table = 'patients';
    protected $primaryKey = 'patient_id';

    protected $allowedFields = ['last_name', 'name', 'middle_name', 'sex', 'age', 'birthdate', 'contact', 'department'];

    public function getRecords($start, $length, $searchValue = '', $orderColumn = 'last_name', $orderDir = 'asc')
{
    $builder = $this->db->table('patients p');

    $builder->select('
        p.*,
        GROUP_CONCAT(
            CONCAT(pr.last_name, ", ", pr.name, " (", pp.relationship, ")")
            SEPARATOR " | "
        ) as parents
    ');

    $builder->join('patient_parents pp', 'pp.patient_id = p.patient_id', 'left');
    $builder->join('parents pr', 'pr.parent_id = pp.parent_id', 'left');

    if (!empty($searchValue)) {
        $builder->groupStart()
            ->like('p.last_name', $searchValue)
            ->orLike('p.name', $searchValue)
            ->orLike('p.middle_name', $searchValue)
            ->groupEnd();
    }

    $builder->groupBy('p.patient_id');

    $filteredBuilder = clone $builder;
    $filtered = $filteredBuilder->countAllResults(false);

    $builder->orderBy($orderColumn, $orderDir);
    $builder->limit($length, $start);

    $data = $builder->get()->getResultArray();

    return [
        'data' => $data,
        'filtered' => $filtered
    ];
}

// public function getPatientWithParents($patient_id)
// {
//     return $this->db->table('patients p')
//         ->select('p.*, pr.parent_id, pr.name, pr.last_name, pr.middle_name, pr.contact, pr.address, pp.relationship')
//         ->join('patient_parents pp', 'pp.patient_id = p.patient_id', 'left')
//         ->join('parents pr', 'pr.parent_id = pp.parent_id', 'left')
//         ->where('p.patient_id', $patient_id)
//         ->get()
//         ->getResultArray();
// }
    
}

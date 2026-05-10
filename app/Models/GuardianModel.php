<?php

namespace App\Models;

use CodeIgniter\Model;

class GuardianModel extends Model
{
    protected $table = 'parents';
    protected $primaryKey = 'parent_id';

    protected $allowedFields = ['last_name', 'name', 'middle_name', 'contact', 'address'];

    public function getRecords($start, $length, $searchValue = '', $orderColumn = 'last_name', $orderDir = 'asc')
{
    $builder = $this->builder();
    $builder->select('*');

    if (!empty($searchValue)) {
        $builder->groupStart()
            ->orLike('last_name', $searchValue)
            ->orLike('name', $searchValue)
            ->orLike('middle_name', $searchValue)
            ->groupEnd();
    }

    $filteredBuilder = clone $builder;
    $filteredRecords = $filteredBuilder->countAllResults();

    $builder->orderBy($orderColumn, $orderDir); // ← added
    $builder->limit($length, $start);
    $data = $builder->get()->getResultArray();

    return ['data' => $data, 'filtered' => $filteredRecords];
}
}

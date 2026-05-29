<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'categories';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
    ];

    public function getRecords($start, $length, $searchValue = '', $orderColumn = 'name', $orderDir = 'asc')
{
    $builder = $this->builder();
    $builder->select('*');

    if (!empty($searchValue)) {
        $builder->groupStart()
            ->like('name', $searchValue)
            ->groupEnd();
    }

    $filteredBuilder = clone $builder;
    $filteredRecords = $filteredBuilder->countAllResults();

    $builder->orderBy($orderColumn, $orderDir);
    $builder->limit($length, $start);
    $data = $builder->get()->getResultArray();

    return ['data' => $data, 'filtered' => $filteredRecords];
}


}

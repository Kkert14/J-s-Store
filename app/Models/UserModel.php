<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = ['uuid', 'email', 'password', 'role', 'status', 'name', 'phone', 'created_at', 'updated_at', 'deleted_at'];

    public function getRecords($start, $length, $searchValue = '', $role = '', $orderColumn = 'name', $orderDir = 'asc')
    {
        $builder = $this->builder();
        $builder->select('*');

        if (!empty($role)) {
            $builder->where('role', $role);
        }

        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('email', $searchValue)
                ->orLike('name', $searchValue)
                ->groupEnd();
        }

        $filteredBuilder = clone $builder;
        $filteredRecords = $filteredBuilder->countAllResults();

        $builder->orderBy($orderColumn, $orderDir);
        $builder->limit($length, $start);
        $data = $builder->get()->getResultArray();

        return [
            'data' => $data,
            'filtered' => $filteredRecords
        ];
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class StockMovementModel extends Model
{
    protected $table      = 'stock_movements';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'product_id',
        'movement_type',
        'qty',
        'unit_cost',
        'ref_type',
        'ref_id',
        'reason',
        'user_id',
    ];

    public function getRecords(
        int $start,
        int $length,
        string $searchValue = '',
        string $orderColumn = 'sm.created_at',
        string $orderDir = 'desc'
    ): array {
        $countBuilder = $this->db->table('stock_movements sm');
        $countBuilder->join('products p', 'p.id = sm.product_id', 'left');
        $countBuilder->join('users u', 'u.id = sm.user_id', 'left');

        if ($searchValue !== '') {
            $countBuilder->groupStart()
                ->like('p.name', $searchValue)
                ->orLike('p.sku', $searchValue)
                ->orLike('sm.movement_type', $searchValue)
                ->orLike('sm.reason', $searchValue)
                ->orLike('u.name', $searchValue)
                ->groupEnd();
        }

        $countBuilder->select('COUNT(DISTINCT sm.id) AS cnt', false);
        $filtered = (int) ($countBuilder->get()->getRowArray()['cnt'] ?? 0);

        $builder = $this->db->table('stock_movements sm');
        $builder->select('sm.*, p.name AS product_name, p.sku AS product_sku, u.name AS user_name');
        $builder->join('products p', 'p.id = sm.product_id', 'left');
        $builder->join('users u', 'u.id = sm.user_id', 'left');

        if ($searchValue !== '') {
            $builder->groupStart()
                ->like('p.name', $searchValue)
                ->orLike('p.sku', $searchValue)
                ->orLike('sm.movement_type', $searchValue)
                ->orLike('sm.reason', $searchValue)
                ->orLike('u.name', $searchValue)
                ->groupEnd();
        }

        $builder->orderBy($orderColumn, $orderDir);
        $builder->limit($length, $start);

        return [
            'data' => $builder->get()->getResultArray(),
            'filtered' => $filtered,
        ];
    }
}


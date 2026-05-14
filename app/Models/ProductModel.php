<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sku',
        'name',
        'category_id',
        'unit',
        'cost',
        'price',
        'stock_qty',
        'reorder_level',
        'is_active',
    ];

    public function getRecords(
        $start,
        $length,
        $searchValue = '',
        $orderColumn = 'p.name',
        $orderDir = 'asc'
    ) {
        $countBuilder = $this->db->table('products p');
        $countBuilder->join('categories c', 'c.id = p.category_id', 'left');

        if (!empty($searchValue)) {
            $countBuilder->groupStart()
                ->like('p.name', $searchValue)
                ->orLike('p.sku', $searchValue)
                ->orLike('c.name', $searchValue)
                ->groupEnd();
        }

        $countBuilder->select('COUNT(DISTINCT p.id) AS cnt', false);
        $filtered = (int) ($countBuilder->get()->getRowArray()['cnt'] ?? 0);

        $builder = $this->db->table('products p');
        $builder->select('p.*, c.name AS category_name');
        $builder->join('categories c', 'c.id = p.category_id', 'left');

        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('p.name', $searchValue)
                ->orLike('p.sku', $searchValue)
                ->orLike('c.name', $searchValue)
                ->groupEnd();
        }

        $builder->orderBy($orderColumn, $orderDir);
        $builder->limit($length, $start);
        $data = $builder->get()->getResultArray();

        return [
            'data' => $data,
            'filtered' => $filtered,
        ];
    }

    public function searchActive(string $query, int $limit = 20): array
{
    $builder = $this->builder();
    $builder->select('id, sku, name, unit, price, stock_qty');
    $builder->where('is_active', 1);
    $builder->groupStart()
        ->like('name', $query)
        ->orLike('sku', $query)
        ->groupEnd();
    $builder->orderBy('name', 'asc');
    $builder->limit($limit);
    return $builder->get()->getResultArray();
}
}

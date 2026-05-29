<?php

namespace App\Controllers;

use App\Models\StockMovementModel;
use CodeIgniter\Controller;

class Stock extends Controller
{
    public function index()
    {
        return view('stock/index');
    }

    public function fetchLowStock()
    {
        $request = service('request');
        $db = \Config\Database::connect();

        $start = (int) ($request->getPost('start') ?? 0);
        $length = (int) ($request->getPost('length') ?? 10);
        $searchValue = (string) ($request->getPost('search')['value'] ?? '');

        $orderColumnIndex = (int) ($request->getPost('order')[0]['column'] ?? 2);
        $orderDir = (string) ($request->getPost('order')[0]['dir'] ?? 'asc');

        $columns = [
            1 => 'p.id',
            2 => 'p.name',
            3 => 'p.sku',
            4 => 'c.name',
            5 => 'p.stock_qty',
            6 => 'p.reorder_level',
        ];
        $orderColumn = $columns[$orderColumnIndex] ?? 'p.name';

        $countBuilder = $db->table('products p');
        $countBuilder->join('categories c', 'c.id = p.category_id', 'left');
        $countBuilder->where('p.is_active', 1);
        $countBuilder->where('p.stock_qty <= p.reorder_level', null, false);

        if ($searchValue !== '') {
            $countBuilder->groupStart()
                ->like('p.name', $searchValue)
                ->orLike('p.sku', $searchValue)
                ->orLike('c.name', $searchValue)
                ->groupEnd();
        }

        $countBuilder->select('COUNT(DISTINCT p.id) AS cnt', false);
        $filtered = (int) ($countBuilder->get()->getRowArray()['cnt'] ?? 0);

        $builder = $db->table('products p');
        $builder->select('p.*, c.name AS category_name');
        $builder->join('categories c', 'c.id = p.category_id', 'left');
        $builder->where('p.is_active', 1);
        $builder->where('p.stock_qty <= p.reorder_level', null, false);

        if ($searchValue !== '') {
            $builder->groupStart()
                ->like('p.name', $searchValue)
                ->orLike('p.sku', $searchValue)
                ->orLike('c.name', $searchValue)
                ->groupEnd();
        }

        $builder->orderBy($orderColumn, $orderDir);
        $builder->limit($length, $start);
        $rows = $builder->get()->getResultArray();

        $data = [];
        $counter = $start + 1;
        foreach ($rows as $row) {
            $row['row_number'] = $counter++;
            $data[] = $row;
        }

        return $this->response->setJSON([
            'draw' => (int) $request->getPost('draw'),
            'recordsTotal' => $filtered,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }

    public function fetchMovements()
    {
        $request = service('request');
        $model = new StockMovementModel();

        $start = (int) ($request->getPost('start') ?? 0);
        $length = (int) ($request->getPost('length') ?? 10);
        $searchValue = (string) ($request->getPost('search')['value'] ?? '');

        $orderColumnIndex = (int) ($request->getPost('order')[0]['column'] ?? 1);
        $orderDir = (string) ($request->getPost('order')[0]['dir'] ?? 'desc');

        $columns = [
            1 => 'sm.created_at',
            2 => 'p.name',
            3 => 'sm.movement_type',
            4 => 'sm.qty',
            5 => 'sm.unit_cost',
            6 => 'sm.reason',
            7 => 'u.name',
        ];
        $orderColumn = $columns[$orderColumnIndex] ?? 'sm.created_at';

        $totalRecords = $model->countAll();
        $result = $model->getRecords($start, $length, $searchValue, $orderColumn, $orderDir);

        $data = [];
        $counter = $start + 1;
        foreach ($result['data'] as $row) {
            $row['row_number'] = $counter++;
            $data[] = $row;
        }

        return $this->response->setJSON([
            'draw' => (int) $request->getPost('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $result['filtered'],
            'data' => $data,
        ]);
    }
}

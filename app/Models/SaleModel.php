<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table      = 'sales';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'receipt_no',
        'sale_datetime',
        'cashier_user_id',
        'subtotal',
        'discount_total',
        'grand_total',
        'payment_method',
        'payment_reference',
        'amount_tendered',
        'change_amount',
        'status',
        'void_reason',
        'voided_at',
        'voided_by',
    ];

    public function getRecords(
        $start,
        $length,
        $searchValue = '',
        $orderColumn = 's.sale_datetime',
        $orderDir = 'desc'
    ) {
        $countBuilder = $this->db->table('sales s');
        $countBuilder->join('users u', 'u.id = s.cashier_user_id', 'left');

        if (!empty($searchValue)) {
            $countBuilder->groupStart()
                ->like('s.receipt_no', $searchValue)
                ->orLike('u.name', $searchValue)
                ->orLike('s.payment_method', $searchValue)
                ->orLike('s.status', $searchValue)
                ->groupEnd();
        }

        $countBuilder->select('COUNT(DISTINCT s.id) AS cnt', false);
        $filtered = (int) ($countBuilder->get()->getRowArray()['cnt'] ?? 0);

        $builder = $this->db->table('sales s');
        $builder->select('s.*, u.name AS cashier_name');
        $builder->join('users u', 'u.id = s.cashier_user_id', 'left');

        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('s.receipt_no', $searchValue)
                ->orLike('u.name', $searchValue)
                ->orLike('s.payment_method', $searchValue)
                ->orLike('s.status', $searchValue)
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

    public function sumCompletedBetween(string $startDateTime, string $endDateTime): float
{
    $row = $this->builder()
        ->select('COALESCE(SUM(grand_total), 0) AS total', false)
        ->where('status', 'completed')
        ->where('sale_datetime >=', $startDateTime)
        ->where('sale_datetime <=', $endDateTime)
        ->get()
        ->getRowArray();

    return (float) ($row['total'] ?? 0);
}

    public function revenueLast7Days(): array
{
    return $this->db->table('sales')
        ->select("DATE(sale_datetime) AS label, COALESCE(SUM(grand_total),0) AS total", false)
        ->where('status', 'completed')
        ->where('sale_datetime >=', date('Y-m-d 00:00:00', strtotime('-6 days')))
        ->groupBy('DATE(sale_datetime)')
        ->orderBy('label', 'asc')
        ->get()
        ->getResultArray();
}

    public function revenueCurrentMonthDaily(): array
{
    $start = date('Y-m-01 00:00:00');
    $end   = date('Y-m-t 23:59:59');

    return $this->db->table('sales')
        ->select("DATE(sale_datetime) AS label, COALESCE(SUM(grand_total),0) AS total", false)
        ->where('status', 'completed')
        ->where('sale_datetime >=', $start)
        ->where('sale_datetime <=', $end)
        ->groupBy('DATE(sale_datetime)')
        ->orderBy('label', 'asc')
        ->get()
        ->getResultArray();
}

    public function revenueCurrentYearMonthly(): array
{
    $start = date('Y-01-01 00:00:00');
    $end   = date('Y-12-31 23:59:59');

    return $this->db->table('sales')
        ->select("DATE_FORMAT(sale_datetime, '%Y-%m') AS label, COALESCE(SUM(grand_total),0) AS total", false)
        ->where('status', 'completed')
        ->where('sale_datetime >=', $start)
        ->where('sale_datetime <=', $end)
        ->groupBy("DATE_FORMAT(sale_datetime, '%Y-%m')")
        ->orderBy('label', 'asc')
        ->get()
        ->getResultArray();
}
}


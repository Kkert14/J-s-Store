<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SaleModel;
use App\Models\UserModel;
use App\Models\LogModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role');

        $productModel = new ProductModel();
        $saleModel = new SaleModel();
        $userModel = new UserModel();
        $logModel = new LogModel();

        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd   = date('Y-m-d 23:59:59');

        $weekStart  = date('Y-m-d 00:00:00', strtotime('-6 days'));
        $weekEnd    = $todayEnd;

        $monthStart = date('Y-m-01 00:00:00');
        $monthEnd   = date('Y-m-t 23:59:59');

        $yearStart  = date('Y-01-01 00:00:00');
        $yearEnd    = date('Y-12-31 23:59:59');

        $data = [
            'role' => $role,
            'productCount' => $productModel->countAll(),
            'lowStockCount' => $productModel->countLowStock(),
            'todayRevenue' => $saleModel->sumCompletedBetween($todayStart, $todayEnd),
            'weekRevenue' => $saleModel->sumCompletedBetween($weekStart, $weekEnd),
            'monthRevenue' => $saleModel->sumCompletedBetween($monthStart, $monthEnd),
            'yearRevenue' => $saleModel->sumCompletedBetween($yearStart, $yearEnd),
        ];

        if ($role === 'Admin') {
            $data['userCount'] = $userModel->countAll();
            $data['recentLogs'] = $logModel->getRecentLogs(8);
        }

        $data['chartWeek'] = $this->fillDailySeries($saleModel->revenueLast7Days(), 7);
        $data['chartMonth'] = $this->fillMonthDailySeries($saleModel->revenueCurrentMonthDaily());
        $data['chartYear'] = $this->fillYearMonthlySeries($saleModel->revenueCurrentYearMonthly());

        return view('dashboard', $data);
    }

    private function fillDailySeries(array $rows, int $days): array
    {
        $map = [];
        foreach ($rows as $r) {
            $map[$r['label']] = (float) $r['total'];
        }

        $labels = [];
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $d = date('Y-m-d', strtotime("-{$i} days"));
            $labels[] = date('M j', strtotime($d));
            $data[] = (float) ($map[$d] ?? 0);
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function fillMonthDailySeries(array $rows): array
    {
        $map = [];
        foreach ($rows as $r) {
            $map[$r['label']] = (float) $r['total'];
        }

        $labels = [];
        $data = [];

        $ym = date('Y-m-');
        $daysInMonth = (int) date('t');
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $d = $ym . str_pad((string) $day, 2, '0', STR_PAD_LEFT);
            $labels[] = str_pad((string) $day, 2, '0', STR_PAD_LEFT);
            $data[] = (float) ($map[$d] ?? 0);
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function fillYearMonthlySeries(array $rows): array
    {
        $map = [];
        foreach ($rows as $r) {
            $map[$r['label']] = (float) $r['total'];
        }

        $labels = [];
        $data = [];

        $year = date('Y');
        for ($m = 1; $m <= 12; $m++) {
            $key = $year . '-' . str_pad((string) $m, 2, '0', STR_PAD_LEFT);
            $labels[] = date('M', strtotime($key . '-01'));
            $data[] = (float) ($map[$key] ?? 0);
        }

        return ['labels' => $labels, 'data' => $data];
    }
}

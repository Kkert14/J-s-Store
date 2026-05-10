<?php

namespace App\Controllers;

use App\Models\MedicineModel;
use CodeIgniter\Controller;
use App\Models\LogModel;

class Medicine extends Controller
{
    const LOW_STOCK_THRESHOLD = 5;

    const EXPIRY_WARN_DAYS = 7;

    public function index()
    {
        $model = new MedicineModel();
        $data['medicine']       = $model->findAll();
        $data['low_stock']      = $model->getLowStock(self::LOW_STOCK_THRESHOLD);
        $data['expired']        = $model->getExpired();
        $data['expiring_soon']  = $model->getExpiringSoon(self::EXPIRY_WARN_DAYS);
        return view('medicine/index', $data);
    }

    public function save()
    {
        $medicine_name  = $this->request->getPost('medicine_name');
        $quantity       = $this->request->getPost('quantity');
        $expiry_date    = $this->request->getPost('expiry_date');
        $date_received  = $this->request->getPost('date_received');

        $userModel = new \App\Models\MedicineModel();
        $logModel  = new LogModel();

        $data = [
            'medicine_name' => $medicine_name,
            'quantity'      => $quantity,
            'expiry_date'   => $expiry_date,
            'date_received' => $date_received,
        ];

        if ($userModel->insert($data)) {
            $logModel->addLog('New Medicine has been added: ' . $medicine_name, 'ADD');
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save Medicine']);
        }
    }

    public function update()
    {
        $model    = new MedicineModel();
        $logModel = new LogModel();

        $userId        = $this->request->getPost('medicine_id');
        $medicine_name = $this->request->getPost('medicine_name');
        $quantity      = $this->request->getPost('quantity');
        $expiry_date   = $this->request->getPost('expiry_date');
        $date_received = $this->request->getPost('date_received');

        $userData = [
            'medicine_name' => $medicine_name,
            'quantity'      => $quantity,
            'expiry_date'   => $expiry_date,
            'date_received' => $date_received,
        ];

        $updated = $model->update($userId, $userData);

        if ($updated) {
            $logModel->addLog('Medicine has been updated: ' . $medicine_name, 'UPDATED');
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Medicine updated successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error updating Medicine.'
            ]);
        }
    }

    public function edit($id)
    {
        $model = new MedicineModel();
        $user  = $model->find($id);

        if ($user) {
            return $this->response->setJSON(['data' => $user]);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Medicine not found']);
        }
    }

    public function delete($id)
    {
        $model    = new MedicineModel();
        $logModel = new LogModel();
        $user     = $model->find($id);

        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'Medicine not found.']);
        }

        $deleted = $model->delete($id);

        if ($deleted) {
            $logModel->addLog('Delete Medicine', 'DELETED');
            return $this->response->setJSON(['success' => true, 'message' => 'Medicine deleted successfully.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete Medicine.']);
        }
    }

   public function fetchRecords()
{
    $request = service('request');
    $model   = new \App\Models\MedicineModel();

    $start       = $request->getPost('start')           ?? 0;
    $length      = $request->getPost('length')          ?? 10;
    $searchValue = $request->getPost('search')['value'] ?? '';

    // ← added sorting
    $orderColumnIndex = $request->getPost('order')[0]['column'] ?? 2;
    $orderDir         = $request->getPost('order')[0]['dir']    ?? 'asc';

    $columns = [
        2 => 'medicine_name',
        3 => 'quantity',
        4 => 'expiry_date',
        5 => 'date_received',
    ];

    $orderColumn = $columns[$orderColumnIndex] ?? 'medicine_name';

    $totalRecords = $model->countAll();
    $result       = $model->getRecords($start, $length, $searchValue, $orderColumn, $orderDir);

    $data    = [];
    $counter = $start + 1;

    foreach ($result['data'] as $row) {
        $row['row_number']       = $counter++;
        $row['low_stock']        = ($row['quantity'] < self::LOW_STOCK_THRESHOLD);
        $today                   = date('Y-m-d');
        $soonDate                = date('Y-m-d', strtotime('+' . self::EXPIRY_WARN_DAYS . ' days'));
        $row['is_expired']       = (!empty($row['expiry_date']) && $row['expiry_date'] < $today);
        $row['is_expiring_soon'] = (!empty($row['expiry_date']) && $row['expiry_date'] >= $today && $row['expiry_date'] <= $soonDate);
        $data[] = $row;
    }

    return $this->response->setJSON([
        'draw'            => intval($request->getPost('draw')),
        'recordsTotal'    => $totalRecords,
        'recordsFiltered' => $result['filtered'],
        'data'            => $data,
    ]);
}

// ← new method for +/- buttons
public function adjustStock()
{
    $model      = new MedicineModel();
    $logModel   = new LogModel();

    $id     = $this->request->getPost('medicine_id');
    $action = $this->request->getPost('action'); // 'add' or 'subtract'
    $amount = (int) $this->request->getPost('amount');

    if (!$id || !in_array($action, ['add', 'subtract']) || $amount < 1) {
        return $this->response->setJSON(['success' => false, 'message' => 'Invalid input.']);
    }

    $medicine = $model->find($id);
    if (!$medicine) {
        return $this->response->setJSON(['success' => false, 'message' => 'Medicine not found.']);
    }

    if ($action === 'subtract' && $medicine['quantity'] < $amount) {
        return $this->response->setJSON(['success' => false, 'message' => 'Not enough stock.']);
    }

    $newQty = $action === 'add'
        ? $medicine['quantity'] + $amount
        : $medicine['quantity'] - $amount;

    $model->update($id, ['quantity' => $newQty]);
    $logModel->addLog("Stock {$action}ed for {$medicine['medicine_name']}: {$amount} units", 'UPDATE');

    return $this->response->setJSON([
        'success'      => true,
        'new_quantity' => $newQty,
        'message'      => 'Stock updated successfully.'
    ]);
}
}
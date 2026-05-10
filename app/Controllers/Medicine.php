<?php

namespace App\Controllers;

use App\Models\MedicineModel;
use CodeIgniter\Controller;
use App\Models\LogModel;

class Medicine extends Controller
{
    const LOW_STOCK_THRESHOLD = 5;

    public function index()
    {
        $model = new MedicineModel();
        $data['medicine']   = $model->findAll();
        $data['low_stock']  = $model->getLowStock(self::LOW_STOCK_THRESHOLD);
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

        $totalRecords = $model->countAll();
        $result       = $model->getRecords($start, $length, $searchValue);

        $data    = [];
        $counter = $start + 1;

        foreach ($result['data'] as $row) {
            $row['row_number']  = $counter++;
            $row['low_stock']   = ($row['quantity'] < self::LOW_STOCK_THRESHOLD) ? true : false;
            $data[] = $row;
        }

        return $this->response->setJSON([
            'draw'            => intval($request->getPost('draw')),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $result['filtered'],
            'data'            => $data,
        ]);
    }
}
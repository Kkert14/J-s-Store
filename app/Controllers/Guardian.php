<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GuardianModel;
use CodeIgniter\Controller;
use App\Models\LogModel;

class Guardian extends Controller
{
    public function index(){
        $model = new GuardianModel();
        $data['guardian'] = $model->findAll();
        return view('guardian/index', $data);
    }

    public function save(){
        $name = $this->request->getPost('name');
        $last_name = $this->request->getPost('last_name');
        $middle_name = $this->request->getPost('middle_name');
        $contact = $this->request->getPost('contact');
        $address = $this->request->getPost('address');
        

        $userModel = new \App\Models\GuardianModel();
        $logModel = new LogModel();

        $data = [
            'name'       => $name,
            'last_name'       => $last_name,
            'middle_name'       => $middle_name,
            'contact'       => $contact,
            'address'       => $address,
            
        ];

        if ($userModel->insert($data)) {
            $logModel->addLog('New Guardian has been added: ' . $name, 'ADD');
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save Guardian']);
        }
    }

    public function update(){
        $model = new GuardianModel();
        $logModel = new LogModel();
        $userId = $this->request->getPost('record_id');
        $name = $this->request->getPost('name');
        $last_name = $this->request->getPost('last_name');
        $middle_name = $this->request->getPost('middle_name');
        $contact = $this->request->getPost('contact');
        $address = $this->request->getPost('address');
      

        $userData = [
            'name'       => $name,
            'last_name'       => $last_name,
            'middle_name'       => $middle_name,
            'contact'       => $contact,
            'address'       => $address,

        ];

        $updated = $model->update($userId, $userData);

        if ($updated) {
            $logModel->addLog('New Guardian has been apdated: ' . $name, 'UPDATED');
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Guardian updated successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error updating Guardian.'
            ]);
        }
    }

    public function edit($id){
        $model = new GuardianModel();
    $user = $model->find($id); // Fetch user by ID

    if ($user) {
        return $this->response->setJSON(['data' => $user]); // Return user data as JSON
    } else {
        return $this->response->setStatusCode(404)->setJSON(['error' => 'User not found']);
    }
}

public function delete($id){
    $model = new GuardianModel();
    $logModel = new LogModel();
    $user = $model->find($id);
    if (!$user) {
        return $this->response->setJSON(['success' => false, 'message' => 'Guardian not found.']);
    }

    $deleted = $model->delete($id);

    if ($deleted) {
        $logModel->addLog('Delete Guardian', 'DELETED');
        return $this->response->setJSON(['success' => true, 'message' => 'Guardian deleted successfully.']);
    } else {
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete Guardian.']);
    }
}

public function fetchRecords()
{
    $request = service('request');
    $model = new \App\Models\GuardianModel();

    $start = $request->getPost('start') ?? 0;
    $length = $request->getPost('length') ?? 10;
    $searchValue = $request->getPost('search')['value'] ?? '';

    // ← added sorting
    $orderColumnIndex = $request->getPost('order')[0]['column'] ?? 2;
    $orderDir = $request->getPost('order')[0]['dir'] ?? 'asc';

    $columns = [
        1 => 'parent_id',
        2 => 'last_name',
        3 => 'name',
        4 => 'middle_name',
        5 => 'contact',
        6 => 'address',
    ];

    $orderColumn = $columns[$orderColumnIndex] ?? 'last_name';

    $totalRecords = $model->countAll();
    $result = $model->getRecords($start, $length, $searchValue, $orderColumn, $orderDir);

    $data = [];
    $counter = $start + 1;
    foreach ($result['data'] as $row) {
        $row['row_number'] = $counter++;
        $data[] = $row;
    }

    return $this->response->setJSON([
        'draw' => intval($request->getPost('draw')),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $result['filtered'],
        'data' => $data,
    ]);
}

}
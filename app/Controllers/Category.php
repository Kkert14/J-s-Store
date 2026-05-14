<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\LogModel;
use CodeIgniter\Controller;

class Category extends Controller
{
    public function index()
{
    $model = new CategoryModel();
    $data['categories'] = $model->findAll();
    return view('category/index', $data);
}

    public function save()
{
    $name = trim((string) $this->request->getPost('name'));
    $model = new CategoryModel();
    $logModel = new LogModel();

    if ($name === '') {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Category name is required.']);
    }

    $ok = $model->insert(['name' => $name]);
    if ($ok) {
        $logModel->addLog('New Category has been added: ' . $name, 'ADD');
        return $this->response->setJSON(['status' => 'success']);
    }

    $err = $model->db->error();
    return $this->response->setJSON(['status' => 'error', 'message' => $err['message'] ?? 'Failed to save category.']);
}

    public function edit($id)
{
    $model = new CategoryModel();
    $row = $model->find($id);
    if ($row) {
        return $this->response->setJSON(['data' => $row]);
    }
    return $this->response->setStatusCode(404)->setJSON(['error' => 'Category not found']);
}

    public function update()
{
    $id = (int) $this->request->getPost('id');
    $name = trim((string) $this->request->getPost('name'));
    $model = new CategoryModel();
    $logModel = new LogModel();

    if (!$id || $name === '') {
        return $this->response->setJSON(['success' => false, 'message' => 'Invalid input.']);
    }

    $ok = $model->update($id, ['name' => $name]);
    if ($ok) {
        $logModel->addLog('Category has been updated: ' . $name, 'UPDATED');
        return $this->response->setJSON(['success' => true]);
    }

    $err = $model->db->error();
    return $this->response->setJSON(['success' => false, 'message' => $err['message'] ?? 'Failed to update category.']);
}

    public function delete($id)
{
    $model = new CategoryModel();
    $logModel = new LogModel();
    $row = $model->find($id);
    if (!$row) {
        return $this->response->setJSON(['success' => false, 'message' => 'Category not found.']);
    }

    $ok = $model->delete($id);
    if ($ok) {
        $logModel->addLog('Delete Category: ' . ($row['name'] ?? ''), 'DELETED');
        return $this->response->setJSON(['success' => true]);
    }

    $err = $model->db->error();
    return $this->response->setJSON(['success' => false, 'message' => $err['message'] ?? 'Failed to delete category.']);
}

    public function fetchRecords()
{
    $request = service('request');
    $model = new CategoryModel();

    $start = $request->getPost('start') ?? 0;
    $length = $request->getPost('length') ?? 10;
    $searchValue = $request->getPost('search')['value'] ?? '';

    $orderColumnIndex = $request->getPost('order')[0]['column'] ?? 1;
    $orderDir = $request->getPost('order')[0]['dir'] ?? 'asc';

    $columns = [
        1 => 'name',
    ];

    $orderColumn = $columns[$orderColumnIndex] ?? 'name';

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


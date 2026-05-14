<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\LogModel;
use App\Models\ProductModel;
use App\Models\StockMovementModel;
use CodeIgniter\Controller;

class Product extends Controller
{
    public function index()
{
    $categoryModel = new CategoryModel();
    $data = [
        'categories' => $categoryModel->orderBy('name', 'asc')->findAll(),
    ];
    return view('product/index', $data);
}

    public function save()
{
    $model = new ProductModel();
    $logModel = new LogModel();

    $payload = [
        'sku' => trim((string) $this->request->getPost('sku')) ?: null,
        'name' => trim((string) $this->request->getPost('name')),
        'category_id' => $this->request->getPost('category_id') !== '' ? (int) $this->request->getPost('category_id') : null,
        'unit' => trim((string) $this->request->getPost('unit')) ?: null,
        'cost' => (float) $this->request->getPost('cost'),
        'price' => (float) $this->request->getPost('price'),
        'stock_qty' => (int) $this->request->getPost('stock_qty'),
        'reorder_level' => (int) $this->request->getPost('reorder_level'),
        'is_active' => $this->request->getPost('is_active') ? 1 : 0,
    ];

    if ($payload['name'] === '') {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Product name is required.']);
    }

    $ok = $model->insert($payload);
    if ($ok) {
        $logModel->addLog('New Product has been added: ' . $payload['name'], 'ADD');
        return $this->response->setJSON(['status' => 'success']);
    }

    $err = $model->db->error();
    return $this->response->setJSON(['status' => 'error', 'message' => $err['message'] ?? 'Failed to save product.']);
}

    public function edit($id)
{
    $model = new ProductModel();
    $row = $model->find($id);
    if ($row) {
        return $this->response->setJSON(['data' => $row]);
    }
    return $this->response->setStatusCode(404)->setJSON(['error' => 'Product not found']);
}

    public function update()
{
    $id = (int) $this->request->getPost('id');
    $model = new ProductModel();
    $logModel = new LogModel();

    if (!$id) {
        return $this->response->setJSON(['success' => false, 'message' => 'Invalid product id.']);
    }

    $payload = [
        'sku' => trim((string) $this->request->getPost('sku')) ?: null,
        'name' => trim((string) $this->request->getPost('name')),
        'category_id' => $this->request->getPost('category_id') !== '' ? (int) $this->request->getPost('category_id') : null,
        'unit' => trim((string) $this->request->getPost('unit')) ?: null,
        'cost' => (float) $this->request->getPost('cost'),
        'price' => (float) $this->request->getPost('price'),
        'stock_qty' => (int) $this->request->getPost('stock_qty'),
        'reorder_level' => (int) $this->request->getPost('reorder_level'),
        'is_active' => $this->request->getPost('is_active') ? 1 : 0,
    ];

    if ($payload['name'] === '') {
        return $this->response->setJSON(['success' => false, 'message' => 'Product name is required.']);
    }

    $ok = $model->update($id, $payload);
    if ($ok) {
        $logModel->addLog('Product has been updated: ' . $payload['name'], 'UPDATED');
        return $this->response->setJSON(['success' => true]);
    }

    $err = $model->db->error();
    return $this->response->setJSON(['success' => false, 'message' => $err['message'] ?? 'Failed to update product.']);
}

    public function delete($id)
{
    $model = new ProductModel();
    $logModel = new LogModel();
    $row = $model->find($id);
    if (!$row) {
        return $this->response->setJSON(['success' => false, 'message' => 'Product not found.']);
    }

    $ok = $model->delete($id);
    if ($ok) {
        $logModel->addLog('Delete Product: ' . ($row['name'] ?? ''), 'DELETED');
        return $this->response->setJSON(['success' => true]);
    }

    $err = $model->db->error();
    return $this->response->setJSON(['success' => false, 'message' => $err['message'] ?? 'Failed to delete product.']);
}

    public function fetchRecords()
{
    $request = service('request');
    $model = new ProductModel();

    $start = $request->getPost('start') ?? 0;
    $length = $request->getPost('length') ?? 10;
    $searchValue = $request->getPost('search')['value'] ?? '';

    $orderColumnIndex = $request->getPost('order')[0]['column'] ?? 2;
    $orderDir = $request->getPost('order')[0]['dir'] ?? 'asc';

    $columns = [
        1 => 'p.id',
        2 => 'p.name',
        3 => 'c.name',
        4 => 'p.price',
        5 => 'p.stock_qty',
    ];

    $orderColumn = $columns[$orderColumnIndex] ?? 'p.name';

    $totalRecords = $model->countAll();
    $result = $model->getRecords($start, $length, $searchValue, $orderColumn, $orderDir);

    $data = [];
    $counter = $start + 1;
    foreach ($result['data'] as $row) {
        $row['row_number'] = $counter++;
        $row['low_stock'] = ((int) ($row['stock_qty'] ?? 0) <= (int) ($row['reorder_level'] ?? 0));
        $data[] = $row;
    }

    return $this->response->setJSON([
        'draw' => intval($request->getPost('draw')),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $result['filtered'],
        'data' => $data,
    ]);
}

    public function adjustStock()
{
    $productId = (int) $this->request->getPost('product_id');
    $action = trim((string) $this->request->getPost('action'));
    $qty = (int) $this->request->getPost('qty');
    $unitCost = $this->request->getPost('unit_cost');
    $reason = trim((string) $this->request->getPost('reason'));

    if ($productId < 1) {
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Invalid product.']);
    }

    if (!in_array($action, ['in', 'out'], true)) {
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Invalid stock action.']);
    }

    if ($qty < 1) {
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Quantity must be at least 1.']);
    }

    if ($unitCost !== null && $unitCost !== '') {
        $unitCost = (float) $unitCost;
        if ($unitCost < 0) {
            $unitCost = 0;
        }
    } else {
        $unitCost = null;
    }

    $delta = $action === 'in' ? $qty : -$qty;

    $db = \Config\Database::connect();
    $productModel = new ProductModel();
    $movementModel = new StockMovementModel();
    $logModel = new LogModel();

    $product = $productModel->find($productId);
    if (!$product) {
        return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Product not found.']);
    }

    $currentQty = (int) ($product['stock_qty'] ?? 0);
    $newQty = $currentQty + $delta;

    if ($newQty < 0) {
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Resulting stock cannot be negative.']);
    }

    $db->transBegin();
    try {
        $ok = $productModel->update($productId, ['stock_qty' => $newQty]);
        if (!$ok) {
            $err = $productModel->db->error();
            throw new \RuntimeException($err['message'] ?? 'Failed to update stock.');
        }

        $movementModel->insert([
            'product_id' => $productId,
            'movement_type' => 'adjust',
            'qty' => $delta,
            'unit_cost' => $unitCost,
            'ref_type' => 'product',
            'ref_id' => $productId,
            'reason' => $reason !== '' ? $reason : ($action === 'in' ? 'Stock In' : 'Stock Out'),
            'user_id' => session()->get('user_id'),
        ]);

        $db->transCommit();
    } catch (\Throwable $e) {
        $db->transRollback();
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => $e->getMessage()]);
    }

    $logModel->addLog('Stock adjusted: ' . ($product['name'] ?? ''), 'UPDATED');
    return $this->response->setJSON(['success' => true, 'new_stock_qty' => $newQty]);
}
}

<?php

namespace App\Controllers;

use App\Models\LogModel;
use App\Models\ProductModel;
use App\Models\SaleItemModel;
use App\Models\SaleModel;
use App\Models\StockMovementModel;
use CodeIgniter\Controller;

class Sales extends Controller
{
    public function index()
{
    return view('sales/index');
}

    public function fetchRecords()
{
    $request = service('request');
    $model = new SaleModel();

    $start = $request->getPost('start') ?? 0;
    $length = $request->getPost('length') ?? 10;
    $searchValue = $request->getPost('search')['value'] ?? '';

    $orderColumnIndex = $request->getPost('order')[0]['column'] ?? 2;
    $orderDir = $request->getPost('order')[0]['dir'] ?? 'desc';

    $columns = [
        1 => 's.receipt_no',
        2 => 's.sale_datetime',
        3 => 'u.name',
        4 => 's.grand_total',
        5 => 's.payment_method',
        6 => 's.status',
    ];

    $orderColumn = $columns[$orderColumnIndex] ?? 's.sale_datetime';

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

    public function receipt($id)
{
    $saleModel = new SaleModel();
    $itemModel = new SaleItemModel();

    $sale = $saleModel->find($id);
    if (!$sale) {
        return redirect()->to('/sales');
    }

    $items = $itemModel->where('sale_id', $id)->findAll();

    return view('sales/receipt', [
        'sale' => $sale,
        'items' => $items,
    ]);
}

    public function void($id)
{
    $saleId = (int) $id;
    $reason = trim((string) $this->request->getPost('void_reason'));

    if ($saleId < 1) {
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Invalid sale.']);
    }

    if ($reason === '') {
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Void reason is required.']);
    }

    $db = \Config\Database::connect();
    $saleModel = new SaleModel();
    $itemModel = new SaleItemModel();
    $productModel = new ProductModel();
    $movementModel = new StockMovementModel();
    $logModel = new LogModel();

    $sale = $saleModel->find($saleId);
    if (!$sale) {
        return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Sale not found.']);
    }

    if (($sale['status'] ?? '') !== 'completed') {
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Only completed sales can be voided.']);
    }

    $items = $itemModel->where('sale_id', $saleId)->findAll();
    if (!$items) {
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'No sale items found.']);
    }

    $db->transBegin();
    try {
        $ok = $saleModel->update($saleId, [
            'status' => 'voided',
            'void_reason' => $reason,
            'voided_at' => date('Y-m-d H:i:s'),
            'voided_by' => session()->get('user_id'),
        ]);
        if (!$ok) {
            $err = $saleModel->db->error();
            throw new \RuntimeException($err['message'] ?? 'Failed to void sale.');
        }

        foreach ($items as $it) {
            $productId = (int) ($it['product_id'] ?? 0);
            $qty = (int) ($it['qty'] ?? 0);
            if ($productId < 1 || $qty < 1) {
                continue;
            }

            $product = $productModel->find($productId);
            if (!$product) {
                continue;
            }

            $currentQty = (int) ($product['stock_qty'] ?? 0);
            $newQty = $currentQty + $qty;

            $ok = $productModel->update($productId, ['stock_qty' => $newQty]);
            if (!$ok) {
                $err = $productModel->db->error();
                throw new \RuntimeException($err['message'] ?? 'Failed to restore stock.');
            }

            $movementModel->insert([
                'product_id' => $productId,
                'movement_type' => 'void',
                'qty' => $qty,
                'ref_type' => 'sale',
                'ref_id' => $saleId,
                'reason' => 'Void Sale: ' . ($sale['receipt_no'] ?? ''),
                'user_id' => session()->get('user_id'),
            ]);
        }

        $db->transCommit();
    } catch (\Throwable $e) {
        $db->transRollback();
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => $e->getMessage()]);
    }

    $logModel->addLog('Voided Sale: ' . ($sale['receipt_no'] ?? ''), 'UPDATED');
    return $this->response->setJSON(['success' => true]);
}

    public function delete($id)
{
    if (strtolower((string) session()->get('role')) !== 'admin') {
        return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'Unauthorized.']);
    }

    $saleId = (int) $id;
    if ($saleId < 1) {
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Invalid sale.']);
    }

    $db = \Config\Database::connect();
    $saleModel = new SaleModel();
    $itemModel = new SaleItemModel();
    $movementModel = new StockMovementModel();
    $logModel = new LogModel();

    $sale = $saleModel->find($saleId);
    if (!$sale) {
        return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Sale not found.']);
    }

    if (($sale['status'] ?? '') !== 'voided') {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Only voided sales can be deleted.',
        ]);
    }

    $db->transBegin();
    try {
        $movementModel
            ->where('ref_type', 'sale')
            ->where('ref_id', $saleId)
            ->delete();

        $itemModel->where('sale_id', $saleId)->delete();

        $ok = $saleModel->delete($saleId);
        if (!$ok) {
            $err = $saleModel->db->error();
            throw new \RuntimeException($err['message'] ?? 'Failed to delete sale.');
        }

        $db->transCommit();
    } catch (\Throwable $e) {
        $db->transRollback();
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => $e->getMessage()]);
    }

    $logModel->addLog('Deleted Sale: ' . ($sale['receipt_no'] ?? ''), 'DELETED');
    return $this->response->setJSON(['success' => true]);
}
}

<?php

namespace App\Controllers;

use App\Models\LogModel;
use App\Models\ProductModel;
use App\Models\SaleItemModel;
use App\Models\SaleModel;
use App\Models\StockMovementModel;
use CodeIgniter\Controller;

class Pos extends Controller
{
    public function index()
{
    return view('pos/index');
}

  public function searchProducts()
{
    $q = trim((string) $this->request->getGet('q'));

    $model = new ProductModel();
    $rows = $model->searchActive($q, 20);
    return $this->response->setJSON(['data' => $rows]);
}

    public function checkout()
{
    $db = \Config\Database::connect();
    $productModel = new ProductModel();
    $saleModel = new SaleModel();
    $itemModel = new SaleItemModel();
    $movementModel = new StockMovementModel();
    $logModel = new LogModel();

    $body = $this->request->getBody();
    $payload = json_decode($body, true);

    if (!is_array($payload)) {
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Invalid request.']);
    }

    $items = $payload['items'] ?? [];
    $paymentMethod = trim((string) ($payload['payment_method'] ?? 'Cash'));
    $paymentReference = trim((string) ($payload['payment_reference'] ?? '')) ?: null;
    $amountTendered = (float) ($payload['amount_tendered'] ?? 0);
    $discountTotal = (float) ($payload['discount_total'] ?? 0);

    if (!is_array($items) || count($items) < 1) {
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Cart is empty.']);
    }

    $db->transBegin();

    try {
        $normalizedItems = [];
        $subtotal = 0.0;

        foreach ($items as $i) {
            $productId = (int) ($i['product_id'] ?? 0);
            $qty = (int) ($i['qty'] ?? 0);

            if ($productId < 1 || $qty < 1) {
                throw new \RuntimeException('Invalid cart item.');
            }

            $product = $productModel->find($productId);
            if (!$product || (int) ($product['is_active'] ?? 0) !== 1) {
                throw new \RuntimeException('Product not found or inactive.');
            }

            $available = (int) ($product['stock_qty'] ?? 0);
            if ($available < $qty) {
                throw new \RuntimeException('Not enough stock for ' . ($product['name'] ?? 'product') . '.');
            }

            $unitPrice = (float) ($product['price'] ?? 0);
            $lineTotal = $unitPrice * $qty;
            $subtotal += $lineTotal;

            $normalizedItems[] = [
                'product' => $product,
                'qty' => $qty,
                'unit_price' => $unitPrice,
                'line_total' => $lineTotal,
            ];
        }

        if ($discountTotal < 0) {
            $discountTotal = 0;
        }

        $grandTotal = max(0, $subtotal - $discountTotal);

        if (strtolower($paymentMethod) === 'cash') {
            if ($amountTendered < $grandTotal) {
                throw new \RuntimeException('Tendered amount is less than total.');
            }
        } else {
            if ($amountTendered <= 0) {
                $amountTendered = $grandTotal;
            }
        }

        $changeAmount = max(0, $amountTendered - $grandTotal);

        $receiptNo = $this->generateReceiptNo();

        $saleId = $saleModel->insert([
            'receipt_no' => $receiptNo,
            'sale_datetime' => date('Y-m-d H:i:s'),
            'cashier_user_id' => session()->get('user_id'),
            'subtotal' => $subtotal,
            'discount_total' => $discountTotal,
            'grand_total' => $grandTotal,
            'payment_method' => $paymentMethod,
            'payment_reference' => $paymentReference,
            'amount_tendered' => $amountTendered,
            'change_amount' => $changeAmount,
            'status' => 'completed',
        ], true);

        if (!$saleId) {
            $err = $saleModel->db->error();
            throw new \RuntimeException($err['message'] ?? 'Failed to save sale.');
        }

        foreach ($normalizedItems as $entry) {
            $p = $entry['product'];
            $qty = $entry['qty'];
            $unitPrice = $entry['unit_price'];
            $lineTotal = $entry['line_total'];

            $ok = $itemModel->insert([
                'sale_id' => $saleId,
                'product_id' => (int) $p['id'],
                'sku_snapshot' => $p['sku'] ?? null,
                'name_snapshot' => $p['name'] ?? '',
                'unit_price' => $unitPrice,
                'qty' => $qty,
                'discount' => 0,
                'line_total' => $lineTotal,
            ]);

            if (!$ok) {
                $err = $itemModel->db->error();
                throw new \RuntimeException($err['message'] ?? 'Failed to save sale items.');
            }

            $newQty = ((int) ($p['stock_qty'] ?? 0)) - $qty;
            $ok = $productModel->update((int) $p['id'], ['stock_qty' => $newQty]);
            if (!$ok) {
                $err = $productModel->db->error();
                throw new \RuntimeException($err['message'] ?? 'Failed to update stock.');
            }

            $movementModel->insert([
                'product_id' => (int) $p['id'],
                'movement_type' => 'sale',
                'qty' => -$qty,
                'ref_type' => 'sale',
                'ref_id' => (int) $saleId,
                'reason' => 'POS Sale',
                'user_id' => session()->get('user_id'),
            ]);
        }

        $db->transCommit();
    } catch (\Throwable $e) {
        $db->transRollback();
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => $e->getMessage()]);
    }

    $logModel->addLog('New Sale: ' . $receiptNo, 'ADD');

    return $this->response->setJSON([
        'success' => true,
        'sale_id' => $saleId,
        'receipt_no' => $receiptNo,
    ]);
}

    private function generateReceiptNo(): string
{
    $stamp = date('YmdHis');
    $rand = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
    return 'J\'s-' . $stamp . '-' . $rand;
}
}


<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicineModel extends Model
{
    protected $table      = 'medicines';
    protected $primaryKey = 'medicine_id';

    protected $allowedFields = [
        'medicine_name',
        'quantity',
        'expiry_date',
        'date_received',
    ];

    // ─── DataTable fetch ────────────────────────────────────────────────────────

    public function getRecords($start, $length, $searchValue = '')
    {
        $builder = $this->builder();
        $builder->select('*');

        if (!empty($searchValue)) {
            $builder->groupStart()
                ->orLike('medicine_name', $searchValue)
                ->groupEnd();
        }

        $filteredBuilder   = clone $builder;
        $filteredRecords   = $filteredBuilder->countAllResults();

        $builder->limit($length, $start);
        $data = $builder->get()->getResultArray();

        return ['data' => $data, 'filtered' => $filteredRecords];
    }

    // ─── Inventory helpers ───────────────────────────────────────────────────────

    /**
     * Deduct stock from a medicine.
     * Returns false if there is not enough stock.
     */
    public function deductStock(int $medicineId, int $qty): bool
    {
        $medicine = $this->find($medicineId);
        if (!$medicine || $medicine['quantity'] < $qty) {
            return false;
        }

        $this->update($medicineId, [
            'quantity' => $medicine['quantity'] - $qty,
        ]);

        return true;
    }

    /**
     * Get all medicines with stock below the given threshold.
     */
    public function getLowStock(int $threshold = 5): array
    {
        return $this->where('quantity <', $threshold)
                    ->where('quantity >', 0)
                    ->orderBy('quantity', 'ASC')
                    ->findAll();
    }

    /**
     * Count medicines with stock below the given threshold.
     */
    public function countLowStock(int $threshold = 5): int
    {
        return $this->where('quantity <', $threshold)->countAllResults();
    }

    /**
     * Get medicines that are already expired.
     */
    public function getExpired(): array
    {
        return $this->where('expiry_date <', date('Y-m-d'))
                    ->orderBy('expiry_date', 'ASC')
                    ->findAll();
    }

    /**
     * Get medicines expiring within the next $days days (but not yet expired).
     */
    public function getExpiringSoon(int $days = 7): array
    {
        $today  = date('Y-m-d');
        $soon   = date('Y-m-d', strtotime("+{$days} days"));

        return $this->where('expiry_date >=', $today)
                    ->where('expiry_date <=', $soon)
                    ->orderBy('expiry_date', 'ASC')
                    ->findAll();
    }

    /**
     * Restore (add back) stock to a medicine.
     */
    public function restoreStock(int $medicineId, int $qty): void
    {
        $medicine = $this->find($medicineId);
        if (!$medicine) {
            return;
        }

        $this->update($medicineId, [
            'quantity' => $medicine['quantity'] + $qty,
        ]);
    }
}
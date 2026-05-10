<?php

namespace App\Models;

use CodeIgniter\Model;

class RecordMedicineModel extends Model
{
    protected $table      = 'record_medicines';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'record_id',
        'medicine_id',
        'quantity_given',
    ];

    /**
     * Get all medicines for a given medical record,
     * joined with the medicines table for the name.
     */
    public function getByRecord(int $recordId): array
    {
        return $this->db->table('record_medicines')
            ->select('record_medicines.*, medicines.medicine_name, medicines.quantity AS stock_remaining')
            ->join('medicines', 'medicines.medicine_id = record_medicines.medicine_id', 'left')
            ->where('record_medicines.record_id', $recordId)
            ->get()
            ->getResultArray();
    }

    /**
     * Replace all medicines for a record:
     * 1. Restore old stock, 2. Delete old rows, 3. Deduct new stock, 4. Insert new rows.
     */
    public function syncMedicines(int $recordId, array $medicines, \App\Models\MedicineModel $medicineModel): array
    {
        $errors = [];

        // Restore stock for previously recorded medicines
        $existing = $this->where('record_id', $recordId)->findAll();
        foreach ($existing as $row) {
            $medicineModel->restoreStock((int) $row['medicine_id'], (int) $row['quantity_given']);
        }

        // Remove old rows
        $this->where('record_id', $recordId)->delete();

        // Insert new rows and deduct stock
        foreach ($medicines as $med) {
            $medId = (int) ($med['medicine_id'] ?? 0);
            $qty   = (int) ($med['quantity_given'] ?? 1);

            if ($medId <= 0 || $qty <= 0) {
                continue;
            }

            $ok = $medicineModel->deductStock($medId, $qty);
            if (!$ok) {
                $info = $medicineModel->find($medId);
                $name = $info['medicine_name'] ?? "Medicine #$medId";
                $errors[] = "Insufficient stock for $name (requested: $qty, available: " . ($info['quantity'] ?? 0) . ").";
                continue;
            }

            $this->insert([
                'record_id'      => $recordId,
                'medicine_id'    => $medId,
                'quantity_given' => $qty,
            ]);
        }

        return $errors;
    }

    /**
     * Restore all stock for a record and delete its medicine rows.
     * Called when a medical record is deleted.
     */
    public function restoreAndDeleteByRecord(int $recordId, \App\Models\MedicineModel $medicineModel): void
    {
        $rows = $this->where('record_id', $recordId)->findAll();
        foreach ($rows as $row) {
            $medicineModel->restoreStock((int) $row['medicine_id'], (int) $row['quantity_given']);
        }
        $this->where('record_id', $recordId)->delete();
    }
}
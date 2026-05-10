<?php

namespace App\Controllers;

use App\Models\PatientModel;
use App\Models\UserModel;
use App\Models\MedicalRecordModel;
use App\Models\MedicineModel;
use App\Models\RecordMedicineModel;
use App\Models\LogModel;
use CodeIgniter\Controller;

class MedicalRecord extends Controller
{

    public function index()
    {
        $patientModel  = new PatientModel();
        $userModel     = new UserModel();
        $medicineModel = new MedicineModel();

        $data = [
            'patients' => $patientModel->findAll(),
            'users'    => $userModel->whereIn('role', ['Doctor', 'Nurse'])->findAll(),
            'medicines' => $medicineModel->where('quantity >', 0)->findAll(), // only in-stock
        ];

        return view('medical_record/index', $data);
    }


    public function save()
    {
        $model        = new MedicalRecordModel();
        $rmModel      = new RecordMedicineModel();
        $medModel     = new MedicineModel();
        $logModel     = new LogModel();

        $data = [
            'patient_id'      => $this->request->getPost('patient_id'),
            'user_id'         => $this->request->getPost('user_id'),
            'date_consulted'  => $this->request->getPost('date_consulted'),
            'chief_complaint' => $this->request->getPost('chief_complaint'),
            'diagnosis'       => $this->request->getPost('diagnosis'),
            'treatment'       => $this->request->getPost('treatment'),
            'remarks'         => $this->request->getPost('remarks'),
        ];

        $recordId = $model->insert($data, true);

        if (!$recordId) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Failed to save medical record.',
            ]);
        }

        // Handle medicines given
        $medicines = $this->parseMedicinesFromPost();
        $errors    = [];

        if (!empty($medicines)) {
            $errors = $rmModel->syncMedicines($recordId, $medicines, $medModel);
        }

        $logModel->addLog('Added medical record for patient ID: ' . $data['patient_id'], 'ADD');

        if (!empty($errors)) {
            return $this->response->setJSON([
                'status'   => 'warning',
                'message'  => 'Record saved but some medicines had issues: ' . implode(' ', $errors),
            ]);
        }

        return $this->response->setJSON(['status' => 'success']);
    }


    public function edit($id)
    {
        $model   = new MedicalRecordModel();
        $rmModel = new RecordMedicineModel();

        $builder = $model->db->table('medical_records');
        $builder->select('medical_records.*, patients.name as patient_name, users.name as doctor_name');
        $builder->join('patients', 'patients.patient_id = medical_records.patient_id', 'left');
        $builder->join('users',    'users.id = medical_records.user_id',               'left');
        $builder->where('medical_records.record_id', $id);

        $data = $builder->get()->getRowArray();

        if (!$data) {
            return $this->response->setStatusCode(404)
                ->setJSON(['error' => 'Record not found']);
        }

        // Attach medicines given for this record
        $data['medicines_given'] = $rmModel->getByRecord((int) $id);

        return $this->response->setJSON(['data' => $data]);
    }


    public function update()
    {
        $model    = new MedicalRecordModel();
        $rmModel  = new RecordMedicineModel();
        $medModel = new MedicineModel();
        $logModel = new LogModel();

        $id = $this->request->getPost('record_id');

        $data = [
            'patient_id'      => $this->request->getPost('patient_id'),
            'user_id'         => $this->request->getPost('user_id'),
            'date_consulted'  => $this->request->getPost('date_consulted'),
            'chief_complaint' => $this->request->getPost('chief_complaint'),
            'diagnosis'       => $this->request->getPost('diagnosis'),
            'treatment'       => $this->request->getPost('treatment'),
            'remarks'         => $this->request->getPost('remarks'),
        ];

        if (!$model->update($id, $data)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Update failed.',
            ]);
        }

        // Sync medicines (restores old stock, deducts new stock)
        $medicines = $this->parseMedicinesFromPost();
        $errors    = $rmModel->syncMedicines((int) $id, $medicines, $medModel);

        $logModel->addLog('Updated medical record ID: ' . $id, 'UPDATE');

        if (!empty($errors)) {
            return $this->response->setJSON([
                'status'  => 'warning',
                'message' => 'Record updated but some medicines had issues: ' . implode(' ', $errors),
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Medical record updated successfully.',
        ]);
    }


    public function delete($id)
    {
        $model    = new MedicalRecordModel();
        $rmModel  = new RecordMedicineModel();
        $medModel = new MedicineModel();
        $logModel = new LogModel();

        $record = $model->find($id);

        if (!$record) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Record not found.',
            ]);
        }

        // Restore stock before deleting
        $rmModel->restoreAndDeleteByRecord((int) $id, $medModel);

        if ($model->delete($id)) {
            $logModel->addLog('Deleted medical record ID: ' . $id, 'DELETE');

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Record deleted successfully.',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Failed to delete record.',
        ]);
    }


    public function fetchRecords()
    {
        $request = service('request');
        $model   = new MedicalRecordModel();

        $start       = $request->getPost('start')           ?? 0;
        $length      = $request->getPost('length')          ?? 10;
        $searchValue = $request->getPost('search')['value'] ?? '';

        $totalRecords = $model->countAll();
        $result       = $model->getRecords($start, $length, $searchValue);

        $data    = [];
        $counter = $start + 1;

        foreach ($result['data'] as $row) {
            $row['row_number'] = $counter++;
            $data[] = $row;
        }

        return $this->response->setJSON([
            'draw'            => intval($request->getPost('draw')),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $result['filtered'],
            'data'            => $data,
        ]);
    }


    public function view($id)
    {
        $model   = new MedicalRecordModel();
        $rmModel = new RecordMedicineModel();

        $builder = $model->db->table('medical_records');
        $builder->select('medical_records.*, patients.name as patient_name, users.name as doctor_name');
        $builder->join('patients', 'patients.patient_id = medical_records.patient_id', 'left');
        $builder->join('users',    'users.id = medical_records.user_id',               'left');
        $builder->where('medical_records.record_id', $id);

        $data = $builder->get()->getRowArray();

        if (!$data) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Not found']);
        }

        $data['medicines_given'] = $rmModel->getByRecord((int) $id);

        return $this->response->setJSON(['data' => $data]);
    }


    public function print($id)
    {
        $model   = new MedicalRecordModel();
        $rmModel = new RecordMedicineModel();

        $builder = $model->db->table('medical_records');
        $builder->select('medical_records.*, patients.name as patient_name, users.name as doctor_name');
        $builder->join('patients', 'patients.patient_id = medical_records.patient_id', 'left');
        $builder->join('users',    'users.id = medical_records.user_id',               'left');
        $builder->where('medical_records.record_id', $id);

        $record = $builder->get()->getRowArray();

        if (!$record) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Record not found');
        }

        $record['medicines_given'] = $rmModel->getByRecord((int) $id);

        return view('medical_record/print', ['record' => $record]);
    }


    // ─── Helper ─────────────────────────────────────────────────────────────────

    /**
     * Parse medicines[] and quantities[] arrays from POST into a structured array.
     * Expects: medicines[0][medicine_id], medicines[0][quantity_given], ...
     */
    private function parseMedicinesFromPost(): array
    {
        $raw = $this->request->getPost('medicines');
        if (empty($raw) || !is_array($raw)) {
            return [];
        }

        $result = [];
        foreach ($raw as $item) {
            $medId = (int) ($item['medicine_id']    ?? 0);
            $qty   = (int) ($item['quantity_given'] ?? 0);
            if ($medId > 0 && $qty > 0) {
                $result[] = ['medicine_id' => $medId, 'quantity_given' => $qty];
            }
        }
        return $result;
    }
}
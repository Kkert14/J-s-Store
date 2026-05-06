<?php

namespace App\Controllers;

use App\Models\PatientModel;
use App\Models\UserModel;
use App\Models\MedicalRecordModel;
use App\Models\LogModel;
use CodeIgniter\Controller;

class MedicalRecord extends Controller
{
 
    public function index()
    {
        $patientModel = new PatientModel();
        $userModel    = new UserModel();

        $data = [
            'patients' => $patientModel->findAll(),
            'users'    => $userModel->whereIn('role', ['Doctor', 'Nurse'])->findAll()
        ];

        return view('medical_record/index', $data);
    }


    public function save()
    {
        $model    = new MedicalRecordModel();
        $logModel = new LogModel();

        $data = [
            'patient_id'      => $this->request->getPost('patient_id'),
            'user_id'         => $this->request->getPost('user_id'),
            'date_consulted'  => $this->request->getPost('date_consulted'),
            'chief_complaint' => $this->request->getPost('chief_complaint'),
            'diagnosis'       => $this->request->getPost('diagnosis'),
            'treatment'       => $this->request->getPost('treatment'),
            'remarks'         => $this->request->getPost('remarks'),
        ];

        if ($model->insert($data)) {
            $logModel->addLog('Added medical record for patient ID: ' . $data['patient_id'], 'ADD');

            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Failed to save medical record'
        ]);
    }

    public function edit($id)
    {
        $model = new MedicalRecordModel();

   
        $builder = $model->db->table('medical_records');
        $builder->select('
            medical_records.*,
            patients.name as patient_name,
            users.name as doctor_name
        ');
        $builder->join('patients', 'patients.patient_id = medical_records.patient_id', 'left');
        $builder->join('users',    'users.id = medical_records.user_id',               'left');
        $builder->where('medical_records.record_id', $id);

        $data = $builder->get()->getRowArray(); 

        if ($data) {
            return $this->response->setJSON(['data' => $data]);
        }

        return $this->response->setStatusCode(404)
            ->setJSON(['error' => 'Record not found']);
    }

   
    public function update()
    {
        $model    = new MedicalRecordModel();
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

        if ($model->update($id, $data)) {
            $logModel->addLog('Updated medical record ID: ' . $id, 'UPDATE');

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Medical record updated successfully'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Update failed'
        ]);
    }

   
    public function delete($id)
    {
        $model    = new MedicalRecordModel();
        $logModel = new LogModel();

        $record = $model->find($id);

        if (!$record) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Record not found'
            ]);
        }

        if ($model->delete($id)) {
            $logModel->addLog('Deleted medical record ID: ' . $id, 'DELETE');

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Record deleted successfully'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Failed to delete record'
        ]);
    }

    public function fetchRecords()
    {
        $request = service('request'); 

        $model = new MedicalRecordModel();

        $start       = $request->getPost('start')          ?? 0;
        $length      = $request->getPost('length')         ?? 10;
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

  
       //VIEW
  
    public function view($id)
    {
        $model = new MedicalRecordModel();

        $builder = $model->db->table('medical_records');
        $builder->select('
            medical_records.*,
            patients.name as patient_name,
            users.name as doctor_name
        ');
        $builder->join('patients', 'patients.patient_id = medical_records.patient_id', 'left');
        $builder->join('users',    'users.id = medical_records.user_id',               'left');
        $builder->where('medical_records.record_id', $id);

        $data = $builder->get()->getRowArray();

        if ($data) {
            return $this->response->setJSON(['data' => $data]);
        }

        return $this->response->setStatusCode(404)
            ->setJSON(['error' => 'Not found']);
    }

  
      // PRINT
  
    public function print($id)
    {
        $model = new MedicalRecordModel();

        $builder = $model->db->table('medical_records');
        $builder->select('
            medical_records.*,
            patients.name as patient_name,
            users.name as doctor_name
        ');
        $builder->join('patients', 'patients.patient_id = medical_records.patient_id', 'left');
        $builder->join('users',    'users.id = medical_records.user_id',               'left');
        $builder->where('medical_records.record_id', $id);

        $record = $builder->get()->getRowArray();

        if (!$record) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Record not found');
        }

        return view('medical_record/print', ['record' => $record]);
    }

   
}

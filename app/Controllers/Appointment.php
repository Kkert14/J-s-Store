<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\LogModel;
use CodeIgniter\Controller;

class Appointment extends Controller
{
   
    public function index()
{
    $appointmentModel = new AppointmentModel();
    $patientModel = new \App\Models\PatientModel();
    $userModel = new \App\Models\UserModel();

    $data = [
        'appointment' => $appointmentModel->findAll(),
        'patients' => $patientModel->findAll(),
        'users' => $userModel->findAll()
    ];

    return view('appointment/index', $data);
}

  
    public function save()
    {
        $model = new AppointmentModel();
        $logModel = new LogModel();

        $data = [
            'patient_id'        => $this->request->getPost('patient_id'),
            'user_id'           => $this->request->getPost('user_id'),
            'appointment_date'  => $this->request->getPost('appointment_date'),
            'status'            => $this->request->getPost('status'),
            'notes'             => $this->request->getPost('notes'),
        ];

        if ($model->insert($data)) {
            $logModel->addLog('Added appointment for patient ID: ' . $data['patient_id'], 'ADD');

            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to save appointment'
        ]);
    }


    public function update()
    {
        $model = new AppointmentModel();
        $logModel = new LogModel();

        $id = $this->request->getPost('appointment_id');

        $data = [
            'patient_id'        => $this->request->getPost('patient_id'),
            'user_id'           => $this->request->getPost('user_id'),
            'appointment_date'  => $this->request->getPost('appointment_date'),
            'status'            => $this->request->getPost('status'),
            'notes'             => $this->request->getPost('notes'),
        ];

        if ($model->update($id, $data)) {
            $logModel->addLog('Updated appointment ID: ' . $id, 'UPDATE');

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Appointment updated successfully'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Error updating appointment'
        ]);
    }

 
    public function edit($id)
{
    $model = new AppointmentModel();

    $builder = $model->db->table('appointments');
    $builder->select('
        appointments.*,
        patients.name as patient_name,
        users.name as user_name
    ');
    $builder->join('patients', 'patients.patient_id = appointments.patient_id', 'left');
    $builder->join('users', 'users.id = appointments.user_id', 'left');
    $builder->where('appointments.appointment_id', $id);

    $data = $builder->get()->getRowArray();

    if ($data) {
        return $this->response->setJSON(['data' => $data]);
    }

    return $this->response->setStatusCode(404)
        ->setJSON(['error' => 'Appointment not found']);
}

   
    public function delete($id)
    {
        $model = new AppointmentModel();
        $logModel = new LogModel();

        $appointment = $model->find($id);

        if (!$appointment) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Appointment not found'
            ]);
        }

        if ($model->delete($id)) {
            $logModel->addLog('Deleted appointment ID: ' . $id, 'DELETE');

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Appointment deleted successfully'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to delete appointment'
        ]);
    }

    public function fetchRecords()
    {
        $request = service('request');
        $model = new AppointmentModel();

        $start = $request->getPost('start') ?? 0;
        $length = $request->getPost('length') ?? 10;
        $searchValue = $request->getPost('search')['value'] ?? '';

        $totalRecords = $model->countAll();
        $result = $model->getRecords($start, $length, $searchValue);

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
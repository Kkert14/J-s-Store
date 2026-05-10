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
        $patientModel     = new \App\Models\PatientModel();
        $userModel        = new \App\Models\UserModel();

        $data = [
            'appointment' => $appointmentModel->findAll(),
            'patients'    => $patientModel->findAll(),
            'users'       => $userModel->findAll(),
        ];

        return view('appointment/index', $data);
    }

    public function save()
    {
        $model    = new AppointmentModel();
        $logModel = new LogModel();

        $datetime  = $this->request->getPost('appointment_date');
        $userId    = (int) $this->request->getPost('user_id');
        $patientId = (int) $this->request->getPost('patient_id');

        // Conflict check
        $conflicts = $model->checkConflicts($datetime, $userId, $patientId);
        if (!empty($conflicts)) {
            return $this->response->setJSON([
                'status'    => 'conflict',
                'conflicts' => $conflicts,
            ]);
        }

        $data = [
            'patient_id'       => $patientId,
            'user_id'          => $userId,
            'appointment_date' => $datetime,
            'status'           => $this->request->getPost('status') ?: 'pending',
            'notes'            => $this->request->getPost('notes'),
        ];

        if ($model->insert($data)) {
            $logModel->addLog('Added appointment for patient ID: ' . $patientId, 'ADD');
            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save appointment.']);
    }

    public function update()
    {
        $model    = new AppointmentModel();
        $logModel = new LogModel();

        $id        = $this->request->getPost('appointment_id');
        $datetime  = $this->request->getPost('appointment_date');
        $userId    = (int) $this->request->getPost('user_id');
        $patientId = (int) $this->request->getPost('patient_id');

        // Conflict check (exclude current record)
        $conflicts = $model->checkConflicts($datetime, $userId, $patientId, (int) $id);
        if (!empty($conflicts)) {
            return $this->response->setJSON([
                'status'    => 'conflict',
                'conflicts' => $conflicts,
            ]);
        }

        $data = [
            'patient_id'       => $patientId,
            'user_id'          => $userId,
            'appointment_date' => $datetime,
            'status'           => $this->request->getPost('status'),
            'notes'            => $this->request->getPost('notes'),
        ];

        if ($model->update($id, $data)) {
            $logModel->addLog('Updated appointment ID: ' . $id, 'UPDATE');
            return $this->response->setJSON(['status' => 'success', 'message' => 'Appointment updated.']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Error updating appointment.']);
    }

    public function edit($id)
    {
        $model   = new AppointmentModel();
        $builder = $model->db->table('appointments');

        $builder->select('appointments.*, patients.name as patient_name, users.name as user_name');
        $builder->join('patients', 'patients.patient_id = appointments.patient_id', 'left');
        $builder->join('users',    'users.id = appointments.user_id', 'left');
        $builder->where('appointments.appointment_id', $id);

        $data = $builder->get()->getRowArray();

        if ($data) {
            return $this->response->setJSON(['data' => $data]);
        }

        return $this->response->setStatusCode(404)->setJSON(['error' => 'Appointment not found']);
    }

    public function delete($id)
    {
        $model    = new AppointmentModel();
        $logModel = new LogModel();

        if (!$model->find($id)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Appointment not found.']);
        }

        if ($model->delete($id)) {
            $logModel->addLog('Deleted appointment ID: ' . $id, 'DELETE');
            return $this->response->setJSON(['status' => 'success', 'message' => 'Appointment deleted.']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete appointment.']);
    }

    // Quick status update from table row dropdown
    public function updateStatus()
    {
        $model    = new AppointmentModel();
        $logModel = new LogModel();

        $id     = $this->request->getPost('appointment_id');
        $status = $this->request->getPost('status');

        $allowed = ['pending', 'confirmed', 'completed', 'cancelled'];
        if (!in_array($status, $allowed)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid status.']);
        }

        if ($model->update($id, ['status' => $status])) {
            $logModel->addLog("Appointment ID {$id} status changed to {$status}", 'UPDATE');
            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update status.']);
    }

    public function fetchRecords()
    {
        $request = service('request');
        $model   = new AppointmentModel();

        $start       = $request->getPost('start')           ?? 0;
        $length      = $request->getPost('length')          ?? 10;
        $searchValue = $request->getPost('search')['value'] ?? '';

        $orderColumnIndex = $request->getPost('order')[0]['column'] ?? 4;
        $orderDir         = $request->getPost('order')[0]['dir']    ?? 'asc';

        $columns = [
            2 => 'patients.name',
            3 => 'users.name',
            4 => 'appointments.appointment_date',
            5 => 'appointments.status',
        ];

        $orderColumn = $columns[$orderColumnIndex] ?? 'appointments.appointment_date';

        $totalRecords = $model->countAll();
        $result       = $model->getRecords($start, $length, $searchValue, $orderColumn, $orderDir);

        $data    = [];
        $counter = $start + 1;
        $today   = date('Y-m-d');

        foreach ($result['data'] as $row) {
            $row['row_number'] = $counter++;
            $row['is_today']   = (date('Y-m-d', strtotime($row['appointment_date'])) === $today);
            $data[] = $row;
        }

        return $this->response->setJSON([
            'draw'            => intval($request->getPost('draw')),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $result['filtered'],
            'data'            => $data,
        ]);
    }

    // Calendar data endpoint
    public function calendarData()
    {
        $model = new AppointmentModel();
        $year  = $this->request->getGet('year')  ?? date('Y');
        $month = $this->request->getGet('month') ?? date('m');

        $appointments = $model->getForMonth($year, $month);
        return $this->response->setJSON($appointments);
    }
}
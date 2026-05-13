<?php

namespace App\Controllers;

use App\Models\PatientModel;
use CodeIgniter\Controller;
use App\Models\LogModel;

class Patient extends Controller
{
    public function index()
{
    $model         = new PatientModel();
    $guardianModel = new \App\Models\GuardianModel();

    $data = [
        'patient' => $model->findAll(),
        'parents' => $guardianModel->findAll(),
    ];

    return view('patient/index', $data);
}

    public function save()
{
    $name        = $this->request->getPost('name');
    $last_name   = $this->request->getPost('last_name');
    $middle_name = $this->request->getPost('middle_name');
    $sex         = $this->request->getPost('sex');
    $age         = $this->request->getPost('age');
    $birthdate   = $this->request->getPost('birthdate');
    $contact     = $this->request->getPost('contact');
    $department  = $this->request->getPost('department');

    $parent_id       = $this->request->getPost('parent_id');
    $relationship    = $this->request->getPost('relationship');
    if ($parent_id === '__new__') {
        $parent_id = null;
    }

    // New parent fields (if creating inline)
    $new_parent_name        = $this->request->getPost('new_parent_name');
    $new_parent_last_name   = $this->request->getPost('new_parent_last_name');
    $new_parent_middle_name = $this->request->getPost('new_parent_middle_name');
    $new_parent_contact     = $this->request->getPost('new_parent_contact');
    $new_parent_address     = $this->request->getPost('new_parent_address');

    $patientModel  = new \App\Models\PatientModel();
    $guardianModel = new \App\Models\GuardianModel();
    $logModel      = new LogModel();
    $db            = \Config\Database::connect();

    $data = [
        'name'        => $name,
        'last_name'   => $last_name,
        'middle_name' => $middle_name,
        'sex'         => $sex,
        'age'         => $age,
        'birthdate'   => $birthdate,
        'contact'     => $contact,
        'department'  => $department,
    ];

    $db->transBegin();

    try {
        $patientId = $patientModel->insert($data, true);
        if (!$patientId) {
            throw new \RuntimeException('Failed to save patient');
        }

        if (!empty($new_parent_name) && empty($parent_id)) {
            $parent_id = $guardianModel->insert([
                'name'        => $new_parent_name,
                'last_name'   => $new_parent_last_name,
                'middle_name' => $new_parent_middle_name,
                'contact'     => $new_parent_contact,
                'address'     => $new_parent_address,
            ], true);

            if (!$parent_id) {
                throw new \RuntimeException('Failed to save parent');
            }
        }

        if (!empty($parent_id)) {
            $ok = $this->insertPatientParentLink($db, (int) $patientId, (int) $parent_id, $relationship);
            if (!$ok) {
                $err = $db->error();
                throw new \RuntimeException($err['message'] ?? 'Failed to link parent');
            }
        }

        $db->transCommit();
    } catch (\Throwable $e) {
        $db->transRollback();
        return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
    }

    $logModel->addLog('New Record has been added: ' . $name, 'ADD');
    return $this->response->setJSON(['status' => 'success']);
}

    public function update(){
        $model = new PatientModel();
        $guardianModel = new \App\Models\GuardianModel();
        $logModel = new LogModel();
        $db = \Config\Database::connect();

        $userId = $this->request->getPost('patient_id');
        $name = $this->request->getPost('name');
        $last_name = $this->request->getPost('last_name');
        $middle_name = $this->request->getPost('middle_name');
        $sex = $this->request->getPost('sex');
        $age = $this->request->getPost('age');
        $birthdate = $this->request->getPost('birthdate');
        $contact = $this->request->getPost('contact');
        $department = $this->request->getPost('department');

        $parent_id = $this->request->getPost('parent_id');
        $relationship = $this->request->getPost('relationship');
        if ($parent_id === '__new__') {
            $parent_id = null;
        }

        $new_parent_name = $this->request->getPost('new_parent_name');
        $new_parent_last_name = $this->request->getPost('new_parent_last_name');
        $new_parent_middle_name = $this->request->getPost('new_parent_middle_name');
        $new_parent_contact = $this->request->getPost('new_parent_contact');
        $new_parent_address = $this->request->getPost('new_parent_address');

        $userData = [
            'name' => $name,
            'last_name' => $last_name,
            'middle_name' => $middle_name,
            'sex' => $sex,
            'age' => $age,
            'birthdate' => $birthdate,
            'contact' => $contact,
            'department' => $department,
        ];

        $db->transStart();

        $updated = $model->update($userId, $userData);
        if (!$updated) {
            $db->transRollback();
            $modelErrs = $model->errors();
            $dbErr = $model->db->error();
            $msg = !empty($modelErrs)
                ? implode(' ', $modelErrs)
                : ($dbErr['message'] ?? 'Error updating record.');
            return $this->response->setJSON([
                'success' => false,
                'message' => $msg
            ]);
        }

        if (!empty($new_parent_name) && empty($parent_id)) {
            $parent_id = $guardianModel->insert([
                'name' => $new_parent_name,
                'last_name' => $new_parent_last_name,
                'middle_name' => $new_parent_middle_name,
                'contact' => $new_parent_contact,
                'address' => $new_parent_address,
            ], true);

            if (!$parent_id) {
                $db->transRollback();
                $err = $guardianModel->db->error();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $err['message'] ?? 'Failed to save parent.'
                ]);
            }
        }

        $db->table('patient_parents')->where('patient_id', $userId)->delete();

        if (!empty($parent_id)) {
            $ok = $this->insertPatientParentLink($db, (int) $userId, (int) $parent_id, $relationship);
            if (!$ok) {
                $db->transRollback();
                $err = $db->error();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $err['message'] ?? 'Failed to update patient parent link.'
                ]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            $err = $db->error();
            return $this->response->setJSON([
                'success' => false,
                'message' => $err['message'] ?? 'Error updating record.'
            ]);
        }

        $logModel->addLog('Patient record has been updated: ' . $name, 'UPDATED');
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Record updated successfully.'
        ]);
    }

    private function insertPatientParentLink($db, int $patientId, int $parentId, ?string $relationship): bool
{
    $payload = [
        'patient_id'   => $patientId,
        'parent_id'    => $parentId,
        'relationship' => $relationship,
    ];

    $shouldFallback = false;

    try {
        $ok = $db->table('patient_parents')->insert($payload);
        if ($ok) {
            return true;
        }
    } catch (\Throwable $e) {
        $msg = $e->getMessage();
        if (strpos($msg, "Duplicate entry '0'") !== false || strpos($msg, "doesn't have a default value") !== false) {
            $shouldFallback = true;
        } else {
            return false;
        }
    }

    $err = $db->error();
    $errMsg = (string) ($err['message'] ?? '');
    if (
        strpos($errMsg, "Duplicate entry '0'") !== false ||
        strpos($errMsg, "doesn't have a default value") !== false
    ) {
        $shouldFallback = true;
    } elseif (!$shouldFallback) {
        return false;
    }

    $row = $db->table('patient_parents')->selectMax('id', 'max_id')->get()->getRowArray();
    $nextId = ((int) ($row['max_id'] ?? 0)) + 1;

    try {
        return (bool) $db->table('patient_parents')->insert(array_merge(['id' => $nextId], $payload));
    } catch (\Throwable $e) {
        return false;
    }
}

    public function edit($id){
        $model = new PatientModel();
        $user = $model->find($id);

        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'User not found']);
        }

        $db = \Config\Database::connect();
        $parentLink = $db->table('patient_parents')
            ->select('parent_id, relationship')
            ->where('patient_id', $id)
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();

        if (!empty($parentLink)) {
            $user['parent_id'] = $parentLink['parent_id'];
            $user['relationship'] = $parentLink['relationship'];
        }

        return $this->response->setJSON(['data' => $user]);
}

public function delete($id){
    $model = new PatientModel();
    $logModel = new LogModel();
    $user = $model->find($id);
    if (!$user) {
        return $this->response->setJSON(['success' => false, 'message' => 'Record not found.']);
    }

    $deleted = $model->delete($id);

    if ($deleted) {
        $logModel->addLog('Delete Record', 'DELETED');
        return $this->response->setJSON(['success' => true, 'message' => 'Record deleted successfully.']);
    } else {
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete Record.']);
    }
}

public function fetchRecords()
{
    $request = service('request');
    $model = new \App\Models\PatientModel();

    $start = $request->getPost('start') ?? 0;
    $length = $request->getPost('length') ?? 10;
    $searchValue = $request->getPost('search')['value'] ?? '';

    //Sorting part
    $orderColumnIndex = $request->getPost('order')[0]['column'] ?? 2;
    $orderDir = $request->getPost('order')[0]['dir'] ?? 'asc';

    $columns = [
        1 => 'p.patient_id',
        2 => 'p.last_name',
        3 => 'p.name',
        4 => 'p.middle_name',
        5 => 'p.sex',
        6 => 'p.age',
        7 => 'p.birthdate',
        8 => 'p.contact',
        10 => 'p.department',
    ];

    $orderColumn = $columns[$orderColumnIndex] ?? 'p.last_name';

    $totalRecords = $model->countAll();

    $result = $model->getRecords(
        $start,
        $length,
        $searchValue,
        $orderColumn,
        $orderDir
    );

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

public function view($id)
{
    $model = new PatientModel();
    $patient = $model->find($id);

    if (!$patient) {
        return $this->response->setJSON(['data' => null]);
    }

    $db = \Config\Database::connect();

    // MULTIPLE parents support
    $parents = $db->table('patient_parents pp')
        ->select('p.name, p.last_name, p.middle_name, p.contact, p.address, pp.relationship')
        ->join('parents p', 'p.parent_id = pp.parent_id', 'left')
        ->where('pp.patient_id', $id)
        ->get()
        ->getResultArray();

    $patient['parents'] = $parents;

    return $this->response->setJSON(['data' => $patient]);
}

// public function print($id)
// {
//     $model = new PatientModel();
//     $data['patient'] = $model->find($id);

//     return view('patient/print', $data);
// }

public function print($id)
{
    $model = new PatientModel();
    $db = \Config\Database::connect();

    // Patient
    $data['patient'] = $model->find($id);

    if (!$data['patient']) {
        return redirect()->back();
    }

    // Parents (CONNECTED VERSION)
    $data['parents'] = $db->table('patient_parents pp')
        ->select('p.name, p.last_name, p.middle_name, p.contact, p.address, pp.relationship')
        ->join('parents p', 'p.parent_id = pp.parent_id', 'left')
        ->where('pp.patient_id', $id)
        ->get()
        ->getResultArray();

    // Optional: medical records if you use them
    $data['records'] = $db->table('medical_records')
        ->where('patient_id', $id)
        ->get()
        ->getResultArray();

    return view('patient/print', $data);
}
}

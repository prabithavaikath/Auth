<?php
namespace App\Controllers;

use App\Models\RecordModel;
use CodeIgniter\RESTful\ResourceController;

class SuperAdminController extends ResourceController
{
    protected $recordModel;

    public function __construct()
    {
        $this->recordModel = new RecordModel();
    }

    // View all records (SuperAdmin can view all)
    public function view()
    {
        $records = $this->recordModel->getAllRecords();
        return $this->respond($records, 200);
    }

    // Add a new record (SuperAdmin can add)
    public function add()
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'created_by' => 'SuperAdmin',
            'created_at' => date('Y-m-d H:i:s')
        ];
    
        $this->recordModel->addRecord($data);
    
        // Send Email Notification
        $email = \Config\Services::email();
        $email->setTo('admin@example.com');  // Set appropriate email
        $email->setSubject('Record Added');
        $email->setMessage('A new record has been added by SuperAdmin.');
        $email->send();
    
        return $this->respond(['message' => 'Record added successfully'], 201);
    }
    

    // Update a record (SuperAdmin can update)
    public function update($id)
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];

        $updated = $this->recordModel->updateRecord($id, $data);
        if ($updated) {
            return $this->respond(['message' => 'Record updated successfully'], 200);
        }
        return $this->respond(['message' => 'Record not found'], 404);
    }

    // Delete a record (SuperAdmin can delete)
    public function delete($id)
    {
        $deleted = $this->recordModel->deleteRecord($id);
        if ($deleted) {
            return $this->respond(['message' => 'Record deleted successfully'], 200);
        }
        return $this->respond(['message' => 'Record not found'], 404);
    }
}

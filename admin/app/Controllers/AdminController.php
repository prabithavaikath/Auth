<?php
namespace App\Controllers;

use App\Models\RecordModel;
use CodeIgniter\RESTful\ResourceController;

class AdminController extends ResourceController
{
    protected $recordModel;

    public function __construct()
    {
        $this->recordModel = new RecordModel();
    }

    // View all records (Admin can view all)
    public function view()
    {
        $records = $this->recordModel->getAllRecords();
        return $this->respond($records, 200);
    }

    // Delete a record (Admin can delete)
    public function delete($id)
    {
        $deleted = $this->recordModel->deleteRecord($id);
        if ($deleted) {
            return $this->respond(['message' => 'Record deleted successfully'], 200);
        }
        return $this->respond(['message' => 'Record not found'], 404);
    }
}

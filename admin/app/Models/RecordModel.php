<?php


namespace App\Models;

use CodeIgniter\Model;

class RecordModel extends Model
{
    protected $table = 'records';  
    protected $primaryKey = 'id';  // Primary key

    // Allowed fields for insert and update operations
    protected $allowedFields = ['name', 'description', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    // Function to get all records
    public function getAllRecords()
    {
        return $this->where('deleted_at', null)->findAll();  // Only return records not soft deleted
    }

    // Function to add a new record
    public function addRecord($data)
    {
        return $this->insert($data);  // Insert data into the table
    }

    // Function to update an existing record
    public function updateRecord($id, $data)
    {
        return $this->update($id, $data);  // Update record based on its ID
    }

    // Function to delete a record (soft delete)
    public function deleteRecord($id)
    {
        $data = ['deleted_at' => date('Y-m-d H:i:s')];  // Soft delete by setting the deleted_at timestamp
        return $this->update($id, $data);
    }
}

<?php
namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface {
    public function getAll()
    {
        return Employee::with('user')->get();
    }

    public function getById($id)
    {
        return Employee::with('user')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Employee::create($data);
    }

    public function update($id, array $data)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($data);

        return $employee;
    }

    public function delete($id)
    {
        return Employee::destroy($id);
    }
}

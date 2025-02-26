<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeRepository;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository) {
        $this->employeeRepository = $employeeRepository;
    }

    public function index() {
        return response()->json($this->employeeRepository->getAll());
    }

    public function show($id) {
        return response()->json($this->employeeRepository->getById($id));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'phone' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required|date',
            'address' => 'required',
            'hire_date' => 'required|date',
        ]);

        return response()->json($this->employeeRepository->create($data), 201);
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'phone' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required|date',
            'address' => 'required',
            'hire_date' => 'required|date',
        ]);

        return response()->json($this->employeeRepository->update($id, $data));
    }

    public function destroy($id) {
        return response()->json($this->employeeRepository->delete($id));
    }
}

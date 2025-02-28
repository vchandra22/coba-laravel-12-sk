<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository) {
        $this->employeeRepository = $employeeRepository;
    }

    public function index() {
        try {
            return response()->json($this->employeeRepository->getAll());
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data karyawan', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id) {
        try {
            $employee = $this->employeeRepository->getById($id);
            if (!$employee) {
                return response()->json(['error' => 'Karyawan tidak ditemukan'], 404);
            }
            return response()->json($employee);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Karyawan tidak ditemukan'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->validate([
                'user_id' => 'required|exists:users,id',
                'phone' => 'required',
                'birth_place' => 'required',
                'birth_date' => 'required|date',
                'address' => 'required',
                'hire_date' => 'required|date',
            ]);

            $employee = $this->employeeRepository->create($data);
            return response()->json($employee, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal menambahkan karyawan', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = $request->validate([
                'phone' => 'required',
                'birth_place' => 'required',
                'birth_date' => 'required|date',
                'address' => 'required',
                'hire_date' => 'required|date',
            ]);

            $employee = $this->employeeRepository->update($id, $data);
            return response()->json($employee);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Karyawan tidak ditemukan'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui karyawan', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id) {
        try {
            $deleted = $this->employeeRepository->delete($id);
            return response()->json(['message' => 'Karyawan berhasil dihapus']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Karyawan tidak ditemukan'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal menghapus karyawan', 'message' => $e->getMessage()], 500);
        }
    }
}

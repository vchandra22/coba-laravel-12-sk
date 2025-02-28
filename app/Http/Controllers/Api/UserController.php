<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        try {
            return response()->json($this->userRepository->getAll());
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data user', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json($this->userRepository->getById($id));
        } catch (Exception $e) {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ]);

            $data['password'] = bcrypt($data['password']);

            return response()->json($this->userRepository->create($data), 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal menambahkan user', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'sometimes|string',
                'email' => 'sometimes|email|unique:users,email,' . $id,
                'password' => 'sometimes|min:6',
            ]);

            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            return response()->json($this->userRepository->update($id, $data));
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui user', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            return response()->json(['message' => 'User berhasil dihapus'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal menghapus user', 'message' => $e->getMessage()], 500);
        }
    }
}

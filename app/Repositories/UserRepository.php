<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function getAll()
    {
        // menggunakan eloquent -> mudah digunakan
        // return User::with('employee')->get();

        // menggunakan querry builder -> performa lebih baik
        $users = DB::table('users')
            ->join('employees', 'users.id', '=', 'employees.user_id')
            ->select('users.*', 'employees.id as employee_id', 'employees.user_id', 'employees.phone',
                'employees.birth_place', 'employees.birth_date', 'employees.address', 'employees.hire_date',
                'employees.created_at as employee_created_at', 'employees.updated_at as employee_updated_at')
            ->get();

        return $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'employee' => [
                    'id' => $user->employee_id,
                    'user_id' => $user->user_id,
                    'phone' => $user->phone,
                    'birth_place' => $user->birth_place,
                    'birth_date' => $user->birth_date,
                    'address' => $user->address,
                    'hire_date' => $user->hire_date,
                    'created_at' => $user->employee_created_at,
                    'updated_at' => $user->employee_updated_at,
                ]
            ];
        });
    }

    public function getById($id)
    {
        return User::with('employee')->findOrFail($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);

        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return true;
    }
}

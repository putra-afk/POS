<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\UserModel;


class UserController extends Controller
{
    public function profile($id, $name)
    {
        return view('user.profile', compact('id', 'name'));
    }

    public function index()
    {
        $data = [
            'level_id' => 2,
            'username' => 'manager_tiga',
            'nama' => 'Manager 3',
            'password' => Hash::make('12345')
        ];

        // Menyimpan data ke dalam tabel m_user
        UserModel::create($data);

        // Ambil semua data dari tabel m_user
        $user = UserModel::all();
        return view("user", ["data" => $user]);
    }
}

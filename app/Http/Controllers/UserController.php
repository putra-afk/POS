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
        // Tambah data user dengan Eloquent Model
        $data = [
            "nama" => "Pelanggan Pertama",
        ];

        UserModel::where("username", "customer-1")->update($data); // Update data user

        // Ambil semua data dari tabel m_user
        $user = UserModel::all();
        return view("user", ["data" => $user]);
    }
}

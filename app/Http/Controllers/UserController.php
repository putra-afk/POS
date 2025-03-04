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
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];

        // Menyimpan data ke dalam tabel m_user
        // UserModel::create($data);

        //$user = UserModel::all();
        // Ambil semua data dari tabel m_user
        //$user = UserModel::find(1);

        // Ambil data dari tabel m_user berdasarkan kolom level_id
        //$user = UserModel::where('level_id', 1)->first();

        // Ambil data dari tabel m_user berdasarkan kolom level_id
        //$user = UserModel::firstWhere('level_id', 1);

        // Ambil data dari tabel m_user berdasarkan kolom level_id
        // $user = UserModel::findOr(20, ['username', 'nama'], function () {
        //     abort(404);
        // });

        // Ambil data dari tabel m_user berdasarkan kolom level_id
        //$user = UserModel::findOrFail(1);

        // Ambil data dari tabel m_user berdasarkan kolom level_id
        //$user = UserModel::where('username', 'manager9')->firstOrFail();
        //return view("user", ["data" => $user]);

        // Menghitung jumlah data dari tabel m_user
        //$user = UserModel::where('level_id', 2)->count();


        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ]
        // );

        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager22',
        //         'nama' => 'Manager Dua Dua',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ]
        // );

        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ]
        // );

        $user = UserModel::firstOrNew(
            [
                'username' => 'manager33',
                'nama' => 'Manager Tiga Tiga',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ]
        );
        $user->save();
        return view("user", ["data" => $user]);
    }
}

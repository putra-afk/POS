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

        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ]
        // );
        // $user->save();
        // return view("user", ["data" => $user]);

        // $user = UserModel::create([
        //     'username' => 'manager55',
        //     'nama' => 'Manager55',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);

        // $user->username = 'manager56';

        // $user->isDirty(); // true
        // $user->isDirty('username'); // true
        // $user->isDirty('nama'); // false
        // $user->isDirty(['nama', 'username']); // true

        // $user->save();

        // $user->isDirty(); // false
        // $user->isDirty('username'); // false
        // $user->isDirty('nama'); // false
        // $user->isDirty(['nama', 'username']); // false

        // $user->isClean(); // true

        // dd($user->isDirty());

        // $user = UserModel::create([
        //     'username' => 'manager11',
        //     'nama' => 'Manager11',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);

        // $user->username = 'manager12';

        // $user->save();

        // $user->wasChanged(); // true
        // $user->wasChanged('username'); // true
        // $user->wasChanged(['username', 'level_id']); // true
        // $user->wasChanged('nama'); // false

        // dd($user->wasChanged(['nama', 'username'])); // true

        $user = UserModel::all();
        return view('user', ['data' => $user]);

        $user = UserModel::with('level')->get();
        return view('user', ['data' => $user]);
    }


    public function tambah()
    {
        return view('user_tambah'); // Load the form view
    }

    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('user'); // Redirect to the user page
    }

    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('user');
    }

    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $user = UserModel::find($id);

        if (!$user) {
            return redirect('user')->with('error', 'User not found');
        }

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make($request->password); // Corrected Hash usage
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('user')->with('success', 'User updated successfully');
    }
}

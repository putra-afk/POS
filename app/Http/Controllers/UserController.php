<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;

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

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        // $user = UserModel::with('level')->get();
        // return view('user', ['data' => $user]);

        $breadcrumb = (object) [
            "title" => "Daftar User",
            "list" => ['Home', 'User']
        ];

        $page = (object) [
            "title" => "Daftar user yang terdaftar dalam sistem"
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        $level = LevelModel::all(); // Ambil data level untuk filter

        $users = UserModel::all();

        return view('user.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level, // Pastikan dikirim ke view
            'activeMenu' => $activeMenu,
            'users' => $users
        ]);
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

    public function list(Request $request)
    {
        $users = UserModel::with('level')->select('user_id', 'username', 'nama', 'level_id');

        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                return '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> '
                    . '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> '
                    . '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin?\');">Hapus</button></form>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menampilkan halaman form tambah user
    public function create()
    {
        $breadcrumb = (object) [
            "title" => "Tambah User",
            "list" => ["Home", "User", "Tambah"]
        ];

        $page = (object) [
            "title" => "Tambah user baru"
        ];

        $level = LevelModel::all(); // Ambil data level untuk ditampilkan di form
        $activeMenu = "user"; // Set menu yang sedang aktif

        return view('user.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'username' => 'required|string|min:3|unique:m_user,username',
            // nama harus diisi, berupa string, dan maksimal 100 karakter
            'nama' => 'required|string|max:100',
            // password harus diisi dan minimal 5 karakter
            'password' => 'required|min:5',
            // level_id harus diisi dan berupa angka
            'level_id' => 'required|integer'
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password), // password dienkripsi sebelum disimpan
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    // Menampilkan detail user
    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit User'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif
        $level = LevelModel::all(); // ambil data level untuk filter level

        return view('user.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5', // password bisa diisi minimal 5 karakter dan bisa tidak diisi
            'level_id' => 'required|integer'
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    // Menghapus data user
    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) { // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id); // Hapus data user
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}

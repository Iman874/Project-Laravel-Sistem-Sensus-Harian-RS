<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\Perawat;
use App\Models\Bangsal;

class PerawatController extends Controller
{
    // index
    public function index()
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::guard(session('guard'))->user();

        // Ambil variabel dengan pengecekan jika ada
        $role = $user->role ?? null;
        $nama = $user->nama ?? null;

        $data = Perawat::all();

        $bangsal = Bangsal::all();

        $data = Crypt::encrypt(['perawat' => $data]);

        return view('page.home', compact(
            'data',
            'role', 
            'nama',
            'bangsal'
        ));
    }

    // store
    public function store(Request $request)
    {
        //dd($request->all());
        // Validasi input dari form
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'penempatan' => 'required|string|max:255',
            'role' => 'required|string|max:255'
        ]);

        // Hash password
        $validatedData['password'] = bcrypt($validatedData['password']);

        if (Perawat::where('username', $request->username)->exists()) {
            return redirect()->back()->with('status', Crypt::encryptString('Username sudah digunakan'));
        }  

        try {
            // Panggil method create dari model Perawat
            Perawat::create($validatedData);

            return redirect()->back()->with('status', Crypt::encryptString('create'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', Crypt::encryptString('eror'));
        }
    }

    // edit
    public function edit($id)
    {
        // Ambil data perawat berdasarkan id
        $perawat = Perawat::find($id);
        return response()->json($perawat);
    }

    // update
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'username' => 'required|string|max:255', 
            'password' => 'nullable|string|min:8',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'penempatan' => 'required|string|max:255',
            'role' => 'required|string|max:255'
        ]);

        // Jika password diisi, hash password
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        // Cek apakah username sudah digunakan oleh perawat lain, kecuali dirinya sendiri
        if (Perawat::where('username', $request->username)->where('id_perawat', '!=', $id)->exists()) {
            return redirect()->back()->with('status', Crypt::encryptString('Username sudah digunakan'));
        }
        
        try {
            // Update data di database
            Perawat::where('id_perawat', $id)->update($validatedData);

            return redirect()->back()->with('status', Crypt::encryptString('update'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', Crypt::encryptString('eror'));
        }
    }

    // delete
    public function destroy($id)
    {
        try {
            // Hapus data perawat berdasarkan id
            Perawat::destroy($id);

            return redirect()->back()->with('status', Crypt::encryptString('delete'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', Crypt::encryptString('eror'));
        }
        
    }
}



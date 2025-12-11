<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StaffController extends Controller
{
    
    public function index()
    {
        // Tampilkan hanya user dengan role 'admin'
        $admin = User::where('role', 'admin')->get();
        return view('admin.staff.index', compact('admin'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('staff.index')->with('success', 'Admin baru berhasil ditambahkan.');
    }
   
    public function destroy(string $id)
    {
        $admin = User::findOrFail($id);
        
        if ($admin->role !== 'admin') {
            return redirect()->route('staff.index')->with('error', 'Hanya admin yang dapat dihapus.');
        }

        $admin->delete();
        return redirect()->route('staff.index')->with('success', 'Admin berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with(['department', 'position'])->latest()->paginate(5);
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('employees.create', compact('departments', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:employees,email',
            'password'      => 'required|string|min:4|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'departemen_id' => 'required|integer|exists:departments,id',
            'jabatan_id'    => 'required|integer|exists:positions,id',
            'status'        => 'required|string|max:50',
        ]);
        
        // Ambil password dari form (manual input)
        $plainPassword = $request->password;
        
        $employee = Employee::create([
            'nama_lengkap'  => $request->nama_lengkap,
            'email'         => $request->email,
            'password'      => bcrypt($plainPassword), // Hash password yang diinput manual
            'nomor_telepon' => $request->nomor_telepon,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'tanggal_masuk' => $request->tanggal_masuk,
            'departemen_id' => $request->departemen_id,
            'jabatan_id'    => $request->jabatan_id,
            'status'        => $request->status,
            'role'          => 'employee', // Default role
        ]);

        // Buat akun login untuk employee di tabel users (hindari duplikasi email)
        if (!User::where('email', $employee->email)->exists()) {
            User::create([
                'name'     => $employee->nama_lengkap,
                'email'    => $employee->email,
                'password' => Hash::make($plainPassword), // Pakai password yang sama
                'role'     => 'employee',
            ]);
        }
        
        // Flash success dengan info password
        session()->flash('success', 'Data Pegawai Berhasil Disimpan! Password untuk login: ' . $plainPassword);

        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with(['department', 'position'])->find($id);
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::find($id);
        $departments = Department::all();
        $positions = Position::all();
        return view('employees.edit', compact('employee', 'departments', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);
        
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:employees,email,' . $id,
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'departemen_id' => 'required|integer|exists:departments,id', 
            'jabatan_id'    => 'required|integer|exists:positions,id',
            'status'        => 'required|string|max:50',
        ]);
        
        $employee->update($request->only([
            'nama_lengkap',
            'email',
            'nomor_telepon',
            'tanggal_lahir',
            'alamat',
            'tanggal_masuk',
            'departemen_id',
            'jabatan_id',
            'status',
        ]));
        
        // Update user jika email berubah
        $user = User::where('email', $employee->getOriginal('email'))->first();
        if ($user && $user->email !== $employee->email) {
            $user->update([
                'name' => $employee->nama_lengkap,
                'email' => $employee->email,
            ]);
        }
        
        return redirect()->route('employees.index')->with('success', 'Data Pegawai Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        return redirect()->route('employees.index');
    }
}

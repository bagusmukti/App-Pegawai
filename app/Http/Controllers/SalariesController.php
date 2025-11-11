<?php

namespace App\Http\Controllers;

use App\Models\Salaries;
use App\Models\Employee;
use Illuminate\Http\Request;

class SalariesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salaries = Salaries::with('employee')->latest()->paginate(5);
        return view('salaries.index', compact('salaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('salaries.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id'   => 'required|exists:employees,id',
            'bulan'         => 'required|string|max:25',
            'gaji_pokok'    => 'required|numeric|min:0',
            // 'tunjangan'     => 'required|numeric|min:0',
            // 'potongan'      => 'required|numeric|min:0',
            // 'total_gaji'    => 'required|numeric|min:0',

        ]);
        Salaries::create($request->all());
        return redirect()->route('salaries.index')->with('success', 'Data Slip Gaji Berhasil Disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $salaries = Salaries::with('employee')->findOrFail($id);
        return view('salaries.show', compact('salaries'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $salaries = Salaries::findOrFail($id);
        $employees = Employee::all();
        return view('salaries.edit', compact('salaries', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'karyawan_id'   => 'required|exists:employees,id',
            'bulan'         => 'required|string|max:25',
            'gaji_pokok'    => 'required|numeric|min:0',
            // 'tunjangan'     => 'required|numeric|min:0',
            // 'potongan'      => 'required|numeric|min:0',
            // 'total_gaji'    => 'required|numeric|min:0',
        ]);
        $salaries = Salaries::findOrFail($id);
        $salaries->update($request->all());
        return redirect()->route('salaries.index')->with('success', 'Data slip gaji berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $salaries = Salaries::findOrFail($id);
        $salaries->delete();
        return redirect()->route('salaries.index')->with('success', 'Data slip gaji berhasil dihapus');
    }
}

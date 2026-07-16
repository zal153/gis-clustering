<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kriterias = Kriteria::all();
        $totalBobot = $kriterias->sum('bobot');
        return view('kriteria.index', compact('kriterias', 'totalBobot'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kriteria $kriterium)
    {
        return view('kriteria.edit', compact('kriterium'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kriteria $kriterium)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|between:0,100',
        ]);

        $kriterium->fill([
            'nama' => $request->nama,
            'bobot' => $request->bobot,
        ])->save();

        return redirect()->route('kriteria.index')->with('success', 'Bobot kriteria berhasil diperbarui.');
    }
}

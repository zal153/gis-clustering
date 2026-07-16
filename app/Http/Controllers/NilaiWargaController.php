<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Kriteria;
use App\Models\NilaiWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiWargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wargas = Warga::with(['nilaiWargas.kriteria'])->latest()->get();
        $kriterias = Kriteria::all();

        return view('nilai.index', compact('wargas', 'kriterias'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warga $warga)
    {
        $kriterias = Kriteria::all();
        $nilaiWarga = $warga->nilaiWargas->keyBy(function($item) {
            return $item->kriteria->kode;
        });

        return view('nilai.edit', compact('warga', 'kriterias', 'nilaiWarga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'c1' => 'required|numeric|min:0',
            'c2' => 'required|integer|min:0',
            'c3' => 'required|integer|in:0,1,2,3',
            'c4' => 'required|integer|in:1,2,3',
        ]);

        DB::transaction(function() use ($request, $warga) {
            $kriterias = Kriteria::all()->keyBy('kode');

            // C1
            NilaiWarga::updateOrCreate(
                ['warga_id' => $warga->id, 'kriteria_id' => $kriterias['C1']->id],
                ['nilai' => $request->c1, 'nilai_normalisasi' => $this->normalizeValue('C1', $request->c1)]
            );

            // C2
            NilaiWarga::updateOrCreate(
                ['warga_id' => $warga->id, 'kriteria_id' => $kriterias['C2']->id],
                ['nilai' => $request->c2, 'nilai_normalisasi' => $this->normalizeValue('C2', $request->c2)]
            );

            // C3
            NilaiWarga::updateOrCreate(
                ['warga_id' => $warga->id, 'kriteria_id' => $kriterias['C3']->id],
                ['nilai' => $request->c3, 'nilai_normalisasi' => $this->normalizeValue('C3', $request->c3)]
            );

            // C4
            NilaiWarga::updateOrCreate(
                ['warga_id' => $warga->id, 'kriteria_id' => $kriterias['C4']->id],
                ['nilai' => $request->c4, 'nilai_normalisasi' => $this->normalizeValue('C4', $request->c4)]
            );
        });

        return redirect()->route('nilai.index')->with('success', 'Skor kriteria warga berhasil diperbarui.');
    }

    /**
     * Normalisasi nilai kriteria secara otomatis.
     */
    private function normalizeValue(string $kode, $rawValue): int
    {
        switch ($kode) {
            case 'C1':
                $val = (int)$rawValue;
                if ($val < 300000) return 1;
                if ($val <= 600000) return 2;
                return 3;
            case 'C2':
                return (int)$rawValue;
            case 'C3':
                return (int)$rawValue;
            case 'C4':
                return (int)$rawValue;
            default:
                return (int)$rawValue;
        }
    }
}

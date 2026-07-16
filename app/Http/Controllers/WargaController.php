<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Kriteria;
use App\Models\NilaiWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wargas = Warga::query()
            ->with(["nilaiWargas.kriteria"])
            ->latest()
            ->get();

        return view("warga.index", compact("wargas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kriterias = Kriteria::all();
        return view("warga.create", compact("kriterias"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                "nik" => "required|digits:16|unique:wargas,nik",
                "nama" => "required|string|max:255",
                "dusun" => "nullable|string|max:100",
                "alamat" => "required|string",
                "pekerjaan" => "nullable|string|max:100",
                "latitude" => "required|numeric|between:-90,90",
                "longitude" => "required|numeric|between:-180,180",
                "c1" => "required|numeric|min:0",
                "c2" => "required|integer|min:0",
                "c3" => "required|integer|in:0,1,2,3",
                "c4" => "required|integer|in:1,2,3",
            ],
            [
                "nik.digits" => "NIK harus berisi 16 digit.",
                "nik.unique" => "NIK sudah terdaftar.",
                "latitude.between" => "Latitude harus di antara -90 dan 90.",
                "longitude.between" =>
                    "Longitude harus di antara -180 dan 180.",
            ],
        );

        DB::transaction(function () use ($request) {
            $warga = Warga::query()->create([
                "nik" => $request->nik,
                "nama" => $request->nama,
                "dusun" => $request->dusun,
                "alamat" => $request->alamat,
                "pekerjaan" => $request->pekerjaan,
                "latitude" => $request->latitude,
                "longitude" => $request->longitude,
            ]);

            $kriterias = Kriteria::all()->keyBy("kode");

            // C1: Pendapatan
            NilaiWarga::query()->create([
                "warga_id" => $warga->id,
                "kriteria_id" => $kriterias["C1"]->id,
                "nilai" => $request->c1,
                "nilai_normalisasi" => $this->normalizeValue(
                    "C1",
                    $request->c1,
                ),
            ]);

            // C2: Tanggungan
            NilaiWarga::query()->create([
                "warga_id" => $warga->id,
                "kriteria_id" => $kriterias["C2"]->id,
                "nilai" => $request->c2,
                "nilai_normalisasi" => $this->normalizeValue(
                    "C2",
                    $request->c2,
                ),
            ]);

            // C3: Pendidikan
            NilaiWarga::query()->create([
                "warga_id" => $warga->id,
                "kriteria_id" => $kriterias["C3"]->id,
                "nilai" => $request->c3,
                "nilai_normalisasi" => $this->normalizeValue(
                    "C3",
                    $request->c3,
                ),
            ]);

            // C4: Kondisi Rumah
            NilaiWarga::query()->create([
                "warga_id" => $warga->id,
                "kriteria_id" => $kriterias["C4"]->id,
                "nilai" => $request->c4,
                "nilai_normalisasi" => $this->normalizeValue(
                    "C4",
                    $request->c4,
                ),
            ]);
        });

        return redirect()
            ->route("warga.index")
            ->with("success", "Data Warga berhasil ditambahkan.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warga $warga)
    {
        $kriterias = Kriteria::all();
        $nilaiWarga = $warga->nilaiWargas->keyBy(function ($item) {
            return $item->kriteria->kode;
        });

        return view("warga.edit", compact("warga", "kriterias", "nilaiWarga"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warga $warga)
    {
        $request->validate(
            [
                "nik" => "required|digits:16|unique:wargas,nik," . $warga->id,
                "nama" => "required|string|max:255",
                "dusun" => "nullable|string|max:100",
                "alamat" => "required|string",
                "pekerjaan" => "nullable|string|max:100",
                "latitude" => "required|numeric|between:-90,90",
                "longitude" => "required|numeric|between:-180,180",
                "c1" => "required|numeric|min:0",
                "c2" => "required|integer|min:0",
                "c3" => "required|integer|in:0,1,2,3",
                "c4" => "required|integer|in:1,2,3",
            ],
            [
                "nik.digits" => "NIK harus berisi 16 digit.",
                "nik.unique" => "NIK sudah terdaftar.",
                "latitude.between" => "Latitude harus di antara -90 dan 90.",
                "longitude.between" =>
                    "Longitude harus di antara -180 dan 180.",
            ],
        );

        DB::transaction(function () use ($request, $warga) {
            $warga
                ->fill([
                    "nik" => $request->nik,
                    "nama" => $request->nama,
                    "dusun" => $request->dusun,
                    "alamat" => $request->alamat,
                    "pekerjaan" => $request->pekerjaan,
                    "latitude" => $request->latitude,
                    "longitude" => $request->longitude,
                ])
                ->save();

            $kriterias = Kriteria::all()->keyBy("kode");

            // C1
            NilaiWarga::query()->updateOrCreate(
                [
                    "warga_id" => $warga->id,
                    "kriteria_id" => $kriterias["C1"]->id,
                ],
                [
                    "nilai" => $request->c1,
                    "nilai_normalisasi" => $this->normalizeValue(
                        "C1",
                        $request->c1,
                    ),
                ],
            );

            // C2
            NilaiWarga::query()->updateOrCreate(
                [
                    "warga_id" => $warga->id,
                    "kriteria_id" => $kriterias["C2"]->id,
                ],
                [
                    "nilai" => $request->c2,
                    "nilai_normalisasi" => $this->normalizeValue(
                        "C2",
                        $request->c2,
                    ),
                ],
            );

            // C3
            NilaiWarga::query()->updateOrCreate(
                [
                    "warga_id" => $warga->id,
                    "kriteria_id" => $kriterias["C3"]->id,
                ],
                [
                    "nilai" => $request->c3,
                    "nilai_normalisasi" => $this->normalizeValue(
                        "C3",
                        $request->c3,
                    ),
                ],
            );

            // C4
            NilaiWarga::query()->updateOrCreate(
                [
                    "warga_id" => $warga->id,
                    "kriteria_id" => $kriterias["C4"]->id,
                ],
                [
                    "nilai" => $request->c4,
                    "nilai_normalisasi" => $this->normalizeValue(
                        "C4",
                        $request->c4,
                    ),
                ],
            );
        });

        return redirect()
            ->route("warga.index")
            ->with("success", "Data Warga berhasil diperbarui.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warga $warga)
    {
        DB::transaction(function () use ($warga) {
            // Hapus nilai kriteria dan hasil clustering warga terlebih dahulu
            $warga->nilaiWargas()->delete();
            $warga->hasilClusterings()->delete();
            Warga::destroy($warga->id);
        });

        return redirect()
            ->route("warga.index")
            ->with("success", "Data Warga berhasil dihapus.");
    }

    /**
     * Normalisasi nilai kriteria secara otomatis.
     */
    private function normalizeValue(string $kode, $rawValue): int
    {
        switch ($kode) {
            case "C1":
                // Pendapatan
                $val = (int) $rawValue;
                if ($val < 300000) {
                    return 1;
                }
                if ($val <= 600000) {
                    return 2;
                }
                return 3;
            case "C2":
                // Jumlah Tanggungan
                return (int) $rawValue;
            case "C3":
                // Pendidikan
                return (int) $rawValue;
            case "C4":
                // Kondisi Rumah
                return (int) $rawValue;
            default:
                return (int) $rawValue;
        }
    }
}

<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksas'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create($id)
    {
        $obats = Obat::orderBy('nama_obat')->get();
        return view('dokter.periksa-pasien.create', compact('obats', 'id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'obat_json' => 'required',
            'catatan' => 'nullable|string',
            'biaya_periksa' => 'required|integer',
        ]);

        $obatIds = collect(json_decode($request->obat_json, true))
            ->filter()
            ->unique()
            ->values();

        if ($obatIds->isEmpty()) {
            throw ValidationException::withMessages([
                'obat_json' => 'Pilih minimal satu obat.',
            ]);
        }

        DB::transaction(function () use ($request, $obatIds) {
            $obats = Obat::whereIn('id', $obatIds)->lockForUpdate()->get();

            if ($obats->count() !== $obatIds->count()) {
                throw ValidationException::withMessages([
                    'obat_json' => 'Data obat tidak valid. Silakan pilih ulang obat.',
                ]);
            }

            $obatHabis = $obats->first(fn ($obat) => $obat->stok <= 0);

            if ($obatHabis) {
                throw ValidationException::withMessages([
                    'obat_json' => "Stok {$obatHabis->nama_obat} habis. Silakan pilih obat lain.",
                ]);
            }

            $periksa = Periksa::create([
                'id_daftar_poli' => $request->id_daftar_poli,
                'tgl_periksa' => now(),
                'catatan' => $request->catatan,
                'biaya_periksa' => $obats->sum('harga') + 150000,
            ]);

            foreach ($obats as $obat) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obat->id,
                ]);

                $obat->decrement('stok');
            }
        });

        return redirect()->route('periksa-pasien.index')->with('success', 'Data periksa berhasil disimpan dan stok obat otomatis dikurangi.');
    }
}

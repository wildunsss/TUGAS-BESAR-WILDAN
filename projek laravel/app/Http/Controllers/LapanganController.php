<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LapanganController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari', '');
        $status = $request->query('status', '');

        $query = Lapangan::with('area');

        if (!empty($cari)) {
            $query->where(function ($q) use ($cari) {
                $q->where('nama_lapangan', 'like', "%{$cari}%")
                  ->orWhere('kode', 'like', "%{$cari}%");
            });
        }

        if (!empty($status)) {
            $query->where('status_fisik', $status);
        }

        $data = $query->orderBy('id', 'desc')->get();

        $tersedia = Lapangan::orderBy('nama_lapangan')->pluck('nama_lapangan');

        $daftarPesan = [
            'tambah' => 'Lapangan berhasil ditambahkan.',
            'ubah'   => 'Lapangan berhasil diperbarui.',
            'hapus'  => 'Lapangan berhasil dihapus.',
        ];

        $pesanParam = $request->query('pesan');
        $pesan = session('pesan') ?? ($daftarPesan[$pesanParam] ?? '');

        $judulTab = 'Data Lapangan';
        $permukaan = Lapangan::PERMUKAAN;
        $statusFisik = Lapangan::STATUS_FISIK;
        $kelasStatus = Lapangan::KELAS_STATUS;

        return view('lapangan', compact(
            'data',
            'cari',
            'status',
            'tersedia',
            'pesan',
            'judulTab',
            'permukaan',
            'statusFisik',
            'kelasStatus'
        ));
    }

    public function create()
    {
        $areas = Area::orderBy('nama_area')->get();
        $id = 0;
        $judulTab = 'Tambah Lapangan';

        $f = [
            'area_id'         => old('area_id', ''),
            'kode'            => old('kode', ''),
            'nama_lapangan'   => old('nama_lapangan', ''),
            'cabang_olahraga' => old('cabang_olahraga', ''),
            'jenis_permukaan' => old('jenis_permukaan', 'rumput_alami'),
            'panjang'         => old('panjang', ''),
            'lebar'           => old('lebar', ''),
            'status_fisik'    => old('status_fisik', 'baik'),
            'keterangan'      => old('keterangan', ''),
        ];

        $galat = session('galat', []);
        $permukaan = Lapangan::PERMUKAAN;
        $statusFisik = Lapangan::STATUS_FISIK;
        $tersedia = Lapangan::orderBy('nama_lapangan')->pluck('nama_lapangan');

        return view('form-lapangan', compact(
            'id',
            'areas',
            'f',
            'galat',
            'judulTab',
            'permukaan',
            'statusFisik',
            'tersedia'
        ));
    }

    public function store(Request $request)
    {
        return $this->processSave($request, 0);
    }

    public function edit(Request $request, $id)
    {
        $lapangan = Lapangan::find($id);

        if (!$lapangan) {
            return redirect()->route('lapangan.index');
        }

        $areas = Area::orderBy('nama_area')->get();
        $judulTab = 'Edit Lapangan';

        $f = [
            'area_id'         => old('area_id', $lapangan->area_id),
            'kode'            => old('kode', $lapangan->kode),
            'nama_lapangan'   => old('nama_lapangan', $lapangan->nama_lapangan),
            'cabang_olahraga' => old('cabang_olahraga', $lapangan->cabang_olahraga),
            'jenis_permukaan' => old('jenis_permukaan', $lapangan->jenis_permukaan),
            'panjang'         => old('panjang', $lapangan->panjang + 0),
            'lebar'           => old('lebar', $lapangan->lebar + 0),
            'status_fisik'    => old('status_fisik', $lapangan->status_fisik),
            'keterangan'      => old('keterangan', $lapangan->keterangan),
        ];

        $galat = session('galat', []);
        $permukaan = Lapangan::PERMUKAAN;
        $statusFisik = Lapangan::STATUS_FISIK;
        $tersedia = Lapangan::orderBy('nama_lapangan')->pluck('nama_lapangan');

        return view('form-lapangan', compact(
            'id',
            'areas',
            'f',
            'galat',
            'judulTab',
            'permukaan',
            'statusFisik',
            'tersedia',
            'lapangan'
        ));
    }

    public function update(Request $request, $id)
    {
        return $this->processSave($request, (int) $id);
    }

    public function storeOrUpdate(Request $request)
    {
        $id = (int) $request->input('id', 0);
        return $this->processSave($request, $id);
    }

    private function processSave(Request $request, int $id)
    {
        $permukaanKeys = implode(',', array_keys(Lapangan::PERMUKAAN));
        $statusFisikKeys = implode(',', array_keys(Lapangan::STATUS_FISIK));

        $validator = Validator::make($request->all(), [
            'area_id'         => ['required', 'exists:areas,id'],
            'kode'            => ['required', 'unique:lapangans,kode,' . ($id ?: 'NULL') . ',id'],
            'nama_lapangan'   => ['required', 'string'],
            'cabang_olahraga' => ['required', 'string'],
            'jenis_permukaan' => ['required', 'in:' . $permukaanKeys],
            'panjang'         => ['required', 'numeric', 'gt:0'],
            'lebar'           => ['required', 'numeric', 'gt:0'],
            'status_fisik'    => ['required', 'in:' . $statusFisikKeys],
            'keterangan'      => ['nullable', 'string'],
        ], [
            'area_id.required'         => 'Area wajib dipilih.',
            'area_id.exists'           => 'Area wajib dipilih.',
            'kode.required'            => 'Kode wajib diisi.',
            'kode.unique'              => 'Kode sudah dipakai lapangan lain.',
            'nama_lapangan.required'   => 'Nama lapangan wajib diisi.',
            'cabang_olahraga.required' => 'Cabang olahraga wajib diisi.',
            'jenis_permukaan.required' => 'Jenis permukaan tidak valid.',
            'jenis_permukaan.in'       => 'Jenis permukaan tidak valid.',
            'panjang.required'         => 'Panjang harus angka lebih dari 0.',
            'panjang.numeric'          => 'Panjang harus angka lebih dari 0.',
            'panjang.gt'               => 'Panjang harus angka lebih dari 0.',
            'lebar.required'           => 'Lebar harus angka lebih dari 0.',
            'lebar.numeric'            => 'Lebar harus angka lebih dari 0.',
            'lebar.gt'                 => 'Lebar harus angka lebih dari 0.',
            'status_fisik.required'    => 'Status fisik tidak valid.',
            'status_fisik.in'          => 'Status fisik tidak valid.',
        ]);

        if ($validator->fails()) {
            $redirectUrl = $id ? route('lapangan.edit', $id) : route('lapangan.create');
            return redirect($redirectUrl)
                ->withErrors($validator)
                ->with('galat', $validator->errors()->all())
                ->withInput();
        }

        $data = [
            'area_id'         => $request->input('area_id'),
            'kode'            => trim($request->input('kode')),
            'nama_lapangan'   => trim($request->input('nama_lapangan')),
            'cabang_olahraga' => trim($request->input('cabang_olahraga')),
            'jenis_permukaan' => $request->input('jenis_permukaan'),
            'panjang'         => $request->input('panjang'),
            'lebar'           => $request->input('lebar'),
            'status_fisik'    => $request->input('status_fisik'),
            'keterangan'      => $request->input('keterangan'),
        ];

        if ($id > 0) {
            $lapangan = Lapangan::findOrFail($id);
            $lapangan->update($data);
            return redirect()->route('lapangan.index', ['pesan' => 'ubah'])
                ->with('pesan', 'Lapangan berhasil diperbarui.');
        } else {
            Lapangan::create($data);
            return redirect()->route('lapangan.index', ['pesan' => 'tambah'])
                ->with('pesan', 'Lapangan berhasil ditambahkan.');
        }
    }

    public function destroy(Request $request, $id = null)
    {
        $id = $id ?? $request->input('id') ?? $request->query('id');

        if ($id) {
            $lapangan = Lapangan::find($id);
            if ($lapangan) {
                $lapangan->delete();
            }
        }

        return redirect()->route('lapangan.index', ['pesan' => 'hapus'])
            ->with('pesan', 'Lapangan berhasil dihapus.');
    }
}

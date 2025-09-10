<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Population;
use Illuminate\Http\Request;
use App\Imports\PopulationImport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PopulationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Urutkan: Kelompok per No KK, lalu prioritas hubungan: KK -> ISTRI -> ANAK -> lainnya, lalu nama
        $populations = Population::orderBy('no_kk')
            ->orderByRaw("CASE 
                WHEN UPPER(TRIM(hubungan_kepala_keluarga)) = 'KK' THEN 0 
                WHEN UPPER(TRIM(hubungan_kepala_keluarga)) = 'ISTRI' THEN 1 
                WHEN UPPER(TRIM(hubungan_kepala_keluarga)) = 'ANAK' THEN 2 
                ELSE 99 END")
            ->orderBy('nama')
            ->get();

        // Soft-normalize date fields so data tersimpan konsisten untuk tampilan berikutnya
        $populations->each(function (Population $p) {
            $dirty = false;
            // Jika tanggal_lahir penuh ada, pecah ke komponen bila kosong
            if (!empty($p->tanggal_lahir) && preg_match('/^\d{4}-\d{2}-\d{2}$/', (string)$p->tanggal_lahir)) {
                try {
                    if (!is_numeric($p->tanggal_lahir)) {
                        $dt = Carbon::parse($p->tanggal_lahir);
                        if (empty($p->bulan_lahir)) { $p->bulan_lahir = $dt->format('m'); $dirty = true; }
                        if (empty($p->tahun_lahir)) { $p->tahun_lahir = $dt->format('Y'); $dirty = true; }
                        if (empty($p->tanggal_lahir)) { $p->tanggal_lahir = $dt->format('d'); $dirty = true; }
                    }
                } catch (\Exception $e) {
                    // skip jika gagal parse
                }
            } else {
                // Jika komponen ada, pastikan zero padding dan simpan kembali
                if (!empty($p->tanggal_lahir)) {
                    $d = preg_replace('/[^0-9]/', '', (string)$p->tanggal_lahir);
                    if ($d !== '') { $val = str_pad($d, 2, '0', STR_PAD_LEFT); if ($p->tanggal_lahir !== $val) { $p->tanggal_lahir = $val; $dirty = true; } }
                }
                if (!empty($p->bulan_lahir)) {
                    $m = preg_replace('/[^0-9]/', '', (string)$p->bulan_lahir);
                    if ($m !== '') { $val = str_pad($m, 2, '0', STR_PAD_LEFT); if ($p->bulan_lahir !== $val) { $p->bulan_lahir = $val; $dirty = true; } }
                }
                if (!empty($p->tahun_lahir)) {
                    $y = preg_replace('/[^0-9]/', '', (string)$p->tahun_lahir);
                    if ($y !== '' && $p->tahun_lahir !== $y) { $p->tahun_lahir = $y; $dirty = true; }
                }
            }
            if ($dirty) {
                $p->save();
            }
        });
        return view('admin.population.index', compact('populations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $allRows = [];
            $dusunNames = ['Dusun 1', 'Dusun 2', 'Dusun 3'];
            foreach ($spreadsheet->getAllSheets() as $idx => $sheet) {
                $sheetData = $sheet->toArray(null, true, true, true);
                if (count($sheetData) < 2) continue;
                $headers = array_map('trim', $sheetData[1]);
                for ($i = 2; $i <= count($sheetData); $i++) {
                    $row = $sheetData[$i];
                    $assoc = [];
                    $colIdx = 0;
                    foreach ($headers as $key) {
                        $col = chr(65 + $colIdx); // A, B, C, ...
                        $assoc[$key] = $row[$col] ?? null;
                        $colIdx++;
                    }
                    $assoc['dusun'] = $dusunNames[$idx] ?? 'Dusun ' . ($idx + 1);
                    $allRows[] = $assoc;
                }
            }
            // Helper konversi serial Excel ke tanggal
            $excelDateToYMD = function($value) {
                if (is_null($value)) return null;
                if (is_string($value) && (str_contains($value, '+') || str_contains($value, 'days'))) return null;
                if (is_numeric($value) && $value > 20000 && $value < 90000) {
                    // Excel serial date
                    $unix = ($value - 25569) * 86400;
                    return date('Y-m-d', $unix);
                }
                if (is_string($value) && strtotime($value)) {
                    return date('Y-m-d', strtotime($value));
                }
                return null;
            };
            $imported = 0;
            foreach ($allRows as $row) {
                $data = [
                    'no_kk' => $row['No. KK'] ?? null,
                    'nik' => $row['NIK'] ?? null,
                    'nama' => $row['Nama'] ?? null,
                    'alamat_kk' => $row['Alamat KK'] ?? null,
                    'jenis_kelamin' => $row['L'] ? 'L' : ($row['P'] ? 'P' : null),
                    'hubungan_kepala_keluarga' => $row['Hubungan Kepala Keluarga'] ?? null,
                    'tempat_lahir' => $row['Tempat'] ?? null,
                    'status_perkawinan' => $row['Status'] ?? null,
                    'suku' => $row['Suku'] ?? null,
                    'pendidikan_terakhir' => $row['Pendidikan Terlahir'] ?? $row['Pendidikan Terakhir'] ?? null,
                    'mata_pencaharian' => $row['Mata Pencaharian'] ?? null,
                    'pekerjaan_tambahan' => $row['Pekerjaan Tambahan'] ?? null,
                    'luas_lahan_pertanian' => isset($row['Luas Lahan M']) ? str_replace([',', '.'], ['', '.'], $row['Luas Lahan M']) : null,
                    'komoditas_utama' => $row['Komoditas Utama'] ?? null,
                    'komoditas_buah_sayur' => $row['Komoditas Buah & sayur'] ?? null,
                    'bantuan' => $row['Bantuan'] ?? null,
                    'dusun' => $row['dusun'] ?? null,
                    // Kendaraan/ternak
                    'mobil' => isset($row['Mobil']) ? (int) $row['Mobil'] : 0,
                    'motor' => isset($row['Motor']) ? (int) $row['Motor'] : 0,
                    'sepeda' => isset($row['Sepeda']) ? (int) $row['Sepeda'] : 0,
                    'sapi' => isset($row['Sapi']) ? (int) $row['Sapi'] : 0,
                    'kambing' => isset($row['Kambing']) ? (int) $row['Kambing'] : 0,
                    'ayam' => isset($row['Ayam']) ? (int) $row['Ayam'] : 0,
                    // Status rumah
                    'status_kepemilikan_rumah' => $row['Kepemilikan'] ?? null,
                    'status_dinding' => $row['Dinding'] ?? null,
                    'status_atap' => $row['Atap'] ?? null,
                    'status_lantai' => $row['Lantai'] ?? null,
                ];
                // Validasi dan normalisasi tanggal KK dikeluarkan
                $data['kk_dikeluarkan'] = $excelDateToYMD($row['KK di keluarkan pada tanggal'] ?? null);
                // Validasi dan normalisasi tanggal lahir
                $data['tanggal_lahir'] = null;
                $data['bulan_lahir'] = null;
                $data['tahun_lahir'] = null;
                if (!empty($row['Tggl']) && is_numeric($row['Tggl']) && $row['Tggl'] > 0 && $row['Tggl'] <= 31) {
                    $data['tanggal_lahir'] = str_pad($row['Tggl'], 2, '0', STR_PAD_LEFT);
                }
                if (!empty($row['Bulan']) && is_numeric($row['Bulan']) && $row['Bulan'] > 0 && $row['Bulan'] <= 12) {
                    $data['bulan_lahir'] = str_pad($row['Bulan'], 2, '0', STR_PAD_LEFT);
                }
                if (!empty($row['Tahun']) && is_numeric($row['Tahun']) && $row['Tahun'] > 1900 && $row['Tahun'] < 2100) {
                    $data['tahun_lahir'] = $row['Tahun'];
                }
                Population::create($data);
                $imported++;
            }
            return redirect()->route('admin.population.index')->with('success', "Import selesai! $imported data berhasil diimpor.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
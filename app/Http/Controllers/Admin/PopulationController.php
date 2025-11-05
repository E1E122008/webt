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
use Illuminate\Support\Facades\Log;

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
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:populations,nik|max:16',
            'no_kk' => 'required|string|max:16',
            'jenis_kelamin' => 'required|in:L,P',
            'dusun' => 'required|string|in:Dusun 1,Dusun 2,Dusun 3',
        ]);

        $data = $request->all();
        
        // Convert dusun string to dusun_id
        $dusunMapping = [
            'Dusun 1' => 1,
            'Dusun 2' => 2,
            'Dusun 3' => 3,
        ];
        $data['dusun_id'] = $dusunMapping[$data['dusun']] ?? null;
        unset($data['dusun']); // Remove the string dusun field
        
        // Fix date format - combine tanggal_lahir, bulan_lahir, tahun_lahir into proper date
        if (isset($data['tanggal_lahir']) && isset($data['bulan_lahir']) && isset($data['tahun_lahir'])) {
            $tanggal = $data['tanggal_lahir'];
            $bulan = $data['bulan_lahir'];
            $tahun = $data['tahun_lahir'];
            
            // Validate and create proper date
            if (is_numeric($tanggal) && is_numeric($bulan) && is_numeric($tahun)) {
                $tanggal = str_pad($tanggal, 2, '0', STR_PAD_LEFT);
                $bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
                $data['tanggal_lahir'] = $tahun . '-' . $bulan . '-' . $tanggal;
            } else {
                $data['tanggal_lahir'] = null;
            }
        }
        
        // Set default values for numeric fields
        $data['mobil'] = $data['mobil'] ?? 0;
        $data['motor'] = $data['motor'] ?? 0;
        $data['sepeda'] = $data['sepeda'] ?? 0;
        $data['sapi'] = $data['sapi'] ?? 0;
        $data['kambing'] = $data['kambing'] ?? 0;
        $data['ayam'] = $data['ayam'] ?? 0;
        $data['luas_lahan_pertanian'] = $data['luas_lahan_pertanian'] ?? 0;

        Population::create($data);

        return redirect()->route('admin.population.index')->with('success', 'Data penduduk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $population = Population::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'population' => $population
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data penduduk tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $population = Population::findOrFail($id);
        return response()->json($population);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:populations,nik,' . $id,
            'no_kk' => 'required|string|max:16',
            'jenis_kelamin' => 'required|in:L,P',
            'dusun' => 'required|string|in:Dusun 1,Dusun 2,Dusun 3',
        ]);

        $population = Population::findOrFail($id);
        $data = $request->all();
        
        // Convert dusun string to dusun_id
        $dusunMapping = [
            'Dusun 1' => 1,
            'Dusun 2' => 2,
            'Dusun 3' => 3,
        ];
        $data['dusun_id'] = $dusunMapping[$data['dusun']] ?? null;
        unset($data['dusun']); // Remove the string dusun field
        
        // Fix date format - combine tanggal_lahir, bulan_lahir, tahun_lahir into proper date
        if (isset($data['tanggal_lahir']) && isset($data['bulan_lahir']) && isset($data['tahun_lahir'])) {
            $tanggal = $data['tanggal_lahir'];
            $bulan = $data['bulan_lahir'];
            $tahun = $data['tahun_lahir'];
            
            // Validate and create proper date
            if (is_numeric($tanggal) && is_numeric($bulan) && is_numeric($tahun)) {
                $tanggal = str_pad($tanggal, 2, '0', STR_PAD_LEFT);
                $bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
                $data['tanggal_lahir'] = $tahun . '-' . $bulan . '-' . $tanggal;
            } else {
                $data['tanggal_lahir'] = null;
            }
        }
        
        // Set default values for numeric fields
        $data['mobil'] = $data['mobil'] ?? 0;
        $data['motor'] = $data['motor'] ?? 0;
        $data['sepeda'] = $data['sepeda'] ?? 0;
        $data['sapi'] = $data['sapi'] ?? 0;
        $data['kambing'] = $data['kambing'] ?? 0;
        $data['ayam'] = $data['ayam'] ?? 0;
        $data['luas_lahan_pertanian'] = $data['luas_lahan_pertanian'] ?? 0;

        $population->update($data);

        return response()->json(['success' => true, 'message' => 'Data penduduk berhasil diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $population = Population::findOrFail($id);
        $population->delete();
        
        return response()->json(['success' => true, 'message' => 'Data penduduk berhasil dihapus!']);
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
                // Baca data dengan format yang aman
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                
                Log::info("Sheet $idx - Highest row: $highestRow, Highest column: $highestColumn");
                
                if ($highestRow < 4) continue; // Minimal butuh 4 baris: 1 kosong, 2 header, 3 sub-header, 4+ data
                
                // Baca header dari baris 2, mulai dari kolom B (karena kolom A kosong)
                $headers = [];
                for ($col = 'B'; $col <= $highestColumn; $col++) {
                    $cellValue = $sheet->getCell($col . '2')->getValue();
                    $trimmedValue = trim($cellValue);
                    $headers[] = $trimmedValue;
                }
                
                // Debug: Log headers yang dibaca
                Log::info('Headers found:', $headers);
                
                // Baca data dari baris 4 ke bawah (karena baris 3 adalah sub-header)
                for ($row = 4; $row <= $highestRow; $row++) {
                    $assoc = [];
                    $colIdx = 0;
                    
                    // Mulai dari kolom B (karena kolom A kosong)
                    for ($col = 'B'; $col <= $highestColumn; $col++) {
                        $cell = $sheet->getCell($col . $row);
                        $value = $cell->getValue(); // Gunakan getValue() bukan getCalculatedValue()
                        
                        // Bersihkan nilai dari format Excel yang bermasalah
                        if (is_string($value)) {
                            // Remove apostrophe prefix
                            if (str_starts_with($value, "'")) {
                                $value = substr($value, 1);
                            }
                            // Remove Excel formula artifacts
                            if (str_contains($value, '+') && str_contains($value, 'days')) {
                                $value = null;
                            }
                        }
                        
                        if (isset($headers[$colIdx]) && $headers[$colIdx] !== '') {
                            $assoc[$headers[$colIdx]] = $value;
                        }
                        $colIdx++;
                    }
                    
                    // Skip row jika tidak ada data yang valid
                    if (empty(array_filter($assoc))) {
                        continue;
                    }
                    
                    $dusunName = $dusunNames[$idx] ?? 'Dusun ' . ($idx + 1);
                    $dusunMapping = [
                        'Dusun 1' => 1,
                        'Dusun 2' => 2,
                        'Dusun 3' => 3,
                    ];
                    $assoc['dusun_id'] = $dusunMapping[$dusunName] ?? null;
                    $allRows[] = $assoc;
                }
            }
            // Helper konversi serial Excel ke tanggal
            $excelDateToYMD = function($value) {
                if (is_null($value)) return null;
                
                // Handle string values that might be Excel formulas or corrupted dates
                if (is_string($value)) {
                    // Remove any Excel formula artifacts like "+ 7402012505100003 days"
                    if (str_contains($value, '+') && str_contains($value, 'days')) {
                        return null;
                    }
                    
                    // Handle apostrophe-prefixed values (Excel text format)
                    if (str_starts_with($value, "'")) {
                        $value = substr($value, 1); // Remove the apostrophe
                    }
                    
                    // Try to parse as date if it looks like a date
                    if (strtotime($value)) {
                        return date('Y-m-d', strtotime($value));
                    }
                    
                    // If it's a long numeric string (like NIK), don't treat as date
                    if (is_numeric($value) && strlen($value) > 10) {
                        return null;
                    }
                }
                
                // Handle numeric Excel serial dates
                if (is_numeric($value) && $value > 20000 && $value < 90000) {
                    // Excel serial date
                    $unix = ($value - 25569) * 86400;
                    return date('Y-m-d', $unix);
                }
                
                return null;
            };
            $imported = 0;
            foreach ($allRows as $rowIndex => $row) {
                // Debug: Log struktur data untuk baris pertama
                if ($rowIndex === 0) {
                    Log::info('Excel data structure:', [
                        'headers' => array_keys($row),
                        'sample_row' => $row
                    ]);
                }
                
                // Helper untuk membersihkan nilai dari Excel
                $cleanValue = function($value) {
                    if (is_null($value)) return null;
                    if (is_string($value)) {
                        // Remove apostrophe prefix
                        if (str_starts_with($value, "'")) {
                            $value = substr($value, 1);
                        }
                        // Remove any Excel formula artifacts
                        if (str_contains($value, '+') && str_contains($value, 'days')) {
                            return null;
                        }
                    }
                    return $value;
                };
                
                $data = [
                    'no_kk' => $cleanValue($row['No. KK'] ?? null),
                    'nik' => $cleanValue($row['NIK'] ?? null),
                    'nama' => $row['Nama'] ?? null,
                    'alamat_kk' => $row['Alamat KK'] ?? null,
                    'jenis_kelamin' => (isset($row['L']) && $row['L']) ? 'L' : ((isset($row['P']) && $row['P']) ? 'P' : null),
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
                    'dusun_id' => $row['dusun_id'] ?? null,
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
                ];
                // Validasi dan normalisasi tanggal KK dikeluarkan
                $data['kk_dikeluarkan'] = $excelDateToYMD($row['KK di keluarkan pada tanggal'] ?? null);
                // Validasi dan normalisasi tanggal lahir
                $data['tanggal_lahir'] = null;
                $data['bulan_lahir'] = null;
                $data['tahun_lahir'] = null;
                
                $tanggal = $cleanValue($row['Tggl'] ?? null);
                $bulan = $cleanValue($row['Bulan'] ?? null);
                $tahun = $cleanValue($row['Tahun'] ?? null);
                
                if (!empty($tanggal) && is_numeric($tanggal) && $tanggal > 0 && $tanggal <= 31) {
                    $data['tanggal_lahir'] = str_pad($tanggal, 2, '0', STR_PAD_LEFT);
                }
                if (!empty($bulan) && is_numeric($bulan) && $bulan > 0 && $bulan <= 12) {
                    $data['bulan_lahir'] = str_pad($bulan, 2, '0', STR_PAD_LEFT);
                }
                if (!empty($tahun) && is_numeric($tahun) && $tahun > 1900 && $tahun < 2100) {
                    $data['tahun_lahir'] = $tahun;
                }
                
                // Validasi data yang diperlukan sebelum insert
                if (empty($data['nik']) || empty($data['nama'])) {
                    Log::warning('Skipping row with missing required data:', [
                        'nik' => $data['nik'],
                        'nama' => $data['nama'],
                        'row_data' => $row
                    ]);
                    continue;
                }
                
                Population::create($data);
                $imported++;
            }
            return redirect()->route('admin.population.index')->with('success', "Import selesai! $imported data berhasil diimpor.");
        } catch (\Exception $e) {
            Log::error('Import Excel error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv',
            'dusun_id' => 'required|in:1,2,3'
        ]);

        try {
            $file = $request->file('file');
            $csvData = array_map('str_getcsv', file($file->getRealPath()));

            // Normalize: skip leading empty columns until header (so "No" becomes first column)
            $headerRowIndex = 0;
            $leadingEmptyCols = 0;
            for ($i = 0; $i < count($csvData); $i++) {
                $row = $csvData[$i];
                if (empty($row)) { continue; }
                // Find first non-empty cell index
                $firstNonEmpty = 0;
                for ($j = 0; $j < count($row); $j++) {
                    if (trim((string)($row[$j] ?? '')) !== '') { $firstNonEmpty = $j; break; }
                }
                $cellNo   = $row[$firstNonEmpty]   ?? null;
                $cellNama = $row[$firstNonEmpty+1] ?? null;
                if ($cellNo === 'No' && $cellNama === 'Nama') {
                    $headerRowIndex = $i;
                    $leadingEmptyCols = $firstNonEmpty; // how many empty cols to trim
                    break;
                }
            }

            if ($leadingEmptyCols > 0) {
                // Trim the detected leading empty columns from all rows
                foreach ($csvData as $idx => $row) {
                    $csvData[$idx] = array_slice($row, $leadingEmptyCols);
                }
                Log::info('Normalized CSV by trimming leading empty columns', [
                    'trimmed_cols' => $leadingEmptyCols,
                    'header_row_index' => $headerRowIndex,
                ]);
            }

            // Detect CSV format after normalization
            $csvFormat = $this->detectCsvFormat($csvData);
            Log::info('Detected CSV format: ' . $csvFormat);
            
            if ($csvFormat === 'unknown') {
                return redirect()->back()->with('error', 'Format CSV tidak dikenali. Pastikan file CSV memiliki header yang benar dengan kolom "No" dan "Nama".');
            }

            // Recompute header row index on normalized data
            $headerRowIndex = 0;
            for ($i = 0; $i < count($csvData); $i++) {
                $row = $csvData[$i];
                if (!empty($row[0]) && $row[0] === 'No' && !empty($row[1]) && $row[1] === 'Nama') {
                    $headerRowIndex = $i;
                    break;
                }
            }

            // Skip rows up to and including the header row, then skip one more row (sub-header)
            for ($i = 0; $i <= $headerRowIndex + 1; $i++) {
                array_shift($csvData);
            }
            
            Log::info('Skipped rows up to header row', [
                'header_row_index' => $headerRowIndex,
                'remaining_rows' => count($csvData)
            ]);
            
            $imported = 0;
            $skipped = 0;
            $selectedDusunId = (int)$request->input('dusun_id');
            // Carry-forward buffer for merged-cell CSV (household-level fields)
            $carry = [];
            
            // Get column mapping based on detected format
            $columnMap = $this->getColumnMapping($csvFormat);
            if (empty($columnMap)) {
                Log::error('CSV format not recognized', [
                    'detected_format' => $csvFormat,
                    'first_row' => $csvData[0] ?? null,
                    'file_name' => $file->getClientOriginalName()
                ]);
                return redirect()->back()->with('error', 'Format CSV tidak dikenali. Pastikan file CSV memiliki format yang benar. Format yang dideteksi: ' . $csvFormat);
            }
            
            foreach ($csvData as $rowIndex => $row) {
                // Skip jika baris benar-benar kosong (tanpa nama & tanpa NIK)
                $namaCol = $columnMap['nama'] ?? 1;
                $nikCol = $columnMap['nik'] ?? 5;
                
                if (empty($row[$namaCol]) && empty($row[$nikCol])) {
                    $skipped++;
                    Log::warning('Skipping empty row (no name and NIK)', [
                        'row_index' => $rowIndex + 3,
                        'row' => $row,
                    ]);
                    continue;
                }

                // Detect new household group (No isi) → reset carry; else reuse household fields
                $noCol = $columnMap['no'] ?? 0;
                $isNewHousehold = !empty($row[$noCol]) && is_numeric($row[$noCol]);
                if ($isNewHousehold) {
                    $carry = [];
                }

                // Bersihkan data dari karakter yang tidak diinginkan (didefinisikan sebelum dipakai)
                $cleanValue = function($value) {
                    if (is_null($value)) return null;
                    $value = trim($value);
                    // Remove quotes jika ada
                    $value = trim($value, '"');
                    // Treat placeholder values as null
                    if ($value === '?' || $value === "-") {
                        return null;
                    }
                    // Remove leading apostrophe that sometimes appears from Excel exports
                    if (strlen($value) > 0 && $value[0] === "'") {
                        $value = substr($value, 1);
                    }
                    return $value === '' ? null : $value;
                };

                // Columns eligible for carry-forward (household-level) - use dynamic mapping
                // Build carryable array dynamically based on available columns
                $carryable = [];
                $carryableFields = [
                    'alamat_kk', 'kk_dikeluarkan', 'no_kk', 'status_perkawinan', 'suku',
                    'pendidikan_terakhir', 'mata_pencaharian', 'pekerjaan_tambahan',
                    'mobil', 'motor', 'sepeda', 'sapi', 'kambing', 'ayam', 'ikan',
                    'luas_lahan_pertanian', 'luas_lahan_peternakan', 'komoditas_utama',
                    'komoditas_buah_sayur', 'bantuan', 'status_kepemilikan_rumah',
                    'status_dinding', 'status_atap', 'penggunaan_listrik', 'mck'
                ];
                
                foreach ($carryableFields as $field) {
                    if (isset($columnMap[$field]) && $columnMap[$field] !== null) {
                        $carryable[] = $columnMap[$field];
                    }
                }

                // Apply carry-forward: clean and store first, then fill blanks
                foreach ($carryable as $idx) {
                    $val = $row[$idx] ?? null;
                    $valClean = $cleanValue($val);
                    if ($valClean !== null && $valClean !== '') {
                        $carry[$idx] = $valClean;
                    } elseif (array_key_exists($idx, $carry)) {
                        // Fill down - use carried value
                        $row[$idx] = $carry[$idx];
                    }
                }
                
                // Ensure critical household data is carried forward
                $criticalFields = ['alamat_kk', 'no_kk', 'suku', 'mata_pencaharian'];
                
                foreach ($criticalFields as $field) {
                    if (isset($columnMap[$field]) && $columnMap[$field] !== null) {
                        $colIndex = $columnMap[$field];
                        if (empty($row[$colIndex]) && !empty($carry[$colIndex])) {
                            $row[$colIndex] = $carry[$colIndex];
                        }
                    }
                }
                
                // Log carry-forward for debugging
                if ($rowIndex < 5) { // Log first 5 rows for debugging
                    Log::info("Row $rowIndex carry-forward", [
                        'is_new_household' => $isNewHousehold,
                        'carry_data' => $carry,
                        'row_data' => array_slice($row, 0, 10) // First 10 columns
                    ]);
                }
                
                // $cleanValue sudah didefinisikan di atas
                
                // Tentukan jenis kelamin berdasarkan kolom Laki-laki/Perempuan
                $lakiLakiCol = $columnMap['laki_laki'] ?? 7;
                $perempuanCol = $columnMap['perempuan'] ?? 8;
                
                $jenis_kelamin = null;
                if (!empty($row[$lakiLakiCol])) { // Kolom Laki-laki
                    $jenis_kelamin = 'L';
                } elseif (!empty($row[$perempuanCol])) { // Kolom Perempuan
                    $jenis_kelamin = 'P';
                }
                
                // Gunakan dusun pilihan user
                $dusun_id = $selectedDusunId;
                
                $data = [
                    'no_kk' => $cleanValue($row[$columnMap['no_kk'] ?? null] ?? null),
                    'nik' => $cleanValue($row[$columnMap['nik'] ?? null] ?? null),
                    'nama' => $cleanValue($row[$columnMap['nama'] ?? null] ?? null),
                    'alamat_kk' => $cleanValue($row[$columnMap['alamat_kk'] ?? null] ?? null),
                    'jenis_kelamin' => $jenis_kelamin,
                    'hubungan_kepala_keluarga' => $cleanValue($row[$columnMap['hubungan_kepala_keluarga'] ?? null] ?? null),
                    'tempat_lahir' => $cleanValue($row[$columnMap['tempat_lahir'] ?? null] ?? null),
                    'status_perkawinan' => $cleanValue($row[$columnMap['status_perkawinan'] ?? null] ?? null),
                    'suku' => $cleanValue($row[$columnMap['suku'] ?? null] ?? null),
                    'pendidikan_terakhir' => $cleanValue($row[$columnMap['pendidikan_terakhir'] ?? null] ?? null),
                    'mata_pencaharian' => $cleanValue($row[$columnMap['mata_pencaharian'] ?? null] ?? null),
                    'pekerjaan_tambahan' => $cleanValue($row[$columnMap['pekerjaan_tambahan'] ?? null] ?? null),
                    // Luas lahan
                    'luas_lahan_pertanian' => $cleanValue($row[$columnMap['luas_lahan_pertanian'] ?? null] ?? null) ? (float)str_replace([',', ' ', '.'], ['', '', ''], $cleanValue($row[$columnMap['luas_lahan_pertanian'] ?? null] ?? null)) : 0,
                    'luas_lahan_peternakan' => $cleanValue($row[$columnMap['luas_lahan_peternakan'] ?? null] ?? null) ? (float)str_replace([',', ' ', '.'], ['', '', ''], $cleanValue($row[$columnMap['luas_lahan_peternakan'] ?? null] ?? null)) : 0,
                    'komoditas_utama' => $cleanValue($row[$columnMap['komoditas_utama'] ?? null] ?? null),
                    'komoditas_buah_sayur' => $cleanValue($row[$columnMap['komoditas_buah_sayur'] ?? null] ?? null),
                    'bantuan' => $cleanValue($row[$columnMap['bantuan'] ?? null] ?? null),
                    'dusun_id' => $dusun_id,
                    // Kendaraan
                    'mobil' => (int)($cleanValue($row[$columnMap['mobil'] ?? null] ?? null) ?: 0),
                    'motor' => (int)($cleanValue($row[$columnMap['motor'] ?? null] ?? null) ?: 0),
                    'sepeda' => (int)($cleanValue($row[$columnMap['sepeda'] ?? null] ?? null) ?: 0),
                    // Ternak
                    'sapi' => (int)($cleanValue($row[$columnMap['sapi'] ?? null] ?? null) ?: 0),
                    'kambing' => (int)($cleanValue($row[$columnMap['kambing'] ?? null] ?? null) ?: 0),
                    'ayam' => (int)($cleanValue($row[$columnMap['ayam'] ?? null] ?? null) ?: 0),
                    'ikan' => (int)($cleanValue($row[$columnMap['ikan'] ?? null] ?? null) ?: 0),
                    // Status rumah
                    'status_kepemilikan_rumah' => $cleanValue($row[$columnMap['status_kepemilikan_rumah'] ?? null] ?? null),
                    'status_dinding' => $cleanValue($row[$columnMap['status_dinding'] ?? null] ?? null),
                    'status_atap' => $cleanValue($row[$columnMap['status_atap'] ?? null] ?? null),
                    'penggunaan_listrik' => $cleanValue($row[$columnMap['penggunaan_listrik'] ?? null] ?? null),
                    'mck' => $cleanValue($row[$columnMap['mck'] ?? null] ?? null),
                    'kk_dikeluarkan' => $cleanValue($row[$columnMap['kk_dikeluarkan'] ?? null] ?? null),
                    'tanggal_lahir' => null, // will be set below if valid
                    'bulan_lahir' => $cleanValue($row[$columnMap['bulan_lahir'] ?? null] ?? null),
                    'tahun_lahir' => $cleanValue($row[$columnMap['tahun_lahir'] ?? null] ?? null),
                ];

                // Parse and validate kk_dikeluarkan date
                $kkDateRaw = $cleanValue($row[$columnMap['kk_dikeluarkan'] ?? null] ?? null);
                if (!empty($kkDateRaw)) {
                    try {
                        // Try to parse the date string
                        $kkDate = \Carbon\Carbon::parse($kkDateRaw);
                        $data['kk_dikeluarkan'] = $kkDate->format('Y-m-d');
                    } catch (\Exception $e) {
                        // If parsing fails, set to null
                        $data['kk_dikeluarkan'] = null;
                        Log::warning('Invalid kk_dikeluarkan date format', [
                            'value' => $kkDateRaw,
                            'row_index' => $rowIndex + 3
                        ]);
                    }
                } else {
                    $data['kk_dikeluarkan'] = null;
                }

                // Build full birth date only if day, month, and year are valid
                $dayRaw = $cleanValue($row[$columnMap['tanggal_lahir'] ?? null] ?? null);
                $monthRaw = $data['bulan_lahir'];
                $yearRaw = $data['tahun_lahir'];

                $day = is_numeric($dayRaw) ? (int)$dayRaw : null;
                $month = is_numeric($monthRaw) ? (int)$monthRaw : null;
                $year = is_numeric($yearRaw) ? (int)$yearRaw : null;

                if ($day && $month && $year && $day >= 1 && $day <= 31 && $month >= 1 && $month <= 12 && $year >= 1900 && $year < 2100) {
                    $data['tanggal_lahir'] = sprintf('%04d-%02d-%02d', $year, $month, $day);
                } else {
                    // Keep components normalized (zero-padded) for UI, but don't store invalid DATE
                    $data['tanggal_lahir'] = null;
                    if ($day) {
                        $data['tanggal_lahir'] = null; // ensure DATE column stays null
                    }
                    if ($month) {
                        $data['bulan_lahir'] = str_pad((string)$month, 2, '0', STR_PAD_LEFT);
                    }
                    if ($year) {
                        $data['tahun_lahir'] = (string)$year;
                    }
                }

                // Validasi data yang diperlukan
                if (empty($data['nik']) || empty($data['nama'])) {
                    $skipped++;
                    Log::warning('Skipping row due to missing required fields', [
                        'row_index' => $rowIndex + 3,
                        'nik' => $data['nik'],
                        'nama' => $data['nama'],
                        'row' => $row,
                    ]);
                    continue;
                }
                
                // Set default values for empty fields
                $data['alamat_kk'] = $data['alamat_kk'] ?: 'Belum Diketahui';
                $data['no_kk'] = $data['no_kk'] ?: 'Belum Diketahui';
                $data['hubungan_kepala_keluarga'] = $data['hubungan_kepala_keluarga'] ?: 'Belum Diketahui';
                $data['tempat_lahir'] = $data['tempat_lahir'] ?: 'Belum Diketahui';
                $data['status_perkawinan'] = $data['status_perkawinan'] ?: 'Belum Diketahui';
                $data['suku'] = $data['suku'] ?: 'Belum Diketahui';
                $data['pendidikan_terakhir'] = $data['pendidikan_terakhir'] ?: 'Belum Diketahui';
                $data['mata_pencaharian'] = $data['mata_pencaharian'] ?: 'Belum Diketahui';
                $data['pekerjaan_tambahan'] = $data['pekerjaan_tambahan'] ?: '-';
                $data['komoditas_utama'] = $data['komoditas_utama'] ?: '-';
                $data['komoditas_buah_sayur'] = $data['komoditas_buah_sayur'] ?: '-';
                $data['bantuan'] = $data['bantuan'] ?: '-';
                $data['status_kepemilikan_rumah'] = $data['status_kepemilikan_rumah'] ?: 'Belum Diketahui';
                $data['status_dinding'] = $data['status_dinding'] ?: 'Belum Diketahui';
                $data['status_atap'] = $data['status_atap'] ?: 'Belum Diketahui';
                $data['penggunaan_listrik'] = $data['penggunaan_listrik'] ?: 'Belum Diketahui';
                $data['mck'] = $data['mck'] ?: 'Belum Diketahui';
                
                // Set default jenis kelamin if not detected
                $data['jenis_kelamin'] = $data['jenis_kelamin'] ?: 'L';
                
                // Cek apakah NIK sudah ada
                $existing = Population::where('nik', $data['nik'])->first();
                if ($existing) {
                    $skipped++;
                    Log::warning('Skipping row due to duplicate NIK', [
                        'row_index' => $rowIndex + 3,
                        'nik' => $data['nik'],
                        'existing_id' => $existing->id,
                    ]);
                    continue;
                }
                
                Population::create($data);
                $imported++;
            }

            return redirect()->route('admin.population.index')->with('success', "Import CSV selesai! $imported data berhasil diimpor, $skipped data di-skip.");
        } catch (\Exception $e) {
            Log::error('Import CSV error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal import CSV: ' . $e->getMessage());
        }
    }

    private function detectCsvFormat($csvData)
    {
        if (empty($csvData) || count($csvData) < 2) {
            Log::error('CSV data is empty or has less than 2 rows');
            return 'unknown';
        }

        // Find the actual header row (skip empty rows at the beginning)
        $headerRow = null;
        $headerRowIndex = 0;
        
        for ($i = 0; $i < count($csvData); $i++) {
            $row = $csvData[$i];
            // Check if this row contains "No" and "Nama" (not all empty)
            if (!empty($row[0]) && $row[0] === 'No' && !empty($row[1]) && $row[1] === 'Nama') {
                $headerRow = $row;
                $headerRowIndex = $i;
                break;
            }
        }

        if (!$headerRow) {
            Log::error('No header row found in CSV', [
                'first_few_rows' => array_slice($csvData, 0, 3)
            ]);
            return 'unknown';
        }

        // Log the header row for debugging
        Log::info('CSV Detection - Header row found:', [
            'row_index' => $headerRowIndex,
            'row' => $headerRow,
            'count' => count($headerRow)
        ]);

        // Check for DUSUN 1 format (1 empty column at start, "No" at column 1)
        if (empty($headerRow[0]) && !empty($headerRow[1]) && $headerRow[1] === 'No' && !empty($headerRow[2]) && $headerRow[2] === 'Nama') {
            Log::info('Detected format: dusun1');
            return 'dusun1';
        }

        // Check for DUSUN 2 format (no empty columns at start, "No" at column 0)
        if (!empty($headerRow[0]) && $headerRow[0] === 'No' && !empty($headerRow[1]) && $headerRow[1] === 'Nama') {
            // Check if it's DUSUN 2 by looking for "Alamat " (with space) or "Alamat" (without space)
            $alamatField = $headerRow[2] ?? '';
            if (strpos($alamatField, 'Alamat') === 0) {
                Log::info('Detected format: dusun2', ['alamat_field' => $alamatField]);
                return 'dusun2';
            }
        }

        // Check for DATA DESA format (no empty columns at start, "No" at column 0)
        if (!empty($headerRow[0]) && $headerRow[0] === 'No' && !empty($headerRow[1]) && $headerRow[1] === 'Nama') {
            // Check if it's DATA DESA by looking for "Alamat kk" specifically
            $alamatField = $headerRow[2] ?? '';
            if ($alamatField === 'Alamat kk') {
                Log::info('Detected format: data_desa', ['alamat_field' => $alamatField]);
                return 'data_desa';
            }
        }

        // Fallback: If we have "No" in first column and "Nama" in second column, assume it's a valid format
        if (!empty($headerRow[0]) && $headerRow[0] === 'No' && !empty($headerRow[1]) && $headerRow[1] === 'Nama') {
            Log::info('Fallback detection: Using data_desa format');
            return 'data_desa';
        }

        Log::error('CSV format completely unrecognized', [
            'header_row' => $headerRow,
            'column_count' => count($headerRow)
        ]);

        return 'unknown';
    }

    private function getColumnMapping($csvFormat)
    {
        switch ($csvFormat) {
            case 'dusun1':
                return [
                    'no' => 1,
                    'nama' => 2,
                    'alamat_kk' => 3,
                    'kk_dikeluarkan' => 4,
                    'no_kk' => 5,
                    'nik' => 6,
                    'laki_laki' => 7,
                    'perempuan' => 8,
                    'hubungan_kepala_keluarga' => 9,
                    'tempat_lahir' => 10,
                    'tanggal_lahir' => 11,
                    'bulan_lahir' => 12,
                    'tahun_lahir' => 13,
                    'status_perkawinan' => 14,
                    'suku' => 15,
                    'pendidikan_terakhir' => 16,
                    'mata_pencaharian' => 17,
                    'pekerjaan_tambahan' => 18,
                    'mobil' => 19,
                    'motor' => 20,
                    'sepeda' => 21,
                    'sapi' => 22,
                    'kambing' => 23,
                    'ayam' => 24,
                    'ikan' => 25,
                    'luas_lahan_pertanian' => 26,
                    'luas_lahan_peternakan' => 27,
                    'komoditas_utama' => 28,
                    'komoditas_buah_sayur' => 29,
                    'bantuan' => 31,
                    'status_kepemilikan_rumah' => 32,
                    'status_dinding' => 33,
                    'status_atap' => 34,
                    'penggunaan_listrik' => 35,
                    'mck' => 36,
                ];
            case 'dusun2':
                return [
                    'no' => 0,
                    'nama' => 1,
                    'alamat_kk' => 2,
                    'kk_dikeluarkan' => 3,
                    'no_kk' => 4,
                    'nik' => 5,
                    'laki_laki' => 6,
                    'perempuan' => 7,
                    'hubungan_kepala_keluarga' => 8,
                    'tempat_lahir' => 9,
                    'tanggal_lahir' => 10,
                    'bulan_lahir' => 11,
                    'tahun_lahir' => 12,
                    'status_perkawinan' => 13,
                    'suku' => 14,
                    'pendidikan_terakhir' => 15,
                    'mata_pencaharian' => 16,
                    'pekerjaan_tambahan' => 17,
                    'mobil' => 18,
                    'motor' => 19,
                    'sepeda' => 20,
                    'sapi' => 21,
                    'kambing' => 22,
                    'ayam' => 23,
                    'ikan' => 24, // Add ikan column for DUSUN 2
                    'luas_lahan_pertanian' => 25,
                    'luas_lahan_peternakan' => 26,
                    'komoditas_utama' => 27,
                    'komoditas_buah_sayur' => 28,
                    'bantuan' => 29,
                    'status_kepemilikan_rumah' => 30,
                    'status_dinding' => 31,
                    'status_atap' => 32,
                    'penggunaan_listrik' => 33,
                    'mck' => 34,
                ];
            case 'data_desa':
                return [
                    'no' => 0,
                    'nama' => 1,
                    'alamat_kk' => 2,
                    'kk_dikeluarkan' => 3,
                    'no_kk' => 4,
                    'nik' => 5,
                    'laki_laki' => 6,
                    'perempuan' => 7,
                    'hubungan_kepala_keluarga' => 8,
                    'tempat_lahir' => 9,
                    'tanggal_lahir' => 10,
                    'bulan_lahir' => 11,
                    'tahun_lahir' => 12,
                    'status_perkawinan' => 13,
                    'suku' => 14,
                    'pendidikan_terakhir' => 15,
                    'mata_pencaharian' => 16,
                    'pekerjaan_tambahan' => 17,
                    'mobil' => 18,
                    'motor' => 19,
                    'sepeda' => 20,
                    'sapi' => 21,
                    'kambing' => 22,
                    'ayam' => 23,
                    'ikan' => 24,
                    'luas_lahan_pertanian' => 25,
                    'luas_lahan_peternakan' => 26,
                    'komoditas_utama' => 27,
                    'komoditas_buah_sayur' => 28,
                    'bantuan' => 29,
                    'status_kepemilikan_rumah' => 30,
                    'status_dinding' => 31,
                    'status_atap' => 32,
                    'penggunaan_listrik' => 33,
                    'mck' => 34,
                ];
            default:
                return [];
        }
    }
}
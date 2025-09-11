<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    public function index()
    {
        // Ambil semua bidang unik
        $bidangs = Facility::select('bidang')->distinct()->pluck('bidang')->filter()->values();
        // Group data per bidang
        $facilitiesByBidang = Facility::orderBy('bidang')->orderBy('nama')->get()->groupBy('bidang');
        return view('facilities.index', compact('facilitiesByBidang', 'bidangs'));
    }

    public function show($id)
    {
        $facility = Facility::findOrFail($id);
        return view('facilities.show', compact('facility'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'bidang' => 'required|string|max:100',
                'deskripsi' => 'nullable|string',
                'jumlah_unit' => 'required|integer|min:0',
            ]);
            
            // Set default values for fields not in form
            $validated['jenis'] = 'sarana'; // Default to sarana
            $validated['gambar'] = null; // No image by default
            $validated['status'] = 'aktif'; // Default to aktif
            
            Facility::create($validated);
            return redirect()->route('admin.facilities')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi. Silakan periksa kembali data yang diinput.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $facility = Facility::findOrFail($id);
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'bidang' => 'required|string|max:100',
                'deskripsi' => 'nullable|string',
                'jumlah_unit' => 'required|integer|min:0',
            ]);
            
            // Keep existing values for fields not in form
            $validated['jenis'] = $facility->jenis; // Keep existing jenis
            $validated['gambar'] = $facility->gambar; // Keep existing gambar
            $validated['status'] = $facility->status; // Keep existing status
            
            $facility->update($validated);
            return redirect()->route('admin.facilities')->with('success', 'Data berhasil diupdate!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi. Silakan periksa kembali data yang diinput.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $facility = Facility::findOrFail($id);
            
            // Delete associated image if exists
            if ($facility->gambar && Storage::disk('public')->exists($facility->gambar)) {
                Storage::disk('public')->delete($facility->gambar);
            }
            
            $facility->delete();
            return redirect()->route('admin.facilities')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.facilities')->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'bidang' => 'required|string|max:100',
            'jenis' => 'required|in:sarana,prasarana',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('facilities', 'public');
        }
        Facility::create($validated);
        return redirect()->route('facilities.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $facility = Facility::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'bidang' => 'required|string|max:100',
            'jenis' => 'required|in:sarana,prasarana',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($facility->gambar && \Storage::disk('public')->exists($facility->gambar)) {
                \Storage::disk('public')->delete($facility->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('facilities', 'public');
        }
        $facility->update($validated);
        return redirect()->route('facilities.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        if ($facility->gambar && \Storage::disk('public')->exists($facility->gambar)) {
            \Storage::disk('public')->delete($facility->gambar);
        }
        $facility->delete();
        return redirect()->route('facilities.index')->with('success', 'Data berhasil dihapus!');
    }
}

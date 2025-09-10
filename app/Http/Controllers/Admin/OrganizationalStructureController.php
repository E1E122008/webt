<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrganizationalStructure;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrganizationalStructureController extends Controller
{
    public function __construct()
    {
        // Middleware is handled at route level
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $structures = OrganizationalStructure::orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.organizational-structure.index', compact('structures'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'role_type' => 'required|in:kepala_desa,perangkat,bpd,lpm,dusun,rt,lainnya',
            'role_text' => 'nullable|string|max:255',
            'info' => 'nullable|string',
            'term_period' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
            'name', 'position', 'role_type', 'role_text', 
            'info', 'term_period', 'sort_order'
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $path = $photo->storeAs('public/FOTO/struktur', $filename);
            $data['photo_path'] = 'storage/FOTO/struktur/' . $filename;
        }

        // Set default values
        $data['term_period'] = $data['term_period'] ?? '2024 - Sekarang';
        $data['sort_order'] = $data['sort_order'] ?? 0;

        OrganizationalStructure::create($data);

        return redirect()->route('admin.organizational-structure.index')
            ->with('success', 'Struktur organisasi berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $structure = OrganizationalStructure::findOrFail($id);
        return response()->json($structure);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $structure = OrganizationalStructure::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'role_type' => 'required|in:kepala_desa,perangkat,bpd,lpm,dusun,rt,lainnya',
            'role_text' => 'nullable|string|max:255',
            'info' => 'nullable|string',
            'term_period' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
            'name', 'position', 'role_type', 'role_text', 
            'info', 'term_period', 'sort_order'
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($structure->photo_path && Storage::exists(str_replace('storage/', 'public/', $structure->photo_path))) {
                Storage::delete(str_replace('storage/', 'public/', $structure->photo_path));
            }

            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $path = $photo->storeAs('public/FOTO/struktur', $filename);
            $data['photo_path'] = 'storage/FOTO/struktur/' . $filename;
        }

        $structure->update($data);

        return redirect()->route('admin.organizational-structure.index')
            ->with('success', 'Struktur organisasi berhasil diperbarui!');
    }

    /**
     * Toggle status of the specified resource.
     */
    public function toggleStatus(Request $request, $id)
    {
        $structure = OrganizationalStructure::findOrFail($id);
        $structure->update(['is_active' => $request->is_active]);

        $status = $request->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return response()->json(['message' => "Struktur berhasil {$status}"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $structure = OrganizationalStructure::findOrFail($id);

        // Delete photo if exists
        if ($structure->photo_path && Storage::exists(str_replace('storage/', 'public/', $structure->photo_path))) {
            Storage::delete(str_replace('storage/', 'public/', $structure->photo_path));
        }

        $structure->delete();

        return redirect()->route('admin.organizational-structure.index')
            ->with('success', 'Struktur organisasi berhasil dihapus!');
    }

    /**
     * Reorder structures
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'structures' => 'required|array',
            'structures.*.id' => 'required|exists:organizational_structures,id',
            'structures.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->structures as $item) {
            OrganizationalStructure::where('id', $item['id'])
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['message' => 'Urutan berhasil diperbarui']);
    }
}

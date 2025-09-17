<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::ordered()->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        Log::info('Announcements.store called', ['input' => $request->all()]);
        // Normalise checkbox before validation so rule 'boolean' passes
        $request->merge([
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'announcement_date' => 'required|date',
            'announcement_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'attachment' => 'nullable|file|max:10240'
        ]);

        $data = $request->except('attachment');
        $data['is_active'] = (bool) $request->input('is_active');
        // Normalise time to HH:MM:SS for MySQL TIME columns
        if (!empty($data['announcement_time']) && preg_match('/^\d{2}:\d{2}$/', $data['announcement_time'])) {
            $data['announcement_time'] = $data['announcement_time'] . ':00';
        }

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('announcements', 'public');
            $data['attachment_path'] = $path;
        }

        try {
            $announcement = Announcement::create($data);
            Log::info('Announcement created', ['id' => $announcement->id]);
            return redirect()->route('admin.announcements.index')
                ->with('success', 'Pengumuman berhasil ditambahkan');
        } catch (\Throwable $e) {
            Log::error('Failed to create announcement', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['general' => 'Gagal menyimpan pengumuman: '.$e->getMessage()])->withInput();
        }
    }

    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        // Normalise checkbox before validation
        $request->merge([
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'announcement_date' => 'required|date',
            'announcement_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'attachment' => 'nullable|file|max:10240'
        ]);

        $data = $request->except('attachment');
        $data['is_active'] = (bool) $request->input('is_active');
        if (!empty($data['announcement_time']) && preg_match('/^\d{2}:\d{2}$/', $data['announcement_time'])) {
            $data['announcement_time'] = $data['announcement_time'] . ':00';
        }

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('announcements', 'public');
            $data['attachment_path'] = $path;
        }

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengumuman berhasil dihapus'
            ]);
        }

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus');
    }

    public function toggleStatus(Announcement $announcement)
    {
        $announcement->update([
            'is_active' => !$announcement->is_active
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Status pengumuman berhasil diubah');
    }
}

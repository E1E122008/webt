<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{

    public function index()
    {
        $news = News::with('author')->latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required|in:umum,pertanian,sosial,ekonomi,pemerintahan',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published'
        ]);

        $data = $request->all();
        $data['author_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
            $data['image'] = $imagePath;
        }

        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        News::create($data);

        return redirect()->route('admin.news')
            ->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required|in:umum,pertanian,sosial,ekonomi,pemerintahan',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            
            $imagePath = $request->file('image')->store('news', 'public');
            $data['image'] = $imagePath;
        }

        if ($request->status === 'published' && $news->status === 'draft') {
            $data['published_at'] = now();
        }

        $news->update($data);

        return redirect()->route('admin.news')
            ->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy(News $news)
    {
        try {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            $newsTitle = $news->title;
            $news->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berita "' . $newsTitle . '" berhasil dihapus'
                ]);
            }

            return redirect()->route('admin.news')
                ->with('success', 'Berita berhasil dihapus');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus berita: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.news')
                ->with('error', 'Gagal menghapus berita');
        }
    }

    public function toggleStatus(News $news)
    {
        $news->update([
            'status' => $news->status === 'published' ? 'draft' : 'published',
            'published_at' => $news->status === 'draft' ? now() : null
        ]);

        return redirect()->route('admin.news')
            ->with('success', 'Status berita berhasil diubah');
    }
}

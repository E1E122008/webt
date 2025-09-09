<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews = News::published()->latest('published_at')->take(4)->get();
        $siteSettings = \App\Helpers\SettingsHelper::getAll();
        return view('home', compact('latestNews', 'siteSettings'));
    }

    public function about()
    {
        // Load struktur organisasi data untuk halaman about
        $struktur = [];
        $path = public_path('data/struktur.json');
        
        if (File::exists($path)) {
            $decoded = json_decode(File::get($path), true);
            if ($decoded !== null) {
                $struktur = $decoded;
            }
        }
        
        return view('about', compact('struktur'));
    }

    public function contact()
    {
        // Load struktur organisasi data untuk halaman contact
        $struktur = [];
        $path = public_path('data/struktur.json');
        
        if (File::exists($path)) {
            $decoded = json_decode(File::get($path), true);
            if ($decoded !== null) {
                $struktur = $decoded;
            }
        }
        
        // Load site settings for social media and contact info
        $siteSettings = \App\Helpers\SettingsHelper::getAll();
        
        return view('contact', compact('struktur', 'siteSettings'));
    }

    public function news()
    {
        return view('news');
    }

    public function potensi()
    {
        // Load struktur organisasi data untuk halaman potensi
        $struktur = [];
        $path = public_path('data/struktur.json');
        
        if (File::exists($path)) {
            $decoded = json_decode(File::get($path), true);
            if ($decoded !== null) {
                $struktur = $decoded;
            }
        }
        
        return view('potensi', compact('struktur'));
    }

    public function program()
    {
        return view('program');
    }

    public function galeri()
    {
        // Get media (images and videos) from kegiatan folder with descriptions
        $kegiatanPath = public_path('FOTO/kegiatan');
        $descriptionsPath = public_path('FOTO/kegiatan/descriptions.json');
        $media = [];
        
        // Load descriptions if exists
        $descriptions = [];
        if (File::exists($descriptionsPath)) {
            $descriptions = json_decode(File::get($descriptionsPath), true) ?? [];
        }
        
        if (File::exists($kegiatanPath)) {
            $files = File::files($kegiatanPath);
            foreach ($files as $file) {
                $filename = $file->getFilename();
                // Skip descriptions.json file
                if ($filename === 'descriptions.json') continue;

                $extension = strtolower($file->getExtension());
                $isVideo = in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'ogg']);

                $media[] = [
                    'name' => $filename,
                    'path' => '/FOTO/kegiatan/' . $filename,
                    'description' => $descriptions[$filename]['description'] ?? null,
                    'category' => $descriptions[$filename]['category'] ?? null,
                    'image_date' => $descriptions[$filename]['image_date'] ?? null,
                    'type' => $descriptions[$filename]['type'] ?? ($isVideo ? 'video' : 'image')
                ];
            }
        }
        
        return view('galeri', compact('media'));
    }

    public function statistik()
    {
        return view('statistik');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function visiMisi()
    {
        return view('profile.visi-misi');
    }

    public function struktur()
    {
        $struktur = [];
        $path = public_path('data/struktur.json');
        if (file_exists($path)) {
            $json = @file_get_contents($path);
            if ($json !== false) {
                $decoded = json_decode($json, true);
                if (is_array($decoded)) {
                    $struktur = $decoded;
                }
            }
        }
        return view('profile.struktur', compact('struktur'));
    }

    public function demografi()
    {
        // Ambil data sarana & prasarana dari database
        $facilities = \App\Models\Facility::orderBy('jenis')->orderBy('nama')->get();
        return view('profile.demografi', compact('facilities'));
    }
}

@extends('layouts.app')

@section('title', $facility->nama . ' - Sarana/Prasarana')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if($facility->gambar)
                    <img src="{{ asset('storage/' . $facility->gambar) }}" class="card-img-top" alt="{{ $facility->nama }}">
                @endif
                <div class="card-body">
                    <h3 class="card-title mb-2">{{ $facility->nama }}</h3>
                    <span class="badge bg-info">{{ ucfirst($facility->jenis) }}</span>
                    <span class="badge bg-success">{{ ucfirst($facility->status) }}</span>
                    <p class="mt-3">{!! nl2br(e($facility->deskripsi)) !!}</p>
                    <a href="{{ route('facilities.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

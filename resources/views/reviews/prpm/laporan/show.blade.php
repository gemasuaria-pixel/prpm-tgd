@extends('layouts.app')

@section('title', 'Detail Laporan Penelitian')

@section('content')
<div class="container py-4">

    {{-- 🔹 Tombol Kembali --}}
    <div class="mb-3">
        <a href="{{ route('ketua-prpm.review.laporan.index') }}" class="btn btn-light border rounded-pill px-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- 🔹 Card Detail --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Detail Laporan Penelitian</h5>

            <div class="row mb-2">
                <div class="col-md-4 fw-semibold">Judul Penelitian</div>
                <div class="col-md-8">{{ $laporan->judul ?? '-' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 fw-semibold">Peneliti</div>
                <div class="col-md-8">{{ $laporan->user->name ?? '-' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 fw-semibold">Tanggal Upload</div>
                <div class="col-md-8">{{ $laporan->created_at->format('d M Y') }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 fw-semibold">File Laporan</div>
                <div class="col-md-8">
                    @if ($laporan->document && $laporan->document->file_path)
                        <a href="{{ asset('storage/' . $laporan->document->file_path) }}" target="_blank" class="btn btn-primary btn-sm">
                            <i class="bi bi-file-earmark-text"></i> Lihat File
                        </a>
                    @else
                        <span class="text-muted">Belum ada file</span>
                    @endif
                </div>
            </div>

            @if ($laporan->document && $laporan->document->link_jurnal)
                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">Link Jurnal</div>
                    <div class="col-md-8">
                        <a href="{{ $laporan->document->link_jurnal }}" target="_blank" class="text-decoration-underline text-primary">
                            {{ $laporan->document->link_jurnal }}
                        </a>
                    </div>
                </div>
            @endif

            @if ($laporan->document && $laporan->document->link_video)
                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">Link Video</div>
                    <div class="col-md-8">
                        <a href="{{ $laporan->document->link_video }}" target="_blank" class="text-decoration-underline text-primary">
                            {{ $laporan->document->link_video }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- 🔹 Bagian Review --}}
    @if ($laporan->reviews->isNotEmpty())
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body">
            <h6 class="fw-semibold text-primary mb-2">Hasil Review</h6>
            <div class="list-group list-group-flush">
                @foreach ($laporan->reviews as $review)
                    <div class="list-group-item px-0">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 fw-semibold">{{ $review->reviewer->name }}</h6>
                            <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                        </div>
                        <p class="mb-1">{{ $review->komentar ?? '-' }}</p>
                        <span class="badge 
                            @if ($review->status == 'approved_by_prpm') bg-success-subtle text-success 
                            @elseif($review->status == 'rejected') bg-danger-subtle text-danger 
                            @else bg-warning-subtle text-warning @endif">
                            {{ ucfirst(str_replace('_',' ',$review->status)) }}
                        </span>
                    </div>
                @endforeach
            </div>

            {{-- 🔸 Tombol Final jika semua reviewer sudah review --}}
            @if ($laporan->reviews->every(fn($r) => $r->status !== null))
                <div class="mt-3 text-end">
                    <form action="{{ route('review.laporan.final', $laporan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            <i class="bi bi-check2-circle"></i> Finalkan
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
    @endif

</div>
@endsection

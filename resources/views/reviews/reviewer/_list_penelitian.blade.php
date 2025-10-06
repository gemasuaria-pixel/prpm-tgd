@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Form Review Proposal Penelitian</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5>{{ $review->reviewable->judul_penelitian }}</h5>
            <p><strong>Bidang:</strong> {{ $review->reviewable->bidang_penelitian }}</p>
            <p><strong>Rumpun Ilmu:</strong> {{ $review->reviewable->rumpun_ilmu }}</p>

            <hr>

            <form method="POST" action="{{ route('reviewer.review-submit', $review->id) }}">
                @csrf

                <div class="mb-3">
                    <label for="komentar" class="form-label">Komentar Reviewer</label>
                    <textarea name="komentar" id="komentar" class="form-control" rows="5" required>{{ old('komentar', $review->komentar) }}</textarea>
                    @error('komentar')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nilai" class="form-label">Nilai (0 - 100)</label>
                    <input type="number" name="nilai" id="nilai" class="form-control" 
                        min="0" max="100" step="1" value="{{ old('nilai', $review->nilai) }}" required>
                    @error('nilai')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('reviewer.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.main')

@section('content')
<div class="container">
    <h3>Daftar Proposal yang Harus Direview</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Status Review</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $review)
                <tr>
                    <td>{{ $review->reviewable->judul_penelitian }}</td>
                    <td>{{ ucfirst($review->status) }}</td>
                    <td>
                        <a href="{{ route('reviewer.review-form', $review->id) }}" class="btn btn-primary">Beri Review</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

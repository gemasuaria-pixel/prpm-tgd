@extends('layouts.main')

@section('content')
<div class="container">
    <h4>Daftar Usulan Menunggu Persetujuan</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Ketua Pengusul</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proposals as $proposal)
                <tr>
                    <td>{{ $proposal->judul_penelitian }}</td>
                    <td>{{ $proposal->ketua_pengusul }}</td>
                    <td><span class="badge bg-warning">{{ $proposal->status }}</span></td>
                    <td>
                        <form action="{{ route('review.update', $proposal->id) }}" method="POST">
                            @csrf
                            <select name="status" class="form-select form-select-sm">
                                <option value="approved">Setujui</option>
                                <option value="rejected">Tolak</option>
                                <option value="revision">Minta Revisi</option>
                            </select>
                            <textarea name="catatan_reviewer" class="form-control mt-2" placeholder="Catatan (opsional)"></textarea>
                            <button type="submit" class="btn btn-primary btn-sm mt-2">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

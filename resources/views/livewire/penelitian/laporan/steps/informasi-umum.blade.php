<div>
    <h6 class="fw-bold border-bottom pb-2">Informasi Umum</h6>
    <div class="row mt-2">
        <div class="col-md-12">
            <label class="small text-muted">judul proposal</label>
            <div class="fw-semibold">{{ $proposal->judul }}</div>
        </div>
        <div class="col-md-4">
            <label class="small text-muted">Tahun Pelaksanaan</label>
            <div class="fw-semibold">{{ $proposal->tahun_pelaksanaan }}</div>
        </div>
        <div class="col-md-4">
            <label class="small text-muted">Rumpun Ilmu</label>
            <div class="fw-semibold">{{ $proposal->rumpun_ilmu }}</div>
        </div>
        <div class="col-md-4">
            <label class="small text-muted">Bidang Ilmu</label>
            <div class="fw-semibold">{{ $proposal->bidang_penelitian }}</div>
        </div>
    </div>

    <h6 class="fw-bold mt-4 border-bottom pb-2">B. Anggota</h6>

    <table class="table table-sm table-bordered mt-3">
        <thead class="table-light">
            <tr>
                <th>Nama</th>
                <th>NIDN</th>
                <th>Alamat</th>
                <th>Kontak</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proposal->anggota as $anggota)
                <tr>
                    <td>{{ $anggota->individu->name }}</td>
                    <td>{{ $anggota->individu->nidn ?? '-' }}</td>
                    <td>{{ $anggota->individu->alamat ?? '-' }}</td>
                    <td>{{ $anggota->individu->kontak ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

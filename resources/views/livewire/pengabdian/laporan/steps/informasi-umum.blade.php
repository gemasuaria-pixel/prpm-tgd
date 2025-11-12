<div>
    <h5 class="fw-bold mb-4 text-primary">A. Informasi Proposal</h5>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <label class="form-label fw-semibold">Judul Proposal</label>
            <div>{{ $proposal->judul }}</div>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Tahun Pelaksanaan</label>
            <div>{{ $proposal->tahun_pelaksanaan }}</div>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Rumpun Ilmu</label>
            <div>{{ $proposal->rumpun_ilmu }}</div>
        </div>
    </div>

    <h6 class="fw-bold mt-4">B. Anggota Dosen</h6>
    <table class="table table-bordered mt-2">
        <thead class="table-light">
            <tr>
                <th>Nama</th>
                <th>NIDN</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
          @foreach ($proposal->anggota as $anggota)
                <tr>
                    @if ($anggota->individu instanceof App\Models\User)
            <tr>
              <td>{{ $anggota->individu->name }}</td>
              <td>{{ $anggota->individu->nidn }}</td>
              <td>{{ $anggota->individu->alamat }}</td>
            </tr>
        @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <h6 class="fw-bold mt-4">C. Anggota Mahasiswa</h6>
    <table class="table table-bordered mt-2">
        <thead class="table-light">
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Program Studi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proposal->anggota as $anggota)
                <tr>
                     @if ($anggota->individu instanceof App\Models\Mahasiswa)
            <tr>
              <td>{{ $anggota->individu->nama }}</td>
              <td>{{ $anggota->individu->nim }}</td>
              <td>{{ $anggota->individu->program_studi }}</td>
            </tr>
        @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <h6 class="fw-bold mt-4">D. Informasi Mitra</h6>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label fw-semibold">Nama Mitra</label>
            <div>{{ $proposal->nama_mitra ?? '-' }}</div>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Jenis Mitra</label>
            <div>{{ $proposal->jenis_mitra ?? '-' }}</div>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Kontak Mitra</label>
            <div>{{ $proposal->kontak_mitra ?? '-' }}</div>
        </div>
        <div class="col-md-12">
            <label class="form-label fw-semibold">Alamat Mitra</label>
            <div>{{ $proposal->alamat_mitra ?? '-' }}</div>
        </div>
    </div>
</div>

@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h4 class="mb-4">Form Review Laporan Penelitian</h4>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                @php
                    /** @var \App\Models\Penelitian\LaporanPenelitian $laporan */
                    $laporan = $review->reviewable;
                    $proposal = $laporan->proposalPenelitian ?? null;

                    // Ambil external links dari laporan (bukan dari proposal)
                    $externalLinksRaw = $laporan->external_links ?? null;
                    $externalLinks = [];

                    if (!empty($externalLinksRaw)) {
                        // Jika sudah JSON array/object
                        if (is_string($externalLinksRaw)) {
                            $decoded = json_decode($externalLinksRaw, true);
                            if (json_last_error() === JSON_ERROR_NONE && !empty($decoded)) {
                                // jika decoded berupa array numerik atau associative
                                if (array_is_list($decoded)) {
                                    $externalLinks = $decoded;
                                } else {
                                    // jika object tunggal, turn menjadi array of one
                                    $externalLinks = [$decoded];
                                }
                            } else {
                                // bukan JSON valid — anggap sebagai single URL string
                                $externalLinks = [['type' => 'link', 'url' => $externalLinksRaw]];
                            }
                        } elseif (is_array($externalLinksRaw)) {
                            // kalau kolom sudah disimpan sebagai array (cast), gunakan langsung
                            $externalLinks = $externalLinksRaw;
                        }
                    }

                    // helper: aman untuk akses nama ketua
                    $ketuaName = optional($proposal->ketuaPengusul)->name ?? '-';
                @endphp

                {{-- ================== INFORMASI LAPORAN & PROPOSAL ================== --}}
                <h5 class="fw-semibold text-primary mb-3">{{ $laporan->judul ?? '-'}}</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Ketua Pengusul:</strong> {{ $ketuaName }}</p>
                        <p><strong>Rumpun Ilmu:</strong> {{ $proposal->rumpun_ilmu ?? '-' }}</p>
                        <p><strong>Bidang Penelitian:</strong>{{ $proposal->bidang_penelitian ?? '-' }}</p>
                        <p><strong>Tahun Pelaksanaan:</strong> {{ $proposal->tahun_pelaksanaan ?? '-' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Kata Kunci:</strong> {{ $laporan->kata_kunci ?? '-' }}</p>
                        <p>
                            <strong>Dokumen Laporan:</strong><br>
                            @if ($laporan->documents && $laporan->documents->count() > 0)
                                @foreach ($laporan->documents as $doc)
                                    <a href="{{ asset('storage/' . ($doc->file_path ?? '')) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary mt-1 w-auto">
                                        <i class="bi bi-file-earmark-text me-1"></i> {{ ucfirst($doc->tipe ?? 'Dokumen') }}
                                    </a>
                                @endforeach
                            @else
                                <span class="text-muted">Belum ada dokumen laporan</span>
                            @endif
                        </p>
                    </div>
                </div>



                {{-- ================== RINGKASAN ================== --}}
                <div class="mb-4">
                    <strong>Ringkasan Hasil Penelitian:</strong>
                    <div class="border rounded p-3 bg-light mt-1">
                        {{ $laporan->ringkasan_laporan ?? (optional($proposal->infoPenelitian)->abstrak ?? 'Belum ada ringkasan hasil.') }}
                    </div>
                </div>

                {{-- ================== LINK EKSTERNAL (di LAPORAN) ================== --}}
                @if (!empty($externalLinks))
                    <div class="mb-4">
                        <strong>Link Luaran Penelitian:</strong>
                        <ul class="list-group list-group-flush mt-2">
                            @foreach ($externalLinks as $link)
                                @php
                                    // aman-aman: pastikan struktur minimal ['url'=>..., 'type'=>...]
                                    $type = strtolower($link['type'] ?? 'link');
                                    $url = $link['url'] ?? ($link['link'] ?? null);
                                @endphp

                                @if ($url)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            @if ($type === 'video')
                                                <i class="bi bi-play-circle text-danger me-1"></i>
                                                <strong>Video:</strong>
                                            @elseif ($type === 'jurnal' || $type === 'journal')
                                                <i class="bi bi-journal-text text-primary me-1"></i>
                                                <strong>Jurnal:</strong>
                                            @else
                                                <i class="bi bi-link-45deg text-secondary me-1"></i>
                                                <strong>Link:</strong>
                                            @endif

                                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer">
                                                {{ \Illuminate\Support\Str::limit($url, 80) }}
                                            </a>
                                        </div>

                                        <span class="badge bg-light text-dark text-capitalize">{{ $type }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="mb-4">
                        <strong>Link Eksternal:</strong>
                        <div class="text-muted mt-2">Tidak ada link eksternal pada laporan ini.</div>
                    </div>
                @endif

                {{-- ================== ANGGOTA PENELITIAN ================== --}}
                <div class="mb-4">
                    <strong>Daftar Anggota Penelitian:</strong>
                    <div class="table-responsive mt-2">
                        <table class="table table-sm table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>NIDN</th>
                                    <th>Alamat</th>
                                    <th>Kontak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($proposal->anggotaDosen ?? [] as $anggota)
                                    <tr>
                                        <td>{{ $anggota->user->name ?? ($anggota->name ?? '-') }}</td>
                                        <td>{{ $anggota->user->nidn ?? '-' }}</td>
                                        <td>{{ $anggota->user->alamat ?? '-' }}</td>
                                        <td>{{ $anggota->user->kontak ?? ($anggota->phone ?? '-') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-2">
                                            Belum ada anggota penelitian.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr>

                {{-- ================== FORM REVIEW ================== --}}
                <form method="POST" action="{{ route('reviewer.laporan.submit', $review->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="komentar" class="form-label fw-semibold">Komentar Reviewer</label>
                        <textarea name="komentar" id="komentar" class="form-control" rows="5" required>{{ old('komentar', $review->komentar) }}</textarea>
                        @error('komentar')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status Review</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="approved" {{ old('status', $review->status) == 'approved' ? 'selected' : '' }}>
                                Layak
                            </option>
                            <option value="revisi" {{ old('status', $review->status) == 'revisi' ? 'selected' : '' }}>
                                Revisi
                            </option>
                            <option value="rejected" {{ old('status', $review->status) == 'rejected' ? 'selected' : '' }}>
                                Tidak Layak
                            </option>
                           
                        </select>
                        @error('status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="d-flex justify-content-between">
                        <a href="{{ route('reviewer.laporan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Simpan Review
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

<?php

namespace App\Http\Controllers\Penelitian\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Penelitian\LaporanPenelitian;
use App\Models\Penelitian\ProposalPenelitian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    /**
     *  Tampilkan form upload laporan untuk proposal final
     */
    public function index(ProposalPenelitian $proposal)
    {
        $user = Auth::user();

        // Pastikan proposal milik dosen yang login
        if ($proposal->ketua_pengusul_id !== $user->id) {
            abort(403, 'Anda tidak berhak mengakses proposal ini.');
        }

        if ($proposal->status !== 'final') {
            abort(403, 'Proposal belum berstatus final.');
        }

        // Load relasi anggota
        $proposal->load('anggota');

        return view('penelitian.laporan.create', compact('proposal'));
    }

    /**
     *  Simpan laporan penelitian
     */
    public function store(Request $request, ProposalPenelitian $proposal)
    {

        //  Pastikan proposal milik dosen
        if ($proposal->ketua_pengusul_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengunggah laporan untuk proposal ini.');
        }
        // validasi form
        $request->validate([
            // 'abstrak' => 'nullable|string',
            'judul' => 'nullable|string|max:255',
            'kata_kunci' => 'nullable|string|max:255',
            'metode_penelitian' => 'nullable|string|max:255',
            'ringkasan_laporan' => 'nullable|string|max:255',
            'file_laporan' => 'required|file|mimes:pdf,doc,docx|max:25000',
            'luaran.jurnal.*' => 'nullable|url',
            'luaran.video.*' => 'nullable|url',
        ]);


        // cek laporan existing
        if ($proposal->laporanPenelitian()->exists()) {
            return redirect()->back()->with('error', 'Proposal ini sudah memiliki laporan.');
        }

        //  Simpan laporan
        $laporan = LaporanPenelitian::create([
            'judul' => $request->judul,
            'proposal_penelitian_id' => $proposal->id,
            // 'abstrak' => $request->abstrak,
            'kata_kunci' => $request->kata_kunci,
            'metode_penelitian' => $request->metode_penelitian,
            'ringkasan_laporan' => $request->ringkasan_laporan,
            'status' => 'menunggu_validasi_prpm',
            'komentar_prpm' => null,
        ]);

        $externalLinks = [];
        if ($request->filled('luaran.jurnal')) {
            foreach ($request->luaran['jurnal'] as $link) {
                if ($link) {
                    $externalLinks[] = ['type' => 'jurnal', 'url' => $link];
                }
            }
        }
        if ($request->filled('luaran.video')) {
            foreach ($request->luaran['video'] as $link) {
                if ($link) {
                    $externalLinks[] = ['type' => 'video', 'url' => $link];
                }
            }
        }

        // Simpan JSON ke kolom external_links
        $laporan->external_links = $externalLinks;
        $laporan->save();
        //  Upload file ke storage
        $path = $request->file('file_laporan')->store('laporan', 'public');

        //  Simpan metadata file ke tabel documents
        $laporan->documents()->create([
            'tipe' => 'laporan_penelitian',
            'file_path' => $path,
        ]);

        return redirect()->route('dosen.penelitian.proposal.create', $proposal)
            ->with('status', 'Laporan berhasil diunggah dan menunggu verifikasi PRPM.');

    }
}

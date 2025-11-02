<?php

namespace App\Http\Controllers\Pengabdian\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Pengabdian\LaporanPengabdian;
use App\Models\Pengabdian\ProposalPengabdian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    /**
     * Tampilkan form upload laporan untuk proposal pengabdian final
     */
    public function index(ProposalPengabdian $proposal)
    {
        $user = Auth::user();

        // Pastikan proposal milik dosen yang login
        if ($proposal->ketua_pengusul_id !== $user->id) {
            abort(403, 'Anda tidak berhak mengakses proposal ini.');
        }

        // Pastikan status final (sama dengan flow penelitian)
        if ($proposal->status !== 'final') {
            abort(403, 'Proposal belum berstatus final.');
        }

        // Load relasi anggota (jika view butuh)
        $proposal->load('anggota');

        return view('pengabdian.laporan.create', compact('proposal'));
    }

    /**
     * Simpan laporan pengabdian
     */
    public function store(Request $request, ProposalPengabdian $proposal)
    {
        // Pastikan proposal milik dosen yang login
        if ($proposal->ketua_pengusul_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengunggah laporan untuk proposal ini.');
        }

        // Validasi form
        $request->validate([
            'judul' => 'nullable|string|max:255',
            'tahun_pelaksanaan' => 'nullable|digits:4',
            'ringkasan' => 'nullable|string|max:1000',
            'file_laporan' => 'required|file|mimes:pdf,doc,docx|max:25000',
            'luaran.jurnal.*' => 'nullable|url',
            'luaran.video.*' => 'nullable|url',
        ]);

        // Cek apakah proposal sudah memiliki laporan
        if ($proposal->laporanPengabdian()->exists()) {
            return redirect()->back()->with('error', 'Proposal ini sudah memiliki laporan.');
        }

        // Simpan laporan
        $laporan = LaporanPengabdian::create([
            'judul' => $request->judul,
            'proposal_pengabdian_id' => $proposal->id,
            'tahun_pelaksanaan' => $request->tahun_pelaksanaan,
            'ringkasan' => $request->ringkasan,
            'status' => 'menunggu_validasi_prpm',
            'komentar_prpm' => null,
        ]);

        // Kumpulkan external links (jurnal & video)
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

        // Simpan JSON ke kolom external_links (pastikan kolom di migration bertipe json/text)
        $laporan->external_links = $externalLinks;
        $laporan->save();

        // Upload file ke storage (disk public)
        $path = $request->file('file_laporan')->store('pengabdian/laporan', 'public');

        // Simpan metadata file ke tabel documents (relasi polymorphic)
        $laporan->documents()->create([
            'tipe' => 'laporan_pengabdian',
            'file_path' => $path,
        ]);

        return redirect()->route('dosen.pengabdian.index', $proposal)
            ->with('status', 'Laporan pengabdian berhasil diunggah dan menunggu verifikasi PRPM.');
    }
}

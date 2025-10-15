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
     * 📝 Tampilkan form upload laporan untuk proposal final
     */
    public function index()
    {
        $user = Auth::user();

        // ✅ Ambil proposal final milik dosen (dengan anggota)
        $proposal = ProposalPenelitian::with('members')
            ->where('ketua_pengusul_id', $user->id)
            ->where('status', 'final')
            ->first();

        if (!$proposal) {
            abort(403, 'Proposal tidak ditemukan atau belum berstatus final.');
        }

        return view('penelitian.laporan.create', compact('proposal'));
    }

    /**
     * 📤 Simpan laporan penelitian
     */
    public function store(Request $request)
    {
        $request->validate([
            'proposal_penelitian_id' => 'required|exists:proposal_penelitians,id',
            'abstrak' => 'nullable|string',
            'kata_kunci' => 'nullable|string|max:255',
            'metode_penelitian' => 'nullable|string|max:255',
            'ringkasan_laporan' => 'nullable|string|max:255',
            'file_laporan' => 'required|file|mimes:pdf,doc,docx|max:25000',
        ]);

        // ✅ Pastikan proposal ada dan milik dosen yang login
        $proposal = ProposalPenelitian::findOrFail($request->proposal_penelitian_id);
        if ($proposal->ketua_pengusul_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengunggah laporan untuk proposal ini.');
        }

        // ✅ Cek apakah proposal sudah punya laporan
        $existing = LaporanPenelitian::where('proposal_penelitian_id', $proposal->id)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Proposal ini sudah memiliki laporan. Tidak bisa upload lagi.');
        }

        // ✅ Simpan laporan
        $laporan = LaporanPenelitian::create([
            'proposal_penelitian_id' => $proposal->id,
            'abstrak' => $request->abstrak,
            'kata_kunci' => $request->kata_kunci,
            'metode_penelitian' => $request->metode_penelitian,
            'ringkasan_laporan' => $request->ringkasan_laporan,
            'status' => 'pending',
            'komentar_prpm' => null,
        ]);

        // ✅ Upload file ke storage
        $path = $request->file('file_laporan')->store('laporan', 'public');

        // ✅ Simpan metadata file ke tabel documents
        $laporan->documents()->create([
            'tipe' => 'laporan_penelitian',
            'file_path' => $path,
        ]);

        return redirect()->route('dosen.uploadLaporan')
            ->with('status', 'Laporan berhasil diunggah dan menunggu verifikasi PRPM.');
    }
}

<?php

namespace App\Http\Controllers\Penelitian\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Laporan\LaporanPenelitian;
use App\Models\Proposal\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CreateController extends Controller
{
    /**
     * Tampilkan form upload laporan untuk proposal final
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil proposal final milik dosen
        $proposal = Proposal::with('members')
            ->where('dosen_id', $user->id)
            ->where('status_prpm', 'final')
            ->first();

        if (! $proposal) {
            abort(403, 'Proposal tidak ditemukan atau belum berstatus final.');
        }

        return view('penelitian.laporan.create', compact('proposal'));
    }

    /**
     * Simpan laporan penelitian
     */
    public function store(Request $request)
    {

        // Cek apakah proposal sudah punya laporan
        $existing = LaporanPenelitian::where('proposal_id', $request->proposal_id)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Proposal ini sudah memiliki laporan. Tidak bisa upload lagi.');
        }
        
        $request->validate([
            'proposal_id' => 'required|exists:proposal,id',
            'abstrak' => 'nullable|string',
            'kata_kunci' => 'nullable|string|max:255',
            'metode_penelitian' => 'nullable|string|max:255',
            'ringkasan_laporan' => 'nullable|string|max:255',
            'file_laporan' => 'required|file|mimes:pdf,doc,docx|max:25000',
        ]);

        $proposal = Proposal::findOrFail($request->proposal_id);

        // Pastikan proposal milik user yang sedang login
        if ($proposal->dosen_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengunggah laporan untuk proposal ini.');
        }

        // Simpan laporan ke tabel laporan_penelitian
        $laporan = LaporanPenelitian::create([
            'proposal_id' => $proposal->id,
            'abstrak' => $request->abstrak,
            'kata_kunci' => $request->kata_kunci,
            'metode_penelitian' => $request->metode_penelitian,
            'ringkasan_laporan' => $request->ringkasan_laporan,
            'status_prpm' => 'pending',
            'komentar_prpm' => null,
        ]);

        // Simpan file laporan ke storage
        $path = $request->file('file_laporan')->store('laporan', 'public');

        // Simpan metadata file ke tabel documents
        $laporan->documents()->create([
            'tipe' => 'laporan_penelitian',
            'file_path' => $path,
        ]);

        

        return redirect()->route('dosen.uploadLaporan')
            ->with('status', 'Laporan berhasil diunggah dan menunggu verifikasi PRPM.');
    }
}

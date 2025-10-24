<?php

namespace App\Http\Controllers\Penelitian;

use App\Http\Controllers\Controller;
use App\Models\Penelitian\LaporanPenelitian;
use App\Models\Penelitian\ProposalPenelitian;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        // =======================================
        // 1. Ambil semua proposal milik dosen
        // =======================================
        $proposals = ProposalPenelitian::where('ketua_pengusul_id', $userId)
            ->latest('updated_at')
            ->get();

        // =======================================
        // 2. Ambil proposal final (untuk tombol buat laporan)
        // =======================================
        $proposalFinals = $proposals
            ->where('status', 'final')
            ->filter(fn($p) => !$p->laporanPenelitian);

        $proposalFinal = $proposalFinals->first();

        // =======================================
        // 3. Hitungan untuk Card Status Proposal
        // =======================================
        $proposalCount = [
            'total'    => $proposals->count(),
            'diterima' => $proposals->where('status', 'final')->count(),
            'diproses' => $proposals->where('status', 'menunggu_validasi_prpm')->count(),
            'ditolak'  => $proposals->where('status', 'rejected')->count(),
        ];

        // =======================================
        // 4. Ambil semua laporan penelitian
        // =======================================
        $laporans = LaporanPenelitian::whereIn('proposal_penelitian_id', $proposals->pluck('id'))
            ->with('proposalPenelitian') // relasi ke proposal
            ->latest('updated_at')
            ->get();

        // =======================================
        // 5. Hitungan untuk Card Status Laporan
        // =======================================
        $reportCount = [
            'total'    => $laporans->count(),
            'diterima' => $laporans->where('status', 'final')->count(),
            'diproses' => $laporans->where('status', 'menunggu_validasi_prpm')->count(),
            'ditolak'  => $laporans->where('status', 'rejected')->count(),
        ];

        // =======================================
        // 6. Gabungkan Proposal & Laporan ke 1 Collection
        // =======================================
        $allEntries = collect();

        foreach ($proposals as $p) {
            $allEntries->push((object) [
                'id'              => $p->id,
                'judul'           => $p->judul,
                'jenis'           => 'Proposal',
                'status'          => $p->status,
                'tanggal_upload'  => $p->created_at,
                'tanggal_update'  => $p->updated_at,
            ]);
        }

        foreach ($laporans as $r) {
            $allEntries->push((object) [
                'id'              => $r->id,
                'judul'           => $r->judul,
                'jenis'           => 'Laporan',
                'status'          => $r->status,
                'tanggal_upload'  => $r->created_at,
                'tanggal_update'  => $r->updated_at,
            ]);
        }

        $allEntries = $allEntries->sortByDesc('tanggal_update')->values();

        // =======================================
        // 7. Cek kelengkapan profil dosen
        // =======================================
        $isProfileComplete = collect([
            $user->full_name,
            $user->nidn,
            $user->tempat_lahir,
            $user->tanggal_lahir,
            $user->institusi,
            $user->program_studi,
            $user->alamat,
            $user->kontak,
        ])->every(fn($item) => !empty($item));

        // =======================================
        // 8. Kirim data ke view
        // =======================================
        return view('penelitian.index', [
            'proposalFinal'    => $proposalFinal,
            'proposalFinals'   => $proposalFinals,
            'proposalCount'    => $proposalCount,
            'reportCount'      => $reportCount,
            'isProfileComplete'=> $isProfileComplete,
            'allEntries'       => $allEntries,
        ]);
    }
}

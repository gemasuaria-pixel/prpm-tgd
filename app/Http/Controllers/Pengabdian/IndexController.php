<?php

namespace App\Http\Controllers\Pengabdian;

use App\Http\Controllers\Controller;
use App\Models\Pengabdian\LaporanPengabdian;
use App\Models\Pengabdian\ProposalPengabdian;
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
        $proposals = ProposalPengabdian::where('ketua_pengusul_id', $userId)
            ->latest('updated_at')
            ->get();

        // =======================================
        // 2. Ambil proposal final (untuk tombol buat laporan)
        // =======================================
        $proposalFinals = $proposals
            ->where('status', 'final')
            ->filter(fn ($p) => ! $p->laporanPengabdian);

        $proposalFinal = $proposalFinals->first();

        // =======================================
        // 3. Hitungan untuk Card Status Proposal
        // =======================================
        $proposalCount = [
            'total' => $proposals->count(),
            'diterima' => $proposals->where('status', 'final')->count(),
            'diproses' => $proposals->where('status', 'menunggu_validasi_prpm')->count(),
            'ditolak' => $proposals->where('status', 'rejected')->count(),
        ];

        // =======================================
        // 4. Ambil semua laporan pengabdian
        // =======================================
        $laporans = LaporanPengabdian::whereIn('proposal_pengabdian_id', $proposals->pluck('id'))
            ->with('proposalPengabdian') // relasi ke proposal
            ->latest('updated_at')
            ->get();

        // =======================================
        // 5. Hitungan untuk Card Status Laporan
        // =======================================
        $reportCount = [
            'total' => $laporans->count(),
            'diterima' => $laporans->where('status', 'final')->count(),
            'diproses' => $laporans->where('status', 'menunggu_validasi_prpm')->count(),
            'ditolak' => $laporans->where('status', 'rejected')->count(),
        ];

        // =======================================
        // 6. Gabungkan Proposal & Laporan ke 1 Collection
        // =======================================
        $allEntries = collect();

        foreach ($proposals as $p) {
            $allEntries->push((object) [
                'id' => $p->id,
                'judul' => $p->judul,
                'jenis' => 'Proposal',
                'status' => $p->status,
                'tanggal_upload' => $p->created_at,
                'tanggal_update' => $p->updated_at,
            ]);
        }

        foreach ($laporans as $r) {
            $allEntries->push((object) [
                'id' => $r->id,
                'judul' => $r->judul,
                'jenis' => 'Laporan',
                'status' => $r->status,
                'tanggal_upload' => $r->created_at,
                'tanggal_update' => $r->updated_at,
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
        ])->every(fn ($item) => ! empty($item));

        // ===== Tambahkan Pagination di sini =====
        $currentPage = request('page', 1);
        $perPage = 8;

        $paginatedEntries = new \Illuminate\Pagination\LengthAwarePaginator(
            $allEntries->forPage($currentPage, $perPage),
            $allEntries->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->fullUrlWithoutQuery('page'),
            ]
        );

        // =======================================
        // 8. Kirim data ke view
        // =======================================
        return view('pengabdian.index', [
            'proposalFinal' => $proposalFinal,
            'proposalFinals' => $proposalFinals,
            'proposalCount' => $proposalCount,
            'reportCount' => $reportCount,
            'isProfileComplete' => $isProfileComplete,
            'allEntries' => $paginatedEntries,

        ]);
    }
}

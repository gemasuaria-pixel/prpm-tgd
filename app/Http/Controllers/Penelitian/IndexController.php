<?php
namespace App\Http\Controllers\Penelitian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penelitian\ProposalPenelitian;
use App\Models\Penelitian\LaporanPenelitian;

class IndexController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        // 1. Ambil semua proposal milik dosen ini
        $proposals = ProposalPenelitian::where('ketua_pengusul_id', $userId)
            ->latest('updated_at')
            ->get();

        // 2. Hitungan untuk Card Status Proposal
        $proposalCount = [
            'diterima' => $proposals->where('status', 'final')->count(),
            'diproses' => $proposals->whereIn('status', ['menunggu_validasi_prpm'])->count(),
            'ditolak'  => $proposals->where('status', 'rejected')->count(),
        ];

        // 3. Tentukan Proposal yang sudah "Diterima"
        $proposalFinal = $proposals->where('status', 'final')->first();

        // 4. Ambil semua laporan penelitian terkait proposal user
        $proposalIds = $proposals->pluck('id');
        $reports = LaporanPenelitian::whereIn('proposal_id', $proposalIds)
            ->latest('updated_at')
            ->get();

        // 5. Hitungan untuk Card Status Laporan
        $reportCount = [
            'diterima' => $reports->where('status', 'final')->count(),
            'diproses' => $reports->whereIn('status', ['menunggu_validasi_prpm'])->count(),
            'ditolak'  => $reports->where('status', 'rejected')->count(),
        ];

        // 6. Gabungkan Proposal dan Laporan untuk tabel
        $allEntries = collect();

        foreach ($proposals as $p) {
            $allEntries->push((object)[
                'tanggal_upload' => $p->created_at,
                'judul' => $p->judul,
                'jenis' => 'Proposal',
                'status' => $p->status,
                'tanggal_update' => $p->updated_at,
            ]);
        }

        foreach ($reports as $r) {
            $parentProposal = $proposals->firstWhere('id', $r->proposal_id);
            if ($parentProposal) {
                $allEntries->push((object)[
                    'tanggal_upload' => $r->created_at,
                    'judul' => 'Laporan: ' . $parentProposal->judul,
                    'jenis' => 'Laporan',
                    'status' => $r->status,
                    'tanggal_update' => $r->updated_at,
                ]);
            }
        }

        // 7. Cek profil lengkap
        $isProfileComplete = $user->full_name &&
                             $user->nidn &&
                             $user->tempat_lahir &&
                             $user->tanggal_lahir &&
                             $user->institusi &&
                             $user->program_studi &&
                             $user->alamat &&
                             $user->kontak;

        // 8. Urutkan semua entri berdasarkan tanggal update terbaru
        $allEntries = $allEntries->sortByDesc('tanggal_update');

        // 9. Kirim data ke view
        return view('penelitian.index', compact(
            'proposalFinal',
            'proposalCount',
            'reportCount',
            'allEntries',
            'isProfileComplete'
        ));
    }
}

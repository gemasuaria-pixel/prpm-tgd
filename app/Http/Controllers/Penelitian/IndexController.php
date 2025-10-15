<?php

namespace App\Http\Controllers\Penelitian;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Penelitian\ProposalPenelitian;

class IndexController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ✅ Ambil semua proposal milik dosen (dengan relasi laporan)
        $proposals = ProposalPenelitian::with('laporanPenelitian')
            ->where('ketua_pengusul_id', $user->id)
            ->latest()
            ->get();

        // ✅ Ambil proposal final milik dosen ini
        $proposalFinal = ProposalPenelitian::where('ketua_pengusul_id', $user->id)
            ->where('status', 'final')
            ->first();

        // ✅ Hitung jumlah proposal berdasarkan status
        $jumlahDiterima = ProposalPenelitian::where('ketua_pengusul_id', $user->id)
            ->where('status', 'final')
            ->count();

        $jumlahDitolak = ProposalPenelitian::where('ketua_pengusul_id', $user->id)
            ->where('status', 'rejected')
            ->count();

        $jumlahDiproses = ProposalPenelitian::where('ketua_pengusul_id', $user->id)
            ->where('status', 'pending')
            ->count();

$isProfileComplete = $user->full_name &&
                     $user->nidn &&
                     $user->tempat_lahir &&
                     $user->tanggal_lahir &&
                     $user->institusi &&
                     $user->program_studi &&
                     $user->alamat &&
                     $user->kontak;

        return view('penelitian.index', compact(
            'proposals',
            'jumlahDiterima',
            'jumlahDitolak',
            'jumlahDiproses',
            'proposalFinal',
            'isProfileComplete'
        ));
    }
}

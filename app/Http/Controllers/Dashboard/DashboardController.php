<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Penelitian\ProposalPenelitian;
use App\Models\Penelitian\LaporanPenelitian;
use App\Models\Pengabdian\ProposalPengabdian;
use App\Models\Pengabdian\LaporanPengabdian;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // ===============================
        //  PROPOSAL PENELITIAN
        // ===============================
        $proposalPenelitianDiterima = ProposalPenelitian::where('status', 'final')->count();
        $proposalPenelitianDiproses = ProposalPenelitian::whereIn('status', [
            'pending',
            'menunggu_validasi_reviewer',
            'menunggu_validasi_prpm',
            'revisi'
        ])->count();
        $proposalPenelitianDitolak  = ProposalPenelitian::where('status', 'rejected')->count();

        // ===============================
        // PROPOSAL PENGABDIAN
        // ===============================
        $proposalPengabdianDiterima = ProposalPengabdian::where('status', 'final')->count();
        $proposalPengabdianDiproses = ProposalPengabdian::whereIn('status', [
            'pending',
            'menunggu_validasi_reviewer',
            'menunggu_validasi_prpm',
            'revisi'
        ])->count();
        $proposalPengabdianDitolak  = ProposalPengabdian::where('status', 'rejected')->count();

        // ===============================
        //  LAPORAN PENELITIAN
        // ===============================
        $laporanPenelitianDiterima = LaporanPenelitian::where('status', 'final')->count();
        $laporanPenelitianDiproses = LaporanPenelitian::whereIn('status', [
            'menunggu_validasi_reviewer',
            'menunggu_validasi_prpm',
            'approved_by_reviewer',
            'revisi'
        ])->count();
        $laporanPenelitianDitolak  = LaporanPenelitian::where('status', 'rejected')->count();

        // ===============================
        //  LAPORAN PENGABDIAN
        // ===============================
        $laporanPengabdianDiterima = LaporanPengabdian::where('status', 'final')->count();
        $laporanPengabdianDiproses = LaporanPengabdian::whereIn('status', [
            'menunggu_validasi_reviewer',
            'menunggu_validasi_prpm',
            'approved_by_reviewer',
            'revisi'
        ])->count();
        $laporanPengabdianDitolak  = LaporanPengabdian::where('status', 'rejected')->count();

        // ===============================
        //  TOTAL GLOBAL
        // ===============================
        $diterimaCount = $proposalPenelitianDiterima + $proposalPengabdianDiterima + $laporanPenelitianDiterima + $laporanPengabdianDiterima;
        $diprosesCount = $proposalPenelitianDiproses + $proposalPengabdianDiproses + $laporanPenelitianDiproses + $laporanPengabdianDiproses;
        $ditolakCount  = $proposalPenelitianDitolak  + $proposalPengabdianDitolak  + $laporanPenelitianDitolak  + $laporanPengabdianDitolak;

        // Luaran (nanti bisa hitung jurnal, video, HKI, dsb)
        $luaranCount = 0;

        return view('dashboard.dashboard', compact(
            'user',
            'diterimaCount',
            'diprosesCount',
            'ditolakCount',
            'luaranCount'
        ));
    }
}

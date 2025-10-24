<?php

namespace App\Http\Controllers\Penelitian\Proposal;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Penelitian\ProposalPenelitian;
use App\Models\AnggotaDosen;

class CreateController extends Controller
{
    public function index()
    {
        $dosenTerdaftar = User::role('dosen')->get();
        return view('penelitian.proposal.create', compact('dosenTerdaftar'));
    }

    public function store(Request $request)
    {
        //  Validasi data input
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tahun_pelaksanaan' => 'required|digits:4|integer',
            'rumpun_ilmu' => 'nullable|string|max:255',
            'bidang_penelitian' => 'required|string|max:255',
            'abstrak' => 'nullable|string',
            'kata_kunci' => 'nullable|string|max:255',
            'luaran_tambahan_dijanjikan' => 'nullable|string|max:255',
            'syarat_ketentuan' => ['accepted'],
            'documents' => 'required|file|mimes:pdf,doc,docx|max:25600',
            'anggota' => 'required|array|min:1',
            'anggota.*' => 'exists:users,id', // Hanya user_id valid
        ]);

        //  Simpan data proposal
        $proposal = ProposalPenelitian::create([
            'ketua_pengusul_id' => Auth::id(),
            'judul' => $validated['judul'],
            'tahun_pelaksanaan' => $validated['tahun_pelaksanaan'],
            'rumpun_ilmu' => $validated['rumpun_ilmu'] ?? null,
            'bidang_penelitian' => $validated['bidang_penelitian'],
            'abstrak' => $validated['abstrak'] ?? null,
            'kata_kunci' => $validated['kata_kunci'] ?? null,
            'luaran_tambahan_dijanjikan' => $validated['luaran_tambahan_dijanjikan'] ?? null,
            'syarat_ketentuan' => true,
            'status' => 'menunggu_validasi_prpm',
            'komentar_prpm' => null,
        ]);

        //  Simpan anggota dosen (relasi ke user)
        foreach ($validated['anggota'] as $userId) {
            $proposal->anggotaDosen()->create([
                'user_id' => $userId,
            ]);
        }

        //  Upload & simpan dokumen proposal
        if ($request->hasFile('documents')) {
            $path = $request->file('documents')->store('proposals', 'public');
            $proposal->documents()->create([
                'tipe' => 'proposal_penelitian',
                'file_path' => $path,
            ]);
        }

        return redirect()->route('dosen.penelitian.index')
            ->with('status', 'Proposal penelitian berhasil disimpan beserta anggota & dokumennya.');
    }
}

<?php

namespace App\Http\Controllers\Penelitian\Proposal;

use App\Http\Controllers\Controller;
use App\Models\Proposal\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    public function index()
    {
        return view('penelitian.proposal.create');
    }

 // Controller: ProposalPenelitianController@store
public function store(Request $request)
{
    // Validasi data proposal
    $validated = $request->validate([
        'judul' => 'required|string|max:255',
        'tahun_pelaksanaan' => 'required|digits:4|integer',
        'ketua_pengusul' => 'required|string|max:255',
        'rumpun_ilmu' => 'nullable|string|max:255',
        'bidang_penelitian' => 'required|string|max:255',
        'abstrak' => 'nullable|string',
        'kata_kunci' => 'nullable|string|max:255',
        'luaran_tambahan_dijanjikan' => 'nullable|string|max:255',
        'pernyataan' => 'nullable|string',
        'documents' => 'required|file|mimes:pdf,doc,docx|max:25600',
        'anggota' => 'required|array',
        'anggota.*.nama' => 'required|string',
        'anggota.*.nidn' => 'required|string',
        'anggota.*.alamat' => 'required|string',
        'anggota.*.kontak' => 'required|string',
    ]);

    // Simpan proposal
    $proposal = Proposal::create([
        'dosen_id' => Auth::id(),
        'jenis' => 'penelitian',
        'judul' => $validated['judul'],
        'tahun_pelaksanaan' => $validated['tahun_pelaksanaan'],
        'ketua_pengusul' => $validated['ketua_pengusul'],
        'rumpun_ilmu' => $validated['rumpun_ilmu'] ?? null,
        'luaran_tambahan_dijanjikan' => $validated['luaran_tambahan_dijanjikan'] ?? null,
        'pernyataan' => $validated['pernyataan'] ?? 'Saya menyatakan bahwa data dan dokumen yang dikirimkan adalah benar.',
        'status_prpm' => 'pending',
        'status_final_prpm' => 'pending',
        'komentar_prpm' => null,
    ]);
// Simpan infoPenelitian
$proposal->infoPenelitian()->create([
    'bidang_penelitian' => $validated['bidang_penelitian'],
    'abstrak' => $validated['abstrak'] ?? null,
    'kata_kunci' => $validated['kata_kunci'] ?? null,
]);

    // Simpan anggota dosen ke tabel members (polymorphic)
    foreach ($validated['anggota'] as $a) {
        $proposal->members()->create([
            'tipe' => 'dosen',
            'nama' => $a['nama'],
            'nidn' => $a['nidn'],
            'alamat' => $a['alamat'],
            'kontak' => $a['kontak'],
        ]);
    }

    // Upload dokumen
    if ($request->hasFile('documents')) {
        $path = $request->file('documents')->store('proposals', 'public');
        $proposal->documents()->create([
            'tipe' => 'proposal_penelitian',
            'file_path' => $path,
        ]);
    }

    return redirect()->route('dosen.ProposalPenelitian')
        ->with('status', 'Proposal berhasil disimpan beserta anggota.');
}

}

<?php

namespace App\Http\Controllers\Penelitian\Proposal;

use App\Http\Controllers\Controller;
use App\Models\DokumenPenelitian;
use App\Models\UsulanPenelitian;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function index()
    {

        return view('dosen.penelitian.proposal.create');
    }

    public function store(Request $request)
    {


    // 1️⃣ Validasi
    $validated = $request->validate([
        'judul_penelitian' => ['required', 'string', 'max:255'],
        'tahun_pelaksanaan' => ['required', 'integer', ],
        'rumpun_ilmu' => ['required', 'string', 'max:255'],
        'ketua_pengusul' => ['required', 'string', 'max:255'],
        'bidang_penelitian' => ['nullable', 'string', 'max:255'],
        'kata_kunci' => ['required', 'string', 'max:255'],
        'abstrak' => ['required', 'string'],
        'luaran_tambahan' => ['nullable', 'string'],
        'file_proposal' => ['nullable', 'file', 'mimes:pdf', 'max:10240'], // 10MB
    ]);

    // 2️⃣ Simpan usulan utama
    $usulan = \App\Models\UsulanPenelitian::create([
        'judul_penelitian' => $validated['judul_penelitian'],
        'tahun_pelaksanaan' => $validated['tahun_pelaksanaan'],
        'rumpun_ilmu' => $validated['rumpun_ilmu'],
        'ketua_pengusul' => $validated['ketua_pengusul'],
        'bidang_penelitian' => $validated['bidang_penelitian'] ?? null,
        'kata_kunci' => $validated['kata_kunci'],
        'abstrak' => $validated['abstrak'],
        'luaran_tambahan' => $validated['luaran_tambahan'] ?? null,
        'pernyataan' => true,
        'status' => 'pending',
    ]);


    // 3️⃣ Simpan file dokumen kalau ada
    if ($request->hasFile('file_proposal')) {
        $path = $request->file('file_proposal')->store('proposals', 'public');

        dokumenPenelitian::create([
            'usulan_id' => $usulan->id,
            'jenis_dokumen' => 'proposal',
            'file_path' => $path,
        ]);
    }

    // 4️⃣ Simpan anggota penelitian
    if ($request->has('anggota')) {
        foreach ($request->anggota as $index => $anggota) {
            $usulan->anggota()->create([
                'nama' => $anggota['nama'] ?? null,
                'nidn' => $anggota['nidn'] ?? null,
                'alamat' => $anggota['alamat'] ?? null,
                'kontak' => $anggota['kontak'] ?? null,
                'urutan' => $index + 1,
            ]);
        }
    }

    
    return redirect()->route('user.usulanProposal')
        ->with('status', 'Usulan berhasil disimpan.');
}



}

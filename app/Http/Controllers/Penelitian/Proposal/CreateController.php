<?php

namespace App\Http\Controllers\Penelitian\Proposal;

use App\Http\Controllers\Controller;
use App\Models\DokumenPenelitian;
use App\Models\ProposalPenelitian;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function index()
    {
        return view('penelitian.proposal.create');
    }

    public function store(Request $request)
    {
        // 1️⃣ Validasi
        $validated = $request->validate([
            'judul_penelitian' => ['required', 'string', 'max:255'],
            'tahun_pelaksanaan' => ['required', 'integer'],
            'rumpun_ilmu' => ['required', 'string', 'max:255'],
            'ketua_pengusul' => ['required', 'string', 'max:255'],
            'bidang_penelitian' => ['nullable', 'string', 'max:255'],
            'kata_kunci' => ['required', 'string', 'max:255'],
            'abstrak' => ['required', 'string'],
            'luaran_tambahan' => ['nullable', 'string'],
            'file_proposal' => ['sometimes', 'file', 'mimes:pdf', 'max:10240'],
            'anggota' => ['sometimes', 'array'],
            'anggota.*.nama' => ['required_with:anggota', 'string', 'max:150'],
            'anggota.*.nidn' => ['nullable', 'string', 'max:50'],
            'anggota.*.alamat' => ['nullable', 'string', 'max:255'],
            'anggota.*.kontak' => ['nullable', 'string', 'max:50'],
        ]);

        // 2️⃣ Simpan proposal utama
        $proposal = ProposalPenelitian::create([
            'judul_penelitian' => $validated['judul_penelitian'],
            'tahun_pelaksanaan' => $validated['tahun_pelaksanaan'],
            'rumpun_ilmu' => $validated['rumpun_ilmu'],
            'ketua_pengusul' => $validated['ketua_pengusul'],
            'bidang_penelitian' => $validated['bidang_penelitian'] ?? null,
            'kata_kunci' => $validated['kata_kunci'],
            'abstrak' => $validated['abstrak'],
            'luaran_tambahan' => $validated['luaran_tambahan'] ?? null,
            'pernyataan' => true,
            'status_prpm' => 'pending',
            'komentar_prpm' => null,
        ]);

        // 3️⃣ Simpan file proposal jika ada
        if ($request->hasFile('file_proposal')) {
            $path = $request->file('file_proposal')->store('proposals', 'public');

            DokumenPenelitian::create([
                'proposal_id' => $proposal->id,
                'jenis_dokumen' => 'proposal',
                'file_path' => $path,
            ]);
        }

        // 4️⃣ Simpan anggota penelitian jika ada
        if (!empty($validated['anggota'])) {
            foreach ($validated['anggota'] as $index => $anggota) {
                $proposal->anggota()->create([
                    'nama' => $anggota['nama'],
                    'nidn' => $anggota['nidn'] ?? null,
                    'alamat' => $anggota['alamat'] ?? null,
                    'kontak' => $anggota['kontak'] ?? null,
                    'urutan' => $index + 1,
                ]);
            }
        }

        // 5️⃣ Redirect dengan status
        return redirect()->route('dosen.ProposalPenelitian')
            ->with('status', 'Proposal berhasil disimpan.');
    }
}

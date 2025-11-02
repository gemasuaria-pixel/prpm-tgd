<?php

namespace App\Http\Controllers\Pengabdian\Proposal;

use App\Http\Controllers\Controller;
use App\Models\Pengabdian\ProposalPengabdian;
use App\Models\AnggotaProposal;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    /**
     * Tampilkan form pembuatan proposal
     */
    public function index()
    {
        // Ambil semua dosen dan mahasiswa untuk select
        $dosenTerdaftar = User::role('dosen')->get();
        $mahasiswaTerdaftar = Mahasiswa::all();

        return view(
            'pengabdian.proposal.create',
            compact('dosenTerdaftar', 'mahasiswaTerdaftar')
        );
    }

    /**
     * Simpan proposal
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tahun_pelaksanaan' => 'required|digits:4|integer',
            'rumpun_ilmu' => 'nullable|string|max:255',
            'bidang_pengabdian' => 'required|string|max:255',
            'abstrak' => 'nullable|string',
            'kata_kunci' => 'nullable|string|max:255',
            'luaran_tambahan_dijanjikan' => 'nullable|string|max:255',

            // Mitra
            'nama_mitra' => 'required|string|max:255',
            'alamat_mitra' => 'required|string|max:255',
            'kontak_mitra' => 'required|string|max:50',
            'jenis_mitra' => 'required|string|max:50',
            'pernyataan_kebutuhan' => 'required|string',

            // Checkbox
            'syarat_ketentuan' => ['accepted'],

            // Mahasiswa (array of IDs)
            'mahasiswa' => 'nullable|array',
            'mahasiswa.*' => 'exists:mahasiswa,id',

            // Dosen (array of IDs)
            'anggota_dosen' => 'nullable|array',
            'anggota_dosen.*' => 'exists:users,id',
        ]);

        // Simpan Proposal Pengabdian
        $proposal = ProposalPengabdian::create([
            'ketua_pengusul_id' => Auth::id(),
            'judul' => $validated['judul'],
            'tahun_pelaksanaan' => $validated['tahun_pelaksanaan'],
            'rumpun_ilmu' => $validated['rumpun_ilmu'] ?? null,
            'bidang_pengabdian' => $validated['bidang_pengabdian'],
            'abstrak' => $validated['abstrak'] ?? null,
            'kata_kunci' => $validated['kata_kunci'] ?? null,
            'luaran_tambahan_dijanjikan' => $validated['luaran_tambahan_dijanjikan'] ?? null,
            'status' => 'menunggu_validasi_prpm',
            'syarat_ketentuan' => true,

            // Mitra
            'nama_mitra' => $validated['nama_mitra'],
            'alamat_mitra' => $validated['alamat_mitra'],
            'kontak_mitra' => $validated['kontak_mitra'],
            'jenis_mitra' => $validated['jenis_mitra'],
            'pernyataan_kebutuhan' => $validated['pernyataan_kebutuhan'],
        ]);

        // Simpan relasi Mahasiswa
        if (!empty($validated['mahasiswa'])) {
            foreach ($validated['mahasiswa'] as $mahasiswaId) {
                $proposal->anggota()->create([
                    'anggota_id' => $mahasiswaId,
                    'anggota_type' => Mahasiswa::class
                ]);
            }
        }

        // Simpan relasi Dosen
        if (!empty($validated['anggota_dosen'])) {
            foreach ($validated['anggota_dosen'] as $dosenId) {
                $proposal->anggota()->create([
                    'anggota_id' => $dosenId,
                    'anggota_type' => User::class
                ]);
            }
        }

        // Simpan dokumen jika ada
        if ($request->hasFile('documents')) {
            $path = $request->file('documents')->store('proposals_pengabdian', 'public');

            $proposal->documents()->create([
                'tipe' => 'proposal_pengabdian',
                'file_path' => $path,
            ]);
        }

        return redirect()->route('dosen.pengabdian.index')
            ->with('status', 'Proposal pengabdian berhasil disimpan dengan anggota dan dokumen!');
    }
}

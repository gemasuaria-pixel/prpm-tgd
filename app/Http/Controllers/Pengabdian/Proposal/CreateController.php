<?php

namespace App\Http\Controllers\Pengabdian\Proposal;

use App\Models\User;
use App\Models\AnggotaDosen;
use Illuminate\Http\Request;
use App\Models\AnggotaMahasiswa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengabdian\ProposalPengabdian;

class CreateController extends Controller
{
 public function index()
    {
        // Ambil semua dosen & mahasiswa untuk pilihan anggota
        $dosenTerdaftar = User::role('dosen')->get();

        return view('pengabdian.proposal.create', compact('dosenTerdaftar'));
    }

    public function store(Request $request)
    {
        // ✅ Validasi Input
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jumlah_anggota_kelompok' => 'required|integer|min:1',
            'tahun_pelaksanaan' => 'required|digits:4|integer',
            'rumpun_ilmu' => 'nullable|string|max:255',
            'bidang_pengabdian' => 'required|string|max:255',
            'abstrak' => 'nullable|string',
            'kata_kunci' => 'nullable|string|max:255',
            'luaran_tambahan_dijanjikan' => 'nullable|string|max:255',

            // Mitra
            'nama_mitra' => 'required|string|max:255',
            'alamat_mitra' => 'required|string|max:255',
            'pimpinan_mitra' => 'required|string|max:255',
            'kontak_mitra' => 'required|string|max:50',
            'jenis_mitra' => 'required|string|max:50',
            'pernyataan_kebutuhan' => 'required|string',

            // Checkbox
            'syarat_ketentuan' => ['accepted'],

          
            // Anggota mahasiswa (opsional)
            'mahasiswa' => 'nullable|array',
            'mahasiswa.*.nama' => 'required_with:mahasiswa|string|max:255',
            'mahasiswa.*.nim' => 'required_with:mahasiswa|string|max:50',
            'mahasiswa.*.prodi' => 'nullable|string|max:100',
            'mahasiswa.*.kontak' => 'nullable|string|max:50',
            'mahasiswa.*.alamat' => 'nullable|string|max:255',
        ]);

        // ✅ Simpan Proposal Pengabdian
        $proposal = ProposalPengabdian::create([
            'ketua_pengusul_id' => Auth::id(),
            'judul' => $validated['judul'],
            'tahun_pelaksanaan' => $validated['tahun_pelaksanaan'],
            'rumpun_ilmu' => $validated['rumpun_ilmu'] ?? null,
            'bidang_pengabdian' => $validated['bidang_pengabdian'],
            'abstrak' => $validated['abstrak'] ?? null,
            'kata_kunci' => $validated['kata_kunci'] ?? null,
            'luaran_tambahan_dijanjikan' => $validated['luaran_tambahan_dijanjikan'] ?? null,
            'jumlah_anggota_kelompok' => $validated['jumlah_anggota_kelompok'],

            'status' => 'menunggu_validasi_prpm',
            'syarat_ketentuan' => true,

            // Mitra
            'nama_mitra' => $validated['nama_mitra'],
            'alamat_mitra' => $validated['alamat_mitra'],
            'pimpinan_mitra' => $validated['pimpinan_mitra'],
            'kontak_mitra' => $validated['kontak_mitra'],
            'jenis_mitra' => $validated['jenis_mitra'],
            'pernyataan_kebutuhan' => $validated['pernyataan_kebutuhan'],
        ]);

    

        // ✅ Simpan Anggota Mahasiswa (jika diisi)
        if (!empty($validated['mahasiswa'])) {
            foreach ($validated['mahasiswa'] as $mhs) {
                $proposal->anggotaMahasiswa()->create([
                    'nama' => $mhs['nama'],
                    'nim' => $mhs['nim'],
                    'alamat' => $mhs['alamat'] ?? null,
                    'kontak' => $mhs['kontak'] ?? null,
                    'prodi' => $mhs['prodi'] ?? null,
                ]);
            }
        }

        // ✅ Simpan Dokumen (jika ada upload)
        if ($request->hasFile('documents')) {
            $path = $request->file('documents')->store('proposals_pengabdian', 'public');

            $proposal->documents()->create([
                'tipe' => 'proposal_pengabdian',
                'file_path' => $path,
            ]);
        }

        return redirect()->route('dosen.pengabdian.index')
            ->with('status', 'Proposal pengabdian berhasil disimpan lengkap dengan anggota, mitra, dan dokumen!');
    }
}

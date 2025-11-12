<?php

namespace App\Livewire\Pengabdian\Laporan;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengabdian\LaporanPengabdian;
use App\Models\Pengabdian\ProposalPengabdian;

class LaporanWizard extends Component
{
    use WithFileUploads;

    public $step = 1;
    public $proposal;
    public $proposalId;

    public $laporan = [
        'judul' => '',
        'ringkasan' => '',
        'tahun_pelaksanaan' => '',
    ];

    public $file_path;

    public $luaran = [
        'jurnal' => [],
        'video' => [],
    ];

    public $pernyataan = false;

    public function mount($proposalId)
    {
        // Ambil proposal dengan relasi anggota
        $this->proposal = ProposalPengabdian::with(['anggota', 'anggota.individu'])
            ->findOrFail($proposalId);

        // Cek akses
        $user = Auth::user();
        if ($this->proposal->ketua_pengusul_id !== $user->id) {
            abort(403, 'Anda tidak berhak mengakses proposal ini.');
        }

        // Pastikan proposal sudah final
        if ($this->proposal->status !== 'final') {
            abort(403, 'Proposal belum berstatus final.');
        }

        // Jika laporan sudah pernah dibuat → isi form dengan data lama
        if ($laporan = LaporanPengabdian::where('proposal_pengabdian_id', $proposalId)->first()) {
            foreach ($this->laporan as $key => $value) {
                if (isset($laporan->$key)) {
                    $this->laporan[$key] = $laporan->$key;
                }
            }

            $this->luaran = json_decode($laporan->external_links ?? json_encode($this->luaran), true);
        }
    }

    // 🔹 Navigasi Wizard
    public function nextStep()
    {
        $this->validateStep();
        if ($this->step < 4) {
            $this->step++;
        }
    }

    public function prevStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    //  Validasi per langkah
    protected function validateStep()
    {
        if ($this->step === 2) {
            $this->validate([
                'laporan.judul' => 'required|string|max:255',
                'laporan.ringkasan' => 'required|string|min:10',
                'laporan.tahun_pelaksanaan' => 'required|digits:4|integer|min:2024',
            ]);
        }

        if ($this->step === 3) {
            $this->validate([
                'file_path' => 'required|file|mimes:pdf,doc,docx|max:25000',
            ]);
        }
    }

    // ➕ Tambah / hapus link luaran
    public function addLuaran($type)
    {
        $this->luaran[$type][] = '';
    }

    public function removeLuaran($type, $index)
    {
        unset($this->luaran[$type][$index]);
        $this->luaran[$type] = array_values($this->luaran[$type]);
    }

    // ✅ Submit akhir
    public function submit()
    {
        $this->validate([
            'laporan.judul' => 'required|string|max:255',
            'laporan.tahun_pelaksanaan' => 'required|int|min:4',
            'laporan.ringkasan' => 'required|string|min:4',
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:25000',
            'pernyataan' => 'accepted',
        ]);

        // Simpan file laporan ke storage
        $path = $this->file_path->store('pengabdian/laporan', 'public');
        $this->file_path = $path;

        // Simpan laporan ke database
        $laporan = LaporanPengabdian::updateOrCreate(
            ['proposal_pengabdian_id' => $this->proposal->id],
            [
                'judul' => $this->laporan['judul'],
                'tahun_pelaksanaan' => $this->laporan['tahun_pelaksanaan'],
                'ringkasan' => $this->laporan['ringkasan'],
                'external_links' => json_encode($this->luaran),
                'file_path' => $path,
                'status' => 'menunggu_validasi_prpm',
                'komentar_prpm' => null,
            ]
        );

        // Simpan juga ke tabel dokumen (jika ada relasi)
        $laporan->documents()->create([
            'tipe' => 'laporan_pengabdian',
            'file_path' => $path,
        ]);

        // Flash sukses
        session()->flash('success', 'Laporan pengabdian berhasil disimpan!');

        // Reset data form
        $this->reset([
            'laporan',
            'file_path',
            'luaran',
            'pernyataan',
            'step',
        ]);

        // Redirect
        return redirect()->route('dosen.pengabdian.index');
    }

    public function render()
    {
        return view('livewire.pengabdian.laporan.laporan-wizard');
    }
}

<?php

namespace App\Livewire\Pengabdian\Proposal;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengabdian\ProposalPengabdian;
use App\Models\Mahasiswa;
use App\Models\User;

class ProposalWizard extends Component
{
    use WithFileUploads;

    public int $step = 2;

    // --- STEP 1: Identitas Proposal ---
    public $identitas = [
        'judul' => '',
        'tahun_pelaksanaan' => '',
        'rumpun_ilmu' => '',
        'bidang_pengabdian' => '',
    ];

    // --- STEP 2: Anggota (dosen & mahasiswa) ---
    public $anggota_dosen = [];
    public $anggota_mahasiswa = [];

    // --- STEP 3: Mitra ---
    public $mitra = [
        'nama_mitra' => '',
        'alamat_mitra' => '',
        'kontak_mitra' => '',
        'jenis_mitra' => '',
        'pernyataan_kebutuhan' => '',
    ];

    // --- STEP 4: Dokumen dan metadata ---
    public $dokumen = [
        'abstrak' => '',
        'kata_kunci' => '',
        'luaran_tambahan_dijanjikan' => '',
        'file_path' => null,
        'syarat_ketentuan' => false,
    ];

    // --- Ambil data untuk dropdown ---
    public $dosenTerdaftar = [];
public $mahasiswaTerdaftar = [];


    public function mount()
    {
         $this->dosenTerdaftar = User::role('dosen')
    ->select('id', 'name', 'nidn', 'alamat', 'kontak')
    ->get()
    ->toArray();



   $this->mahasiswaTerdaftar = Mahasiswa::select('id','nama','nim','prodi','no_hp','alamat')->get()->toArray();

    }

    public function render()
    {
        return view('livewire.pengabdian.proposal.proposal-wizard');
    }

    // --- Navigasi antar langkah ---
public function nextStep()
{
    info('Current Step: '.$this->step);
    info('Errors: '.json_encode($this->getErrorBag()->toArray()));

    $this->validateCurrentStep();
    if ($this->step < 4) $this->step++;
}


    public function prevStep()
    {
        if ($this->step > 1) $this->step--;
    }

    // --- Validasi per step ---
    protected function validateCurrentStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'identitas.judul' => 'required|string|max:255',
                'identitas.tahun_pelaksanaan' => 'required|digits:4|integer',
                'identitas.bidang_pengabdian' => 'required|string|max:255',
            ]);
        } elseif ($this->step === 2) {
            // Minimal 1 anggota dosen atau mahasiswa
            if (empty($this->anggota_dosen) && empty($this->anggota_mahasiswa)) {
                $this->addError('anggota', 'Minimal ada satu anggota (dosen atau mahasiswa).');
            }
        } elseif ($this->step === 3) {
            $this->validate([
                'mitra.nama_mitra' => 'required|string|max:255',
                'mitra.alamat_mitra' => 'required|string|max:255',
                'mitra.kontak_mitra' => 'required|string|max:50',
                'mitra.jenis_mitra' => 'required|string|max:50',
                'mitra.pernyataan_kebutuhan' => 'required|string',
            ]);
        } elseif ($this->step === 4) {
            $this->validate([
                'dokumen.file_path' => 'required|file|mimes:pdf,docx|max:2048',
                'dokumen.syarat_ketentuan' => 'accepted',
            ]);
        }
    }

    // --- Tambah / hapus anggota ---
  
    // --- Submit final ---
    public function submit()
    {
       

        $this->validateCurrentStep();

        // 1️⃣ Simpan proposal
        $proposal = ProposalPengabdian::create([
            'ketua_pengusul_id' => Auth::id(),
            'judul' => $this->identitas['judul'],
            'tahun_pelaksanaan' => $this->identitas['tahun_pelaksanaan'],
            'rumpun_ilmu' => $this->identitas['rumpun_ilmu'] ?? null,
            'bidang_pengabdian' => $this->identitas['bidang_pengabdian'],
            'abstrak' => $this->dokumen['abstrak'] ?? null,
            'kata_kunci' => $this->dokumen['kata_kunci'] ?? null,
            'luaran_tambahan_dijanjikan' => $this->dokumen['luaran_tambahan_dijanjikan'] ?? null,
            'status' => 'menunggu_validasi_prpm',
            'syarat_ketentuan' => true,
            'nama_mitra' => $this->mitra['nama_mitra'],
            'alamat_mitra' => $this->mitra['alamat_mitra'],
            'kontak_mitra' => $this->mitra['kontak_mitra'],
            'jenis_mitra' => $this->mitra['jenis_mitra'],
            'pernyataan_kebutuhan' => $this->mitra['pernyataan_kebutuhan'],
        ]);

        // 2️⃣ Simpan anggota dosen
        foreach ($this->anggota_dosen as $dosenId) {
            $proposal->anggota()->create([
                'anggota_id' => $dosenId,
                'anggota_type' => User::class,
            ]);
        }

        // 3️⃣ Simpan anggota mahasiswa
        foreach ($this->anggota_mahasiswa as $mhsId) {
            $proposal->anggota()->create([
                'anggota_id' => $mhsId,
                'anggota_type' => Mahasiswa::class,
            ]);
        }

        // 4️⃣ Simpan dokumen
        if ($this->dokumen['file_path']) {
            $path = $this->dokumen['file_path']->store('proposals_pengabdian', 'public');
            $proposal->documents()->create([
                'tipe' => 'proposal_pengabdian',
                'file_path' => $path,
            ]);
        }
dd($this->identitas, $this->anggota_dosen, $this->mitra, $this->dokumen);
        // 5️⃣ Reset wizard
        $this->resetWizard();
        session()->flash('success', 'Proposal berhasil disimpan dengan anggota dan dokumen!');
    }


    protected function resetWizard()
    {
        $this->reset([
            'step',
            'identitas',
            'anggota_dosen',
            'anggota_mahasiswa',
            'mitra',
            'dokumen',
        ]);
        $this->step = 1;
    }
}

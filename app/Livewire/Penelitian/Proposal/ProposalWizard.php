<?php

namespace App\Livewire\Penelitian\Proposal;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Penelitian\ProposalPenelitian;
use App\Models\Mahasiswa;

class ProposalWizard extends Component
{
    use WithFileUploads;

    public int $step = 1;

    // ------------------------------------------------------------------
    //  STEP 1: Identitas Proposal
    // ------------------------------------------------------------------
    public $identitas = [
        'judul' => '',
        'tahun_pelaksanaan' => '',
        'rumpun_ilmu' => '',
        'bidang_penelitian' => '',
    ];

    // ------------------------------------------------------------------
    //  STEP 2: Anggota (dosen & mahasiswa)
    // ------------------------------------------------------------------
    public $anggota_dosen = [];

    // Dropdown data
    public $dosenTerdaftar = [];
  

    // ------------------------------------------------------------------
    //  STEP 3: Dokumen & Metadata
    // ------------------------------------------------------------------
    public $dokumen = [
        'abstrak' => '',
        'kata_kunci' => '',
        'luaran_tambahan_dijanjikan' => '',
        'file_path' => null,
    ];

    // ------------------------------------------------------------------
    //  STEP 4: Dokumen & Metadata
    // ------------------------------------------------------------------
    public $syarat_ketentuan = false;

    // ------------------------------------------------------------------
    //  Lifecycle
    // ------------------------------------------------------------------
    public function mount()
    {
        $this->dosenTerdaftar = User::role('dosen')
            ->select('id', 'name', 'nidn', 'alamat', 'kontak')
            ->get()
            ->toArray();

    }

    public function render()
    {
        return view('livewire.penelitian.proposal.proposal-wizard');
    }

    // ------------------------------------------------------------------
    //  Navigasi Step
    // ------------------------------------------------------------------
    public function nextStep()
    {
        $this->validateCurrentStep();
         if ($this->step < 4) {
        $this->step++;
       $this->dispatch('setStep', $this->step); //  kirim ke StepIndicator
    }
    }

    public function prevStep()
    {
          if ($this->step > 1) {
        $this->step--;
        $this->dispatch('setStep', $this->step); //  kirim ke StepIndicator
    }
    }

    // ------------------------------------------------------------------
    //  Validasi per Step
    // ------------------------------------------------------------------
    protected function validateCurrentStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'identitas.judul' => 'required|string|max:255',
                'identitas.tahun_pelaksanaan' => 'required|digits:4|integer|min:2024',
                'identitas.rumpun_ilmu' => 'required|string|max:255',
                'identitas.bidang_penelitian' => 'required|string|max:255',
            ]);
        }

        if ($this->step === 2) {
            if (empty($this->anggota_dosen)) {
                $this->validate([
                  'anggota_dosen' => 'required|array|min:1'
            ]);
               
            }
        }

        if ($this->step === 3) {
            $this->validate([
                'dokumen.abstrak' => 'required|string|min:30|max:2000',
                'dokumen.kata_kunci' => 'required|string|max:255',
                'dokumen.luaran_tambahan_dijanjikan' => 'required|string',
                'dokumen.file_path' => 'required|file|mimes:pdf,docx|max:4096',
            
            ]);
        }

        if ($this->step === 4) {
            $this->validate([
                'syarat_ketentuan' => 'accepted',
            ]);
        }
    }

    // ------------------------------------------------------------------
    // 🔹 Custom Pesan Error
    // ------------------------------------------------------------------
    protected $messages = [
        // Step 1
        'identitas.judul.required' => 'Judul penelitian wajib diisi.',
        'identitas.tahun_pelaksanaan.required' => 'Tahun pelaksanaan harus diisi.',
        'identitas.bidang_penelitian.required' => 'Bidang penelitian wajib diisi.',
        'identitas.rumpun_ilmu.required' => 'Rumpun ilmu wajib diisi.',

        // Step 2
        'anggota' => 'Tambahkan minimal satu anggota dosen atau mahasiswa.',

        // Step 3
        'dokumen.abstrak.required' => 'Abstrak wajib diisi.',
        'dokumen.kata_kunci.required' => 'Kata kunci wajib diisi.',
        'dokumen.luaran_tambahan_dijanjikan.required' => 'Pilih jenis luaran tambahan.',
        'dokumen.file_path.required' => 'File proposal harus diunggah.',
        'dokumen.file_path.mimes' => 'File harus berupa PDF atau DOCX.',

        // Step 4
        'syarat_ketentuan.accepted' => 'Anda harus menyetujui syarat & ketentuan.',
    ];

    // ------------------------------------------------------------------
    // 🔹 Submit Final
    // ------------------------------------------------------------------
    public function submit()
    {
        $this->validateCurrentStep();

        // 1 Simpan proposal penelitian
        $proposal = ProposalPenelitian::create([
            'ketua_pengusul_id' => Auth::id(),
            'judul' => $this->identitas['judul'],
            'tahun_pelaksanaan' => $this->identitas['tahun_pelaksanaan'],
            'rumpun_ilmu' => $this->identitas['rumpun_ilmu'],
            'bidang_penelitian' => $this->identitas['bidang_penelitian'],
            'abstrak' => $this->dokumen['abstrak'],
            'kata_kunci' => $this->dokumen['kata_kunci'],
            'luaran_tambahan_dijanjikan' => $this->dokumen['luaran_tambahan_dijanjikan'],
            'status' => 'menunggu_validasi_prpm',
        ]);

        // 2 Simpan anggota dosen
        foreach ($this->anggota_dosen as $dosen) {
            $proposal->anggota()->create([
                'anggota_id' => (int) $dosen['id'],
                'anggota_type' => User::class,
            ]);
        }


        // 4 Upload file dokumen
        if ($this->dokumen['file_path']) {
            $path = $this->dokumen['file_path']->store('proposals_penelitian', 'public');
            $proposal->documents()->create([
                'tipe' => 'proposal_penelitian',
                'file_path' => $path,
            ]);
        }

        
        // 5️ Reset wizard
        $this->resetWizard();
        session()->flash('success', 'Proposal penelitian berhasil disimpan!');
    }

    protected function resetWizard()
    {
        $this->reset([
            'step',
            'identitas',
            'anggota_dosen',
            'dokumen',
        ]);
        $this->step = 1;
    }
}

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

    public int $step = 1;

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
    ];
    
    // --- STEP 5: preview ---
    public $syarat_ketentuan = false;

    // --- Dropdown data ---
    public $dosenTerdaftar = [];
    public $mahasiswaTerdaftar = [];

    public function mount()
    {
        $this->dosenTerdaftar = User::role('dosen')
            ->select('id', 'name', 'nidn', 'alamat', 'kontak')
            ->get()
            ->toArray();

        $this->mahasiswaTerdaftar = Mahasiswa::select('id', 'nama', 'nim', 'prodi', 'no_hp', 'alamat')
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.pengabdian.proposal.proposal-wizard');
    }

    // ------------------------------------------------------------------
    // 🔹 Navigasi antar langkah
    // ------------------------------------------------------------------
    public function nextStep()
    {
        $this->validateCurrentStep();
         if ($this->step < 5) {
        $this->step++;
       $this->dispatch('setStep', $this->step);
    }
    
    }


    public function prevStep()
    {
         if ($this->step > 1) {
        $this->step--;
        $this->dispatch('setStep', $this->step);//  kirim ke StepIndicator
    }
    }

    // ------------------------------------------------------------------
    // 🔹 Validasi per step
    // ------------------------------------------------------------------
    protected function validateCurrentStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'identitas.judul' => 'required|string|max:255',
                'identitas.tahun_pelaksanaan' => 'required|digits:4|integer|min:2024',
                'identitas.bidang_pengabdian' => 'required|string|max:255',
                'identitas.rumpun_ilmu' => 'required|string|max:255',
            ]);
        }

        if ($this->step === 2) {
          
            if (empty($this->anggota_dosen) && empty($this->anggota_mahasiswa)) {
                $this->addError('anggota', 'Minimal ada satu anggota (dosen atau mahasiswa).');
            }
        }

        if ($this->step === 3) {
            $this->validate([
                'mitra.nama_mitra' => 'required|string|max:255',
                'mitra.alamat_mitra' => 'required|string|max:255',
                'mitra.kontak_mitra' => 'required|string|max:50',
                'mitra.jenis_mitra' => 'required|string|max:50',
                'mitra.pernyataan_kebutuhan' => 'required|string',
            ]);
        }
if ($this->step === 4) {
    $this->validate([
        'dokumen.abstrak' => 'required|string|min:30|max:2000',
        'dokumen.kata_kunci' => 'required|string|max:255',
        'dokumen.luaran_tambahan_dijanjikan' => 'required|string|in:jurnal,program,buku',
        'dokumen.file_path' => 'required|file|mimes:pdf,docx|max:2048',
      
    ]);
}
if ($this->step === 5) {
    $this->validate([
        
        'syarat_ketentuan' => 'accepted',
    ]);
}

    }

    // ------------------------------------------------------------------
    // 🔹 Custom Pesan Error dan Nama Field
    // ------------------------------------------------------------------
    // ------------------------------------------------------------------
// 🔹 Custom Pesan Error dan Nama Field (lengkap)
// ------------------------------------------------------------------
protected $messages = [
    // Step 1 - Identitas
    'identitas.judul.required' => 'Judul pengabdian wajib diisi.',
    'identitas.judul.max' => 'Judul pengabdian tidak boleh lebih dari :max karakter.',
    'identitas.tahun_pelaksanaan.required' => 'Tahun pelaksanaan harus diisi.',
    'identitas.tahun_pelaksanaan.digits' => 'Tahun pelaksanaan harus berupa 4 digit angka.',
    'identitas.tahun_pelaksanaan.integer' => 'Tahun pelaksanaan harus berupa angka.',
    'identitas.tahun_pelaksanaan.min' => 'Tahun pelaksanaan tidak valid.',
    'identitas.bidang_pengabdian.required' => 'Silakan pilih bidang pengabdian.',
    'identitas.rumpun_ilmu.required' => 'Rumpun ilmu wajib diisi.',
    'identitas.rumpun_ilmu.max' => 'Rumpun ilmu terlalu panjang.',

    // Step 2 - Anggota (custom addError)
    'anggota' => 'Minimal ada satu anggota (dosen atau mahasiswa).',

    // Step 3 - Mitra
    'mitra.nama_mitra.required' => 'Nama mitra wajib diisi.',
    'mitra.nama_mitra.max' => 'Nama mitra terlalu panjang.',
    'mitra.alamat_mitra.required' => 'Alamat mitra wajib diisi.',
    'mitra.alamat_mitra.max' => 'Alamat mitra terlalu panjang.',
    'mitra.kontak_mitra.required' => 'Kontak mitra wajib diisi.',
    'mitra.kontak_mitra.max' => 'Kontak mitra terlalu panjang.',
    'mitra.jenis_mitra.required' => 'Jenis mitra wajib diisi.',
    'mitra.jenis_mitra.in' => 'Jenis mitra tidak valid.',
    'mitra.pernyataan_kebutuhan.required' => 'Pernyataan kebutuhan mitra wajib diisi.',

    // Step 4 - Dokumen
    'dokumen.abstrak.required' => 'Bagian abstrak harus diisi.',
    'dokumen.abstrak.min' => 'Abstrak minimal :min karakter agar cukup informatif.',
    'dokumen.abstrak.max' => 'Abstrak tidak boleh lebih dari :max karakter.',
    'dokumen.kata_kunci.required' => 'Kata kunci wajib diisi untuk membantu klasifikasi.',
    'dokumen.kata_kunci.max' => 'Kata kunci terlalu panjang.',
    'dokumen.luaran_tambahan_dijanjikan.required' => 'Pilih salah satu jenis luaran tambahan.',
    'dokumen.luaran_tambahan_dijanjikan.in' => 'Jenis luaran tidak valid.',
    'dokumen.file_path.required' => 'File proposal harus diunggah.',
    'dokumen.file_path.mimes' => 'File proposal harus berupa PDF atau DOCX.',
    'dokumen.file_path.max' => 'Ukuran file maksimal 2MB.',
    
    // Step 5 - Syarat & Ketentuan
    'syarat_ketentuan.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
];

protected $validationAttributes = [
    // Identitas
    'identitas.judul' => 'Judul Pengabdian',
    'identitas.tahun_pelaksanaan' => 'Tahun Pelaksanaan',
    'identitas.bidang_pengabdian' => 'Bidang Pengabdian',
    'identitas.rumpun_ilmu' => 'Rumpun Ilmu',

    // Anggota
    'anggota' => 'Anggota',

    // Mitra
    'mitra.nama_mitra' => 'Nama Mitra',
    'mitra.alamat_mitra' => 'Alamat Mitra',
    'mitra.kontak_mitra' => 'Kontak Mitra',
    'mitra.jenis_mitra' => 'Jenis Mitra',
    'mitra.pernyataan_kebutuhan' => 'Pernyataan Kebutuhan',

    // Dokumen
    'dokumen.abstrak' => 'Abstrak',
    'dokumen.kata_kunci' => 'Kata Kunci',
    'dokumen.luaran_tambahan_dijanjikan' => 'Luaran Tambahan',
    'dokumen.file_path' => 'File Proposal',

    // Syarat & Ketentuan
    'syarat_ketentuan' => 'Syarat & Ketentuan',
];

    // ------------------------------------------------------------------
    //  Submit Final
    // ------------------------------------------------------------------
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
        foreach ($this->anggota_dosen as $dosen) {
            $proposal->anggota()->create([
                'anggota_id' => (int) $dosen['id'],
                'anggota_type' => User::class,
            ]);
        }

        // 3️⃣ Simpan anggota mahasiswa
        foreach ($this->anggota_mahasiswa as $mhs) {
            $proposal->anggota()->create([
                'anggota_id' => (int) $mhs['id'],
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

        // 5️⃣ Reset wizard
        $this->resetWizard();
        session()->flash('success', 'Proposal berhasil disimpan beserta anggota dan dokumen!');
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

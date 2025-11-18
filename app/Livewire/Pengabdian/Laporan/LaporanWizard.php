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
        'kata_kunci' => '',
        'ringkasan_laporan' => '',
        
    ];

    public $file_path;

    public $luaran = [
        'jurnal' => [],
        'video' => [],
    ];

    public $pernyataan = false;

    public function mount($proposalId)
    {
        $this->proposal = ProposalPengabdian::with(['anggota', 'anggota.individu'])
            ->findOrFail($proposalId);

        $user = Auth::user();

        if ($this->proposal->ketua_pengusul_id !== $user->id) {
            abort(403, 'Anda tidak berhak mengakses proposal ini.');
        }

        if ($this->proposal->status !== 'final') {
            abort(403, 'Proposal belum berstatus final.');
        }

        // Jika laporan sudah ada, isi form
        if ($laporan = LaporanPengabdian::where('proposal_pengabdian_id', $proposalId)->first()) {
            foreach ($this->laporan as $key => $value) {
                if (isset($laporan->$key)) {
                    $this->laporan[$key] = $laporan->$key;
                }
            }

            $this->luaran = json_decode($laporan->external_links ?? json_encode($this->luaran), true);
        }
    }

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

    protected function validateStep()
    {
        // Step 2: isi laporan utama
        if ($this->step === 2) {
            $this->validate([
                'laporan.judul' => 'required|string|max:255',
                'laporan.kata_kunci' => 'required|string|min:3',
                'laporan.ringkasan_laporan' => 'required|string|min:10',
              
            ]);
        }

        // Step 3: upload dokumen
        if ($this->step === 3) {
            $this->validate([
                'file_path' => 'required|file|mimes:pdf,doc,docx|max:25000',
            ]);
        }
    }

    public function addLuaran($type)
    {
        $this->luaran[$type][] = '';
    }

    public function removeLuaran($type, $index)
    {
        unset($this->luaran[$type][$index]);
        $this->luaran[$type] = array_values($this->luaran[$type]);
    }

    public function submit()
    {
        $this->validate([
            'laporan.judul' => 'required|string|max:255',
            'laporan.kata_kunci' => 'required|string|min:3',

            'file_path' => 'required|file|mimes:pdf,doc,docx|max:25000',
            'pernyataan' => 'accepted',
        ]);

        // Simpan file laporan
        $path = $this->file_path->store('pengabdian/laporan', 'public');
        $this->file_path = $path;

        // Simpan ke database
        $laporan = LaporanPengabdian::updateOrCreate(
            ['proposal_pengabdian_id' => $this->proposal->id],
            [
                'judul' => $this->laporan['judul'],
                'kata_kunci' => $this->laporan['kata_kunci'],
                'ringkasan_laporan' => $this->laporan['ringkasan_laporan'],
                'external_links' => json_encode($this->luaran),
                'file_path' => $path,
                'status' => 'menunggu_validasi_prpm',
                'komentar_prpm' => null,
            ]
        );

        // Simpan dokumen ke tabel documents bila ada relasi
        $laporan->documents()->create([
            'tipe' => 'laporan_pengabdian',
            'file_path' => $path,
        ]);

        session()->flash('success', 'Laporan pengabdian berhasil disimpan!');

        // Reset state
        $this->reset([
            'laporan',
            'file_path',
            'luaran',
            'pernyataan',
            'step',
        ]);

        return redirect()->route('dosen.pengabdian.index');
    }

    public function render()
    {
        return view('livewire.pengabdian.laporan.laporan-wizard');
    }
}

<?php

namespace App\Livewire\Penelitian\Laporan;

use App\Models\Penelitian\LaporanPenelitian;
use App\Models\Penelitian\ProposalPenelitian;
use Livewire\Component;
use Livewire\WithFileUploads;

class LaporanWizard extends Component
{
    use WithFileUploads;

    public $step = 1;

    public $proposal;

    public $proposalId;

    public $laporan = [
        'judul' => '',
        'kata_kunci' => '',
        'abstrak' => '',
        'metode_penelitian' => '',
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
        $this->proposal = ProposalPenelitian::with(['anggota', 'anggota.individu'])
            ->findOrFail($proposalId);

        if ($laporan = LaporanPenelitian::where('proposal_penelitian_id', $proposalId)->first()) {
            foreach ($this->laporan as $key => $value) {
                if (isset($laporan->$key)) {
                    $this->laporan[$key] = $laporan->$key;
                }
            }

            $this->luaran = json_decode($laporan->luaran ?? json_encode($this->luaran), true);
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
        if ($this->step === 2) {
            $this->validate([
                'laporan.judul' => 'required|string|max:255',
                'laporan.kata_kunci' => 'required|string|max:255',
                'laporan.abstrak' => 'required|string|min:10',
                'laporan.metode_penelitian' => 'required|string|max:255',
                'laporan.ringkasan_laporan' => 'required|string|min:10',
            ]);
        }

        if ($this->step === 3) {
            $this->validate([
                'file_path' => 'required|file|mimes:pdf,doc,docx|max:5120',
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
            'laporan.kata_kunci' => 'required|string|max:255',
            'laporan.abstrak' => 'required|string|min:10',
            'laporan.metode_penelitian' => 'required|string|max:255',
            'laporan.ringkasan_laporan' => 'required|string|min:10',
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'pernyataan' => 'accepted',
        ]);

       

        // Simpan ke database (update kalau sudah ada)
        $laporan = LaporanPenelitian::updateOrCreate(
            ['proposal_penelitian_id' => $this->proposal->id],
            [
                'judul' => $this->laporan['judul'],
                'kata_kunci' => $this->laporan['kata_kunci'],
                'abstrak' => $this->laporan['abstrak'],
                'metode_penelitian' => $this->laporan['metode_penelitian'],
                'ringkasan_laporan' => $this->laporan['ringkasan_laporan'],
                'luaran' => json_encode($this->luaran),
                'status' => 'menunggu_validasi_prpm',
            ]
        );

         // Simpan file laporan
        $path = $this->file_path->store('laporan_penelitian', 'public');

        // Update variabel agar preview bisa buka path permanen
        $this->file_path = $path;
        $laporan->documents()->create([
            'tipe' => 'laporan_penelitian',
            'file_path' => $path,
        ]);

        session()->flash('success', 'Laporan penelitian berhasil disimpan!');

        // ✅ Reset semua ke kondisi awal
        $this->reset([
            'laporan',
            'file_path',
            'luaran',
            'pernyataan',
            'step',
        ]);
        
        redirect()->route('dosen.penelitian.index');

    }

    public function render()
    {
        return view('livewire.penelitian.laporan.laporan-wizard');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class AddAnggota extends Component
{
    public $nama, $nidn, $nim, $alamat, $kontak;
    public $anggota = [];
    public $selected = [];
    public $selectAll = false;

    public function updatedSelectAll($value)
    {
        $this->selected = $value
            ? array_column($this->anggota, 'id')
            : [];
    }

    public function addAnggota()
    {
        $this->validate([
            'nama'   => 'required|string|max:255',
            'tipe'   => 'nullable|string|max:50', // bisa dipakai kalau ingin pilih dosen/mahasiswa
            'nidn'   => 'nullable|string|max:50',
            'nim'    => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:50',
        ]);

        $this->anggota[] = [
            'id'     => uniqid(),
            'nama'   => trim($this->nama),
            'nidn'   => trim($this->nidn),
            'nim'    => trim($this->nim),
            'alamat' => trim($this->alamat),
            'kontak' => trim($this->kontak),
        ];

        $this->reset(['nama', 'nidn', 'nim', 'alamat', 'kontak']);
    }

    public function batal()
    {
        $this->reset(['nama', 'nidn', 'nim', 'alamat', 'kontak']);
    }

    public function hapusTerpilih()
    {
        if (empty($this->selected)) return;

        $this->anggota = array_values(array_filter($this->anggota, function ($item) {
            return !in_array($item['id'], $this->selected);
        }));

        $this->reset(['selected', 'selectAll']);
    }

    public function updateOrder($order)
    {
        if (!is_array($order)) return;

        $map = collect($this->anggota)->keyBy('id');

        $this->anggota = collect($order)
            ->map(fn($id) => $map[$id] ?? null)
            ->filter()
            ->values()
            ->toArray();
    }

    /**
     * Simpan anggota ke database
     * $parent = instance ProposalPenelitian / ProposalPengabdian
     */
    public function saveMembers($parent)
    {
        foreach ($this->anggota as $member) {
            $parent->members()->create([
                'tipe'   => $member['nidn'] ? 'dosen' : 'mahasiswa',
                'nama'   => $member['nama'],
                'nidn'   => $member['nidn'] ?? null,
                'nim'    => $member['nim'] ?? null,
                'alamat' => $member['alamat'] ?? null,
                'kontak' => $member['kontak'] ?? null,
            ]);
        }
dd($this->anggota);
        // Reset array setelah disimpan
        $this->anggota = [];
        $this->selected = [];
        $this->selectAll = false;
    }

    public function render()
    {
        return view('livewire.add-anggota');
    }
}

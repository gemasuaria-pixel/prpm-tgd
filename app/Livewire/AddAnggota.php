<?php

namespace App\Livewire;
use Livewire\Component;

class AddAnggota extends Component
{
    public $nama, $nidn, $alamat, $kontak;

    // daftar anggota (setiap item berisi id, nama, nidn, alamat, kontak)
    public $anggota = [];

    // array id yang dipilih (checkbox)
    public $selected = [];

    // select all checkbox
    public $selectAll = false;

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = array_column($this->anggota, 'id');
        } else {
            $this->selected = [];
        }
    }

    public function addAnggota()
    {
        $this->validate([
            'nama'   => 'required|string',
            'nidn'   => 'required|string',
            'alamat' => 'required|string',
            'kontak' => 'required|string',
        ]);

        $this->anggota[] = [
            'id'     => (string) uniqid(), // ID unik untuk stabilitas checkbox
            'nama'   => $this->nama,
            'nidn'   => $this->nidn,
            'alamat' => $this->alamat,
            'kontak' => $this->kontak,
        ];

        $this->reset(['nama', 'nidn', 'alamat', 'kontak']);
    }

    public function batal()
    {
        $this->reset(['nama', 'nidn', 'alamat', 'kontak']);
    }

    public function hapusTerpilih()
    {
        if (empty($this->selected)) {
            return;
        }

        $this->anggota = array_values(array_filter($this->anggota, function ($item) {
            return !in_array($item['id'], $this->selected);
        }));

        $this->selected = [];
        $this->selectAll = false;
    }

    // update urutan setelah drag & drop (menerima array id dalam urutan baru)
    public function updateOrder($order)
    {
        if (!is_array($order)) {
            return;
        }

        // buat map id => item untuk lookup cepat
        $map = [];
        foreach ($this->anggota as $item) {
            $map[$item['id']] = $item;
        }

        $newOrder = [];
        foreach ($order as $id) {
            if (isset($map[$id])) {
                $newOrder[] = $map[$id];
                unset($map[$id]);
            }
        }

        // tambahkan sisa item kalau ada (sebagai jaga-jaga)
        foreach ($map as $item) {
            $newOrder[] = $item;
        }

        $this->anggota = array_values($newOrder);
    }

    public function render()
    {
        return view('livewire.add-anggota');
    }
}



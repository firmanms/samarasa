<?php

namespace App\Livewire;

use App\Models\Sekolah;
use Livewire\Component;

class BantuanSearch extends Component
{

    public $search = '';
    public $results = [];

    public function updatedSearch()
    {
        // Debugging: Pastikan metode ini dipanggil
        dd('updatedSearch method called', $this->search);
        $this->results = Sekolah::where('nama_sekolah', 'like', '%smp%')
            ->take(5)
            ->get();
            dd($this->results);
    }

    public function render()
    {

        return view('livewire.bantuan-search');
    }
}

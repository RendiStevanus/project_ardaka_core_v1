<?php

namespace App\Livewire\MasterData\ProgramStudi;

use App\Models\MasterProgramStudi;
use App\Traits\AlertTrait;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use SweetAlert2\Laravel\Traits\WithSweetAlert;

#[Layout('layouts.app')]
#[Title('Program Studi')]
class Index extends Component
{
    use WithPagination;
    use WithSweetAlert;
    use AlertTrait;

    protected $paginationTheme = 'bootstrap';

    public $paginate = '10';

    public $search = '';

    public $kode = '';
    public $nama = '';
    public $jenjang = '';
    public $akreditasi = '';
    public $program_studi_id = '';

    public function resetInputFields()
    {
        $this->kode = '';
        $this->nama = '';
        $this->jenjang = '';
        $this->akreditasi = '';
    }
    public function render()
    {
        $data = [
            'program_studi' => MasterProgramStudi::where('kode', 'like', "%{$this->search}%")
                ->orWhere('nama', 'like', "%{$this->search}%")
                ->orWhere('jenjang', 'like', "%{$this->search}%")
                ->orWhere('akreditasi', 'like', "%{$this->search}%")
                ->paginate($this->paginate)
                ->withQueryString()
        ];

        return view('livewire.master-data.program-studi.index', $data);
    }

    public function create()
    {
        $this->resetValidation();
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate(
            [
                'kode' => 'required|unique:master_program_studi',
                'nama' => 'required',
                'jenjang' => 'required',
                'akreditasi' => 'required',
            ],
            [
                'kode.required' => 'Kode wajib diisi.',
                'kode.unique' => 'Kode sudah digunakan.',
                'nama.required' => 'Nama wajib diisi.',
                'jenjang.required' => 'Jenjang wajib diisi.',
                'akreditasi.required' => 'Akreditasi wajib diisi.',
            ]
        );

        MasterProgramStudi::create([
            'kode' => $this->kode,
            'nama' => $this->nama,
            'jenjang' => $this->jenjang,
            'akreditasi' => $this->akreditasi,
        ]);

        $this->resetInputFields();
        $this->dispatch('closeCreateModal');

        $this->success('Program Studi berhasil disimpan.');
    }

    public function edit($id)
    {
        $this->resetValidation();

        $program_studi = MasterProgramStudi::findOrFail($id);

        $this->kode = $program_studi->kode;
        $this->nama = $program_studi->nama;
        $this->jenjang = $program_studi->jenjang;
        $this->akreditasi = $program_studi->akreditasi;
        $this->program_studi_id = $program_studi->id;
    }

    public function update($id)
    {
        $this->validate(
            [
                'kode' => 'required|unique:master_program_studi,kode,' . $id,
                'nama' => 'required',
                'jenjang' => 'required',
                'akreditasi' => 'required',
            ],
            [
                'kode.required' => 'Kode wajib diisi.',
                'kode.unique' => 'Kode sudah digunakan.',
                'nama.required' => 'Nama wajib diisi.',
                'jenjang.required' => 'Jenjang wajib diisi.',
                'akreditasi.required' => 'Akreditasi wajib diisi.',
            ]
        );

        $program_studi = MasterProgramStudi::findOrFail($id);

        $program_studi->update([
            'kode' => $this->kode,
            'nama' => $this->nama,
            'jenjang' => $this->jenjang,
            'akreditasi' => $this->akreditasi,
        ]);

        $this->resetInputFields();
        $this->dispatch('closeEditModal');

        $this->success('Program Studi berhasil diperbarui.');
    }

    public function confirmDelete($id)
    {
        $program_studi = MasterProgramStudi::findOrFail($id);

        $this->dispatch(
            'confirmDelete',
            id: $program_studi->id,
            kode: $program_studi->kode,
            nama: $program_studi->nama,
            jenjang: $program_studi->jenjang,
            akreditasi: $program_studi->akreditasi,
        );
    }

    public function destroy($id)
    {
        MasterProgramStudi::findOrFail($id)->delete();

        $this->success('Program Studi berhasil dihapus.');
    }

}

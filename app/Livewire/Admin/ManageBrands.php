<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;

class ManageBrands extends Component
{
    use WithPagination;

    public string $name = '';
    public ?int $editingId = null;

    protected $rules = [
        'name' => 'required|string|min:2'
    ];

    public function edit($id): void
    {
        $this->editingId = $id;
        if (\Schema::hasTable('brands')) {
            $b = Brand::findOrFail($id);
            $this->name = $b->name;
        } else {
            $this->name = 'Dummy Brand #'.$id;
        }
    }

    public function save(): void
    {
        $this->validate();
        if (\Schema::hasTable('brands')) {
            if ($this->editingId) {
                Brand::whereKey($this->editingId)->update(['name'=>$this->name]);
            } else {
                Brand::create(['name'=>$this->name]);
            }
        }
        $this->reset('name','editingId');
    }

    public function delete($id): void
    {
        if (\Schema::hasTable('brands')) Brand::whereKey($id)->delete();
    }

    protected function data()
    {
        if (! \Schema::hasTable('brands')) {
            return collect(range(1,12))->map(fn($i)=>(object)['id'=>$i,'name'=>'Dummy Brand #'.$i]);
        }
        return Brand::query()->orderBy('id','desc');
    }

    public function render()
    {
        $data = $this->data();
        if ($data instanceof \Illuminate\Database\Eloquent\Builder) {
            $brands = $data->paginate(10);
        } else {
            $perPage=10; $page=$this->page; $total=$data->count(); $items=$data->slice(($page-1)*$perPage,$perPage)->values();
            $brands = new \Illuminate\Pagination\LengthAwarePaginator($items,$total,$perPage,$page,['path'=>request()->url()]);
        }
        return view('livewire.admin.manage-brands', compact('brands'));
    }
}

<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ManageCategories extends Component
{
    use WithPagination;

    public string $name = '';
    public ?int $editingId = null;

    protected $rules = [
        'name' => 'required|string|min:2'
    ];

    public function resetForm(): void
    {
        $this->reset('name','editingId');
    }

    public function edit($id): void
    {
        $this->editingId = $id;
        if (\Schema::hasTable('categories')) {
            $c = Category::findOrFail($id);
            $this->name = $c->name;
        } else {
            $this->name = 'Dummy Category #'.$id;
        }
    }

    public function save(): void
    {
        $this->validate();
        if (\Schema::hasTable('categories')) {
            if ($this->editingId) {
                Category::whereKey($this->editingId)->update(['name'=>$this->name]);
            } else {
                Category::create(['name'=>$this->name]);
            }
        }
        $this->resetForm();
    }

    public function delete($id): void
    {
        if (\Schema::hasTable('categories')) {
            Category::whereKey($id)->delete();
        }
    }

    protected function data()
    {
        if (! \Schema::hasTable('categories')) {
            return collect(range(1,15))->map(fn($i)=>(object)['id'=>$i,'name'=>'Dummy Category #'.$i]);
        }
        return Category::query()->orderBy('id','desc');
    }

    public function render()
    {
        $data = $this->data();
        if ($data instanceof \Illuminate\Database\Eloquent\Builder) {
            $categories = $data->paginate(10);
        } else {
            $perPage=10; $page=$this->page; $total=$data->count(); $items=$data->slice(($page-1)*$perPage,$perPage)->values();
            $categories = new \Illuminate\Pagination\LengthAwarePaginator($items,$total,$perPage,$page,['path'=>request()->url()]);
        }
        return view('livewire.admin.manage-categories', compact('categories'));
    }
}

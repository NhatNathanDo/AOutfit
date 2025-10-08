<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ManageProducts extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showForm = false;
    public ?int $editingId = null;
    public array $form = [
        'name' => '',
        'price' => '',
    ];

    protected $rules = [
        'form.name' => 'required|string|min:2',
        'form.price' => 'required|numeric|min:0',
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    protected function query()
    {
        // If Product table not migrated yet fallback to collection
        if (! \Schema::hasTable('products')) {
            $items = collect(range(1,25))->map(fn($i)=> (object) [
                'id'=>$i,
                'name'=>"Dummy Product #$i",
                'price'=> rand(100,1000)/10,
            ]);
            if ($this->search) {
                $items = $items->filter(fn($p)=> str_contains(strtolower($p->name), strtolower($this->search)));
            }
            return $items->values();
        }
        $q = Product::query();
        if ($this->search) {
            $q->where('name','like','%'.$this->search.'%');
        }
        return $q->latest();
    }

    public function create(): void
    {
        $this->reset('form','editingId');
        $this->showForm = true;
    }

    public function edit($id): void
    {
        $this->editingId = $id;
        if (\Schema::hasTable('products')) {
            $p = Product::findOrFail($id);
            $this->form = ['name'=>$p->name,'price'=>$p->price];
        } else {
            $this->form = ['name'=>'Dummy Product #'.$id,'price'=> rand(100,1000)/10];
        }
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        if (\Schema::hasTable('products')) {
            if ($this->editingId) {
                Product::whereKey($this->editingId)->update($this->form);
            } else {
                Product::create($this->form);
            }
        }
        $this->showForm = false;
    }

    public function delete($id): void
    {
        if (\Schema::hasTable('products')) {
            Product::whereKey($id)->delete();
        }
    }

    public function render()
    {
        $data = $this->query();
        if ($data instanceof \Illuminate\Database\Eloquent\Builder || $data instanceof \Illuminate\Database\Eloquent\Relations\Relation) {
            $products = $data->paginate(10);
        } else {
            $perPage = 10; $page = $this->page; $collection = $data; $total = $collection->count();
            $items = $collection->slice(($page-1)*$perPage, $perPage)->values();
            $products = new \Illuminate\Pagination\LengthAwarePaginator($items,$total,$perPage,$page,[ 'path'=>request()->url() ]);
        }
        return view('livewire.admin.manage-products', compact('products'));
    }
}

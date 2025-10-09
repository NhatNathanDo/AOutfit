<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class ActivityFeed extends Component
{
    public array $activities = [];

    public function mount(): void
    {
        $this->activities = $this->generate();
    }

    protected function generate(): array
    {
        return collect(range(1,10))->map(function($i){
            return [
                'id' => $i,
                'type' => collect(['order','user','product'])->random(),
                'message' => 'Hoạt động #' . $i . ' vừa xảy ra',
                'time' => now()->subMinutes($i*5)->diffForHumans(),
                'read' => false,
            ];
        })->all();
    }

    public function markAllRead(): void
    {
        foreach ($this->activities as &$a) {
            $a['read'] = true;
        }
    }

    public function toggleRead($id): void
    {
        foreach ($this->activities as &$a) {
            if ($a['id'] === $id) {
                $a['read'] = ! $a['read'];
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.activity-feed');
    }
}

<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Shell extends Component
{
    public string $section = 'dashboard';
    public bool $sidebarOpen = true;

    protected $queryString = [
        'section' => ['except' => 'dashboard']
    ];

    public function setSection(string $section): void
    {
        if (! in_array($section, ['dashboard','products','categories','brands'])) return;
        $this->section = $section;
    }

    public function toggleSidebar(): void
    {
        $this->sidebarOpen = ! $this->sidebarOpen;
    }

    public function render()
    {
        return view('livewire.admin.shell');
    }
}

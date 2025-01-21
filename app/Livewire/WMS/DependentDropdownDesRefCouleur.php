<?php

namespace App\Livewire\WMS;

use Livewire\Component;

class DependentDropdownDesRefCouleur extends Component
{
    public $selectedDirection;

    public $selectedService;

    public $directions;

    public $services;

    public function mount()
    {
        // Initialize data, e.g., fetch directions from the database
        $this->directions = Direction::all();
    }

    public function updatedSelectedDirection($value)
    {
        if ($value) {
            // If direction_id is provided, update the services based on the selected direction
            $this->services = Service::where('direction_id', $value)->get();
        } else {
            // If direction_id is null, set $services to an empty collection or any default value
            $this->services = collect(); // or set it to Service::all() if you want all services to be available by default
        }
    }

    public function render()
    {
        return view('livewire.dependent-dropdown-employe-inscrit');
    }
}

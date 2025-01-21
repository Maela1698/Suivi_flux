<?php

namespace App\View\Components\WMS;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class retour_modal_stock_tissu extends Component
{
    /**
     * Create a new component instance.
     */
    public $typeretour;
    public $idtyperetour;
    public $idstock;
    public function __construct($idtyperetour, $typeretour, $idstock)
    {
        $this->typeretour = $typeretour;
        $this->idtyperetour = $idtyperetour;
        $this->idstock = $idstock;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.w-m-s.retour-modal-stock-tissu');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class MeuComponente extends Component
{
    public $contador = 0;
    public $mensagem = '';

    public function incrementar()
    {
        $this->contador++;
    }

    public function resetContador()
    {
        $this->contador = 0;
        $this->mensagem = '';
    }

    public function render()
    {
        return view('livewire.meu-componente');
    }
}

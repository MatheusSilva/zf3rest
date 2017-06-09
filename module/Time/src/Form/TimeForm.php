<?php
namespace Time\Form;

use Zend\Form\Form;

class TimeForm extends Form 
{
    public function __construct($name = null) 
    {
        // We will ignore the name provided to the constructor
        parent::__construct('time');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'nome',
            'type' => 'text',
            'options' => [
                'label' => 'Nome',
            ],
        ]);

        $this->add([
            'name' => 'tecnico_codigo_tecnico',
            'type' => 'text',
            'options' => [
                'label' => 'Código do técnico',
            ],
        ]);

        $this->add([
            'name' => 'categoria_codigo_categoria',
            'type' => 'text',
            'options' => [
                'label' => 'Código da categoria',
            ],
        ]);

        $this->add([
            'name' => 'divisao_codigo_divisao',
            'type' => 'text',
            'options' => [
                'label' => 'Código da divisão',
            ],
        ]);

        $this->add([
            'name' => 'desempenho_time',
            'type' => 'text',
            'options' => [
                'label' => 'Desempenho do time',
            ],
        ]);

        $this->add([
            'name' => 'comprar_novo_jogador',
            'type' => 'text',
            'options' => [
                'label' => 'Comprar novo jogador',
            ],
        ]);

        $this->add([
            'name' => 'capa',
            'type' => 'text',
            'options' => [
                'label' => 'Capa do time',
            ],
        ]);
    }

}
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

        //este modulo ainda não foi terminado
         
        //tecnico_codigo_tecnico
        //categoria_codigo_categoria
        //divisao_codigo_divisao
        //desempenho_time
        //comprar_novo_jogador
        //capa
    }

}
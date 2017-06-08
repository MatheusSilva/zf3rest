<?php
namespace Time\InputFilter;

use Zend\InputFilter\InputFilter;

class FormTimeFilter extends InputFilter 
{

    public function __construct() 
    {

        $this->add([
            'name'       => 'id',
            'required'   => false,
            'allowEmpty' => false,
            'filters'    => [
            ],
            'validators' => [
            ],
        ]);

        $this->add([
            'name' => 'nome',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 30,
                    ],
                ],
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
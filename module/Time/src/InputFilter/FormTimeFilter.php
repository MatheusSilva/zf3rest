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

        $this->add([
            'name' => 'tecnico_codigo_tecnico',
            'required' => true,
            'filters' => [
                ['name' => 'Int'],
            ],
            'validators' => [
                [
                    'name' => 'Int',
                    'options' => [
                        'min' => 1,
                        'max' => 11,
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'categoria_codigo_categoria',
            'required' => true,
            'filters' => [
                ['name' => 'Int'],
            ],
            'validators' => [
                [
                    'name' => 'Int',
                    'options' => [
                        'min' => 1,
                        'max' => 11,
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'divisao_codigo_divisao',
            'required' => true,
            'filters' => [
                ['name' => 'Int'],
            ],
            'validators' => [
                [
                    'name' => 'Int',
                    'options' => [
                        'min' => 1,
                        'max' => 11,
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'desempenho_time',
            'required' => true,
            'filters' => [
                ['name' => 'Int'],
            ],
            'validators' => [
                [
                    'name' => 'Between',
                    'options' => [
                        'min' => 0,
                        'max' => 1,
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'comprar_novo_jogador',
            'required' => true,
            'filters' => [
                ['name' => 'Int'],
            ],
            'validators' => [
                [
                    'name' => 'Between',
                    'options' => [
                        'min' => 0,
                        'max' => 1,
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'capa',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 5,
                        'max' => 100,
                    ],
                ],
            ],
        ]);
    }

}
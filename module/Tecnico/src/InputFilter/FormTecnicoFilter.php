<?php
namespace Tecnico\InputFilter;

use Zend\InputFilter\InputFilter;

class FormTecnicoFilter extends InputFilter 
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

        $this->add(array(
            'name'       => 'data_nascimento',
            'required'   => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
               array(
                    'name' => 'date',
                    'options' => array(
                        'format' => 'd/m/Y',
                    ),
                ),
             ),
        ));

    }

}
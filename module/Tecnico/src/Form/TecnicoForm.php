<?php
namespace Tecnico\Form;

use Zend\Form\Form;

class TecnicoForm extends Form 
{

    public function __construct($name = null) 
    {
        // We will ignore the name provided to the constructor
        parent::__construct('tecnico');

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
            'name' => 'data_nascimento',
            'type' => 'text',
            'options' => [
                'label' => 'Data de Nascimento',
            ],
        ]);
    }

}
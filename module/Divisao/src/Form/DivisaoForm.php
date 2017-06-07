<?php
namespace Divisao\Form;

use Zend\Form\Form;

class DivisaoForm extends Form 
{

    public function __construct($name = null) 
    {
        // We will ignore the name provided to the constructor
        parent::__construct('divisao');

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
    }

}
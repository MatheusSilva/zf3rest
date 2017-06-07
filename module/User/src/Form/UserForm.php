<?php
namespace User\Form;

use Zend\Form\Form;

class UserForm extends Form {

    public function __construct($name = null) {
        // We will ignore the name provided to the constructor
        parent::__construct('user');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'login',
            'type' => 'text',
            'options' => [
                'label' => 'Login',
            ],
        ]);
        $this->add([
            'name' => 'nome',
            'type' => 'text',
            'options' => [
                'label' => 'Nome',
            ],
        ]);
        $this->add([
            'name' => 'email',
            'type' => 'text',
            'options' => [
                'label' => 'email',
            ],
        ]);
        $this->add([
            'name' => 'telefone',
            'type' => 'text',
            'options' => [
                'label' => 'Número de telefone',
            ],
        ]);
        $this->add([
            'name' => 'endereco',
            'type' => 'text',
            'options' => [
                'label' => 'endereco',
            ],
        ]);
    }

}
<?php
namespace Tecnico\Model;

class Tecnico 
{
    public $codigo_tecnico;
    public $nome;
    public $data_nascimento;

    public function exchangeArray(array $data) 
    {
        $this->codigo_tecnico = null;

        if (!empty($data['id'])) { 
            $this->codigo_tecnico = $data['id'];
        } elseif (!empty($data['codigo_tecnico'])) {
            $this->codigo_tecnico = $data['codigo_tecnico'];
        }
    
        $this->nome = !empty($data['nome']) ? $data['nome'] : null;
        $data = !empty($data['data_nascimento']) ? $data['data_nascimento'] : null;

        if ($data != null) {
            $data = explode("/", $data);
            $data = $data[2]."-".$data[1]."-".$data[0];
        }//if ($data != null) {

        $this->data_nascimento = $data;
    }

    public function getArrayCopy() 
    {
        return [
            'codigo_tecnico'   => $this->codigo_tecnico,
            'nome'             => $this->nome,
            'data_nascimento'  => $this->data_nascimento,
        ];
    }

}
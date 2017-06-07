<?php
namespace Divisao\Model;

class Divisao 
{
    public $codigo_divisao;
    public $nome;

    public function exchangeArray(array $data) 
    {
        $this->codigo_divisao = null;

        if (!empty($data['id'])) { 
            $this->codigo_divisao = $data['id'];
        } elseif (!empty($data['codigo_divisao'])) {
            $this->codigo_divisao = $data['codigo_divisao'];
        }
    
        $this->nome = !empty($data['nome']) ? $data['nome'] : null;
    }

    public function getArrayCopy() 
    {
        return [
            'codigo_divisao'  => $this->codigo_divisao,
            'nome'              => $this->nome,
        ];
    }

}
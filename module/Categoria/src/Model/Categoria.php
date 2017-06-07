<?php
namespace Categoria\Model;

class Categoria 
{
    public $codigo_categoria;
    public $nome;

    public function exchangeArray(array $data) 
    {
        $this->codigo_categoria = null;

        if (!empty($data['id'])) { 
            $this->codigo_categoria = $data['id'];
        } elseif (!empty($data['codigo_categoria'])) {
            $this->codigo_categoria = $data['codigo_categoria'];
        }
    
        $this->nome = !empty($data['nome']) ? $data['nome'] : null;
    }

    public function getArrayCopy() 
    {
        return [
            'codigo_categoria'  => $this->codigo_categoria,
            'nome'              => $this->nome,
        ];
    }

}
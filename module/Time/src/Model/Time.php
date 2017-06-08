<?php
namespace Time\Model;

class Time 
{
    public $codigo_time;
    public $nome;
    public $tecnico_codigo_tecnico;
    public $categoria_codigo_categoria;
    public $divisao_codigo_divisao;
    public $desempenho_time;
    public $comprar_novo_jogador;
    public $capa;

    public function exchangeArray(array $data) 
    {
        $this->codigo_time = null;

        if (!empty($data['id'])) { 
            $this->codigo_time = $data['id'];
        } elseif (!empty($data['codigo_time'])) {
            $this->codigo_time = $data['codigo_time'];
        }
    
        $this->nome = !empty($data['nome']) ? $data['nome'] : null;
        $this->tecnico_codigo_tecnico = !empty($data['tecnico_codigo_tecnico']) ? $data['tecnico_codigo_tecnico'] : null;
        $this->categoria_codigo_categoria = !empty($data['categoria_codigo_categoria']) ? $data['categoria_codigo_categoria'] : null;
        $this->divisao_codigo_divisao = !empty($data['divisao_codigo_divisao']) ? $data['divisao_codigo_divisao'] : null;
        $this->desempenho_time = !empty($data['desempenho_time']) ? $data['desempenho_time'] : null;
        $this->comprar_novo_jogador = !empty($data['comprar_novo_jogador']) ? $data['comprar_novo_jogador'] : null;
        $this->capa = !empty($data['capa']) ? $data['capa'] : null;
    }

    public function getArrayCopy() 
    {
        return [
            'codigo_time'                   => $this->codigo_time,
            'nome'                          => $this->nome,
            'tecnico_codigo_tecnico'        => $this->tecnico_codigo_tecnico,
            'categoria_codigo_categoria'    => $this->categoria_codigo_categoria,
            'divisao_codigo_divisao'        => $this->divisao_codigo_divisao,
            'desempenho_time'               => $this->desempenho_time,
            'comprar_novo_jogador'          => $this->comprar_novo_jogador,
            'capa'                          => $this->capa,
        ];
    }

}
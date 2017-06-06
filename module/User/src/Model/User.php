<?php
namespace User\Model;

class User {
    public $codigo_torcedor;
    public $login;
    public $senha;
    public $nome;
    public $email;
    public $telefone;
    public $endereco;

    public function exchangeArray(array $data) {
        $this->codigo_torcedor       = !empty($data['id']) ? $data['id'] : null;
        $this->login = !empty($data['login']) ? $data['login'] : null;
        $this->senha = !empty($data['senha']) ? $data['senha'] : null;
        $this->nome = !empty($data['nome']) ? $data['nome'] : null;
        $this->email    = !empty($data['email']) ? $data['email'] : null;
        $this->telefone  = !empty($data['telefone']) ? $data['telefone'] : null;
        $this->endereco  = !empty($data['endereco']) ? $data['endereco'] : null;
    }

    public function getArrayCopy() {
        return [
            'codigo_torcedor'        => $this->codigo_torcedor,
            'login'  => $this->login,
            'senha'  => $this->senha,
            'nome'  => $this->nome,
            'email'     => $this->email,
            'telefone'   => $this->telefone,
            'endereco'   => $this->endereco,
        ];
    }

}
<?php
namespace User\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class UserTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        return $this->tableGateway->select();
    }

    public function getUser($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['codigo_torcedor' => $id]);
        $row = $rowset->current();
        return $row;
    }

    public function saveUser(User $user) {
        $data = [
            'login'  => $user->login,
            'nome'  => $user->nome,
            'email'     => $user->email,
            'telefone'   => $user->telefone,
            'endereco'   => $user->endereco,
        ];

        $id = (int) $user->codigo_torcedor;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getUser($id)) {
            throw new RuntimeException(sprintf(
                'Não é possível atualizar torcedor com identificador %d; não existe',
                $id
            ));
        }

        $this->tableGateway->update($data, ['codigo_torcedor' => $id]);
    }

    public function deleteUser($id) {
        $this->tableGateway->delete(['codigo_torcedor' => (int) $id]);
    }

}

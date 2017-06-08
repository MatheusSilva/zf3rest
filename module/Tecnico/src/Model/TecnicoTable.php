<?php
namespace Tecnico\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class TecnicoTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) 
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() 
    {
        return $this->tableGateway->select();
    }

    public function getTecnico($id) 
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['codigo_tecnico' => $id]);
        $row = $rowset->current();
        return $row;
    }

    public function saveTecnico(Tecnico $tecnico) 
    {
        $data = [
            'nome'  => $tecnico->nome,
            'data_nascimento'  => $tecnico->data_nascimento,
        ];

        $id = (int) $tecnico->codigo_tecnico;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getTecnico($id)) {
            throw new RuntimeException(sprintf(
                'Não é possível atualizar a divisão com identificador %d; não existe',
                $id
            ));
        }

        $this->tableGateway->update($data, ['codigo_tecnico' => $id]);
    }

    public function deleteTecnico($id) 
    {
        $this->tableGateway->delete(['codigo_tecnico' => (int) $id]);
    }

}

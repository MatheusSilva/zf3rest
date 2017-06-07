<?php
namespace Divisao\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class DivisaoTable
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

    public function getDivisao($id) 
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['codigo_divisao' => $id]);
        $row = $rowset->current();
        return $row;
    }

    public function saveDivisao(Divisao $divisao) 
    {
        $data = [
            'nome'  => $divisao->nome,
        ];

        $id = (int) $divisao->codigo_divisao;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getDivisao($id)) {
            throw new RuntimeException(sprintf(
                'Não é possível atualizar a divisão com identificador %d; não existe',
                $id
            ));
        }

        $this->tableGateway->update($data, ['codigo_divisao' => $id]);
    }

    public function deleteDivisao($id) 
    {
        $this->tableGateway->delete(['codigo_divisao' => (int) $id]);
    }

}

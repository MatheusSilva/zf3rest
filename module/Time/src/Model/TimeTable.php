<?php
namespace Time\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class TimeTable
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

    public function getTime($id) 
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['codigo_time' => $id]);
        $row = $rowset->current();
        return $row;
    }

    public function saveTime(Time $time) 
    {
        $data = [
            'nome'                        => $time->nome,
            'tecnico_codigo_tecnico'      => $time->tecnico_codigo_tecnico,
            'categoria_codigo_categoria'  => $time->categoria_codigo_categoria,
            'divisao_codigo_divisao'      => $time->divisao_codigo_divisao,
            'desempenho_time'             => $time->desempenho_time,
            'comprar_novo_jogador'        => $time->comprar_novo_jogador,
            'capa'                        => $time->capa,
        ];

        $id = (int) $time->codigo_time;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getTime($id)) {
            throw new RuntimeException(sprintf(
                'Não é possível atualizar a divisão com identificador %d; não existe',
                $id
            ));
        }

        $this->tableGateway->update($data, ['codigo_time' => $id]);
    }

    public function deleteTime($id) 
    {
        $this->tableGateway->delete(['codigo_time' => (int) $id]);
    }

}

<?php
namespace Categoria\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class CategoriaTable
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

    public function getCategoria($id) 
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['codigo_categoria' => $id]);
        $row = $rowset->current();
        return $row;
    }

    public function saveCategoria(Categoria $categoria) 
    {
        $data = [
            'nome'  => $categoria->nome,
        ];

        $id = (int) $categoria->codigo_categoria;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getCategoria($id)) {
            throw new RuntimeException(sprintf(
                'Não é possível atualizar torcedor com identificador %d; não existe',
                $id
            ));
        }

        $this->tableGateway->update($data, ['codigo_categoria' => $id]);
    }

    public function deleteCategoria($id) 
    {
        $this->tableGateway->delete(['codigo_categoria' => (int) $id]);
    }

}

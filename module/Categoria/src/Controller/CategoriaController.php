<?php
namespace Categoria\Controller;

use Categoria\Form\CategoriaForm;
use Categoria\InputFilter\FormCategoriaFilter;
use Categoria\Model\CategoriaTable;
use Categoria\Model\Categoria;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CategoriaController extends AbstractRestfulController 
{
    private $table;

    public function __construct(CategoriaTable $table) 
    {
        $this->table = $table;
    }
  
    public function getList() 
    {
        $categorias = $this->table->fetchAll();

        $data = $categoriaArr = [];

        foreach ($categorias as $categoria) {
            $data[] = $categoria;
        }

        if (empty($data)) {
            $categoriaArr['status']     = 'sucesso';
            $categoriaArr['message']    = 'Categorias não encontradas';
            $categoriaArr['categorias'] = [];
            return new JsonModel($categoriaArr);
        }

        $categoriaArr['status']     = 'sucesso';
        $categoriaArr['message']    = 'Categorias estão disponíveis';
        $categoriaArr['categorias'] = $data;
        return new JsonModel($categoriaArr);
    }

    public function get($id) 
    {
        $id = (int) $id;

        if (0 === $id) {
            $dataArr['status']  = 'erro';
            $dataArr['message'] = 'Categoria não existe';
            return new JsonModel($dataArr);
        }

        $categoria = $this->table->getCategoria($id);

        $dataArr = $categoriaArr = [];

        if ($categoria) {
            // Private/Protected Object to Array Conversion
            $categoriaArr = json_decode(json_encode($categoria), true);
        } else {
            $dataArr['status']  = 'erro';
            $dataArr['message'] = 'Categoria não existe';
            $dataArr['categoriaDetalhes'] = [];
            return new JsonModel($dataArr);
        }

        $dataArr['status']          = 'sucesso';
        $dataArr['message']         = 'Detalhes da categoria estão disponíveis';
        $dataArr['categoriaDetalhes'] = $categoriaArr;
        return new JsonModel($dataArr);
    }

    public function create($data) 
    {
        $form = new CategoriaForm();
        $request = $this->getRequest();
        $token = $request->getHeader('token')->getFieldValue();
        
        if ($token != "Abc2fh4gkmnop13ax") { 
            /*teste hardcode temporario no if.
             * mudar para uma função que busca este token na tabela torcedor
             * usar uma função mestra  
             */
            $dataArr['status']  = 'error';
            $dataArr['message'] = 'Por favor faça o login novamente!';
            return new JsonModel($dataArr);
        }

        $inputfilter = new FormCategoriaFilter();
        $form->setInputFilter($inputfilter);
        $form->setData($request->getPost());

        $dataArr=[];

        if ($form->isValid()) {
            $categoria = new Categoria();
            $categoria->exchangeArray($form->getData());
            $this->table->saveCategoria($categoria);
            $dataArr['status']  = 'sucesso';
            $dataArr['message'] = 'Categoria adicionada com sucesso!';
            return new JsonModel($dataArr);
        }
           
        $dataArr['status']  = 'erro';
        $messages = $form->getMessages();

        if (!empty($messages)) {
            $dataArr['message'] = $messages;    
        }

        return new JsonModel($dataArr);
    }

    public function update($id, $data) 
    {
        $id = (int) $id;

        $dataArr=[];

        if (0 === $id) {
            $dataArr['status']  = 'erro';
            $dataArr['message'] = 'Categoria não existe';
            return new JsonModel($dataArr);
        }

        $form = new CategoriaForm();

        $inputfilter = new FormCategoriaFilter();
        $form->setInputFilter($inputfilter);
        $data['id'] = $id;
        $form->setData($data);

        if ($form->isValid()) {
            $categoria = new Categoria();
            $categoria->exchangeArray($form->getData());

            try {
                $this->table->saveCategoria($categoria);
                $dataArr['status']  = 'sucesso';
                $dataArr['message'] = 'Categoria atualizada com sucesso!';
                return new JsonModel($dataArr);
            } catch (\Exception $e) {
                $dataArr['status']  = 'erro';
                $dataArr['message'] = 'Categoria não existe';
                return new JsonModel($dataArr);
            }
        }

        $dataArr['status']  = 'erro';
        $messages = $form->getMessages();

        if (!empty($messages)) {
            $dataArr['message'] = $messages;    
        }

        return new JsonModel($dataArr);
    }

    public function delete($id) 
    {
        $id = (int) $id;

        $dataArr=[];

        if (0 === $id) {
            $dataArr['status']  = 'erro';
            $dataArr['message'] = 'Categoria não existe';
            return new JsonModel($dataArr);
        }

        $categoria = $this->table->getCategoria($id);

        if ($categoria) {
            $this->table->deleteCategoria($id);
            $dataArr['status']  = 'sucesso';
            $dataArr['message'] = 'Categoria excluída com sucesso!';
            return new JsonModel($dataArr);
        }

        $dataArr['status']  = 'erro';
        $dataArr['message'] = 'Categoria não existe';
        return new JsonModel($dataArr);
    }

}
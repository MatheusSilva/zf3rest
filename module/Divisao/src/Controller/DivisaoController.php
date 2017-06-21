<?php
namespace Divisao\Controller;

use Divisao\Form\DivisaoForm;
use Divisao\InputFilter\FormDivisaoFilter;
use Divisao\Model\DivisaoTable;
use Divisao\Model\Divisao;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class DivisaoController extends AbstractRestfulController 
{
    private $table;

    public function __construct(DivisaoTable $table) 
    {
        $this->table = $table;
    }
    
    public function getList() 
    {
        $divisaos = $this->table->fetchAll();

        $data = $divisaoArr = [];

        foreach ($divisaos as $divisao) {
            $data[] = $divisao;
        }

        if (empty($data)) {
            $divisaoArr['status']     = 'sucesso';
            $divisaoArr['message']    = 'Divisões não encontradas';
            $divisaoArr['divisao'] = [];
            return new JsonModel($divisaoArr);
        }

        $divisaoArr['status']     = 'sucesso';
        $divisaoArr['message']    = 'Divisões estão disponíveis';
        $divisaoArr['divisao'] = $data;
        return new JsonModel($divisaoArr);
    }

    public function get($id) 
    {
        $id = (int) $id;

        if (0 === $id) {
            $dataArr['status']  = 'erro';
            $dataArr['message'] = 'Divisão não existe';
            return new JsonModel($dataArr);
        }

        $divisao = $this->table->getDivisao($id);

        $dataArr = $divisaoArr = [];

        if ($divisao) {
            // Private/Protected Object to Array Conversion
            $divisaoArr = json_decode(json_encode($divisao), true);
        } else {
            $dataArr['status']  = 'erro';
            $dataArr['message'] = 'Divisão não existe';
            $dataArr['divisaoDetalhes'] = [];
            return new JsonModel($dataArr);
        }

        $dataArr['status']  = 'sucesso';
        $dataArr['message'] = 'Detalhes da divisão estão disponíveis';
        $dataArr['divisaoDetalhes'] = $divisaoArr;
        return new JsonModel($dataArr);
    }

    public function create($data) 
    {
        $form = new DivisaoForm();
        $request = $this->getRequest();

        $inputfilter = new FormDivisaoFilter();
        $form->setInputFilter($inputfilter);
        $form->setData($request->getPost());

        $dataArr=[];

        if ($form->isValid()) {
            $divisao = new Divisao();
            $divisao->exchangeArray($form->getData());
            $this->table->saveDivisao($divisao);
            $dataArr['status']  = 'sucesso';
            $dataArr['message'] = 'Divisão adicionada com sucesso!';
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
            $dataArr['message'] = 'Divisão não existe';
            return new JsonModel($dataArr);
        }

        $form = new DivisaoForm();

        $inputfilter = new FormDivisaoFilter();
        $form->setInputFilter($inputfilter);
        $data['id'] = $id;
        $form->setData($data);

        if ($form->isValid()) {
            $divisao = new Divisao();
            $divisao->exchangeArray($form->getData());

            try {
                $this->table->saveDivisao($divisao);
                $dataArr['status']  = 'sucesso';
                $dataArr['message'] = 'Divisão atualizada com sucesso!';
                return new JsonModel($dataArr);
            } catch (\Exception $e) {
                $dataArr['status']  = 'erro';
                $dataArr['message'] = 'Divisão não existe';
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
            $dataArr['message'] = 'Divisão não existe';
            return new JsonModel($dataArr);
        }

        $divisao = $this->table->getDivisao($id);

        if ($divisao) {
            $this->table->deleteDivisao($id);
            $dataArr['status']  = 'sucesso';
            $dataArr['message'] = 'Divisão excluída com sucesso!';
            return new JsonModel($dataArr);
        }

        $dataArr['status']  = 'erro';
        $dataArr['message'] = 'Divisão não existe';
        return new JsonModel($dataArr);
    }

}
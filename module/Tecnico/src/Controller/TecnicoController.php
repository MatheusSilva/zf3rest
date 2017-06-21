<?php
namespace Tecnico\Controller;

use Tecnico\Form\TecnicoForm;
use Tecnico\InputFilter\FormTecnicoFilter;
use Tecnico\Model\TecnicoTable;
use Tecnico\Model\Tecnico;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class TecnicoController extends AbstractRestfulController 
{
    private $table;

    public function __construct(TecnicoTable $table) 
    {
        $this->table = $table;
    }
    
    public function getList() 
    {
        $tecnicos = $this->table->fetchAll();

        $data = $tecnicoArr = [];

        foreach ($tecnicos as $tecnico) {
            $data[] = $tecnico;
        }

        if (empty($data)) {
            $tecnicoArr['status']     = 'sucesso';
            $tecnicoArr['message']    = 'Técnicos não encontrados';
            $tecnicoArr['tecnicos'] = [];
            return new JsonModel($tecnicoArr);
        }

        $tecnicoArr['status']     = 'sucesso';
        $tecnicoArr['message']    = 'Técnicos estão disponíveis';
        $tecnicoArr['tecnicos'] = $data;
        return new JsonModel($tecnicoArr);
    }

    public function get($id) 
    {
        $id = (int) $id;

        if (0 === $id) {
            $dataArr['status']  = 'erro';
            $dataArr['message'] = 'Técnico não existe';
            return new JsonModel($dataArr);
        }

        $tecnico = $this->table->getTecnico($id);

        $dataArr = $tecnicoArr = [];

        if ($tecnico) {
            // Private/Protected Object to Array Conversion
            $tecnicoArr = json_decode(json_encode($tecnico), true);
        } else {
            $dataArr['status']  = 'erro';
            $dataArr['message'] = 'Técnico não existe';
            $dataArr['tecnicoDetalhes'] = [];
            return new JsonModel($dataArr);
        }

        $dataArr['status']  = 'sucesso';
        $dataArr['message'] = 'Detalhes do Técnico estão disponíveis';
        $dataArr['tecnicoDetalhes'] = $tecnicoArr;
        return new JsonModel($dataArr);
    }

    public function create($data) 
    {
        $form = new TecnicoForm();
        $request = $this->getRequest();

        $inputfilter = new FormTecnicoFilter();
        $form->setInputFilter($inputfilter);
        $form->setData($request->getPost());

        $dataArr=[];

        if ($form->isValid()) {
            $tecnico = new Tecnico();
            $tecnico->exchangeArray($form->getData());
            $this->table->saveTecnico($tecnico);
            $dataArr['status']  = 'sucesso';
            $dataArr['message'] = 'Técnico adicionado com sucesso!';
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
            $dataArr['message'] = 'Técnico não existe';
            return new JsonModel($dataArr);
        }

        $form = new TecnicoForm();

        $inputfilter = new FormTecnicoFilter();
        $form->setInputFilter($inputfilter);
        $data['id'] = $id;
        $form->setData($data);

        if ($form->isValid()) {
            $tecnico = new Tecnico();
            $tecnico->exchangeArray($form->getData());
            
            try {
                $this->table->saveTecnico($tecnico);
                $dataArr['status']  = 'sucesso';
                $dataArr['message'] = 'Técnico atualizada com sucesso!';
                return new JsonModel($dataArr);
            } catch (\Exception $e) {
                $dataArr['status']  = 'erro';
                $dataArr['message'] = 'Técnico não existe';
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
            $dataArr['message'] = 'Técnico não existe';
            return new JsonModel($dataArr);
        }

        $tecnico = $this->table->getTecnico($id);

        if ($tecnico) {
            $this->table->deleteTecnico($id);
            $dataArr['status']  = 'sucesso';
            $dataArr['message'] = 'Técnico excluído com sucesso!';
            return new JsonModel($dataArr);
        }

        $dataArr['status']  = 'erro';
        $dataArr['message'] = 'Técnico não existe';
        return new JsonModel($dataArr);
    }

}
<?php
namespace Time\Controller;

use Time\Form\TimeForm;
use Time\InputFilter\FormTimeFilter;
use Time\Model\TimeTable;
use Time\Model\Time;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class TimeController extends AbstractRestfulController 
{
    private $table;

    public function __construct(TimeTable $table) 
    {
        $this->table = $table;
    }

    public function getList() 
    {
        $times = $this->table->fetchAll();

        $data = $timeArr = [];

        foreach ($times as $time) {
            $data[] = $time;
        }

        if (empty($data)) {
            $timeArr['status']     = 'sucesso';
            $timeArr['message']    = 'Divisões não encontradas';
            $timeArr['torcedores'] = [];
            return new JsonModel($timeArr);
        }

        $timeArr['status']     = 'sucesso';
        $timeArr['message']    = 'Divisões estão disponíveis';
        $timeArr['torcedores'] = $data;
        return new JsonModel($timeArr);
    }

    public function get($id) 
    {
        $id = (int) $id;

        if (0 === $id) {
            $dataArr['status']  = 'erro';
            $dataArr['message'] = 'Divisão não existe';
            return new JsonModel($dataArr);
        }

        $time = $this->table->getTime($id);

        $dataArr = $timeArr = [];

        if ($time) {
            // Private/Protected Object to Array Conversion
            $timeArr = json_decode(json_encode($time), true);
        } else {
            $dataArr['status']  = 'erro';
            $dataArr['message'] = 'Divisão não existe';
            $dataArr['torcedorDetails'] = [];
            return new JsonModel($dataArr);
        }

        $dataArr['status']  = 'sucesso';
        $dataArr['message'] = 'Detalhes da divisão estão disponíveis';
        $dataArr['torcedorDetails'] = $timeArr;
        return new JsonModel($dataArr);
    }

    public function create($data) 
    {
        $form = new TimeForm();
        $request = $this->getRequest();

        $inputfilter = new FormTimeFilter();
        $form->setInputFilter($inputfilter);
        $form->setData($request->getPost());

        $dataArr=[];

        if ($form->isValid()) {
            $time = new Time();
            $time->exchangeArray($form->getData());
            $this->table->saveTime($time);
            $dataArr['status']  = 'sucesso';
            $dataArr['message'] = 'Divisão adicionada com sucesso!';
            return new JsonModel($dataArr);
        }

        $dataArr['status']  = 'erro';
        $dataArr['message'] = 'Dados inválidos';
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

        $form = new TimeForm();

        $inputfilter = new FormTimeFilter();
        $form->setInputFilter($inputfilter);
        $data['id'] = $id;
        $form->setData($data);

        if ($form->isValid()) {
            $time = new Time();
            $time->exchangeArray($form->getData());

            try {
                $this->table->saveTime($time);
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
        $dataArr['message'] = 'Dados inválidos';
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

        $time = $this->table->getTime($id);

        if ($time) {
            $this->table->deleteTime($id);
            $dataArr['status']  = 'sucesso';
            $dataArr['message'] = 'Divisão excluída com sucesso!';
            return new JsonModel($dataArr);
        }

        $dataArr['status']  = 'erro';
        $dataArr['message'] = 'Divisão não existe';
        return new JsonModel($dataArr);
    }

}
<?php
namespace Time\Controller;

use Time\Form\TimeForm;
use Time\InputFilter\FormTimeFilter;
use Time\Model\TimeTable;
use Time\Model\Time;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

use Zend\I18n\Translator\Resources;
use Zend\I18n\Translator\Translator;

class TimeController extends AbstractActionController 
{
    private $table;

    public function __construct(TimeTable $table) 
    {
        $this->table = $table;
    }

    private function translateMessageErrors($arrMessages)
    {
        $translator = new Translator();
        $translator->addTranslationFilePattern(
            'phpArray',
            Resources::getBasePath(),
            Resources::getPatternForValidator()
        );

        $arrAux = $arrMessages;

        foreach ($arrAux as $keyProp => $valueProp) {
            foreach ($valueProp as $key => $value) {
            $arrMessages[$keyProp][$key] = $translator->translate($value, 'default', 'pt_BR');
            }
        }
        
        return $arrMessages;    
    }

    public function indexAction() 
    {
        $times = $this->table->fetchAll();

        $data = $timeArr = [];

        foreach ($times as $time) {
            $data[] = $time;
        }

        if (empty($data)) {
            $timeArr['status']     = 'sucesso';
            $timeArr['message']    = 'Times não encontradas';
            $timeArr['torcedores'] = [];
            return new JsonModel($timeArr);
        }

        $timeArr['status']     = 'sucesso';
        $timeArr['message']    = 'Times estão disponíveis';
        $timeArr['torcedores'] = $data;
        return new JsonModel($timeArr);
    }

    public function detalheAction() 
    {
        $id = (int) $this->params()->fromRoute('id');

        if (0 === $id) {
            $dataArr['status']  = 'erro';
            $dataArr['message'] = 'Time não existe';
            return new JsonModel($dataArr);
        }

        $time = $this->table->getTime($id);

        $dataArr = $timeArr = [];

        if ($time) {
            // Private/Protected Object to Array Conversion
            $timeArr = json_decode(json_encode($time), true);
        } else {
            $dataArr['status']  = 'erro';
            $dataArr['message'] = 'Time não existe';
            $dataArr['torcedorDetails'] = [];
            return new JsonModel($dataArr);
        }

        $dataArr['status']  = 'sucesso';
        $dataArr['message'] = 'Detalhes do time estão disponíveis';
        $dataArr['torcedorDetails'] = $timeArr;
        return new JsonModel($dataArr);
    }

    public function createAction() 
    {
        /*if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
        }*/

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
            $dataArr['message'] = 'Time adicionado com sucesso!';
            return new JsonModel($dataArr);
        }

        $dataArr['status']  = 'erro';
        $messages = $form->getMessages();

        if (!empty($messages)) {
            $dataArr['message'] = $messages;    
        }

        return new JsonModel($dataArr);
    }

    public function updateAction() 
    {
        $id = (int) $this->params()->fromRoute('id');

        $dataArr=[];

        if (0 === $id) {
            $dataArr['status']  = 'erro';
            $dataArr['message'] = 'Time não existe';
            return new JsonModel($dataArr);
        }

        $form = new TimeForm();
        $request = $this->getRequest();

        $inputfilter = new FormTimeFilter();
        $form->setInputFilter($inputfilter);
        $data = $request->getPost();
        $data['id'] = $id;
        $form->setData($data);

        if ($form->isValid()) {
            $time = new Time();
            $time->exchangeArray($form->getData());

            try {
                $this->table->saveTime($time);
                $dataArr['status']  = 'sucesso';
                $dataArr['message'] = 'Time atualizado com sucesso!';
                return new JsonModel($dataArr);
            } catch (\Exception $e) {
                $dataArr['status']  = 'erro';
                $dataArr['message'] = 'Time não existe';
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

    public function deleteAction() 
    {
        $id = (int) $this->params()->fromRoute('id');

        $dataArr=[];

        if (0 === $id) {
            $dataArr['status']  = 'erro';
            $dataArr['message'] = 'Time não existe';
            return new JsonModel($dataArr);
        }

        $time = $this->table->getTime($id);

        if ($time) {
            $this->table->deleteTime($id);
            $dataArr['status']  = 'sucesso';
            $dataArr['message'] = 'Time excluído com sucesso!';
            return new JsonModel($dataArr);
        }

        $dataArr['status']  = 'erro';
        $dataArr['message'] = 'Time não existe'; 
        
        return new JsonModel($dataArr);
    }

}
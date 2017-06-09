<?php
namespace User\Controller;

use User\Form\UserForm;
use User\InputFilter\FormUserFilter;
use User\Model\UserTable;
use User\Model\User;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\I18n\Translator\Resources;
use Zend\I18n\Translator\Translator;

class UserController extends AbstractRestfulController {

    private $table;

    public function __construct(UserTable $table) {
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

    public function getList() {
        $users = $this->table->fetchAll();
        $data = $userArr = [];
        foreach($users as $user) {
            $data[] = $user;
        }

        if(empty($data)){
            $userArr['status'] ='sucesso';
            $userArr['message'] = 'Torcedores não encontrados';
            $userArr['torcedores'] = [];
            return new JsonModel($userArr);
        }

        $userArr['status'] ='sucesso';
        $userArr['message'] = 'Torcedores estão disponíveis';
        $userArr['torcedores'] = $data;
        return new JsonModel($userArr);

    }

    public function get($id) {
        $id = (int) $id;

        if (0 === $id) {
            $dataArr['status'] ='erro';
            $dataArr['message'] = 'Torcedor não existe';
            return new JsonModel($dataArr);
        }

        $user = $this->table->getUser($id);

        $dataArr = $userArr = [];
        if($user){
            // Private/Protected Object to Array Conversion
            $userArr = json_decode(json_encode($user), true);
        } else {
            $dataArr['status'] ='erro';
            $dataArr['message'] = 'Torcedor não existe';
            $dataArr['torcedorDetails'] = [];
            return new JsonModel($dataArr);
        }

        $dataArr['status'] ='sucesso';
        $dataArr['message'] = 'Detalhes do torcedor estão disponíveis';
        $dataArr['torcedorDetails'] = $userArr;
        return new JsonModel($dataArr);

    }

    public function create($data) {
        $form = new UserForm();
        $request = $this->getRequest();

        $inputfilter = new FormUserFilter();
        $form->setInputFilter($inputfilter);
        $form->setData($request->getPost());

        $dataArr=[];
        if ($form->isValid()) {
            $user = new User();
            $user->exchangeArray($form->getData());
            $this->table->saveUser($user);
            $dataArr['status'] ='sucesso';
            $dataArr['message'] = 'Torcedor adicionado com sucesso!';
            return new JsonModel($dataArr);
        }

        $dataArr['status'] ='erro';
        $messages = $form->getMessages();

        if (!empty($messages)) {
            $dataArr['message'] = $this->translateMessageErrors($messages);    
        }

        return new JsonModel($dataArr);
    }

    public function update($id, $data) {

        $id = (int) $id;

        $dataArr=[];
        if (0 === $id) {
            $dataArr['status'] ='erro';
            $dataArr['message'] = 'Torcedor não existe';
            return new JsonModel($dataArr);
        }

        $form = new UserForm();

        $inputfilter = new FormUserFilter();
        $form->setInputFilter($inputfilter);
        $data['id'] = $id;
        $form->setData($data);

        if ($form->isValid()) {
            $user = new User();
            $user->exchangeArray($form->getData());
            try{
                $this->table->saveUser($user);
                $dataArr['status'] ='sucesso';
                $dataArr['message'] = 'Torcedor atualizado com sucesso!';
                return new JsonModel($dataArr);
            } catch (\Exception $e) {
                $dataArr['status'] ='erro';
                $dataArr['message'] = 'Torcedor não existe';
                return new JsonModel($dataArr);
            }
        }

        $dataArr['status'] ='erro';
        $messages = $form->getMessages();

        if (!empty($messages)) {
            $dataArr['message'] = $this->translateMessageErrors($messages);    
        }

        return new JsonModel($dataArr);

    }

    public function delete($id) {
        $id = (int) $id;

        $dataArr=[];
        if (0 === $id) {
            $dataArr['status'] ='erro';
            $dataArr['message'] = 'Torcedor não existe';
            return new JsonModel($dataArr);
        }

        $user = $this->table->getUser($id);

        if($user){
            $this->table->deleteUser($id);
            $dataArr['status'] ='sucesso';
            $dataArr['message'] = 'Torcedor excluído com sucesso!';
            return new JsonModel($dataArr);
        }

        $dataArr['status'] ='erro';
        $dataArr['message'] = 'Torcedor não existe';
        return new JsonModel($dataArr);

    }

}
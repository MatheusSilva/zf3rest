<?php
namespace User\Controller;

use User\Form\UserForm;
use User\InputFilter\FormUserFilter;
use User\Model\UserTable;
use User\Model\User;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class UserController extends AbstractRestfulController 
{

    private $table;

    public function __construct(UserTable $table) 
    {
        $this->table = $table;
    }

    public function getList() 
    {
        $users = $this->table->fetchAll();
        $data = $userArr = [];
        
        foreach($users as $user) {
            //var_dump($user);exit;
            $data[] = [
                //'codigo_torcedor' => $user->codigo_torcedor,
                'nome' => $user->nome,
                'email' => $user->email
            ];
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

    public function get($id) 
    {
        $id = (int) $id;

        if (0 === $id) {
            $dataArr['status'] ='erro';
            $dataArr['message'] = 'Torcedor não existe';
            return new JsonModel($dataArr);
        }

        $objUser = $this->table->getUser($id);
   
        if (empty($objUser)) {
            $dataArr['status'] ='erro';
            $dataArr['message'] = 'Torcedor não existe';
            $dataArr['torcedorDetalhes'] = [];
            return new JsonModel($dataArr);
        }

        $data[] = [
            'nome' => $objUser->nome,
            'email' => $objUser->email
        ];
        
        $dataArr['status'] ='sucesso';
        $dataArr['message'] = 'Detalhes do torcedor estão disponíveis';
        $dataArr['torcedorDetalhes'] = $data;
        return new JsonModel($dataArr);

    }

    public function create($data) 
    {
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
            $dataArr['message'] = $messages;    
        }

        return new JsonModel($dataArr);
    }

    public function update($id, $data) 
    {

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
            $dataArr['message'] = $messages;    
        }

        return new JsonModel($dataArr);

    }

    public function delete($id) 
    {
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
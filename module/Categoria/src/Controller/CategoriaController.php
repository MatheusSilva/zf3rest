<?php
namespace Categoria\Controller;

use Categoria\Form\CategoriaForm;
use Categoria\InputFilter\FormCategoriaFilter;
use Categoria\Model\CategoriaTable;
use Categoria\Model\Categoria;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\I18n\Translator\Resources;
use Zend\I18n\Translator\Translator;

class CategoriaController extends AbstractRestfulController 
{
    private $table;

    public function __construct(CategoriaTable $table) 
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
            $categoriaArr['torcedores'] = [];
            return new JsonModel($categoriaArr);
        }

        $categoriaArr['status']     = 'sucesso';
        $categoriaArr['message']    = 'Categorias estão disponíveis';
        $categoriaArr['torcedores'] = $data;
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
            $dataArr['torcedorDetails'] = [];
            return new JsonModel($dataArr);
        }

        $dataArr['status']          = 'sucesso';
        $dataArr['message']         = 'Detalhes da categoria estão disponíveis';
        $dataArr['torcedorDetails'] = $categoriaArr;
        return new JsonModel($dataArr);
    }

    public function create($data) 
    {
        $form = new CategoriaForm();
        $request = $this->getRequest();

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
            $dataArr['message'] = $this->translateMessageErrors($messages);    
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
            $dataArr['message'] = $this->translateMessageErrors($messages);    
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
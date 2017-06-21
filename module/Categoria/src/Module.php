<?php
namespace Categoria;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use Application\Util\Translator;
use Zend\Validator\AbstractValidator;
use Zend\I18n\Translator\Resources;

class Module implements ConfigProviderInterface 
{ 
    public function onBootstrap(MvcEvent $e)
    {
        $translator = Translator::factory([ 'locale' => 'pt_BR', ]);
        $translator->addTranslationFilePattern(
            'phparray', // WARNING, NO UPPERCASE
            Resources::getBasePath(),
            Resources::getPatternForValidator()
        );
        AbstractValidator::setDefaultTranslator($translator);
    }

    public function getConfig() 
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig() 
    {
        return [
            'factories' => [
                Model\CategoriaTable::class => function($container) {
                    $tableGateway = $container->get(Model\CategoriaTableGateway::class);
                    return new Model\CategoriaTable($tableGateway);
                },
                Model\CategoriaTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Categoria());
                    $nomeRealTabelaDB = 'categoria';
                    return new TableGateway($nomeRealTabelaDB, $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig() 
    {
        return [
            'factories' => [
                Controller\CategoriaController::class => function($container) {
                    return new Controller\CategoriaController(
                        $container->get(Model\CategoriaTable::class)
                    );
                },
            ],
        ];
    }

}
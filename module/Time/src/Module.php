<?php
namespace Time;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface 
{

    public function getConfig() 
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig() 
    {
        return [
            'factories' => [
                Model\TimeTable::class => function($container) {
                    $tableGateway = $container->get(Model\TimeTableGateway::class);
                    return new Model\TimeTable($tableGateway);
                },
                Model\TimeTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Time());
                    $nomeRealTabelaDB = 'time';
                    return new TableGateway($nomeRealTabelaDB, $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig() 
    {
        return [
            'factories' => [
                Controller\TimeController::class => function($container) {
                    return new Controller\TimeController(
                        $container->get(Model\TimeTable::class)
                    );
                },
            ],
        ];
    }

}
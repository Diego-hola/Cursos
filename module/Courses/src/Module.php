<?php
namespace Courses;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        // Courselist Table 
        return [
            'factories' => [
                //TABLA COURSELIST
                Model\CourselistTable::class => function($container) {
                    $tableGateway = $container->get(Model\CourselistTableGateway::class);
                    return new Model\CourselistTable($tableGateway);
                },
                Model\CourselistTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Courselist());
                    return new TableGateway('courselist', $dbAdapter, null, $resultSetPrototype);
                },
                // tabla POSITIONS 
                Model\JpositionTable::class => function($container) {
                    $tableGateway = $container->get(Model\JpositionTableGateway::class);
                    return new Model\JpositionTable($tableGateway);
                },
                Model\JpositionTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Jposition());
                    return new TableGateway('jposition', $dbAdapter, null, $resultSetPrototype);
                },
                 // tabla CONTACTS 
                 Model\ContactTable::class => function($container) {
                    $tableGateway = $container->get(Model\ContactTableGateway::class);
                    return new Model\ContactTable($tableGateway);
                },
                Model\ContactTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Contact());
                    return new TableGateway('contact', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    // Add this method:
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\CourselistController::class => function($container) {
                    return new Controller\CourselistController(
                        $container->get(Model\CourselistTable::class)
                    );
                },
                
                Controller\JpositionController::class => function($container) {
                    return new Controller\JpositionController(
                        $container->get(Model\JpositionTable::class)
                    );
                },
                Controller\ContactController::class => function($container) {
                    return new Controller\ContactController(
                        $container->get(Model\ContactTable::class)
                    );
                },
            ],
        ];
    }

}

?>
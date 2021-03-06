<?php
//module bootstrap
namespace AcidMan;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use AcidMan\Service\ServiceConfiguration;
use AcidMan\Service\InstallerService;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        //@todo translator
        //$e->getApplication()->getServiceManager()->get('translator');
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
        // Add this method:
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Installer' => function($serviceManager) {
                    $installer = new Service\InstallerService;
                    $dbAdapter = $serviceManager->get('AssetsDB');
                    $dbInstallAdapter = Service\Installer\DBAdapterFactory::getDbInstallerAdapter($dbAdapter);
                    $installer->setDBInstallAdapter($dbInstallAdapter);
                    return $installer;
                }
            ),
            'invokables' => array(
            ),
            'aliases' => array(
                'AssetsDB' => 'Zend\Db\Adapter\Adapter',
            ),
        );
    }
    
}
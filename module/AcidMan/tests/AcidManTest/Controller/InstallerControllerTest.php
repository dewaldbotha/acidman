<?php
namespace AcidManTest\Controller;

use AcidManTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use AcidMan\Controller\InstallerController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;

class InstallerControllerTest extends PHPUnit_Framework_TestCase
{
    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    protected function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $this->controller = new InstallerController();
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'installer'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
    }
    
    public function testInstallerControllerHasInstallerService()
    {
        $this->assertTrue($this->controller->getServiceLocator()->has('Installer'));
    }
    
    public function testIndexActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'index');
    
        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
    
        $this->assertEquals(200, $response->getStatusCode());
    }
}
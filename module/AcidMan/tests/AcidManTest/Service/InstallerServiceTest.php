<?php
namespace AcidManTest\Service;

use AcidManTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use AcidMan\Service\InstallerService;
use PHPUnit_Framework_TestCase;

class InstallerServiceTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        
    }
    
    public function testIsValidEnvironmentReturnsArray()
    {
        $service = new InstallerService();
        $this->assertTrue(is_array($service->isValidEnvironment()));
    }
}
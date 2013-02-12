<?php
namespace AcidManTest\Service;

use AcidManTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use AcidMan\Service\InstallerService;
use PHPUnit_Framework_TestCase;


class InstallerServiceTest extends PHPUnit_Framework_TestCase
{
    protected $fixture = null;
    
    protected function setUp()
    {
        $this->fixture = new InstallerService();
        $serviceManager = Bootstrap::getServiceManager();
        $this->fixture->setServiceLocator($serviceManager);
    }
    
    protected function tearDown()
    {
        $this->fixture = null;
    }
    
    public function testIsValidEnvironmentReturnsBool()
    {
        $this->assertTrue(is_bool($this->fixture->isValidEnvironment()));
    }
    
    public function testCheckValidPHPEnvironmentReturnsBool() 
    {
        $this->assertTrue(is_bool($this->fixture->checkValidPHPVersion()));
    }
    
    
    public function testCheckValidDBDriversReturnsBool()
    {
        $this->assertTrue(is_bool($this->fixture->checkValidDBDrivers()));
    }
    
    public function testCheckValidDBDriversReturnExceptionOnInvalidDBAdapter() 
    {
        $this->setExpectedException('AcidMan\Service\Exception\InstallerException');
        
        $this->fixture->getServiceLocator()->setAllowOverride(true)
                                           ->setService('AssetsDB',null);
                                           
        $this->fixture->checkValidDBDrivers();
    }
    
    public function testCheckValidDataPathReturnsBool()
    {
        $this->assertTrue(is_bool($this->fixture->checkValidDataPath()));
    }
    
    public function testGetMinimunRequiredPHPVersionReturnsString()
    {
        $this->assertTrue(is_string($this->fixture->getMinimunRequiredPHPVersion()));
    }
    
    public function testGetSupportedDriversReturnsArray()
    {
        $this->assertTrue(is_array($this->fixture->getSupportedDrivers()));
    }
    
    public function testGetAssetPathReturnsString()
    {
        $this->assertTrue(is_string($this->fixture->getAssetPath()));
    }
    
    public function testGetFailuresReturnsArray() 
    {
        $this->assertTrue(is_array($this->fixture->getFailures()));
    }
    
    public function testAddRequirementFailIsFluid()
    {
        $this->assertTrue($this->fixture->addRequirementFail('phpversion', 'Unit Test') instanceof InstallerService);
    }
    
    public function testAddRequirementAddsRequirement() {
        $fail = array('phpversion'=>'Unit Test');
        $this->fixture->addRequirementFail('phpversion', 'Unit Test');
        $this->assertEquals($fail, $this->fixture->getFailures());
    }
    
}
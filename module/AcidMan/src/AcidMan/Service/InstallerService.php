<?php
namespace AcidMan\Service;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

class InstallerService implements ServiceManagerAwareInterface
{
    CONST PHP_REQUIRED_VERSION = '5.3';
    
    public function isValidEnvironment() 
    {
        $required = array('phpversion','');
        
        $failed = array();
        
        //check php version
        if (phpversion() >= self::PHP_REQUIRED_VERSION) {
            $failed['phpversion'] = 'PHP Version required: '.self::PHP_REQUIRED_VERSION.' - PHP Version available: '.phpversion(); 
        }
        
        //check database
        $db = $this->getServiceManager()->get('Database');
         
        return true;
    }
    
    public function getServiceManager()
    {
        return $this->serviceManager;
    }
    
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
    
}
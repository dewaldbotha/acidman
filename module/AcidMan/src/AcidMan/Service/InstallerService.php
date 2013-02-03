<?php
namespace AcidMan\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class InstallerService extends AbstractService
{
    CONST PHP_VERSION_REQUIRED = '5.3';
    
    CONST DATA_PATH_REQUIRED = '/data/AcidMan';
    
    protected $supportedDBDrivers = array('mysql');
    
    protected $required = array('phpversion','dbdrivers','assetpath');
    
    protected $failed = array();
    
    public function isValidEnvironment() 
    {
        $result = $this->checkValidPHPVersion() &&
                  $this->checkValidDBDrivers() &&
                  $this->checkValidDataPath();
                  
        return $result;
    }
    
    public function checkValidPHPVersion() 
    {
        if (phpversion() < $this->getMinimunRequiredPHPVersion()) {
            $this->addRequirementFail('phpversion', 'PHP Version required: '.$this->getMinimunRequiredPHPVersion().' - PHP Version available: '.phpversion());
            return false;
        }
        return true;
    }
    
    public function checkValidDBDrivers()
    {
        try {
            $db = $this->getServiceLocator()->get('AssetsDB');
            if (!in_array($db->getDriver()->getConnection()->getDriverName(), $this->getSupportedDrivers())) {
                $this->addRequirementFail('dbdrivers', 'Driver not availble or supported (only '.implode(',',$this->getSupportedDrivers()).')');
                return false;
            }
            return true;    
        } catch (\Exception $e) {
            throw new Exception\InstallerException('Database adapter not initialised',1);
        }
        
    }
    
    public function checkValidDataPath()
    {
        $path = realpath(getcwd().self::DATA_PATH_REQUIRED);
       
        if (!$path || !is_readable($path) || !is_writable($path)) {
            $this->addRequirementFail('assetpath', 'Path ('.$this->getAssetPath().') must be available, accessible and writable');
            return false;
        }
        return true;
    }
    
    public function getMinimunRequiredPHPVersion() 
    {
        return self::PHP_VERSION_REQUIRED;    
    }
    
    public function getSupportedDrivers() 
    {
        return $this->supportedDBDrivers;    
    }
    
    public function getAssetPath()
    {
        return self::DATA_PATH_REQUIRED;
    }
    
    public function addRequirementFail($requirement, $message)
    {
        if (!in_array($requirement, $this->required)) {
            throw new Exception\InstallerException;
        }
        $this->failed[$requirement] = $message;
        
        return $this;
    } 
    
    public function getFailures()
    {
        return $this->failed;
    }
}
<?php
namespace AcidMan\Service\Installer;

class DBAdapterFactory
{
    protected static $supportedDBDrivers = array('MySQL');
    
    public static function getDbInstallerAdapter($adapter)
    {
        $type = $adapter->getDriver()->getConnection()->getDriverName();
        
        if (!self::checkValidDBAdapterDriver($type)) {
            return false;
        }
        
        $type = array_filter(self::getSupportedDrivers(), function($var) use ($type) {
                    if (strtolower($var) === strtolower($type)) 
                        return $var;
        });
        
        $installerAdapter = __NAMESPACE__.'\\'.$type[0].'Adapter';
        
        return new $installerAdapter($adapter);
    }
    
    public static function checkValidDBAdapterDriver($type) 
    {
        if (!in_array(strtolower($type), array_map('strtolower', self::getSupportedDrivers()))) {
            return false;
        }
        
        return true;
    }
    
    public static function getSupportedDrivers()
    {
        return self::$supportedDBDrivers;
    }
    
}
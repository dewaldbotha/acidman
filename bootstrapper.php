<?php
/**
 * Autoloader - No one likes things to be complicated....
 */

//Set some sane defaults for the app
define('ZF2_LIBRARY_PATH', realpath(getcwd().DIRECTORY_SEPARATOR.'vendor/ZF2/library'));

//check for libraries
if ((ZF2_LIBRARY_PATH && is_dir(ZF2_LIBRARY_PATH)) === false) {
    die('Invalid Path or Missing ZF2 Library');
}

if (is_readable(ZF2_LIBRARY_PATH) === false) {
    die('ZF2 Library Found - but not accessible.  Please check file permissions');   
}

//Setup autoloader
require_once ZF2_LIBRARY_PATH.'/Zend/Loader/AutoloaderFactory.php';

Zend\Loader\AutoloaderFactory::factory(array(
    'Zend\Loader\StandardAutoloader' => array(
        'autoregister_zf' => true
    )
));
    
if (!class_exists('Zend\Loader\AutoloaderFactory')) {
    throw new RuntimeException('Unable to load Zend Framework 2');
}
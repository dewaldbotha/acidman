<?php
namespace AcidMan\Controller;
use Zend\View\Model\ViewModel;

class InstallerController extends AbstractController
{
    public function indexAction()
    {
        $installer = $this->getServiceLocator()->get('Installer');
        
        return new ViewModel(array(
            'isValidEnvironment' => $installer->isValidEnvironment(),
            'failures' => $installer->getFailures(),   
        ));
    }
    
    public function step2Action() 
    {
        return new ViewModel(array());
    }
}
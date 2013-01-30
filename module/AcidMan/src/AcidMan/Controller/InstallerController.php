<?php
namespace AcidMan\Controller;
use Zend\View\Model\ViewModel;

class InstallerController extends AbstractController
{
    public function indexAction()
    {
        $installer = $this->getServiceLocator()->get('Installer');
        $results = $installer->isValidEnvironment();
        return new ViewModel(array(
            'results' => $results   
        ));
    }
}
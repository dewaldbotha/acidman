<?php
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/acidman/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'AcidMan\Controller',
                        'controller' => 'Home',
                        'action' => 'index',
                    ),
                ),
           ),
           'installer' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/acidman/installer[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'AcidMan\Controller\Installer',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    /*  @todo translations
     * 
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    */
    'controllers' => array(
        'invokables' => array(
            'AcidMan\Controller\Home'       => 'AcidMan\Controller\HomeController',
            'AcidMan\Controller\Installer'  => 'AcidMan\Controller\InstallerController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'acidman/index/index' => __DIR__ . '/../view/acidman/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
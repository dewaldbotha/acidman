<?php
return array(
    // Available Modules
    'modules' => array(
        'Application',
        'Admin',
    ),

    // These are various options for the listeners attached to the ModuleManager
    'module_listener_options' => array(
        //Where to look for modules
        'module_paths' => array(
            './module',
            './vendor',
        ),
        //config paths
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
    ),
    
);
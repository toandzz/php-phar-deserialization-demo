<?php
return [
    'modules' => [
        'Application',
    ],
    'module_listener_options' => [
        'module_paths' => [
            './module',
        ],
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php',
        ],
    ],
];

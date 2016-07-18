<?php

/**
 * Register application modules
 */
$application->registerModules(array(
    'frontend' => array(
        'className' => 'Coredev\Frontend\Module',
        'path' => __DIR__ . '/../apps/frontend/Module.php'
    ),
    'backend' => array(
        'className' => 'Coredev\Backend\Module',
        'path' => __DIR__ . '/../apps/backend/Module.php'
    )
));

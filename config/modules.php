<?php

/**
 * Register application modules
 */
$application->registerModules(array(
    'frontend' => array(
        'className' => 'Webtamduc\Frontend\Module',
        'path' => __DIR__ . '/../apps/frontend/Module.php'
    )
));

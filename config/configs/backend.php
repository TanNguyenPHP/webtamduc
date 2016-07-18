<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 15-07-2016
 * Time: 3:35 PM
 */
defined('APP_PATH') || define('APP_PATH', realpath('.'));
return new \Phalcon\Config(array(
    'database' => array(
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'sonic1988',
        'dbname'   => 'dbtamduc',
        'charset'  => 'utf8',
    ),
    'application' => array(
        'controllersDir' => APP_PATH . '/apps/backend/controllers/',
        'modelsDir'      => __DIR__ . '/../models/',
        'migrationsDir'  => __DIR__ . '/../migrations/',
        'viewsDir'       => APP_PATH . '/apps/backend/views/',
        'baseUri'        => ''
    )
));

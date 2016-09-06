<?php
/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 */

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Di\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Flash\Direct as Flash;

/**
 * The FactoryDefault Dependency Injector automatically registers the right services to provide a full stack framework
 */
$di = new FactoryDefault();

/**
 * Registering a router
 */
$di->setShared('router', function () {
    $router = new Router();

    $router->setDefaultModule('frontend');
    $router->setDefaultNamespace('Coredev\Frontend\Controllers');

    $router->add(
        '/quanly',
        array(
            'module' => 'backend',
            'namespace' => 'Coredev\Backend\Controllers',
            'controller' => 'login',
            'action' => 'index'
        )
    );

    $router->add(
        "/posts/:params",
        array(
            'module' => 'frontend',
            'controller' => 'posts',
            'action' => 'detail',
            'params' => 1
        )
    );
    $router->add(
        "/posts",
        array(
            'module' => 'frontend',
            'controller' => 'posts',
            'action' => 'index'
        )
    );
    $router->add(
        "/posts/",
        array(
            'module' => 'frontend',
            'controller' => 'posts',
            'action' => 'index'
        )
    );
    return $router;
});

/**
 * The URL component is used to generate all kinds of URLs in the application
 */
$di->setShared('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () use ($config) {
    $dbConfig = $config->database->toArray();
    $adapter = $dbConfig['adapter'];
    unset($dbConfig['adapter']);

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;

    return new $class($dbConfig);
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Starts the session the first time some component requests the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash(array(
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ));
});

/**
* Set the default namespace for dispatcher
*/
$di->setShared('dispatcher', function() use ($di) {
    $eventsManager = new \Phalcon\Events\Manager();

    $eventsManager->attach("dispatch:beforeException", function($event, $dispatcher, $exception) {

        //Handle 404 exceptions
        if ($exception instanceof \Phalcon\Mvc\Dispatcher\Exception) {
            $dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'index'
            ));
            return false;
        }

        //Handle other exceptions
        $dispatcher->forward(array(
            'controller' => 'index',
            'action' => 'index'
        ));

        return false;
    });

    $dispatcher = new \Phalcon\Mvc\Dispatcher();

    //Bind the EventsManager to the dispatcher
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
    //$dispatcher = new Phalcon\Mvc\Dispatcher();
    //$dispatcher->setDefaultNamespace('Coredev\Frontend\Controllers');
    //return $dispatcher;
});

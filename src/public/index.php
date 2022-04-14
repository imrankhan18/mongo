<?php
require_once('../vendor/autoload.php');

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;
use Phalcon\Di;
use Phalcon\Escaper;
use Phalcon\Session;
use Phalcon\Session\Adapter\Stream as sm;
use Phalcon\Http\Response\Cookies;
use Phalcon\Logger;
use Phalcon\Events\Manager;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Session\Manager as ss;
use Phalcon\Events\Manager as EventsManager;

$config = new Config([]);
// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . "/controllers/",
        APP_PATH . "/models/",
        APP_PATH . "/listener/",

    ]
);
// $loader->registerNamespaces(
//     [

//         'App\Listener' => APP_PATH . "/listener",
//     ]
// );
$loader->registerFiles([APP_PATH . '/vendor/autoload.php']);
$loader->register();

$container = new FactoryDefault();


$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);


$container->set(
    "session",
    function () {
        $session = new ss();
        $files = new sm(
            [
                'savePath' => '/tmp',
            ]
        );
        $session->setAdapter($files);
        $session->start();

        return $session;
    }
);

$container->set(
    "cookies",
    function () {

        $cookies = new Cookies();
        $cookies->useEncryption(false);
        return $cookies;
    }
);

$container->set(
    'mongo',
    function () {
        $mongo = new \MongoDB\Client("mongodb://mongo", array("username" => 'root', "password" => "password123"));

        return $mongo;
    },
    true
);

$application = new Application($container);

$eventsManager = new EventsManager();
$container->set(
    'eventsManager',
    function () use ($eventsManager) {
        $eventsManager->attach(
            'spotify',
            new NotificationListener()
        );
        return $eventsManager;
    }
);

$container = new Di();

$container->set(
    'escaper',
    function () {
        return new Escaper();
    }
);

$loader = new Loader();
$loader->registerDirs(
    [
        APP_PATH . "/controller/",
        APP_PATH . "/models/"
    ]
);
$loader->registerNameSpaces(
    [
        'App\Components' => APP_PATH . "/components"
    ]
);
$loader->register();

$container = new Di();

$container->set(
    'logger',
    function () {
        $adapter = new Stream('/app/components/main.log');
        $logger  = new Logger(
            'messages',
            [
                'main' => $adapter,
            ]
        );

        return $logger;
    }
);

try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}

<?php 
ini_set('display_errors', '1');
error_reporting(E_ALL);

define('APP_ROOT', __DIR__);
define('BASE_PATH', '/CorePHPMVC/');
define('BASE_URL', 'http://'.$_SERVER['SERVER_NAME'].BASE_PATH);


// Autoloader function
spl_autoload_register(function($class) {
    $classFile = str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".php";
    $classPath = APP_ROOT . DIRECTORY_SEPARATOR . $classFile;

    if (file_exists($classPath)) {
        require_once($classPath);
    } else {
        echo "File not found: " . $classPath;
    }
});
session_start();
require_once(APP_ROOT."/helper.php");
use \App\Services\Router;

$router = new Router($_SERVER['REQUEST_URI']);
$router->run();


?>

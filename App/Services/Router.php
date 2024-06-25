<?php
namespace App\Services;

use App\Controller\InvoiceController;
class Router{

    private $controller;
    private $method;
    private $params = [];
    private $queryData = [];
    private $requestUri;
    private $parsedUrl;

    public function __construct($url) {

        $this->requestUri =  str_replace(BASE_PATH, '', $_SERVER['REQUEST_URI']);
        $this->parsedUrl = parse_url($this->requestUri, PHP_URL_PATH);

        // Check if $url has a query part
        $query = parse_url($url, PHP_URL_QUERY);
        if ($query !== null) {
            parse_str($query, $data);
            if (isset($data['data'])) {
                $this->queryData = json_decode(urldecode($data['data']), true);
            } else {
                // Handle case where 'data' key is missing in the query string
                $this->queryData = [];
            }
        } else {
            // Handle case where there's no query part in $url
            $this->queryData = [];
        }

        $this->parsedUrl = $this->removeBaseUrl($this->parsedUrl);
        $this->parseUrl();
    }
    private function removeBaseUrl($url) {
        // Remove the base URL part
        $baseUrl = parse_url(APP_ROOT, PHP_URL_PATH);
        if (strpos($url, $baseUrl) === 0) {
             $url = substr($url, strlen($baseUrl));        
        }
        return $url;
    } private function parseUrl() {
        $urlComponents = explode('/', trim($this->parsedUrl, '/'));

        //echo "<pre>"; print_r($urlComponents); echo "</pre>";

        if (count($urlComponents) < 2) {
            $this->invalidUrl('invalid url param');
            return;
        }    
        $this->controller = ucfirst(array_shift($urlComponents)) . 'Controller';
        $this->method = array_shift($urlComponents);

        while (!empty($urlComponents)) {
            $this->params[] = array_shift($urlComponents);
        }

    }

    public function run() {
        
        $ControllerPath= "\App\Controller\\";
        $fullControllerName = $ControllerPath . $this->controller;
        if (!class_exists($fullControllerName)) {
            echo "class not exist"; exit;
            $this->invalidUrl('controller not exit');
            return;
        }
        $controllerInstance = new $fullControllerName();
        
        if (!method_exists($controllerInstance, $this->method)) {
            $this->invalidUrl('method not exist');
            return;
        }

        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }

    private function invalidUrl($message) {
        echo "Invalid URL!".$message;
        exit;
    }    
}


?>
<?php

use App\Controller\DropdownController;

function view($fileName, $data = []) {
    $filePath = APP_ROOT . '/App/View/' . $fileName . '.php';
    
    if (file_exists($filePath)) {
        // Extract variables into the current symbol table
        extract($data);
        // Require the view file
        require $filePath;
    } else {
        throw new \Exception("File not found: " . $filePath);
    }
}


function redirect($url){
    $url = BASE_PATH.$url;
    header("location:$url");
    exit;
}
function url($path){
    return BASE_URL.$path;
}

function redirectWith($url, $data){
    $queryString = urlencode(json_encode($data));
        // Create the URL with the query string
        $url = BASE_PATH.$url.'?data='.$queryString;
        header("location:$url");
        exit;
}
function redirectBack() {
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previousUrl = $_SERVER['HTTP_REFERER'];
        header("Location: $previousUrl");
        exit;
    } else {
        throw new \Exception("No previous URL found to redirect back to.");
    }
}
function renderOptions($dropDownData,$selected ){
    echo "<pre>"; print_r($dropDownData); echo "</pre>";
    foreach ($dropDownData as $option){
        $isSelected = $selected == $option['id'] ? 'selected' : '';
        echo '<option '.$isSelected.' value="'.$option['id'].'">'.$option['text'].'</option>';
    }
}
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}
?>
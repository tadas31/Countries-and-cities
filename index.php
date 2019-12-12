<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

spl_autoload_register(function ($className){
    if (file_exists('Libs/'.$className.'.php')){
        require_once 'Libs/'.$className.'.php';
    }

    else if (file_exists('Controllers/'.$className.'.php')){
        require_once 'Controllers/'.$className.'.php';
    }

    else if (file_exists('Models/'.$className.'.php')){
        require_once 'Models/'.$className.'.php';
    }

    else if (file_exists($className.'.php')){
        require_once $className.'.php';
    }
});


new Bootstrap();
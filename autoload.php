<?php

DEFINE('DOC_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');

spl_autoload_register(function ($class_name) {
    // Replace namespace separator with directory separator
    $path = DOC_ROOT . str_replace('\\', '/', $class_name) . '.php';
    
    if (file_exists($path)) {
        require_once($path);
    }
});

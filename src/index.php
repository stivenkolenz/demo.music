<?php

@error_reporting(E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE);
@ini_set('error_reporting', E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE);

@ini_set('display_errors', true);
@ini_set('html_errors', true);

define('ROOT', __DIR__);
define('TEST', false);

session_start();

function req($name, $path = '/app/classes/')
{
    if (strpos($name, '.php') !== false || strpos($name, '/') !== false) {
        $path = ROOT . $path . $name;
    } else {
        $path = ROOT . $path . $name . '.class.php';
    }

    if (file_exists($path)) {
        return $path;
        // require_once $path;
    } else {
        die('Error load<br>File <b>' . $path . '</b> does not exist');
    }
}

require_once req('engine.php', '/app/');

<?php
function __autoload($class)
{
    $file = "class/" . $class . ".php";
    if (is_readable($file)) {
        require $file;
    }
}

$db = new Database;

<?php

function autoload($classname){
    require_once 'controllers/'.$classname.'.php';
}

spl_autoload_register('autoload');

?>
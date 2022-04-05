<?php

class ErrorController{
        
    /**
     * Carga la vista del error 404
     */
    public function index(){
        require_once 'views/errors/404.php';
    }
}

?>
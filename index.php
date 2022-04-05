<?php
ob_start();
session_start();

require_once 'autoload.php';
require_once 'config/parameters.php';
require_once 'config/database.php';



require_once 'views/layouts/header.php';

function show_error_page(){
    $error = new ErrorController();
    $error->index();
}

if(isset($_GET['controller'])){
    $nombreControlador = ucfirst($_GET['controller'].'Controller');
}else if(!isset($_GET['controller']) && !isset($_GET['action'])){
    // Cargar controlador por defecto
    $nombreControlador = controller_default;
}else{
    show_error_page();
}
if($nombreControlador){

    $controlador = new $nombreControlador();


    if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
        $action = $_GET['action'];
        $controlador->$action();
    }else if(!isset($_GET['controller']) && !isset($_GET['action'])){
        $default_action = action_default;
        $controlador->$default_action();
    }else{
        show_error_page();
    }

}else{
    show_error_page();
}


require_once 'views/layouts/footer.php';

?>
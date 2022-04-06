<?php

require_once 'helpers/Utils.php';
require_once 'models/Expense.php';
require_once 'models/Category.php';

class StaticsController{
    /**
     * Renderiza la página de estadísticas.
     */
    public function index(){
        if(isLogged()){
            // Datos necesarios para los formularios
            $categoryEdit = new Category();
            $categoriesEdit = $categoryEdit->getAll();
            require_once 'views/statics/index.php';
        }
    }
}


?>
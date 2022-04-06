<?php

require_once 'helpers/Utils.php';
require_once 'models/Expense.php';
require_once 'models/Category.php';


class DashboardController{
        
    /**
     * Renderiza el panel de control
     */
    public function index(){
        if(isLogged()){
            // Datos necesarios para los formularios
            $category = new Category();
            $categories = $category->getAll();
            $categoryEdit = new Category();
            $categoriesEdit = $categoryEdit->getAll();
            require_once 'views/dashboard/index.php';
        } 
    }


}

?>
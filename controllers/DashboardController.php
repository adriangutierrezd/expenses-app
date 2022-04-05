<?php

require_once 'helpers/Utils.php';
require_once 'models/Expense.php';
require_once 'models/Category.php';


class DashboardController{
        
    /**
     * Obtiene todos los datos necesarios, carga la vista del panel de control y los envía.
     */
    public function index(){
        if(isLogged()){
            $expense = new Expense();
            $expenses = $expense->getAll();
            $expensesByCategory = $expense->amountSpentByCategory();

            $category = new Category();
            $categories = $category->getAll();
            $categoryEdit = new Category();
            $categoriesEdit = $categoryEdit->getAll();
            $monthSpent = $expense->amountSpent();

            require_once 'views/dashboard/index.php';
        } 
    }


}

?>
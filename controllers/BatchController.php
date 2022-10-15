<?php

require_once 'models/User.php';
require_once 'models/Batch.php';
require_once 'helpers/Utils.php';

class BatchController{
    
    /**
     * Genera un resumen mensual para todos los usuarios: presupuesto - gastos
    */
    public function resumen_mensual(){

        $batch = new Batch();
        $usuarios = $batch->getAllUsersWithBudget();


        foreach($usuarios as $usuario){
            
            $budget = $usuario[4];
            $id_usuario = $usuario[0];
            
            
    
            $date = date('Y-m-d', strtotime("last day of previous month"));
            $spent = 0;
            $fecha_inicio = date('Y-m-d', strtotime("first day of previous month"));
            $fecha_fin = date('Y-m-d', strtotime("last day of previous month"));
            
            
            $expenses = $batch->getExpensesFromPrevMonth($id_usuario, $fecha_inicio, $fecha_fin);

            
            
            // Guarda el total gastado
            $spent = 0;
            
            
            foreach($expenses as $expense){
                $spent += floatval($expense[0]);
            }
            
               
            // Insertamos los resultados
            $batch->saveResults($id_usuario, $budget, $spent, $date);

    
        }

    
    }


    /** 
     * Añade a los gastos del mes de los usuario todos sus gastos recurrentes
    */
    public function cargar_recurrentes(){
        
        // Obtenemos los gastos recurrentes
        $batch = new Batch();
        $recurrentExpenses = $batch->getAllRecurrentExpenses();

        $date = date('Y-m-d');

        // Los insertamos en los respectivos usuarios
        foreach($recurrentExpenses as $expense){
            $user = $expense['user_id'];
            $category = $expense['id_categoria'];
            $amount = $expense['amount'];
            $name = $expense['description'];

            $res = $batch->processRecurrentExpense($name, $category, $amount, $user, $date);

        }

    }

}



?>
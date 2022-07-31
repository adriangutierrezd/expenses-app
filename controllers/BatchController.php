<?php

require_once 'models/User.php';
require_once 'models/Batch.php';
require_once 'helpers/Utils.php';

class BatchController{
    
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

}



?>
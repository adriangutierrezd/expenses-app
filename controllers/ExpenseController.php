<?php

require_once 'models/Expense.php';
require_once 'models/Category.php';
require_once 'helpers/Utils.php';

class ExpenseController{
    
    /**
     * Crea un nuevo gasto
     * 
     * Recoge, limpia y comprueba los datos enviados en el formulario. Si hay algún error lo muestra, y si está todo correcto, crea la instancia de gasto.
     */
    public function save(){
        ob_clean();
        header('Content-Type: application/json');
        $request_body = file_get_contents('php://input');
        $request = json_decode($request_body);
        
        $expense = new Expense();
        $expense->setCategory_id($request->category_id);
        $expense->setName($request->name);
        $expense->setAmount($request->amount);
        $expense->setDate($request->date);

        $save = $expense->save();
        echo json_encode($save);
        die();
    }

    /**
     * Elimina un gasto de la base de datos
     */
    public function delete(){
        ob_clean();
        header('Content-Type: application/json');
        $request_body = file_get_contents('php://input');
        $request = json_decode($request_body);
        $id = $request->id;
        $expense = new Expense();
        $delete = $expense->delete($id);
        echo json_encode($delete);
        die();
    }
    
    /**
     * Actualiza un gasto
     * 
     * Recoge, limpia y comprueba los datos enviados en el formulario. Si hay algún error lo muestra, y si está todo correcto, actualiza el gasto en la base de datos
     */
    public function update(){
        ob_clean();
        header('Content-Type: application/json');
        $request_body = file_get_contents('php://input');
        $request = json_decode($request_body);
        
        $expense = new Expense();
        $expense->setId($request->id);
        $expense->setCategory_id($request->category_id);
        $expense->setName($request->name);
        $expense->setAmount($request->amount);
        $expense->setDate($request->date);

        $update = $expense->update();
        echo json_encode($update);
        die();
    }

    /**
     * Cuando recibe una petición AJAX, obtiene los gastos de la base de datos y las manda a la vista
     */
    public function getExpenseByCategory(){
        ob_clean();
        header('Content-Type: application/json');
        $request_body = file_get_contents('php://input');
        $startDate = null;
        $endDate = null;
        if($request_body != null){
            $request = json_decode($request_body);
            $startDate = $request->start_date;
            $endDate = $request->end_date;
        }
        $expenses = [];
        $expense = new Expense();
        $data = $expense->amountSpentByCategory($startDate, $endDate);
        while($exp = $data->fetch_object()){
            array_push($expenses, $exp);
        }
        echo json_encode($expenses);
        die();
    }   

    public function getExpenseByMonth(){
        ob_clean();
        header('Content-Type: application/json');
        $expenses = [];
        $expense = new Expense();
        $data = $expense->amountSpentByMonth();
        while($exp = $data->fetch_object()){
            array_push($expenses, $exp);
        }
        echo json_encode($expenses);
        die();
    }

    public function getExpenses(){
        ob_clean();
        header('Content-Type: application/json');
        $request_body = file_get_contents('php://input');
        $startDate = null;
        $endDate = null;
        if($request_body != null){
            $request = json_decode($request_body);
            $startDate = $request->start_date;
            $endDate = $request->end_date;
        }
        $expenses = [];
        $expense = new Expense();
        $data = $expense->getAll($startDate, $endDate);
        while($exp = $data->fetch_object()){
            array_push($expenses, $exp);
        }
        echo json_encode($expenses);
        die();
    }


}


?>
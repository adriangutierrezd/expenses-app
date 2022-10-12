<?php

require_once 'models/Expense.php';
require_once 'models/RecurrentExpense.php';
require_once 'models/Result.php';
require_once 'models/Category.php';
require_once 'helpers/Utils.php';

class ExpenseController{

    public function index(){
        if(isLogged()){
            $category = new Category();
            $categories = $category->getAll();
            $categoryEdit = new Category();
            $categoriesEdit = $categoryEdit->getAll();
            require_once 'views/expenses/index.php';
        }
    }
    
    /**
     * Recibe los datos desde Javascript y crea un nuevo gasto
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
        if($save) $this->changesOnPreviousMonth($request->date, 'sumar', $request->amount);
        
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
        if($delete) $this->changesOnPreviousMonth($request->date, 'restar', $request->amount);
        echo json_encode($delete);
        die();
    }
    
    /**
     * Recibe los datos desde Javascript y actualiza un gasto
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
        if($update){

            $direccion = $request->previousAmount - $request->amount;
            $movimiento = '';
            if($direccion < 0) $movimiento = 'sumar';
            if($direccion > 0) $movimiento = 'restar';

            if(strlen($movimiento) > 1) $this->changesOnPreviousMonth($request->date, $movimiento, abs($direccion));
        }
        echo json_encode($update);
        die();
    }

    /**
     * Obtiene el gasto desagregado por categoría del periodo seleccionado
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

    /**
     * Obtiene el gasto desagregado por mes del último año natural
     */
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

    /**
     * Obtiene la información de los gastos del periodo seleccionado
     */
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
        if($data){
            while($exp = $data->fetch_object()){
                array_push($expenses, $exp);
            }
        }else{
            $expenses = 'Debes añadir algún gasto.';
        }
        if(gettype($expenses) === 'array' && count($expenses) <= 0){$expenses = 'Debes añadir algún gasto.';}
        echo json_encode($expenses);
        die();
    }

    /**
     * Determina si estamos añadiendo, modificando o eliminando un gasto de un mes anterior 
     * @param $date -> Fecha del gasto que se está editando, modificando o añadiendo
     * @param $movimiento -> Indica qué se ha hecho: sumar / restar
     * @param $importe -> Importe que se debe sumar o restar
     * @return void
    */
    public function changesOnPreviousMonth($date, $movimiento, $importe){
        $nmesActual = date('n');
        $mesGasto = date('n', strtotime($date));
        $anioGasto = date('Y', strtotime($date));
        
        if($nmesActual > $mesGasto){
            $result = new Result();
            $result->updateResults($_SESSION['login']->id, $mesGasto, $importe, $movimiento, $anioGasto);
        }
    }


    /**
     * Carga la vista de gastos recurrentes
    */
    public function recurrent(){
        if(isLogged()){
            $category = new Category();
            $catgs = $category->getAll();
            $categories = [];
            while ($category = $catgs->fetch_object()){
                $categories[] = (array) $category;
            }
            require_once 'views/expenses/recurrent.php';
        }
    }


    /**
     * Obtiene la información de los gastos del periodo seleccionado
     */
    public function getRecurrentExpenses(){
        ob_clean();
        header('Content-Type: application/json');
        $expenses = [];
        $expense = new RecurrentExpense();
        $data = $expense->getRecurrentExpenses();
        if($data){
            while($exp = $data->fetch_object()){
                array_push($expenses, $exp);
            }
        }else{
            $expenses = 'Debes añadir algún gasto recurrente.';
        }
        if(gettype($expenses) === 'array' && count($expenses) <= 0){$expenses = 'Debes añadir algún gasto recurrente.';}
        echo json_encode($expenses);
        die();
    }


    /**
     * Recibe los datos de un gasto recurrente y lo crea en la base de datos
    */
    public function createRecurrentExpense(){
        ob_clean();
        header('Content-Type: application/json');
        $request_body = file_get_contents('php://input');
        $request = json_decode($request_body);
        
        $expense = new RecurrentExpense();
        $expense->setCategory_id($request->category);
        $expense->setName($request->name);
        $expense->setAmount($request->amount);

        $save = $expense->save();
        
        echo json_encode($save);
        die();
    }


    /**
     * Actualiza un gasto recurrente en la base de datos
    */
    public function updateRecurrentExpense(){
        ob_clean();
        header('Content-Type: application/json');
        $request_body = file_get_contents('php://input');
        $request = json_decode($request_body);
        
        $expense = new RecurrentExpense();
        $expense->setId($request->id);
        $expense->setCategory_id($request->category_id);
        $expense->setName($request->name);
        $expense->setAmount($request->amount);


        $update = $expense->update();
        echo json_encode($update);
        die();
    }


    /**
     * Elimina un gasto recurrente de la base de datos
    */
    public function deleteRecurrentExpense(){
        ob_clean();
        header('Content-Type: application/json');
        $request_body = file_get_contents('php://input');
        $request = json_decode($request_body);
        
        $expense = new RecurrentExpense();
        $expense->setId($request->id);

        $delete = $expense->deleteRecurrentExpense();
        echo json_encode($delete);
        die();
    }

}


?>
<?php

require_once 'models/User.php';
require_once 'models/Expense.php'; 

class BudgetController{

    /**
     * Actualiza el presupuesto del usuario.
     * 
     * Recoge, limpia y comprueba los datos enviados en el formulario. Si hay algún error lo muestra, y si está todo correcto, actualiza el dato en la base de datos y en la sesión.
     */
    public function save(){
        if(isset($_POST)){
            $errorCount = false;
            $errors = [];

            $budget = $_POST['budget'] ? trim($_POST['budget']) : false;

            if($budget == ''){
                $errorCount = true;
                $errors['budget'] = 'Debes introducir un presupuesto';
            }

            if($errorCount){
                $_SESSION['errors'] = $errors;
            }else{
                $user = new User();
                $user->setBudget($budget);
                $save = $user->saveBudget();
                if($save){
                    $_SESSION['success'] = 'Presupuesto añadido con éxito';
                    $_SESSION['login']->budget = $budget;
                }else{
                    $_SESSION['failure'] = 'Ha ocurrido un error';
                }
            }
        }

        header('Location:'.base_url.'dashboard/index');
    }

    /**
     * Recibe los datos desde Javascript y actualiza el presupuesto de un usuario
     */
    public function update(){
        ob_clean();
        header('Content-Type: application/json');
        $request_body = file_get_contents('php://input');
        $request = json_decode($request_body);
        $user = new User();
        $user->setBudget($request->budget);
        $save = $user->saveBudget();
        if($save) $_SESSION['login']->budget = $request->budget;
        echo json_encode($save);
        die();
    }

    /**
     * Obtiene tanto el presupuesto de un usuario como la información de sus gastos el último mes
     */
    public function getStats(){
        ob_clean();
        header('Content-Type: application/json');
        $response = [];
        $user = new User();
        $expenses = [];
        $expense = new Expense();
        $data = $expense->getAll();
        while($exp = $data->fetch_object()){
            array_push($expenses, $exp);
        }
        $budget = $user->getBudget();
        array_push($response, $budget);
        array_push($response, $expenses);
        echo json_encode($response);
        die();
    }


}

?>
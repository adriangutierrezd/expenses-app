<?php


class Batch{

    private $db;
    
    /**
     * Inicia la conexión a la base de datos
     */
    public function __construct(){
        $this->db = Database::connect();
    }
    
    
    /**
     * Obtiene todos los usuarios con preuspuesto
     * @return Array con los usuarios
     */
    public function getAllUsersWithBudget(){
        try{
            $sql = "SELECT * FROM users WHERE budget IS NOT NULL AND budget > 0";
            $result = $this->db->query($sql);

            $usuarios = [];
            while($row = $result->fetch_row()){
                array_push($usuarios, $row);
            }
                    
            return $usuarios;
            
        }catch(Exception $exc){
            return false;
        }
    }
    
    
    /**
     * Obtiene los gastos entre 2 fechas de un usuario concreto
     * @param  mixed $id_usuario -> ID del usuario
     * @param mixed $fecha_inicio -> Fecha de inicio
     * @param mixed $fecha_fin -> Fecha de fin
     * @return un Array con los gastos si la operación es exitosa, false si no lo es
     */
    public function getExpensesFromPrevMonth($id_usuario, $fecha_inicio, $fecha_fin){
        try{
            $sql = "SELECT amount FROM expenses WHERE user_id = '$id_usuario' AND date BETWEEN '$fecha_inicio' AND '$fecha_fin'";
            $result = $this->db->query($sql);

            $expenses = [];
            while($row = $result->fetch_row()){
                array_push($expenses, $row);
            }
                    
            return $expenses;
            
        }catch(Exception $exc){
            return false;
        }
    }
    
    
    /**
     * Guarda los resultados mensuales de un usuario
     * @param  mixed $id_usuario -> ID del usuario
     * @param float $budget -> Presupuesto del mes del usuario
     * @param float $spent -> Gasto total del mes
     * @param mixed $date -> Fecha del mes del resultado
     * @return true si la operación es exitosa, false si no lo es
     */
    public function saveResults($id_usuario, $budget, $spent, $date){
        try{
            $insert = $this->db->query("INSERT INTO results (user_id, budget, spent, date) VALUES($id_usuario, $budget, $spent, '$date')");
            if($insert) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

        

}

?>


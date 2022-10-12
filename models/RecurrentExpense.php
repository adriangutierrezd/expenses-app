<?php


class RecurrentExpense extends Expense{

    /**
     * Inicia la conexión a la base de datos y obtiene el usuario conectado para las distintas operaciones del modelo.
     */
    public function __construct(){
        parent::__construct();  
    }

    
    /**
     * Crea un gasto recurrente en la base de datos
     * @return Boolean True si el proceso es exitoso, false si no lo es
    */
    public function save(){
        try{
            $sql = "INSERT INTO recurrent_expenses (user_id, id_categoria, description, amount) VALUES ($this->user_id, $this->category_id, '$this->name', $this->amount)";
            $save = $this->db->query($sql);
            if($save) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }


    /**
     *  Obtiene todos los gastos recurrentes de un usuario
     * @return Object con los gastos de dicho usuario
    */
    public function getRecurrentExpenses(){
        try{
            $sql = "SELECT re.id_recurrent_expenses, re.user_id, re.description, re.id_categoria, re.amount, c.name, c.color FROM recurrent_expenses re inner join categories c ON 
            c.id = re.id_categoria WHERE re.user_id = '$this->user_id' ORDER BY amount DESC";
            $expenses = $this->db->query($sql);
            if($expenses) return $expenses;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }


    /**
     * Actualiza un gasto recurrente en la base de datos
     * @return true si el la operación es exitosa, y false si no lo es.
     */
    public function update(){
        try{
            $sql = "UPDATE recurrent_expenses SET id_categoria = '$this->category_id', description = '$this->name', amount = '$this->amount' WHERE id_recurrent_expenses = '$this->id'";
            $update = $this->db->query($sql);
            if($update) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

    /**
     * Elimina un gasto recurrente en la base de datos
     * @return true si el la operación es exitosa, y false si no lo es.
     */
    public function deleteRecurrentExpense(){
        try{
            $sql = "DELETE FROM recurrent_expenses WHERE id_recurrent_expenses = '$this->id'";
            $update = $this->db->query($sql);
            if($update) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

}



?>
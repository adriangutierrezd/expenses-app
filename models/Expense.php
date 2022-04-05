<?php


class Expense{
    private $id;
    private $user_id;
    private $category_id;
    private $name;
    private $amount;
    private $date;
    private $db;

    /**
     * Inicia la conexión a la base de datos y obtiene el usuario conectado para las distintas operaciones del modelo.
     */
    public function __construct(){
        $this->db = Database::connect();
        $this->user_id = $_SESSION['login']->id;
    }

    /**
     * Guarda un nuevo gasto en la base de datos
     * @return true si el la operación es exitosa, y false si no lo es.
     */
    public function save(){
        try{
            $sql = "INSERT INTO expenses (id, user_id, category_id, name, amount, date) VALUES (NULL, $this->user_id, $this->category_id, '$this->name', $this->amount, '$this->date')";
            $save = $this->db->query($sql);
            if($save) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

    /**
     * Actualiza un gasto en la base de datos
     * @return true si el la operación es exitosa, y false si no lo es.
     */
    public function update(){
        try{
            $sql = "UPDATE expenses SET name = '$this->name', category_id = $this->category_id, amount = $this->amount, date = '$this->date' WHERE id = $this->id AND user_id = $this->user_id";
            $update = $this->db->query($sql);
            if($update) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

    /**
     * Elimina un gasto de la base de datos
     * @param  mixed $id identificador del gasto a eliminar
     * @return true si el la operación es exitosa, y false si no lo es.
     */
    public function delete($id){
        try{
            $sql = "DELETE FROM expenses WHERE id = $id AND user_id = $this->user_id";
            $delete = $this->db->query($sql);
            if($delete) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

    /**
     * Devuelve los gastos del usuario en un periodo de tiempo concreto, si no se especifica, se devuelven los gastos del mes.
     * @param  mixed $start_date Inicio del periodo
     * @param  mixed $end_date Fin del periodo
     * @return devuelve los gastos si la operación ha sido exitosa, y false si no lo es.
     */
    public function getAll($start_date = null, $end_date = null){
        try{
            if($start_date != null && $end_date != null){
                $sql = "SELECT expenses.id, expenses.category_id, expenses.name AS expense_name, expenses.amount, expenses.date, categories.name AS category_name FROM expenses INNER JOIN categories 
                ON expenses.category_id = categories.id AND expenses.user_id = $this->user_id AND (expenses.date BETWEEN '$start_date' AND '$end_date')";
            }else{
                $sql = "SELECT expenses.id, expenses.category_id, expenses.name AS expense_name, expenses.amount, expenses.date, categories.name AS category_name FROM expenses INNER JOIN categories 
                ON expenses.category_id = categories.id AND expenses.user_id = $this->user_id AND (MONTH(expenses.date) = MONTH(CURRENT_DATE()) AND YEAR(expenses.date) = YEAR(CURRENT_DATE()))";
            }
            $expenses = $this->db->query($sql);
            if($expenses){return $expenses;}
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

    /**
     * Devuelve la suma de todos los gastos de los últimos 12 meses agregados por mes.
     * @return devuelve el mes y su gasto total si la operación ha sido exitosa, y false si no lo es.
     */
    public function amountSpentByMonth(){
        try{
            $sql = "SELECT MONTH(date) AS MONTH, SUM(amount) AS SPENT FROM expenses WHERE user_id = $this->user_id GROUP BY MONTH(date), YEAR(date) ORDER BY date ASC LIMIT 12";
            $query = $this->db->query($sql);
            if($query) return $query;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

    /**
     * Devuelve el gasto total de un usuario en el intervalo de fechas especificado, o en el mes
     * @param  mixed $start_date Inicio del periodo
     * @param  mixed $end_date  Final del periodo
     * @return devuelve el importe desagregado por mes si la operación es exitosa, y false si no lo es.
     */
    function amountSpent($start_date = null, $end_date = null){
        try{
            if($start_date != null && $end_date != null){
                $sql = "SELECT SUM(amount) AS SPENT FROM expenses WHERE user_id = $this->user_id AND (date BETWEEN '$start_date' AND '$end_date'))";
            }else{
                $sql = "SELECT SUM(amount) AS SPENT FROM expenses WHERE user_id = $this->user_id AND (MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()))";
            }
            $amountSpent = $this->db->query($sql);
            $amountSpent = $amountSpent->fetch_object();
            if($amountSpent){return $amountSpent;}
            return false;
        }catch(Exception $exc){
            return false;
        }
    }


        
    /**
     * Devuelve el gasto desagregado por categoría en un periodo concreto, o en el mes.
     * @param  mixed $start_date Inicio del periodo
     * @param  mixed $end_date  Fin del periodo
     * @return devuelve las categorías junto con su importe si la operación es exitosa, y false si no lo es
     */
    function amountSpentByCategory($start_date = null, $end_date = null){
        try{
            if($start_date != null && $end_date != null){
                $sql = "SELECT SUM(e.amount) AS SPENT, c.name AS NAME, c.color AS COLOR FROM expenses e, categories c WHERE e.user_id = $this->user_id AND e.category_id = c.id AND (date BETWEEN '$start_date' AND '$end_date') GROUP BY category_id";
            }else{
                $sql = "SELECT SUM(e.amount) AS SPENT, c.name AS NAME, c.color AS COLOR FROM expenses e, categories c WHERE e.user_id = $this->user_id AND e.category_id = c.id AND (MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())) GROUP BY category_id";
            }
            $query = $this->db->query($sql);
            if($query) return $query;
            return false;
        }catch(Exception $exc){
            return false;
        }   
    }

    /**
     * Actualiza el atributo $category_id del gasto
     * @param  mixed $category_id
     */
    public function setCategory_id($category_id){
        $this->category_id = $category_id;
    }

    /**
     * Actualiza el atributo $nombre del gasto
     * @param  mixed $name
     */
    public function setName($name){
        $this->name = $name;
    }
    
    /**
     * Actualiza el atributo $amount del gasto
     * @param  mixed $amount
     */
    public function setAmount($amount){
        $this->amount = $amount;
    }
    
    /**
     * Actualiza el atributo $id del gasto
     * @param  mixed $id
     */
    public function setId($id){
        $this->id = $id;
    }
    
    /**
     * Actualiza el atributo $date del gasto
     * @param  mixed $date
     */
    public function setDate($date){
        $this->date = $date;
    }
}



?>



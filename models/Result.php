<?php

class Result{
    private $user_id;

    /**
     * Inicia la conexión a la base de datos y obtiene el usuario conectado para las distintas operaciones del modelo.
     */
    public function __construct(){
        $this->db = Database::connect();
        $this->user_id = $_SESSION['login']->id;
    }

    /**
     * Obtiene los resultados obtenido en meses pasados
     */
    public function getResults(){
        try{
            $sql = "SELECT * FROM results WHERE user_id = $this->user_id ORDER BY anio, mes DESC";
            $results = $this->db->query($sql);
            if($results){return $results;}
            return false;
        }catch(Exception $e){
            return false;
        }
    }


    public function updateResults($usuario, $mes, $importe, $movimiento, $anio){
        try{
            $sql = '';
            if($movimiento == 'restar'){
                $sql = "UPDATE results SET spent = spent - $importe WHERE user_id = '$usuario' AND mes = '$mes' AND anio = '$anio'";
            }else{
                $sql = "UPDATE results SET spent = spent + $importe WHERE user_id = '$usuario' AND mes = '$mes' AND anio = '$anio'";
            }
            $results = $this->db->query($sql);
            if($results) return true;
            return false;
        }catch(Exception $e){
            return false;
        }
    }

}

?>
<?php

require_once 'models/Result.php';

class ResultController{

    /**
     * Obtiene los resultados obtenido en meses pasados
     */
    public function getResults(){
        ob_clean();
        header('Content-Type: application/json');
        
        $results = [];
        $result = new Result();
        $data = $result->getResults();
        if($data){
            while($res = $data->fetch_object()){
                array_push($results, $res);
            }
        }else{
            $results = 'Debes esperar a que termine el mes para visualizar estas estadísticas.';
        }
        if(count($results) <= 0){$results = 'Debes esperar a que termine el mes para visualizar estas estadísticas.';}
        echo json_encode($results);
        die();
    }
}

?>
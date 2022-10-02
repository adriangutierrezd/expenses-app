<?php 

    define('DB_HOST_INT', 'localhost');
    define('DB_USER_INT', 'root');
    define('DB_PASS_INT', '');
    define('DB_NAME_INT', 'expensesapp');
    
    $conexion= mysqli_connect(DB_HOST_INT, DB_USER_INT, DB_PASS_INT, DB_NAME_INT);
    if(!$conexion){
        die("Ha sido imposible conectarse: ".mysqli_error($conexion));
    }
    if (mysqli_connect_errno()) {
        die("La conexion ha fallado: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }
    
    /**
     * 1. Sacamos todos los usuarios.
     * 2. Para cada uno de ellos, iteramos sus gastos del mes a fecha de finalizaci���n, y sumamos el total.
     * 3. Lo restamos al presupuesto.
     * 4. Guardamos el resultado
     * 
    **/
    $sql_1 = "SELECT * FROM users";
    
    $r1 = mysqli_query($conexion, $sql_1);
    $usuarios = [];
    while($row = mysqli_fetch_assoc($r1)){
        array_push($usuarios, $row);
    }
    
    
    foreach($usuarios as $usuario){
        $budget = $usuario['budget'];
        if($budget != NULL){
            
            $id_usuario = $usuario['id'];

            $date = strtotime("last day of previous month");
            $spent = 0;
            $fecha_inicio = strtotime("first day of previous month");
            $fecha_fin = strtotime("last day of previous month");
            $mes = date('n', strtotime($fecha_inicio));
            $anio = date('Y', strtotime($fecha_inicio));
            
            
            // Obtenemos todos los gastos del usuario del mes anterior
            
            $sql_2 = "SELECT amount FROM expenses WHERE user_id = '$id_usuario' AND date BETWEEN '$fecha_inicio' AND '$fecha_fin'";
            $r2 = mysqli_query($conexion, $sql_2);
            
            while($row = mysqli_fetch_assoc($r2)){
                $spent += floatval($row['amount']);
            }
            
            // Insertamos los datos en la tabla de resultados
            $sql_insert = "INSERT INTO results (user_id, budget, spent, mes, anio) VALUES($id_usuario, $budget, $spent, $mes, $anio)";
            $save = mysqli_query($conexion, $sql_insert);
            
        }

    }
    


?>
<?php 

    define('DB_HOST_INT', 'localhost');//DB_HOST:  generalmente suele ser "127.0.0.1"
    define('DB_USER_INT', 'adriangu_expensesapp_admin');//Usuario de tu base de datos
    define('DB_PASS_INT', '^Aw134sb4ALH');//Contrase���a del usuario de la base de datos
    define('DB_NAME_INT', 'adriangu_expensesapp');//Nombre de la base de datos
    
    $conexion_intranet=@mysqli_connect(DB_HOST_INT, DB_USER_INT, DB_PASS_INT, DB_NAME_INT);
    if(!$conexion_intranet){
        die("Ha sido imposible conectarse: ".mysqli_error($conexion_intranet));
    }
    if (@mysqli_connect_errno()) {
        die("La conexion ha fallado: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }

    //die();
    
    /**
     * 1. Sacamos todos los usuarios.
     * 2. Para cada uno de ellos, iteramos sus gastos del mes a fecha de finalizaci���n, y sumamos el total.
     * 3. Lo restamos al presupuesto.
     * 4. Guardamos el resultado
     * 
    **/
    
    $sql_1 = "SELECT * FROM users";
    
    $r1 = mysqli_query($conextion_intranet, $sql_1);
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
            
            
            // Obtenemos todos los gastos del usuario del mes anterior
            
            $sql_2 = "SELECT amount FROM expenses WHERE user_id = '$id_usuario' AND date BETWEEN '$fecha_inicio' AND '$fecha_fin'";
            $r2 = mysqli_query($conextion_intranet, $sql_2);
            
            while($row = mysqli_fetch_assoc($r2)){
                $spent += floatval($row['amount']);
            }
            
            // Insertamos los datos en la tabla de resultados
            $sql_insert = "INSERT INTO results (user_id, budget, spent, date) VALUES($id_usuario, $budget, $spent, '$date')";
            $save = mysqli_query($conexion_intranet, $sql_insert);
            
        }

    }
    


?>
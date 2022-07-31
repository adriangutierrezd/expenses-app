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
    
    $sql_1 = "INSERT INTO users (name, username, password) VALUES ('Test batch', 'test_batch', 'passbatch')";
    
    $r1 = mysqli_query($conextion_intranet, $sql_1);

    


?>
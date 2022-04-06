<?php


class User{
    private $id;
    private $name;
    private $username;
    private $password;
    private $budget;
    private $db;
    

        
    /**
     * Inicia la conexión a la base de datos
     */
    public function __construct(){
        $this->db = Database::connect();
        $this->id = $_SESSION['login']->id;
    }

        
    /**
     * Devuelve el nombre de usuario instanciado
     * @return nombre de usuario instanciado
     */
    public function getName(){
        return $this->name;
    }

    /**
     * Actualiza el nombre del usuario
     * @param  mixed $name 
     */
    public function setName($name){
        $this->name = $this->db->real_escape_string($name);
    }
    
    /**
     * Devuelve el nombre de usuario del usuario
     * @return username del usuario instanciado
     */
    public function getUsername(){
        return $this->username;
    }

    /**
     * Actualiza el nombre de usuario del usuario
     * @param  mixed $username
     */
    public function setUsername($username){
        $this->username = $this->db->real_escape_string($username);
    }

    /**
     * Cifra y actualiza la contraseña del usuario
     * @param  mixed $password
     */
    public function setPassword($password){
        $this->password = password_hash($this->db->real_escape_string($password), PASSWORD_BCRYPT, ['cost' => 4]);
    }

        
    /**
     * Guarda un nuevo usuario en la base de datos
     * @return true si la operación es exitosa, false si no lo es
     */
    public function save(){
        try{
            $sql = "INSERT INTO users (id, name, username, password) VALUES(NULL, '{$this->getName()}', '{$this->getUsername()}', '{$this->getPassword()}')";
            $save = $this->db->query($sql);
            if($save){return true;}
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

        
    /**
     * Verifica que el nombre de usuario y contraseña introducidos concuerdan con 1 registro en la base de datos
     * @param  mixed $username
     * @param  mixed $password
     * @return devuelve el objeto usuario si hay concordancia, y false si no la hay o la operación ha fracasado
     */
    public function log($username, $password){
        try{
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $login = $this->db->query($sql);
    
            if($login && $login->num_rows == 1){
                $user = $login->fetch_object();
                if(password_verify($password, $user->password)){
                    return $user;
                }
            }    
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

        
    /**
     * Elimina un usuario de la base de datos
     * @param  mixed $id
     * @return true si la operación es exitosa, false si no lo es
     */
    public function delete($id){
        try{
            $delete = $this->db->query("DELETE FROM users WHERE id = $id");
            if($delete) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }
    
    /**
     * Actualiza un usuario en la base de datos
     * @return true si la operación es exitosa, false si no lo es
     */
    public function update(){
        try{
            $update = $this->db->query("UPDATE users SET name = '$this->name', username = '$this->username' WHERE id = $this->id");
            if($update) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }
    
    /**
     * Actualiza la contraseña de un usuario en la base de datos
     * @return true si la operación es exitosa, false si no lo es
     */
    public function updatePassword(){
        try{
            $update = $this->db->query("UPDATE users SET password = '$this->password' WHERE id = $this->id");
            if($update) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

        
    /**
     * Comprueba si ya existe un registro en la base de datos con el mismo nombre de usuario
     * @param  mixed $username
     * @return true si ya existe un usuario con el mismo nombre de usuario, y false si no existe o la operación ha fracasado
     */
    public function existsUsername($username){
        try{
            if(isset($_SESSION['login'])){
                $query = $this->db->query("SELECT * FROM users WHERE username = '$username' AND id != $this->id");
            }else{
                $query = $this->db->query("SELECT * FROM users WHERE username = '$username'");
            }
            if($query->num_rows == 1) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

        
    /**
     * Guarda el presupuesto del usuario en la base de datos
     * @return true si la operación es exitosa, false si no lo es
     */
    public function saveBudget(){
        try{
            $save = $this->db->query("UPDATE users SET budget = $this->budget WHERE id = $this->id");
            if($save) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

    /**
     * Obtiene el presupuesto del usuario
     * @return false si la operación falla, y el presupuesto si la operación es exitosa
     */
    public function getBudget(){
        try{
            $budget = $this->db->query("SELECT budget FROM users WHERE id = $this->id")->fetch_assoc();
            if($budget){return $budget;}
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

    
    /**
     * Actualiza el presupuesto en la instancia de usuario
     * @param  mixed $budget
     */
    public function setBudget($budget){
        $this->budget = $budget;
    }

    public function getPassword(){
        return $this->password;
    }
}

?>


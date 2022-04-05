<?php

require_once 'helpers/Utils.php';

class Category{

    private $id;
    private $user_id;
    private $name;
    private $color;
    private $db;

    
    
    /**
     * Inicia la conexión a la base de datos y obtiene el usuario conectado para las distintas operaciones del modelo.
     * @return void
     */
    public function __construct(){
        $this->db = Database::connect();
        $this->user_id = $_SESSION['login']->id;
    }

    /**
     * Devuelve todas las categorías del usuario junto con la categoría por defecto.
     * @return categories si la operación es exitosa, y false si no lo es.
     */
    public function getAll(){
        try{
            $categories = $this->db->query("SELECT * FROM categories WHERE user_id = $this->user_id OR id = 1");
            if($categories){return $categories;}
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

        
    /**
     * Guarda una nueva categoría en la base de datos
     * @return true si el la operación es exitosa, y false si no lo es.
     */
    public function save(){
        try{
            $sql = "INSERT INTO categories (id, user_id, name, color)
            VALUES (NULL, $this->user_id, '$this->name', '$this->color')";
            $save = $this->db->query($sql);
            if($save) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }

        
    /**
     * Elimina una categoría de la base de datos y cambia a la categoría por defecto todos aquellos gastos asociados a dicha categoría
     * @param  mixed $id identificador de la categoría a eliminar
     * @return true si el la operación es exitosa, y false si no lo es.
     */
    public function delete($id){
        try{
            $sql = "DELETE FROM categories WHERE id = $id AND user_id = $this->user_id";
            $delete = $this->db->query($sql);
            if($delete){setCategoryDefault(); return true;}
            return false;
        }catch(Exception $exc){
            return false;
        }

    }

        
    /**
     * Actualiza los datos de una categoría
     * @return true si el la operación es exitosa, y false si no lo es.
     */
    public function update(){
        try{
            $sql = "UPDATE categories SET name = '$this->name', color = '$this->color' WHERE id = $this->id AND user_id = $this->user_id";
            $update = $this->db->query($sql);
            if($update) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }

    }

        
    /**
     * Actualiza el atributo $id de la categoría
     * @param  mixed $id 
     * @return void
     */
    public function setId($id){
        $this->id = $id;
    }

        
    /**
     * Actualiza el atributo $nombre de la categoría
     * @param  mixed $name
     * @return void
     */
    public function setName($name){
        $this->name = $name;
    }

    
    /**
     * Actualiza el atributo $color de la categoría
     * @param  mixed $color
     * @return void
     */
    public function setColor($color){
        $this->color = $color;
    }

}


?>


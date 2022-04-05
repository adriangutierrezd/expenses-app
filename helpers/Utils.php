<?php

    
    /**
     * Comprueba si un usuario ha iniciado sesión
     * @return true si el usuario ha iniciado sesión, si no lo ha hecho, le redirige a la página de inicio
     */
    function isLogged(){
        if(!isset($_SESSION['login'])){
            header('Location:'.base_url);
        }else{
            return true;
        }
    }

    
    /**
     * Devuelve el nombre de la categoría a la que pertenece un gasto
     * @param  mixed $category_id
     * @return devuelve el nombre de la categoría, si hay un error o no la encuentra, devuelve esta cadena: '-'
     */
    function getExpenseCategoryName($category_id){
        try{
            $db = Database::connect();
            $category_name = $db->query("SELECT name FROM categories WHERE id = $category_id");

            if($category_name && $category_name->num_rows == 1){
                $category_name = $category_name->fetch_object();
                $category_name = $category_name->name;
                return $category_name;
            }else{
                return '-';
            }
        }catch(Exception $exc){
            return '-';
        }
    }

        
    /**
     * Establece la categoría por defecto en un gasto
     * @return true si la operación es exitosa, false si no lo es
     */
    function setCategoryDefault(){
        try{
            $db = Database::connect();
            $sql = "UPDATE expenses SET category_id = 1 WHERE category_id IS NULL";
            $setting = $db->query($sql);
            if($setting) return true;
            return false;
        }catch(Exception $exc){
            return false;
        }
    }





?>
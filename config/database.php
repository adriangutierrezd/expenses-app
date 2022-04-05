<?php

class Database{
    public static function connect(){
        try{
            $db = new mysqli('localhost', 'root', '', 'expensesapp');
            $db->query("SET NAMES 'utf8'");
            return $db;
        }catch(Exception $exc){
            echo 'Error: '.$exc->getMessage();
        }
    }
}

?>
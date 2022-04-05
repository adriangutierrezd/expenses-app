<?php

require_once 'models/User.php';
require_once 'helpers/Utils.php';

class UserController{
    
    /**
     * Renderiza la página de usuarios y carga datos en una instancia de usuarios para poder mostrarlos por pantalla
     */
    public function index(){
        if(isLogged()){
            $user = new User();
            $user->setName($_SESSION['login']->name);
            $user->setUsername($_SESSION['login']->username);

            require_once 'views/users/index.php';
        }else{
            header('Location:'.base_url);
        }
    }
    
    
    /**
     * Inicia sesión
     * 
     * Recoge, limpia y comprueba los datos enviados en el formulario. Si hay algún error lo muestra, y si está todo correcto, inicia la sesión del usuario y guarda los datos del usuario en ella
     */
    public function log(){
        if(isset($_POST)){
            $errorCount = false;
            $errors = [];

            $username = isset($_POST['usernameRegister']) ? trim($_POST['usernameRegister']) : false;
            $password = isset($_POST['passwordRegister']) ? trim($_POST['passwordRegister']) : false;

            if($username == ''){
                $errors['usernameRegister'] = 'Debes introducir un nombre de usuario';
                $errorCount = true;
            }
            if($password == ''){
                $errors['passwordRegister'] = 'Debes introducir una contraseña';
                $errorCount = true;
            }

            if($errorCount){
                $_SESSION['errors'] = $errors;
                header('Location:'.base_url);
            }else{
                $user = new User();
                $log = $user->log($username, $password);
                if($log && is_object($log)){
                    $_SESSION['login'] = $log;
                    header('Location:'.base_url.'dashboard/index');
                }else{
                    $_SESSION['failure'] = 'Identificación fallida';
                    header('Location:'.base_url);
                }
            }
            
        }

    }

    /**
     * Crea un nuevo usuario
     * 
     * Recoge, limpia y comprueba los datos enviados en el formulario. Si hay algún error lo muestra, y si está todo correcto, crea la instancia de usuario.
     */
    public function save(){
        if (isset($_POST)) {

            $errorCount = false;
            $errors = [];

            $name = isset($_POST['name']) ? trim($_POST['name']) : false;
            $username = isset($_POST['username']) ? trim($_POST['username']) : false;
            $password = isset($_POST['password']) ? trim($_POST['password']) : false;
            $passwordRepeat = isset($_POST['passwordRepeat']) ? trim($_POST['passwordRepeat']) : false;

            if ($name === '') {
                $errors['name'] = 'Debes introducir un nombre';
                $errorCount = true;
            }
            if ($username === '') {
                $errors['username'] = 'Debes introducir un nombre de usuario';
                $errorCount = true;
            }
            $user = new User();
            if($user->existsUsername($username)){
                $errors['username'] = 'Este nombre de usuario ya está en uso';
                $errorCount = true;
            }
            if ($password === '') {
                $errors['password'] = 'Debes introducir una contraseña';
                $errorCount = true; 
            }
            if($password != $passwordRepeat){
                $errors['passwordRepeat'] = 'Las contraseñas no coinciden';
                $errorCount = true; 
            }

            if ($errorCount) {
                $_SESSION['errors'] = $errors;
                header('Location:'.base_url);
            } else {
                $user = new User();
                $user->setName($name);
                $user->setUsername($username);
                $user->setPassword($password);
                $save = $user->save();
                
                if ($save) {
                    $log = $user->log($username, $password);
                    if($log && is_object($log)){
                        $_SESSION['login'] = $log;
                        header('Location:'.base_url.'dashboard/index');
                    }else{
                        $_SESSION['failure'] = 'Ha ocurrido un error.';
                        header('Location:'.base_url);
                    }
                } else {
                    $_SESSION['failure'] = 'Ha ocurrido un error.';
                    header('Location:'.base_url);
                }
            }
        }
    }

    /**
     * Cierra sesión
     */
    public function logout(){
        if(isset($_SESSION['login'])){
            unset($_SESSION['login']);
        }
        header("Location:".base_url);
    }

        
    /**
     * Elimina un usuario
     */
    public function delete(){
        if(isset($_POST)){
            $user = new User();
            $delete = $user->delete($_SESSION['login']->id);
            if($delete){
                header('Location:'.base_url.'user/logout');
            }else{
                $_SESSION['failure'] = 'Ha ocurrido un error.';
                header('Location:'.base_url.'user/index');
            }
        }

    }

    /**
     * Actualiza el nombre y el nombre de usuario de un usuario
     * 
     * Recoge, limpia y comprueba los datos enviados en el formulario. Si hay algún error lo muestra, y si está todo correcto, actualiza la instancia de usuario.
     */
    public function update(){
        if(isset($_POST)){
            $errorCount = false;
            $errors = [];


            $name = isset($_POST['name']) ? trim($_POST['name']) : false;
            $username = isset($_POST['username']) ? trim($_POST['username']) : false;


            if ($name === '') {
                $errors['name'] = 'Debes introducir un nombre';
                $errorCount = true;
            }
            if ($username === '') {
                $errors['username'] = 'Debes introducir un nombre de usuario';
                $errorCount = true;
            }

            $user = new User();
            if($user->existsUsername($username)){
                $errors['username'] = 'Este nombre de usuario ya está en uso';
                $errorCount = true;
            }



            if ($errorCount) {
                $_SESSION['errors'] = $errors;
            }else{
                $user = new User();
                $user->setName($name);
                $user->setUsername($username);

                $update = $user->update();

                if($update){
                    // Show success
                    $_SESSION['login']->name = $user->getName();
                    $_SESSION['login']->username = $user->getUSername();
                    $_SESSION['success'] = 'Cambios guardados con éxito.';
                }else{
                    $_SESSION['failure'] = 'Ha ocurrido un error.';
                }
            }


        } 
        header('Location:'.base_url.'user/index');

    }

    /**
     * Actualiza la contraseña de un usuario
     * 
     * Recoge, limpia y comprueba los datos enviados en el formulario. Si hay algún error, las contraseñas no coinciden o ha introducido mal la contraseña actual lo muestra, y si está todo correcto, actualiza la contraseña.
     */
    public function updatePassword(){
        if(isset($_POST)){
            $errorCount = false;
            $errors = [];

            $actualPassword = isset($_POST['actualPassword']) ? trim($_POST['actualPassword']) : false;
            $newPassword = isset($_POST['newPassword']) ? trim($_POST['newPassword']) : false;
            $newPasswordRepeat = isset($_POST['newPasswordRepeat']) ? trim($_POST['newPasswordRepeat']) : false;


            if ($actualPassword === '') {
                $errors['actualPassword'] = 'Debes introducir tu contraseña actual';
                $errorCount = true;
            }else if(!password_verify($actualPassword, $_SESSION['login']->password)){
                $errors['actualPassword'] = 'Contraseña incorrecta';
                $errorCount = true;
            }
            if($newPassword == ''){
                $errors['newPassword'] = 'Debes introducir tu nueva contraseña';
                $errorCount = true;
            }
            if($newPassword != $newPasswordRepeat){
                $errors['newPassword'] = 'Las contraseñas no coinciden';
                $errorCount = true;
            }
            if($newPasswordRepeat == ''){
                $errors['newPasswordRepeat'] = 'Debes confirmar tu contraseña';
                $errorCount = true;
            }

            if ($errorCount) {
                $_SESSION['errors'] = $errors;
            }else{
                $user = new User();
                $user->setPassword($newPassword);
                $update = $user->updatePassword();
                if($update){
                    $_SESSION['success'] = 'Cambios guardados con éxito.';
                }else{
                    $_SESSION['failure'] = 'Ha ocurrido un error.';
                }
            }

            header('Location:'.base_url.'user/index');
        }
    }


}



?>
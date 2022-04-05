<?php

/**
 * Genera un mensaje para indicar al usuario que hay un campo de un formulario con errores
 * 
 * @param  mixed $errors Array con todos los errores a mostrar
 * @param  mixed $field Nombre del campo del que se quiere mostrar el error
 * @return void
 */
function showErrorForm($errors, $field){
  
    $inputErrorAlert = '';
    if(isset($errors[$field]) && !empty($field)){
        $inputErrorAlert = "<div class='my-4 bg-red-100 shadow-sm rounded-lg p-2 px-3'>
        <div class='flex items-center flex-start mb-2 text-red-600'>
          <i class='bi bi-exclamation-triangle-fill text-lg '></i>
          <p class='font-semibold text-lg ml-2'>Error</p>
        </div>
        <p class='font-medium'>".$errors[$field]."</p>
      </div>";
    }



    return $inputErrorAlert;
}

/**
 * Genera un mensaje de feedback para alertar al usuario de que algo ha ocurrido con éxito o ha fracasado
 */
function showFeeback(){
    $alert = '';
    if(isset($_SESSION['success'])){
        $alert = "<div class='my-4 bg-green-100 shadow-sm rounded-lg p-2 px-3'>
        <div class='flex items-center flex-start mb-2 text-green-600'>
            <i class='bi bi-check-circle-fill text-lg'></i>
            <p class='font-semibold text-lg ml-2'>Correcto</p>
            </div>
            <p class='font-medium'>". $_SESSION['success']."</p>
        </div>";
    }
    if(isset($_SESSION['failure'])){
        $alert = "<div class='my-4 bg-red-100 shadow-sm rounded-lg p-2 px-3'>
        <div class='flex items-center flex-start mb-2 text-red-600'>
          <i class='bi bi-exclamation-triangle-fill text-lg '></i>
          <p class='font-semibold text-lg ml-2'>Error</p>
        </div>
        <p class='font-medium'>".$_SESSION['failure']."</p>
      </div>";
    }
    return $alert;
}


/**
 * Elimina los mensajes de error que se muestran en los formulario
 */
function deleteErrors(){
    $_SESSION['errors'] = null;
    unset($_SESSION['errors']);
}

/**
 * Elimina los mensajes de éxito y fracaso lanzados por la web
 */
function deleteFeedback(){
    $_SESSION['success'] = null;
    unset($_SESSION['success']);

    $_SESSION['failure'] = null;
    unset($_SESSION['failure']);

}

?>
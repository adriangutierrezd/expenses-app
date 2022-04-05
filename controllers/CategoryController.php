<?php

require_once 'models/Category.php';
require_once 'helpers/Utils.php';

class CategoryController{
    
    /**
     * Renderiza la página de categorías.
     */
    public function index(){
        if(isLogged()){
            require_once 'views/categories/index.php';
        }
    }

    public function getCategories(){
        ob_clean();
        header('Content-Type: application/json');
        $categories = [];
        $category = new Category();
        $data = $category->getAll();
        $categories = $data->fetch_all();
        echo json_encode($categories);
        die();
    }
    
    /**
     * Crea una nueva categoría
     * 
     * Recibe los datos del formulario y crea una nueva categoría
     */
    public function save(){
        ob_clean();
        header('Content-Type: application/json');
        $request_body = file_get_contents('php://input');
        $request = json_decode($request_body);
        
        $category = new Category();
        $category->setName($request->name);
        $category->setColor($request->color);

        $save = $category->save();
        echo json_encode($save);
        die();
    }

        
    /**
     * Recibe los datos de una categoría y la elimina
     */
    public function delete(){
        ob_clean();
        header('Content-Type: application/json');
        $request_body = file_get_contents('php://input');
        $request = json_decode($request_body);
        $id = $request->id;
        $category = new Category();
        $delete = $category->delete($id);
        echo json_encode($delete);
        die();
    }

    /**
     * Actualiza una categoría
     * 
     * Recibe los datos del formulario y actualiza una categoría
     */
    public function update(){
        ob_clean();
        header('Content-Type: application/json');
        $request_body = file_get_contents('php://input');
        $request = json_decode($request_body);
        
        $category = new Category();
        $category->setId($request->id);
        $category->setName($request->name);
        $category->setColor($request->color);

        $update = $category->update();
        echo json_encode($update);
        die();
    }

}


?>
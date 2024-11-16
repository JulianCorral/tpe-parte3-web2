<?php
    require_once 'app/controllers/api.controller.php';
    require_once 'app/models/genre.api.model.php';

    class GenreApiController extends ApiController{

        private $modelGenre;
        

        public function __construct(){
            parent::__construct();
            $this->modelGenre = new GenreModel();
         
        }

        //Trae todos los generos
        
        function getGenres() {    

            try{    
                
                $genres = $this->modelGenre->getGenres();
                return $this->view->response($genres,200);
               
            }
            catch (\Throwable $th) {
                $this->view->response("Error no encontrado, revise la documentacion", 500);
            }
        }
            
        //Trae un genero especifico
        function getGenre($params = []){
            try{
                $genre = $this->modelGenre->getGenre($params[':ID']);

                if(!empty($genre)){
                    $this->view->response($genre,200);
                }else{
                    $this->view->response('El genero con el id = '.$params[':ID'].' no existe.',404);
                }
            }
            catch (\Throwable $th) {
                $this->view->response("Error no encontrado, revise la documentacion", 500);
            }
        }
        
        //Elimina un genero pasandole el id
        function deleteGenre($params = []) {
            try{
                $user = $this->authHelper->currentUser();
                if(!$user) {
                    $this->view->response('Unauthorized', 401);
                    return;
                }

                $id = $params[':ID'];
                $genre = $this->modelGenre->getGenre($id);

                if($genre) {
                    $this->modelGenre->deleteGenre($id);
                    $this->view->response('El genero con id = '.$id.' ha sido borrado.', 200);
                } 
                else {
                    $this->view->response('El genero con id = '.$id.' no existe.', 404);
                }
            }
            catch (\Throwable $e) {
                $this->view->response("El genero esta asignado a un videojuego/os, para poder eliminar el genero debera cambiarle el mismo a los videojuegos", 404);
            }   
        }
        
        //Crea un genero nuevo
        function createGenre($params = []) {
            try{
                $user = $this->authHelper->currentUser();
                if(!$user) {
                    $this->view->response('Unauthorized', 401);
                    return;
                }

                $body = $this->getData();

                $edad = $body->Edad;
                $genero = $body->Genero;
                $descripcion = $body->Descripcion;

                if (empty($edad) || empty($genero) || empty($descripcion)) {
                    $this->view->response("Complete los datos", 400);
                }
                else {
                    $id = $this->modelGenre->insertGenre($edad,$genero,$descripcion);

                    $genre = $this->modelGenre->getGenre($id);
                    $this->view->response($genre, 201);
                }
            }
            catch (\Throwable $e) {
                $this->view->response("Error no encontrado", 500);
            }
        }

        //Modifica un genero
        function updateTeam($params = []) {
            try{
                $user = $this->authHelper->currentUser();
                if(!$user) {
                    $this->view->response('Unauthorized', 401);
                    return;
                }

                $id = $params[':ID'];
                $genre = $this->modelGenre->getGenre($id);

                if($genre) {
                    $body = $this->getData();
                
                    $edad = $body->Edad;
                    $genero = $body->Genero;
                    $descripcion = $body->Descripcion;

                    if (empty($edad) || empty($genero) || empty($descripcion)) {
                        $this->view->response("Complete los datos", 400);
                    }
                    else{
                        $this->modelGenre->updateGenre($id,$edad,$genero,$descripcion);

                        $this->view->response('El genero con id='.$id.' ha sido modificado.', 200);
                    }
                } 
                else {
                    $this->view->response('La genero con id='.$id.' no existe.', 404);
                }
            }
            catch (\Throwable $e) {
                $this->view->response("Error no encontrado, revise la documentacion", 500);
            }
        }

    }
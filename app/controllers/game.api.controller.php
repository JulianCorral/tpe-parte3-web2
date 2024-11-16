<?php
    require_once 'app/controllers/api.controller.php';
    require_once 'app/models/game.api.model.php';
    

    class GameApiController extends ApiController{

        private $modelGame;
    
        public function __construct(){
            parent::__construct();
            $this->modelGame = new GameModel();
            
        }

        //Trae todos los videojuegos
        
        function getGames() {    

            $sort = $_GET['sort'] ?? null;
            $order = $_GET['orderby'] ?? null;
            $filter = $_GET['filter'] ?? null;
            $page = $_GET['page'] ?? null;
            $limit = $_GET['limit'] ?? null;
           
            try {
                
                //VALIDACIONES URL
                if(!empty($order)){

                    if($order == "DESC" || $order  == "desc" || $order == "ASC" || $order == "asc"){
                    
                    }else{
                    
                        return $this->view->response("OrderBY mal escrito, prueba escribiendo ASC/asc/DESC/desc o revise la documentacion",400);
                    }
                }

                if(!empty($sort)){
                    //Se fija si tiene alguna columna
                    $valueSort = $this->modelGame->valueSort($sort);
                    
                    if( $valueSort == 0){
                        //Si el resultado es 0 quiere decir que no tiene ninguna columna con el parametro que ingreso el cliente
                        return $this->view->response("La columna no existe, por favor revise la documentacion",400);
                    }
                }
                if(!empty($filter) && !is_numeric($filter)){
            
                    $this->view->response("No se puede colocar un STRING en el filtrado, revise la documentacion", 400);
                
                }
                if(!empty($limit) && !is_numeric($limit)){

                    return $this->view->response("No se puede colocar un STRING en el limit. Revise la documentacion", 400);
                
                }
            
               //Trae los videojuegos por orden , columna y filtrado
               if(!empty($order) && isset($order) && !empty($sort) && isset($sort) && !empty($filter) && isset($filter)){
                          
                    $games = $this->modelGame->orderSortedAndFiltered($order,$sort,$filter);
                
                    if (empty($games)){
                        $this->view->response("El arreglo esta VACIO a causa de ingresar ID erroneo en el filtrado, revise la documentacion", 400);
                    }
                }
                    //Ordenado por columna
                    else if (!empty($order) && isset($order) && !empty($sort) && isset($sort)){

                        $games = $this->modelGame->sortedAndOrder($sort,$order);

                    }
                        //Filtrado
                        else if (!empty($filter) && isset($filter)) {   

                            $games = $this->modelGame->filter($filter);

                            if (empty($games)){
                        
                                $this->view->response("El arreglo esta VACIO a causa de ingresar ID erroneo en el filtrado, revise la documentacion", 400);
                            }
                        }
                            //Paginado
                            else if (isset($page) && (!empty($limit)) && isset($limit)) {
                            
                                if(!empty($page==0) || !is_numeric($page)){
                                
                                    return $this->view->response("Page no puede ser 0 ni un STRING, revise la documentacion",400);
                                }
                            
                                $games = $this->modelGame->paginated($page,$limit);
                            
                                if (empty($games)){
                                
                                    $this->view->response("El arreglo esta VACIO a causa de ingresar un ID erroneo", 400);
                                }
                            }
                                else {
                                
                                    $games = $this->modelGame->getGames();
                                
                                } 

                    return $this->view->response($games,200);
               
            }
        
            catch (\Throwable $th) {
                $this->view->response("Error no encontrado, revise la documentacion", 500);
            }
        }
            
        //Trae un videojuego especifico
        function getGame($params = []){
            try{
                $game = $this->modelGame->getGame($params[':ID']);

                if(!empty($game)){
                    $this->view->response($game,200);
                }else{
                    $this->view->response('El videojuego con el id = '.$params[':ID'].' no existe.',404);
                }
            }
            catch (\Throwable $th) {
                $this->view->response("Error no encontrado, revise la documentacion", 500);
            }
        }
        
        //Elimina un videojuego pasandole el id
        function deleteGame($params = []) {
            try{
                $user = $this->authHelper->currentUser();
                if(!$user) {
                    $this->view->response('Unauthorized', 401);
                    return;
                }

                $id = $params[':ID'];
                $game = $this->modelGame->getGame($id);

                if($game) {
                    $this->modelGame->deleteGame($id);
                    $this->view->response('El videojuego con id = '.$id.' ha sido borrado.', 200);
                } 
                else {
                    $this->view->response('El videojuego con id = '.$id.' no existe.', 404);
                }
            }
            catch (\Throwable $e) {
                $this->view->response("El videojuego contiene comentarios, para poder eliminar el videojuego debera eliminar los comentarios", 404);
            }   
        }
        
        //Crea un videojuego nuevo
        function createGame($params = []) {
            try{
                $user = $this->authHelper->currentUser();
                if(!$user) {
                    $this->view->response('Unauthorized', 401);
                    return;
                }

                $body = $this->getData();

                $nombre = $body->Nombre;
                $fecha = $body->Fecha;
                $precio = $body->precio;
                $descripcion = $body->Descripcion;
                $genero_id = $body->Genero_ID;

                if (empty($nombre) || empty($fecha) || empty($precio) || empty($descripcion) || empty($genero_id)) {
                    $this->view->response("Complete los datos", 400);
                }
                else {
                    $id = $this->modelGame->insertGame($nombre,$fecha,$precio,$descripcion,$genero_id);

                    $game = $this->modelGame->getGame($id);
                    $this->view->response($game, 201);
                }
            }
            catch (\Throwable $e) {
                $this->view->response("Error no encontrado", 500);
            }
        }

        //Modifica un videojuego
        function updateGame($params = []) {
            try{
                $user = $this->authHelper->currentUser();
                if(!$user) {
                    $this->view->response('Unauthorized', 401);
                    return;
                }
                
                $id = $params[':ID'];
                $game = $this->modelGame->getGame($id);

                if($game) {
                    $body = $this->getData();
                
                    $nombre = $body->Nombre;
                    $fecha = $body->Fecha;
                    $precio = $body->precio;
                    $descripcion = $body->Descripcion;
                    $genero_id = $body->Genero_ID;


                    if (empty($nombre) || empty($fecha) || empty($precio) || empty($descripcion) || empty($genero_id)) {
                        $this->view->response("Complete los datos", 400);
                    }
                    else{
                        $this->modelGame->updateGame($id,$nombre,$fecha,$precio,$descripcion,$genero_id);

                        $this->view->response('El videojuego con id='.$id.' ha sido modificado.', 200);
                    }
                } 
                else {
                    $this->view->response('El videojuego con id='.$id.' no existe.', 404);
                }
            }
            catch (\Throwable $e) {
                $this->view->response("Error no encontrado, revise la documentacion", 500);
            }
        }

    }
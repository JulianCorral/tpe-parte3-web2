<?php
    require_once 'app/controllers/api.controller.php';
    require_once 'app/models/comment.api.model.php';

    class CommentApiController extends ApiController {

        private $modelComment;

        public function __construct(){
            parent::__construct();
            $this->modelComment = new CommentModel();
            
        }

        
        //Trae todos los comentarios o un comentario especifico si se le pasa el id
        function get($params = []) {    
            try{
                if (empty($params)){

                    $commentsTotal = $this->modelComment->getAllComments();
                    $this->view->response($commentsTotal,200);

                }
                else{
                    $comment = $this->modelComment->getComment($params[':ID']);
                    if(!empty($comment)){
                        $this->view->response($comment,200);
                    }
                    else{
                        $this->view->response('El comentario con el id = '.$params[':ID'].' no existe.',404);
                    }
                }
            }
            catch (\Throwable $e) {
                $this->view->response("Error no encontrado, revise la documentacion", 500);
            }
        }   

        //Trae los comentarios de un videojuego especifico
        function getGameComments($params = []){
            try{
                if(empty($params)){
                    $this->view->response('No se paso ningun parametro por id',404);
                }
                else{
                    $comments = $this->modelComment->getCommentsGame($params[':ID']);
                    if(!empty($comments)){
                        $this->view->response($comments,200);
                    }
                    else{
                        $this->view->response('El videojuego no tiene comentarios'.$params[':ID'].' no existe.',404);
                    }
                }
            }
            catch (\Throwable $e) {
                $this->view->response("Error no encontrado, revise la documentacion", 500);
            }
        }

        //Crea un comentario nuevo
        function createComment($params = []) {
            try{
                $user = $this->authHelper->currentUser();
                if(!$user) {
                    $this->view->response('Unauthorized', 401);
                    return;
                }

                $body = $this->getData();

                $comment = $body->comment;
                $id_juego = $body->ID_Juego;

                if (empty($comment) || empty($id_juego)) {
                    $this->view->response("Complete los datos", 400);
                } 
                else {
                    $id = $this->modelComment->insertComment($comment,$id_juego);

                    $newComment = $this->modelComment->getComment($id);

                    $this->view->response($newComment, 201);
                }
            }
            catch (\Throwable $e) {
                $this->view->response("Error no encontrado, revise la documentacion", 500);
            }
        }
        // Elimina un comentario de un videojuego
        function deleteComment($params = []){
            try{
                $user = $this->authHelper->currentUser();
                if(!$user) {
                    $this->view->response('Unauthorized', 401);
                    return;
                }
                
                if(!empty($params)){  
                    $idComment = $params[':ID'];
                    $idComment2 = $params[':commentID'];

                    $comment = $this->modelComment->getCommentsGame($idComment);

                    $comment2 = $this->modelComment->getComment($idComment2);

                    if (!empty($comment) && !empty($comment2) && isset($comment) && isset($comment2)) {
                
                        $this->modelComment->deleteComment($idComment2);
                        $this->view->response('El comentario con la id = '.$idComment2.' fue borrado del videojuego con la id = '.$idComment, 200);
                    } 
                    else {
                        return $this->view->response('El comentario con id = '.$idComment2.' no fue borrado, no existe o no hay ningun comentario con esa id', 404);
                    }
                }
                else{
                    $this->view->response("Error, ingrese un id", 500);
                }
            }
            catch (\Throwable $e) {
                $this->view->response("Error no encontrado, revise la documentacion", 500);
            }
        }
    }
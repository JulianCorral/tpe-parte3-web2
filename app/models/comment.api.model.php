<?php   

    require_once 'app/models/model.php';

    class CommentModel extends Model {

        //Trae todos los comentarios
        function getAllComments(){
            $query = $this->db->prepare('SELECT * FROM comentarios ORDER BY ID_Juego ASC');
            $query->execute();
            $comments = $query->fetchAll(PDO::FETCH_OBJ);
            return $comments;
        }

        //Trae un comentario especifico
        function getComment($id_Comment){
            $query = $this->db->prepare( "SELECT * FROM comentarios WHERE ID_Comentario =?");
            $query->execute(array($id_Comment));
            $comment = $query->fetch(PDO::FETCH_OBJ);
            return $comment;
        }

        //Trae todos los comentarios de un videojuego especifico
        function getCommentsGame($id_game){
            $query = $this->db->prepare( "SELECT * FROM comentarios WHERE ID_Juego = ?");
            $query->execute(array($id_game));
            $comments = $query->fetchAll(PDO::FETCH_OBJ);
            return $comments;
        }
        
        //Inserta un nuevo comentario
        function insertComment($comment,$id_game){
            $query = $this->db->prepare("INSERT INTO comentarios (comentario, ID_Juego) VALUES (?, ?)");
            $query->execute(array($comment,$id_game));
            return $this->db->lastInsertId();
        }

        //Eliminar comentario
        function deleteComment($id){
            $query = $this->db->prepare("DELETE FROM comentarios WHERE comentarios.ID_Comentario= ?");
            $query->execute(array($id));
        }
    }
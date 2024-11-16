<?php   

    require_once 'app/models/model.php';

    class GameModel extends Model {

        //Trae todos los videojuegos
        function getGames(){
            $query = $this->db->prepare('SELECT videojuegos.*, generos.* FROM videojuegos JOIN generos ON videojuegos.Genero_ID = generos.Genero_ID');
            $query->execute();
            $games = $query->fetchAll(PDO::FETCH_OBJ);
            return $games;
        }
        //Trae un solo videojuego
        function getGame($ID_Juego){
            $query = $this->db->prepare( 'SELECT videojuegos.Nombre, videojuegos.Fecha, videojuegos.Precio, videojuegos.Descripcion, videojuegos.Genero_ID FROM videojuegos JOIN generos ON videojuegos.Genero_ID = generos.Genero_ID WHERE ID_Juego =?');
            $query->execute(array($ID_Juego));
            $game = $query->fetch(PDO::FETCH_OBJ);
            return $game;
        }

        //Elimina un videojuego
        function deleteGame($ID_Juego) {
            $query = $this->db->prepare('DELETE FROM videojuegos WHERE ID_Juego = ?');
            $query->execute([$ID_Juego]);
        }

        //Inserta un videojuego
        function insertGame($nombre,$fecha,$precio,$descripcion,$genero_id) {
            $query = $this->db->prepare('INSERT INTO videojuegos (Nombre,Fecha,Precio,Descripcion,Genero_ID) VALUES (?,?,?,?,?)');
            $query->execute([$nombre,$fecha,$precio,$descripcion,$genero_id]);
            return $this->db->lastInsertId();
        }

        //Modifica un videojuego
        function updateGame($id,$nombre,$fecha,$precio,$descripcion,$genero_id){
            $query = $this->db->prepare("UPDATE videojuegos SET Nombre =?,Fecha=?,Precio=?,Descripcion=?,Genero_ID=?,position=?,goals=? WHERE ID_Juego =?");
            $query->execute(array($nombre,$fecha,$precio,$descripcion,$genero_id,$id));
        }
        //Se fija si la columna que se paso existe en la tabla
        function valueSort($sort=null){
            $query = $this->db->prepare("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME = ? AND TABLE_NAME = 'videojuegos'");
            $query->execute(array($sort));
            $column = $query->fetchAll(PDO::FETCH_OBJ);
            return count($column);
        }
        //Ordena por todos los parametros orden,columna y filtrado
        function orderSortedAndFiltered ($order,$sort,$filter){
            $query = $this->db->prepare( "SELECT videojuegos.*, generos.Edad FROM videojuegos JOIN generos ON videojuegos.Genero_ID = generos.Genero_ID WHERE videojuegos.Genero_ID = ? ORDER BY $sort $order");
            $query->execute([$filter]);
            $games = $query->fetchAll(PDO::FETCH_OBJ);
            return $games; 
        }
        //Ordena por orden y columna
        function sortedAndOrder($sort,$order){
            $query = $this->db->prepare( "SELECT videojuegos.*, generos.Edad FROM videojuegos JOIN generos ON videojuegos.Genero_ID = generos.Genero_ID ORDER BY $sort $order");
            $query->execute();
            $games = $query->fetchAll(PDO::FETCH_OBJ);
            return $games; 
        }
        //Paginado 
        function paginated($page,$limit){
            $offset = (($page - 1) * $limit); 
            $query = $this->db->prepare("SELECT videojuegos.*, generos.Edad FROM videojuegos JOIN generos ON videojuegos.Genero_ID = generos.Genero_ID ORDER BY ID_Juego  LIMIT ".$offset ." , ".$limit);
            $query->execute();
            $games = $query->fetchAll(PDO::FETCH_OBJ);
            return $games; 
        }    
        //Filtra videojuegos por genero
        function filter($filter){
            $query = $this->db->prepare("SELECT * FROM videojuegos WHERE Genero_ID = ?");
            $query->execute([$filter]);
            $games = $query->fetchAll(PDO::FETCH_OBJ);
            return $games;
        }
    }
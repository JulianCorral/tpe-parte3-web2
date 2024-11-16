<?php   

    require_once 'app/models/model.php';

    class GenreModel extends Model {

    // Funcion que trae todos los generos.
    public function getGenres(){
        $query = $this->db->prepare('SELECT * from generos');
        $query->execute();
        $genres =$query->fetchAll(PDO::FETCH_OBJ);    
        return $genres;
    }

    //Funcion que inserta el genero.
    function insertGenre($edad,$genero,$descripcion) {
        $query = $this->db->prepare('INSERT INTO generos (Edad,Genero,Descripcion) VALUES (?,?,?)');
        $query->execute([$edad,$genero,$descripcion]);
        return $this->db->lastInsertId();
        
    }    
    //Funcion que Elimina el genero a traves de su respectiva ID.
    function deleteGenre($Genero_ID){
        $query =$this->db->prepare('DELETE FROM generos WHERE Genero_ID = ?');
        $query->execute([$Genero_ID]);
    }
    //Funcion que a traves de su ID trae el genero que le corresponda de la BD.
    function getGenre($Genero_ID){
        $query=$this->db->prepare('SELECT generos.Genero_ID, generos.Edad, generos.Genero, generos.Descripcion FROM generos WHERE Genero_ID = ?');
        $query->execute(array($Genero_ID));
        $genre = $query->fetch(PDO::FETCH_OBJ);
        return $genre;
    }
    //Funcion que edita en la base de datos a traves de su ID.
    function updateGenre($Genero_ID,$edad,$genero,$descripcion){
        $query = $this->db->prepare("UPDATE generos SET Edad = ?,Genero = ?,Descripcion = ? WHERE Genero_ID = ?");
        $query->execute(array($edad,$genero,$descripcion,$Genero_ID));
    }

}
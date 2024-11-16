<?php
    require_once 'config.php';
    
    require_once 'libs/router.php';

    require_once 'app/controllers/game.api.controller.php';
    require_once 'app/controllers/comment.api.controller.php';
    require_once 'app/controllers/genre.api.controller.php';
    require_once 'app/controllers/user.api.controller.php';
   


    //Se crea el router
    $router = new Router();

    // Videojuegos
    //                 endpoint      verbo         controller          metodo
    $router->addRoute('games',     'GET',    'GameApiController','getGames');
    $router->addRoute('games',     'POST',   'GameApiController', 'createGame');
    $router->addRoute('games/:ID', 'GET',    'GameApiController','getGame');
    $router->addRoute('games/:ID', 'DELETE', 'GameApiController', 'deleteGame');
    $router->addRoute('games/:ID', 'PUT',    'GameApiController', 'updateGame');

    // Comentarios
    //                 endpoint                         verbo        controller          metodo
    $router->addRoute('comments',                       'GET',   'CommentApiController', 'get');    
    $router->addRoute('comments/:ID',                   'GET',   'CommentApiController', 'get');
    $router->addRoute('games/:ID/comments',           'GET',   'CommentApiController', 'getGameComments');
    $router->addRoute('games/:ID/comments',           'POST',  'CommentApiController', 'createComment');
    $router->addRoute('games/:ID/comments/:commentID','DELETE','CommentApiController', 'deleteComment');    

     // Generos
    //                 endpoint     verbo        controller        metodo
    $router->addRoute('genres',     'GET',    'GenreApiController','getGenres');
    $router->addRoute('genres',     'POST',   'GenreApiController', 'createGenre');
    $router->addRoute('genres/:ID', 'GET',    'GenreApiController','getGenre');
    $router->addRoute('genres/:ID', 'DELETE', 'GenreApiController', 'deleteGenre');
    $router->addRoute('genres/:ID', 'PUT',    'GenreApiController', 'updateGenre');

    //Token
    //                 endpoint     verbo        controller         metodo
    $router->addRoute('user/token', 'GET',    'UserApiController', 'getToken');

    
    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
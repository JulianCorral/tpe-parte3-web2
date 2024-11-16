Hola bienvenidos a la documentacion de nuestra API. Creada por Candela Agostina Rodriguez y Julian Corral, para la materia WEB 2 de la carrera TUDAI.


## Se recomienda usar POSTMAN para que sea mas facil de utilizar y manipular la API.

El ENDPOINT es: ` http://localhost/tpe-parte3-web2/api `


## TABLA VIDEOJUEGOS:

# METODO POST:
 `$router->addRoute('games','POST','GameApiController','createGame');`
 `http://localhost/tpe-parte3-web2/api/games`

 Para insertar un nuevo videojuego se utiliza el formato JSON de la siguiente manera:
 
 {
 "Nombre": "Diablo 2",
 "Fecha": "2000-06-29",
 "Precio": 25000,
 "Descripcion": Diablo II secuela del popular juego diablo...,
 }
 
 Los Genero_ID disponibles son los siguientes: (Se debe poner el numero de id del genero que quieras seleccionar para el videojuego)
 - RPG: 1
 - Deportes: 3
 - Aventura: 4
 - OpenWorld: 5
 
 Si el Genero_ID es incorrecto se informara un Error.

# METODO PUT:
 `$router->addRoute('games/:ID','PUT','GameApiController','updateGame');`
 `http://localhost/tpe-parte3-web2/api/games/1`

 Sirve para modificar un videojuego, se debe poner la id del videojuego a modificar en la URL y utilizar tambien el formato JSON de la siguiente manera:

 {
 "Nombre": "Diablo 2",
 "Fecha": "2000-06-29",
 "Precio": 25000,
 "Descripcion": Diablo II secuela del popular juego diablo...,
 }

  Los Genero_ID disponibles son los siguientes: (Se debe poner el numero de id del genero que quieras seleccionar para el videojuego)
 - RPG: 1
 - Deportes: 3
 - Aventura: 4
 - OpenWorld: 5
 
 Si el Genero_ID es incorrecto se informara un Error.

# METODO DELETE:
 `$router->addRoute('games/:ID','DELETE','GameApiController','deleteGame');`
 `http://localhost/tpe-parte3-web2/api/games/2`
 
 Para eliminar un videojuego se debe seguir la URL de arriba, poniendo la ID del videojuego que queremos eliminar. Hay que tener en cuenta que el videojuego a eliminar no debe tener comentarios puestos si no primero va a tener que eliminar los comentarios del mismo, para luego poder eliminarlo. Si el videojuego tiene comentarios le saldra un aviso de ese respectivo error.

# METODO GET por ID.
 `$router->addRoute('games/:ID','GET','GameApiController','getGame');`
 `http://localhost/tpe-parte3-web2/api/games/1`
 
 Si nosotros queremos traer un videojuego por su respectiva ID tenemos que seguir la idea de la URL de arriba. Hay que estar seguros que la ID exista, si no saldra su respectivo aviso.

# METODO GETALL con sus parametros: `$router->addRoute('games','GET','GameApiController','getGames');`
 # Parametros:
  - orderby = ASC o DESC.
  - sort = Columna existente. ID_Juego, Nombre, Fecha, Precio, Genero_ID.
  - filter: Filtrado por Genero_ID, los Genero_ID son los siguientes: 
  - RPG: 1
  - Deportes: 3
  - Aventura: 4
  - OpenWorld: 5
  - page, limit: Cantidad para omitir y mostrar, tienen que pasar INT por parametros, nunca un string, ni 0 en el parametro page.

 🛑🛑 EJEMPLOS de getALL 🛑🛑
 
  `http://localhost/tpe-parte3-web2/api/games` Este es el getALL basico para traer todos los videojuegos de la tabla.
  
  `http://localhost/tpe-parte3-web2/api/games?orderby=ASC&sort=Precio&filter=1` Ordeno de manera ASC(ascendente), por la columna Precio y filtrando por el genero con Genero_ID = 1 (RPG).
  
  `http://localhost/tpe-parte3-web2/api/games?orderby=DESC&sort=Nombre` Videojuegos mostrados por orden DESC y por alguna columna, en este caso Nombre.
  
  `http://localhost/tpe-parte3-web2/api/games?filter=4` filtrado de los Videojuegos por la Genero_ID, en este caso nos va a traer los videojuegos con Genero_ID = 4 (Aventura).

  `http://localhost/tpe-parte3-web2/api/games?page=1&limit=3` Paginado de la tabla de Videojuegos.

## TABLA COMENTARIOS:

# METODO POST:
 `$router->addRoute('games/:ID/comments','POST','CommentApiController','createComment');`
 `http://localhost/tpe-parte3-web2/api/games/8/comments`

 Al querer hacer un comentario en un videojuego, necesitamos traer la ID del videojuego y hacer el POST en formato JSON de la siguiente manera:

 {
 "comment": "Uno de los mejores RPG de la historia",
 "ID_Juego": 4
 }

 Las ID_Juego disponibles son:
 
  - EA SPORTS FC 24 : 2
  - Diablo 2 : 1
  - Horizon Zero Dawn : 4
  - Lineage 2 : 5
  - Warcraft 3 : 1

# Metodo DELETE
 `$router->addRoute('games/:ID/comments/:commentID','DELETE','CommentApiController','deleteComment');`
 `http://localhost/tpe-parte3-web2/api/games/8/comments/1`
 
 Para eliminar un comentario tengo que poner la ID del videojuego, con la ID del comentario a eliminar, como en el ejemplo mostrado.
 
# Metodo GET - Traer un comentario por ID.
 `$router->addRoute('comments/:ID','GET','CommentApiController', 'get');`
 `http://localhost/tpe-parte3-web2/api/comments/1`
 
 Pongo la ID del comentario a traer. Si no existe un comentario con esa ID sera informado.

## Metodo GET - Para traer todos los comentarios de un videojuego.
 `$router->addRoute('games/:ID/comments','GET','CommentApiController', 'getGamesComments');`
 `http://localhost/tpe-parte3-web2/api/games/2/comments`
 
 Traigo todos los comentarios de un videojuego poniendo la ID del mismo, si ese videojuego no tiene comentarios será informado.

## Metodo GET - Para traer todos los comentarios de todos los videojuegos.
 `$router->addRoute('comments','GET','CommentApiController','get');`
 `http://localhost/tpe-parte3-web2/api/comments`


## TABLA GENEROS:

# METODO POST:
 `$router->addRoute('genres','POST','genreApiController','createGenre');`
 ` http://localhost/tpe-parte3-web2/api/Genres`

 Para insertar un nuevo genero se utiliza el formato JSON de la siguiente manera:

 {
 "Edad": "18",
 "Genero": "OpenWorld",
 "Descripcion": "Mundo Abierto"
 }

# METODO PUT:
 `$router->addRoute('genres/:ID','PUT','genreApiController','updateGenre');`
 `http://localhost/tpe-parte3-web2/api/genres/1`

 Sirve para modificar un genero, se debe poner la id del genero a modificar en la URL y utilizar tambien el formato JSON de la siguiente manera:

  {
 "Edad": "18",
 "Genero": "OpenWorld",
 "Descripcion": "Mundo Abierto"
 }

# METODO DELETE:
 `$router->addRoute('genres/:ID','DELETE','genreApiController','deleteGenre');`
 `http://localhost/tpe-parte3-web2/api/6`

 Para eliminar un genero se debe seguir la URL de arriba, poniendo la ID del genero que queremos eliminar. Hay que tener en cuenta que el genero a eliminar no debe tener estar asignado en ningun videojuego, si no primero va a tener que asignarle otro equipo a los videojuegos, para luego poder eliminarlo. Si el genero esta asignado en algun videojuego saldra su respectivo error.

 # METODO GET por ID.
 `$router->addRoute('genres/:ID','GET','genreApiController','getGenre');`
 `http://localhost/tpe-parte3-web2/api/genres/1`
 
 Si nosotros queremos traer un genero por su respectiva ID tenemos que seguir la idea de la URL de arriba. Hay que estar seguros que la ID exista, si no saldra su respectivo aviso.

## Metodo GET - Para taer todos los equipos.
 `$router->addRoute('genres','GET','genreApiController','getGenres');`
 `http://localhost/tpe-parte3-web2/api/genres`

 Este metodo nos sirve para traer todos los generos.

 ## Para autenticarse y poder hacer el POST/PUT/DELETE de videojuegos y generos o hacer POST/DELETE de comentarios es necesario autenticarse por TOKEN.

 `$router->addRoute('user/token', 'GET',    'UserApiController', 'getToken');`
 `http://localhost/tpe-parte3-web2/api/user/token`

  Usuario: webadmin
  Contraseña: admin





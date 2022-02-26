<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: access");
	header("Access-Control-Allow-Methods: GET,POST");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
	$servidor = "localhost"; 
	$usuario = "root"; 
	$contrasenia = ""; 
	$nombreBaseDatos = "quehaceres";
	$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);


	// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
	if (isset($_GET["consultar"])){
	    $sqlQuehaceres = mysqli_query($conexionBD,"SELECT * FROM quehacer WHERE id=".$_GET["consultar"]);
	    if(mysqli_num_rows($sqlQuehaceres ) > 0){
	        $quehaceres = mysqli_fetch_all($sqlQuehaceres,MYSQLI_ASSOC);
	        echo json_encode($quehaceres);
	        exit();
	    }
	    else{  echo json_encode(["success"=>0]); }
	}
	//borrar pero se le debe de enviar una clave ( para borrado )
	if (isset($_GET["borrar"])){
	    $sqlQuehaceres = mysqli_query($conexionBD,"DELETE FROM quehacer WHERE id=".$_GET["borrar"]);
	    if($sqlQuehaceres){
	        echo json_encode(["success"=>1]);
	        exit();
	    }
	    else{  echo json_encode(["success"=>0]); }
	}
	//Inserta un nuevo registro y recepciona en método post los datos de nombre y correo
	if(isset($_GET["insertar"])){
	    $data = json_decode(file_get_contents("php://input"));
	    $nombre=$data->nombre;
	   
	    if(($nombre!="")){
	            
	    $sqlQuehaceres = mysqli_query($conexionBD,"INSERT INTO quehacer(nombre) VALUES('$nombre') ");
	    echo json_encode(["success"=>1]);
	        }
	    exit();
	}
	// Actualiza datos pero recepciona datos de nombre, correo y una clave para realizar la actualización
	if(isset($_GET["actualizar"])){
	    
	    $data = json_decode(file_get_contents("php://input"));

	    $id=(isset($data->id))?$data->id:$_GET["actualizar"];
	    $nombre=$data->nombre;
	    
	    $sqlQuehaceres = mysqli_query($conexionBD,"UPDATE quehacer SET nombre='$nombre' WHERE id='$id'");
	    echo json_encode(["success"=>1]);
	    exit();
	}
	// Consulta todos los registros de la tabla empleados
	$sqlQuehaceres = mysqli_query($conexionBD,"SELECT * FROM quehacer ");
	if(mysqli_num_rows($sqlQuehaceres) > 0){
	    $quehaceres = mysqli_fetch_all($sqlQuehaceres,MYSQLI_ASSOC);
	    echo json_encode($quehaceres);
	}
	else{ 
		// echo json_encode([["success"=>0]]); 
	}


?>
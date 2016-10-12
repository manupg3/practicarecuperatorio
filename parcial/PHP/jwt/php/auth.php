<?php
include_once '../vendor/autoload.php';
use \Firebase\JWT\JWT;


//opcion 1

// $ClaveDeEncriptacion = "estasEsLaClave";
// $token["usuario"] = "unUsuario";
// $token["perfil"] = "admin";
// $token["iat"] = time();
// $token["exp"] = time()+20;

// $jwt = JWT::encode($token, $ClaveDeEncriptacion);
// $ArrayConToken["ElNombreDelToken"]=$jwt;
//  echo json_encode($ArrayConToken);
 
// opcion 2
    
	$DatosPorPost = file_get_contents("php://input");
  // $DatosPorPost=$_POST['id'];
	$user = json_decode($DatosPorPost);
    
    require_once '../../clases/Persona.php';

     $verificado=Persona::TraerUnaPersona($user->usuario,$user->clave);	
 

 	if($verificado) 
 	{
		$ClaveDeEncriptacion = "estaEsLaClave";
		$token["usuario"] = "unUsuario";
		$token["perfil"] = "admin";
		$token["iat"] = time();
		$token["exp"] = time()+20;
		$jwt = JWT::encode($token, $ClaveDeEncriptacion);
		$ArrayConToken["ElNombreDelToken"]=$jwt;

 	}else{
 		$ArrayConToken["ElNombreDelToken"]=false;
 	}

 	echo json_encode($ArrayConToken);

  die();
?>
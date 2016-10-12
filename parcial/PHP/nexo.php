<?php 

	include "clases/Persona.php";

	include "clases/Votacion.php";

	$accion=$_GET['accion'];

	if($accion=="traer")
	{	
		$respuesta= array();		
		//$respuesta['listado']=Persona::TraerTodasLasPersonas();		
		$respuesta['listado']=Votacion::TraerTodasLasVotaciones();		
		$arrayJson = json_encode($respuesta);
		echo  $arrayJson;
	}		
	else if($accion=="traerListado")
	{	
		$respuesta= array();		
		$respuesta['listado']=Persona::TraerTodasLasPersonas();		
		$arrayJson = json_encode($respuesta);
		echo  $arrayJson;
	}else if($accion=="borrarUsuario")	{         
		$id = $_GET['id'];
		Persona::BorrarPersona($id);		
		
	}else if($accion=="borrar")	{         
		$id = $_GET['id'];
		
		Votacion::Borrar($id);		
	}else if($accion=="modificar")	{

		$votacionPersona = $_GET['votacionPersona'];
		$fechaPersona = $_GET['fechaPersona'];
		$dniPersona = $_GET['dniPersona'];
		$sexoPersona = $_GET['sexoPersona'];
		$idPersona=$_GET['idVotacion'];
		
		//$dniPersona = $_GET['dniPersona'];

		Votacion::Modificar($votacionPersona,$fechaPersona,$dniPersona,$sexoPersona,$idPersona);
		
		///Persona::BorrarPersona($idPersona);		

		//$arrayJson = json_encode($idPersona + " ;"+$nombrePersona+ " ;"+$apellidoPersona+ " ;"+$dniPersona);
		$arrayJson = json_encode($idPersona );
		echo  $arrayJson;




	}else if($accion=="agregarVotacion")	{   

		$votacion = $_GET['votacion'];
		$fecha = $_GET['fecha'];
		$dni = $_GET['dni'];
		$sexo = $_GET['sexo'];
         

		$id = Votacion::InsertarVotacion($votacion,$fecha, $dni, $sexo);	
	
		$arrayJson = json_encode($id );
		echo  $arrayJson;

	}else if($accion=="agregar")	{   
		$nombrePersona = $_GET['nombre'];
		$apellidoPersona = $_GET['apellido'];
		$dniPersona = $_GET['dni'];
		$userPersona=$_GET['usuario'];
     	$passPersona=$_GET['password'];
	    $copiapassPersona=$_GET['copiapassword'];

 
		$idPersona = Persona::InsertarPersona($nombrePersona,$apellidoPersona, $dniPersona,$userPersona,$passPersona);
		
		///Persona::BorrarPersona($idPersona);		

		//$arrayJson = json_encode($idPersona + " ;"+$nombrePersona+ " ;"+$apellidoPersona+ " ;"+$dniPersona);
		$arrayJson = json_encode($idPersona );
		echo  $arrayJson;		
	}else{
		$arrayJson = json_encode("Error: accion no existe");
		echo  $arrayJson;	
	}




 ?>
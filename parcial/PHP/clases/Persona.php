<?php
require_once"AccesoDatos.php";

class Persona
{
//--------------------------------------------------------------------------------//
//--ATRIBUTOS
	public $id;
	public $nombre;
 	public $apellido;
  	public $dni;
  	public $foto;
 	public $user;
  	public $pass;


//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--GETTERS Y SETTERS
  	public function GetId()
	{
		return $this->id;
	}
	 	public function GetUser()
	{
		return $this->user;
	}
	 	public function GetPass()
	{
		return $this->pass;
	}
	public function GetApellido()
	{
		return $this->apellido;
	}
	public function GetNombre()
	{
		return $this->nombre;
	}
	public function GetDni()
	{
		return $this->dni;
	}
	public function GetFoto()
	{
		return $this->foto;
	}

	public function SetId($valor)
	{
		$this->id = $valor;
	}
		public function SetUser($valor)
	{
		$this->user = $valor;
	}
		public function SetPass($valor)
	{
		$this->pass = $valor;
	}
	public function SetApellido($valor)
	{
		$this->apellido = $valor;
	}
	public function SetNombre($valor)
	{
		$this->nombre = $valor;
	}
	public function SetDni($valor)
	{
		$this->dni = $valor;
	}
	public function SetFoto($valor)
	{
		$this->foto = $valor;
	}
//--------------------------------------------------------------------------------//
//--CONSTRUCTOR
	public function __construct($dni=NULL)
	{
		if($dni != NULL){
			$obj = Persona::TraerUnaPersona($dni);
			
			$this->apellido = $obj->apellido;
			$this->nombre = $obj->nombre;
			$this->dni = $dni;
			$this->foto = $obj->foto;
		    $this->foto = $obj->user;
		    $this->foto = $obj->pass;
		            
		}
	}

//--------------------------------------------------------------------------------//
//--TOSTRING	
  	public function ToString()
	{
	  	return $this->apellido."-".$this->nombre."-".$this->dni."-".$this->foto."-".$this->user."-".$this->pass;
	}
//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--METODO DE CLASE
	public static function TraerUnaPersona($ParametroU,$ParametroC) 
	{	


		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		//$consulta =$objetoAccesoDato->RetornarConsulta("select * from persona where id =:id");
		$consulta =$objetoAccesoDato->RetornarConsulta("CALL TraerUnaPersona(:user,:pass)");
		$consulta->bindValue(':user', $ParametroU, PDO::PARAM_INT);
	    $consulta->bindValue(':pass', $ParametroC, PDO::PARAM_INT);
		$consulta->execute();
		$personaBuscada= $consulta->fetchObject('persona');
		return $personaBuscada;	
					
	}
		
	
	public static function TraerTodasLasPersonas()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		//$consulta =$objetoAccesoDato->RetornarConsulta("select * from persona");
		$consulta =$objetoAccesoDato->RetornarConsulta("CALL TraerTodasLasPersonas() ");
		$consulta->execute();			
		$arrPersonas= $consulta->fetchAll(PDO::FETCH_CLASS, "persona");	
		return $arrPersonas;
	}
	
	public static function BorrarPersona($idParametro)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		//$consulta =$objetoAccesoDato->RetornarConsulta("delete from persona	WHERE id=:id");	
		$consulta =$objetoAccesoDato->RetornarConsulta("CALL BorrarPersona(:id)");	
		$consulta->bindValue(':id',$idParametro, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
		
	}

	public static function ModificarPersona($id, $nombre, $apellido)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("CALL ModificarPersonaSinFoto(:id,:nombre,:apellido)");
			$consulta->bindValue(':id',$persona->id, PDO::PARAM_INT);
			$consulta->bindValue(':nombre',$persona->nombre, PDO::PARAM_STR);
			$consulta->bindValue(':apellido', $persona->apellido, PDO::PARAM_STR);
			//$consulta->bindValue(':foto', $persona->foto, PDO::PARAM_STR);
			return $consulta->execute();
	}
	
	// public static function ModificarPersona($persona)
	// {
	// 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	// 		/*$consulta =$objetoAccesoDato->RetornarConsulta("
	// 			update persona 
	// 			set nombre=:nombre,
	// 			apellido=:apellido,
	// 			foto=:foto
	// 			WHERE id=:id");
	// 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();*/ 
	// 		$consulta =$objetoAccesoDato->RetornarConsulta("CALL ModificarPersona(:id,:nombre,:apellido,:foto)");
	// 		$consulta->bindValue(':id',$persona->id, PDO::PARAM_INT);
	// 		$consulta->bindValue(':nombre',$persona->nombre, PDO::PARAM_STR);
	// 		$consulta->bindValue(':apellido', $persona->apellido, PDO::PARAM_STR);
	// 		$consulta->bindValue(':foto', $persona->foto, PDO::PARAM_STR);
	// 		return $consulta->execute();
	// }

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//

	public static function InsertarPersona($nombrePersona,$apellidoPersona, $dniPersona,$userPersona,$passPersona)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		//$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into persona (nombre,apellido,dni,foto)values(:nombre,:apellido,:dni,:foto)");
		$consulta =$objetoAccesoDato->RetornarConsulta("CALL InsertarPersona (:nombre,:apellido,:dni,:user,:pass)");
		$consulta->bindValue(':nombre',$nombrePersona, PDO::PARAM_STR);
		$consulta->bindValue(':apellido', $apellidoPersona, PDO::PARAM_STR);
		$consulta->bindValue(':dni', $dniPersona, PDO::PARAM_STR);
	//	$consulta->bindValue(':foto', $persona->foto, PDO::PARAM_STR);
		$consulta->bindValue(':user', $userPersona, PDO::PARAM_STR);
		$consulta->bindValue(':pass', $passPersona, PDO::PARAM_STR);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	
				
	}	
//--------------------------------------------------------------------------------//



}

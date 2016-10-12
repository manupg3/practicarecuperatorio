<?php

require_once"accesoDatos.php";


class Votacion
{
//--------------------------------------------------------------------------------//
//--ATRIBUTOS
	public $id;
	public $fecha;
 	public $votacion;
  	public $dni;
  	public $sexo;
  	public $foto;

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--GETTERS Y SETTERS
  	public function GetId()
	{
		return $this->id;
	}
	public function GetVotacion()
	{
		return $this->votacion;
	}
	public function GetFecha()
	{
		return $this->fecha;
	}
	public function GetDni()
	{
		return $this->dni;
	}
	public function GetSexo()
	{
		return $this->sexo;
	}
	public function GetFoto()
	{
		return $this->foto;
	}

	public function SetId($valor)
	{
		$this->id = $valor;
	}
	public function SetVotacion($valor)
	{
		$this->votacion = $valor;
	}
	public function SetFecha($valor)
	{
		$this->fecha = $valor;
	}
	public function SetDni($valor)
	{
		$this->dni = $valor;
	}
	public function SetSexo($valor)
	{
		$this->sexo = $valor;
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
			$obj = Votacion::TraerUnaVotacion($dni);			
			$this->votacion = $obj->votacion;
			$this->fecha = $obj->fecha;
			$this->dni = $dni;
			$this->sexo = $obj->$sexo;
			$this->foto = $obj->foto;
		}
	}

//--------------------------------------------------------------------------------//
//--TOSTRING	
  	public function ToString()
	{
	  	return $this->votacion."-".$this->fecha."-".$this->dni."-".$this->sexo."-".$this->foto;
	}
//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--METODO DE CLASE
	public static function TraerUnaVotacion($idParametro) 
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from votacion where id =:id");
		$consulta->bindValue(':id', $idParametro, PDO::PARAM_INT);
		$consulta->execute();
		$vBuscada= $consulta->fetchObject('votacion');
		return $vBuscada;	
					
	}
	
	public static function TraerTodasLasVotaciones()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		//$consulta =$objetoAccesoDato->RetornarConsulta("select * from votacion");
		$consulta =$objetoAccesoDato->RetornarConsulta("CALL TraerTodasLasVotaciones() ");
		$consulta->execute();			
		$arrV= $consulta->fetchAll(PDO::FETCH_CLASS, "votacion");	
		return $arrV;
	}
	
	public static function Borrar($idParametro)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		//$consulta =$objetoAccesoDato->RetornarConsulta("delete from persona	WHERE id=:id");	
		$consulta =$objetoAccesoDato->RetornarConsulta("CALL BorrarVotacion(:id)");	
		$consulta->bindValue(':id',$idParametro, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();	
	}
	
	public static function Modificar($votacionPersona,$fechaPersona,$dniPersona,$sexoPersona,$idPersona)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update votacion 
				set fecha=:fecha,
				votacion=:votacion,
				sexo=:sexo,
				dni=:dni
				WHERE id=:id");

			$consulta->bindValue(':id',$idPersona, PDO::PARAM_INT);
			$consulta->bindValue(':dni',$dniPersona, PDO::PARAM_INT);
			$consulta->bindValue(':fecha',$fechaPersona, PDO::PARAM_STR);
			$consulta->bindValue(':votacion', $votacionPersona, PDO::PARAM_STR);
			$consulta->bindValue(':sexo', $sexoPersona, PDO::PARAM_STR);
			return $consulta->execute();
	}

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//

	public static function InsertarVotacion($votacion,$fecha, $dni, $sexo)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 		
		$consulta =$objetoAccesoDato->RetornarConsulta("CALL InsertarVotacionSinFoto (:fecha,:votacion,:dni,:sexo)");
		$consulta->bindValue(':fecha',$fecha, PDO::PARAM_STR);
		$consulta->bindValue(':votacion', $votacion, PDO::PARAM_STR);
		$consulta->bindValue(':dni', $dni, PDO::PARAM_STR);		
		$consulta->bindValue(':sexo', $sexo, PDO::PARAM_STR);	
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();	
				
	}	
//--------------------------------------------------------------------------------//

}
//var miApp = angular.module("angularABM",['ui.router','angularFileUpload']);

var miApp = angular.module("angularABM",['ui.router', 'satellizer']);

miApp.config(function($stateProvider,$urlRouterProvider, $authProvider){

    $pathName = window.location.pathname.substring(1);
	$authProvider.loginUrl = $pathName +'PHP/jwt/php/auth.php';
	console.log($authProvider.loginUrl);

	//$authProvider.loginUrl = 'ABM_AngularJs_PHP_persona/PHP/jwt/php/auth.php';	
	$authProvider.tokenName = 'ElNombreDelToken';
	$authProvider.tokenPrefix = 'Aplicacion' ;
	$authProvider.authHearder = 'data';


	$stateProvider
	.state(
		"inicio",{
			url:"/inicio",
			templateUrl:"inicio.html",
			controller:"controlInicio"
		})

	.state('login',
			{
					url: '/login',					
					templateUrl: 'login.html',
					controller: 'controlRegisterLogin'
	})

	.state('registro',
			{
					url: '/registro',					
					templateUrl: 'altaUsuario.html',
					controller: 'controlRegistro'
	})



	.state(
		"persona",{
					url:"/persona",
					abstract:true,
					templateUrl:"abstractaPersona.html"
				})	

	.state(
		"persona.menu",{
			url:"/menu",
			views: {
				"contenido":{
					templateUrl:"personaMenu.html",
				    controller:"controlPersonaMenu"
					}
				}			
		})

	.state(
		"persona.alta",{
			url:"/alta",
			views: {
				"contenido":{
					templateUrl:"personaAlta.html",
				    controller:"controlAltaPersonaALta"
					}
				}			
			})	
		
	.state(
		"persona.modificacion",
			{
				url: '/modificacion/:id/:votacion/:fecha/:sexo/:dni',
				views: 
				{
					"contenido":{					
						templateUrl: "personaAlta.html",
						controller: "controlModificacion"
						}
				},

			})


	.state(
		"persona.grilla",{
			url:"/grilla",
			views: {
				"contenido":{
					templateUrl:"personaGrilla.html",
				 	controller:"controlgrillaPersona"
					}
				}			
		})

	.state(
		"persona.listadoUsuarios",{
			url:"/listadoUsuarios",
			views: {
				"contenido":{
					templateUrl:"listadoUsuarios.html",
				 	controller:"controlListadoUsuarios"
					}
				}			
		})
		
		
	$urlRouterProvider.otherwise("/inicio");
});

miApp.controller('controlRegisterLogin', function($scope, $auth, $state) {  
	$scope.usuario = {};
	$scope.usuario.clave = "clave" ;
	$scope.usuario.correo = "usuario" ;
	$scope.usuario.dni = "11113333" ;
	$scope.logueo = true; // false--> muestra
	// if ($auth.isAuthenticated()) {}else{$state.go("login");}
    console.log($scope.usuario);
	$scope.iniciarSesion = function()
	{
		console.log($scope.usuario);
		  $auth.login({
             usuario:$scope.usuario.correo,
             clave:$scope.usuario.clave,
             dni:$scope.usuario.dni
		  })
  			.then(function(response) {
                  console.log(response);
                  console.info("correcto" + $auth.setToken());
    			  console.info("correcto:"  + response.data.ElNombreDelToken);
            
    			if($auth.isAuthenticated())
    			//if(response.data.ElNombreDelToken!=false)
    			{
    				// agregrarlo al localstorage o al session storage
    				//console.info("correcto" + $auth.getPayload());
    				$state.go("persona.menu");
    			}else
    			{
    				 console.info($auth.isAuthenticated());
    				$scope.logueo = false; // false--> muestra
    			}
    			
  			})
  			.catch(function(response) {    		
    			$scope.logueo = false; // false--> muestra
  		});
	}		

	$scope.irARegistro = function()
	{
		  $state.go("registro");
	}
});

miApp.controller("controlRegistro",function($scope,$http,$state){
      
     $scope.Guardar=function(){
        $http.get('PHP/nexo.php',{params:{ accion:"agregar",
                                           nombre:$scope.name,
                                           apellido:$scope.ape,
                                           usuario:$scope.email,
                                           dni:$scope.dni,
                                           password:$scope.persona.password,
                                           copiapassword:$scope.persona.copiapassword
                                            
                                           }}).then(function(respuesta){
                                                $state.go('login');
                                            },function errorCallback(respuesta){
                                                console.log(respuesta);

                                            });     


      }; 	
   
});

miApp.controller("controlInicio",function($scope){
	$scope.DatoTest="Inicio";
});


miApp.controller("controlAltaPersonaALta",function($scope,$http,$state){
  	$scope.dato="Alta";
  	  	$scope.votacion={};
  	$scope.votacion.votacion= "" ;
  	$fecha = new Date();
 	$scope.votacion.fecha =  $fecha.getDay()+ "-"+$fecha.getMonth() + "-" +$fecha.getFullYear() ;
 	$scope.votacion.dni= "" ;
  	$scope.votacion.sexo= "" ;
  //	$scope.persona.foto="";


  	$scope.Guardar=function(){
  		
		$http.get('PHP/nexo.php', { 
								params: 
								{	
									accion :"agregarVotacion",									
									votacion :$scope.votacion.votacion,
									fecha :$scope.votacion.fecha,
									dni : $scope.votacion.dni,
									sexo : $scope.votacion.sexo
								}
		})
		.then(function(respuesta) 
		{            	
			console.log(respuesta);
		   $http.get('PHP/nexo.php', { params: {accion :"traer"}})
			.then(function(respuesta) { 
			console.log(respuesta);    					
			 	$scope.ListadoPersonas = respuesta.data.listado;	
			 
			    $state.go('persona.grilla');
			
			},function errorCallback(response) {
				 $scope.ListadoPersonas= [];				
				 $state.go("grilla");
		 	});
    		},function errorCallback(response) {        
        		//aca se ejecuta cuando hay errores
        		console.log( response); 
        		$state.go("grilla");            
    	});
  	}
	
});

miApp.controller("controlPersonaMenu",function($scope, $state){

	$scope.iraAlta=function(){
		$state.go("persona.alta");  
	} 
	$scope.iraGrilla=function(){
		$state.go("persona.grilla");  
	    } 
   		
});

miApp.controller("controlListadoUsuarios",function($scope,$http, $state){

	$http.get('PHP/nexo.php', { params: {accion :"traerListado"}})
 	.then(function(respuesta) {     	
 		  console.log(respuesta);
      	 $scope.ListadoPersonas = respuesta.data.listado;
          },function errorCallback(response) {
     		 $scope.ListadoPersonas= [];
 	});
			


 	$scope.Borrar=function(u){
		
		$http.get("PHP/nexo.php",{params:{accion :"borrarUsuario",id:u.id}},
			{headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
 			.then(function(respuesta) {                	
         	console.log(respuesta.data);
		$http.get('PHP/nexo.php', { params: {accion :"traerListado"}})
			.then(function(respuesta) {     	
			 	$scope.ListadoPersonas = respuesta.data.listado;			 	
			},function errorCallback(response) {
				 $scope.ListadoPersonas= [];
				console.log( response);
		 	});
    		},function errorCallback(response) {        
        	//aca se ejecuta cuando hay errores
        	console.log( response);           
    	});
	}		

});	

miApp.controller("controlgrillaPersona",function($scope,$http, $state){
	$scope.dato="Grilla";
	 $http.get('PHP/nexo.php', { params: {accion :"traer"}})
 	.then(function(respuesta) {     	
      	 $scope.ListadoPersonas = respuesta.data.listado;

    },function errorCallback(response) {
     		 $scope.ListadoPersonas= [];
 	});
			

 	$scope.modificacion=function(votacion){ 

 		$state.go('persona.modificacion',  
 					{id:votacion.id, votacion:votacion.votacion, fecha:votacion.fecha,dni:votacion.dni,sexo:votacion.sexo}
 				); 
 	}

 	$scope.Borrar=function(votacion){
		
		$http.get("PHP/nexo.php",{params:{accion :"borrar",id:votacion.id}},
			{headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
 			.then(function(respuesta) {                	
         	console.log(respuesta.data);
		$http.get('PHP/nexo.php', { params: {accion :"traer"}})
			.then(function(respuesta) {     	
			 	$scope.ListadoPersonas = respuesta.data.listado;			 	
			},function errorCallback(response) {
				 $scope.ListadoPersonas= [];
				console.log( response);
		 	});
    		},function errorCallback(response) {        
        	//aca se ejecuta cuando hay errores
        	console.log( response);           
    	});
		
		}



});

miApp.controller('controlModificacion', function($scope, $http, $state, $stateParams)
{	
	$scope.votacion={};
	console.log($scope.votacion);
	var id=$stateParams.id;
	console.log(id);
  	$scope.votacion.votacion= $stateParams.votacion ;
  	$scope.votacion.dni= $stateParams.dni ;
  	$scope.votacion.fecha= $stateParams.fecha;
    $scope.votacion.sexo= $stateParams.sexo;
   


	$scope.Guardar=function(persona){		
		$http.get('PHP/nexo.php', { 
								params: 
								{	
									accion :"modificar",
									idVotacion:id,
									votacionPersona :$scope.votacion.votacion,
									fechaPersona :$scope.votacion.fecha,
									sexoPersona :$scope.votacion.sexo,
									dniPersona:$scope.votacion.dni
								}
		})
		.then(function(respuesta) 
		{            	
			console.log(respuesta);
		    $http.get('PHP/nexo.php', { params: {accion :"traer"}})
			.then(function(respuesta) {     					
			 	$scope.ListadoPersonas = respuesta.data.listado;	
			 	$state.go("persona.grilla");
			},function errorCallback(response) {
				 $scope.ListadoPersonas= [];				
				$state.go("persona.grilla");
		 	});
    		},function errorCallback(response) {        
        		//aca se ejecuta cuando hay errores
        		console.log( response); 
        		$state.go("persona.grilla");            
    	});
 	}	
});

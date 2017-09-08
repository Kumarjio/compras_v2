<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentityDev extends CUserIdentity
{
	

	const ERROR_GRAVE_AUTH = 9;
	const REQUIERE_ACCION_USUARIO = 8;
	const ACCION_O_CONTINUAR = 7;
	
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */

	
	 public function authenticate()
	 {
		 $parts = explode("|", $this->username);

		 $userid = $parts[0];
		 
		 $respuesta = "login_ok";
		 
		 
		 $this->errorCode=self::ERROR_NONE;
		 $this->permisos = $parts;
		 $this->cargarCedula($userid); 
		 $this->asignarRol($parts);
		 
		 return $respuesta;
	}

	
	private function cargarCedula($userid){
	    $this->setState("id_empleado", $userid);
	}
	
	private function asignarRol($permisos){
		if(in_array('VIA0999', $permisos)){
			$this->setState('secretaria', true);
		}
    
	}

	public function getPermisos()
	{
		return $this->getState('permisos');
	}
	
    public function setPermisos($value)
    {
        $this->setState('permisos',$value);
    }
	
}

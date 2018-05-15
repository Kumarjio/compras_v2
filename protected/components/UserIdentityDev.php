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
		if(in_array('CYC991', $permisos)){
			$this->setState('jefe', true);
		}
		if(in_array('CYC992', $permisos)){
			$this->setState('gerente', true);
		}
		if(in_array('CYC993', $permisos)){
			$this->setState('presidencia', true);
		}
		if(in_array('CYC990', $permisos)){
			$this->setState('junta', true);
		}
		if(in_array('CYC994', $permisos)){
			$this->setState('jefe_compras', true);
		}
		if(in_array('CYC995', $permisos)){
			$this->setState('comite_compras', true);
		}
		if(in_array('CYC996', $permisos)){
			$this->setState('analista_compras', true);
		}
		if(in_array('CYC989', $permisos)){
			$this->setState('contratacion', true);
		}
		if(in_array('CYC997', $permisos)){
			$this->setState('vicepresidente', true);
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

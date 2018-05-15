<?php
//Yii::import('application.extensions.SWebService');

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	const ERROR_GRAVE_AUTH = 9;
	const USUARIO_INACTIVO = 8;
	const ACCION_O_CONTINUAR = 7;
    const ERROR_NO_PERFIL = 6;
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */

	
	 public function authenticate(){
	 	$usuario = new Usuario();
	 	$usuario = Usuario::model()->find("usuario = :u", array(":u"=>$this->username));
	 	//echo $usuario->usuario;
	 	if(!$usuario){
	 		$this->errorCode = self::ERROR_USERNAME_INVALID;
	 	}elseif(md5($this->password) !== $usuario->contraseña){
	 		$this->errorCode = self::ERROR_PASSWORD_INVALID;
	 	}else{

            if(!$usuario->activo){
            	$this->errorCode = self::USUARIO_INACTIVO;
            }
            else {

		 		$this->setState("usuario",$usuario->usuario);
				//$this->errorCode = self::ERROR_NONE;
		 	
	            //Cargamos Rol(es)
	            $roles = UsuariosRoles::model()->findAll('id_usuario= :id_usuario',array('id_usuario'=>$usuario->id));
	            $array_per = array();
	            foreach($roles as $dt){
	                $this->setPerfil($dt[id_rol]);
	                array_push($array_per, $dt[id_rol]);
	            }
	            if( count($array_per)>0){
	                $this->setPermisos($array_per);
	                $this->errorCode=self::ERROR_NONE;
	            }else{
	                $this->errorCode=self::ERROR_NO_PERFIL;
	            }
            }	 		

        }

        //return !$this->errorCode;

		//if (count($resperl) > 2) {
			//$this->setNombre   = $resperl[1];
			//$this->setUsuario  = strtoupper($resperl[0]);
			//$this->setOficina  = $resperl[2];
			//$this->setGerencia = $resperl[3];			
			//$this->setIp       = $_SERVER['REMOTE_ADDR'];
			
			/*$permisos = UsuarioPerfil::model()->findAll('id_usuario= :id_usuario',array('id_usuario'=>$usuario->id_usuario));
			$perfiles= UsuarioPerfil::model()->findAll('id_usuario= :id_usuario',array('id_usuario'=>$usuario->id_usuario));
			$array_per=array();
			foreach($perfiles as $dt){
				$this->setPerfil($dt[id_perfil]);
				array_push($array_per, $dt[id_perfil]);
			}
			if( count($array_per)>0){
				$this->setPermisos($array_per);
				$this->errorCode=self::ERROR_NONE;
			}else{
				$this->errorCode=self::ERROR_NO_PERFIL;
			}*/
		//}	
	}

	private function cryptPassword($pw){
		return base64_encode(pack("H*",sha1($pw)));
	}
	  
	public function getPermisos(){
		return $this->getState('permisos');
	}
	
    public function setPermisos($value){
        $this->setState('permisos',$value);
    }
        
    public function getNombre(){
		return $this->getState('nombre');
	}
	
    public function setNombre($value){
        $this->setState('nombre',$value);
    }

    public function getUsuario(){
        return $this->getState('usuario');
    }
    
    public function setUsuario($value){
        $this->setState('usuario',$value);
    }

	public function getIp(){
        return $this->getState('ip');
    }
    
    public function setIp($value){
        $this->setState('ip',$value);
    }

    public function getPerfil(){
        return $this->getState('perfil');
    }
    
    public function setPerfil($value){
        $this->setState('perfil',$value);
    }
}

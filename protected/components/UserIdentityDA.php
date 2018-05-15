<?php
Yii::import('application.extensions.SWebService');
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentityDA  extends CUserIdentity
{
	private $_id;
	public $client;
	private $_aya;
	public $username;
	public $permisos;
	
	const ERROR_GRAVE_AUTH = 9;
	const REQUIERE_ACCION_USUARIO = 8;
	const ACCION_O_CONTINUAR = 7;
	const NO_EXISTE_EMPLEADO = 10;
	const ERROR_NONE=11;
	
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	 public function UserIdentityDA($username){
		 $this->username=$username;
	 }
	 
	 public function authenticateDA()
	 {
		 $this->_aya = new SWebService;
		 $this->username = strtolower($this->username);
		 $respuesta = $this->_aya->autorizarNuevoDA($this->username);
		 if($respuesta['AutenticarUsuarioDAResult'] == true)
		 {
			 $this->errorCode=self::ACCION_O_CONTINUAR;
			 $this->permisos=$this->_aya->getPermisos();
			 $this->officetmp = "";
			 $this->cargarCedula($this->username); 
			 $this->setState('permisos', $this->permisos);
			 $this->asignarRol($this->permisos);

		 } else if($respuesta['AutenticarUsuarioDAResult'] == 2){

			 $this->errorCode=self::REQUIERE_ACCION_USUARIO;

		 } else if($respuesta['AutenticarUsuarioDAResult'] == false){

			 $this->errorCode=self::ERROR_GRAVE_AUTH;

		 } else {
			 $this->errorCode=self::ERROR_NONE;
			
			 $this->permisos=$this->_aya->getPermisos();
			 $this->officetmp = "";
			 $this->cargarCedula($this->username);
			 if(Yii::app()->user->getState("id_empleado")== 0){
				 $this->errorCode = self::NO_EXISTE_EMPLEADO;
			 }
			 else{
				Yii::app()->user->setState('permisos', $this->permisos);
				$this->asignarRol($this->permisos);
			 }
		 }
		 return $respuesta;
	 }

	
	private function cargarCedula($user){
	  $cedula = $this->_aya->informacionUsuario($user);
	  $empl = Empleados::model()->findByAttributes(array('numero_identificacion' => $cedula));
	  if($empl == null){
	    throw new CHttpException(500,'No se encuentra registrado como empleado. Favor contactar al administrador del sitio.');

	  }else{
			Yii::app()->user->setState("id_empleado", $empl->id);
	  }
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
		if(in_array('CYC997', $permisos)){
			$this->setState('vicepresidente', true);
		}
	}
	 
	public function getConsulta()
	{
		return $this->getState('consulta');
	}
	
    public function setConsulta($value)
    {
        $this->setState('consulta',$value);
    }
    
    public function getBotones()
	{
		return $this->getState('botones');
	}
	
    public function setBotones($value)
    {
        $this->setState('botones',$value);
    }
    
	public function getPermisos()
	{
		return $this->getState('permisos');
	}
	
    public function setPermisos($value)
    {
        $this->setState('permisos',$value);
    }
    
    public function getOffice()
	{
		return $this->getState('office');
	}
	
    public function setOffice($value)
    {
        $this->setState('office',$value);
    }
 
    public function getOfficetmp()
    {
    	return $this->getState('officetmp');
    }

    public function setOfficetmp($value)
    {
        return $this->setState('officetmp',$value);
    }

}
<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginFormDev extends CFormModel
{
	public $user_and_role;
	public $rememberMe;

	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('user_and_role', 'required'),
			
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'user_and_role' => 'Usuario y Rol',
		);
	}

	public static function usuarioRol(){
		return array(
			array('id' =>'34|CYC403', 'nombre' => 'Solicitante'),
			array('id' =>'691|CYC991', 'nombre' => 'Jefe'),//522
			array('id' =>'792|CYC992', 'nombre' => 'Director'),
			array('id' =>'503|CYC992', 'nombre' => 'Gerente'),//502
			array('id' =>'777|CYC996', 'nombre' => 'Analista Compras'),
			array('id' =>'139|CYC996', 'nombre' => 'Analista Compras Daniela'),
			array('id' =>'515|CYC400', 'nombre' => 'Jefe Facturacion'),
			array('id' =>'138|CYC400', 'nombre' => 'Responsable facturación'),
			array('id' =>'451|CYC992', 'nombre' => 'Gerente Facturacion'),
			array('id' =>'466|CYC401', 'nombre' => 'Causación'),
			array('id' =>'73|CYC400', 'nombre' => 'Jefe Administrativo'),
			array('id' =>'468|CYC404', 'nombre' => 'Operaciones'),
			array('id' =>'771|CYC997', 'nombre' => 'Vicepresidente'),
			array('id' =>'504|CYC992', 'nombre' => 'Gerencia Admin'),
			array('id' =>'515|CYC995', 'nombre' => 'Comite Compras'),
			array('id' =>'32|CYC994', 'nombre' => 'Jefe de Compras'),
			array('id' =>'504|CYC993', 'nombre' => 'Presidencia'),
			array('id' =>'504|CYC990', 'nombre' => 'Junta'),
			array('id' =>'276|CYC997', 'nombre' => 'Administrativo'),
			array('id' =>'59|CYC999', 'nombre' => 'Willies'),
			array('id' =>'592|CYC998', 'nombre' => 'Juridico'),
			array('id' =>'595|CYC989', 'nombre' => 'Contratación'),
			array('id' =>'595|CYC988', 'nombre' => 'Consulta'),
			array('id' =>'595|CYC986', 'nombre' => 'Edición'),
			array('id' =>'595|CYC987', 'nombre' => 'Eliminación'),
		);
	}
	

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate()
        {
	  if(!$this->hasErrors())  // we only want to authenticate when no input errors                                                                                                                                                
	    {
	      $identity=new UserIdentityDev($this->user_and_role, "empty_password");
	      $arreglo = $identity->authenticate();

	      switch($identity->errorCode)
		{
		case UserIdentity::ERROR_NONE:
		  $duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days                                                                                                                                             
		  Yii::app()->user->login($identity,$duration);
		  break;
		case UserIdentity::ERROR_GRAVE_AUTH:
		  $this->addError('password',iconv('ISO-8859-1','UTF-8',$arreglo['p_strMensaje']));
		  return $arreglo;
		  break;
		case UserIdentity::ACCION_O_CONTINUAR:
		  Yii::app()->user->login($identity,$duration);
		  return $arreglo;
		  break;
		case UserIdentity::REQUIERE_ACCION_USUARIO:
		  return $arreglo;
		  break;
		default: // UserIdentity::ERROR_PASSWORD_INVALID                                                                                                                                                             
		  $this->addError('password','Password is incorrect.');
		  break;
		}
	    }
        }


	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}

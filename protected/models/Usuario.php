<?php
/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 * @property string $usuario
 * @property string $nombres
 * @property string $apellidos
 * @property string $correo
 * @property boolean $activo
 * @property boolean $bloqueado
 * @property string $fecha_creacion
 * @property string $usuario_creacion
 * @property string $contraseña
 * @property integer $cargo
 *
 * The followings are the available model relations:
 * @property ObservacionesTrazabilidad[] $observacionesTrazabilidads
 * @property Cargos $cargo0
 * @property Areas $area0
 * @property UsuariosFlujo[] $usuariosFlujos
 * @property Recepcion[] $recepcions
 * @property Trazabilidad[] $trazabilidads
 * @property UsuariosRoles[] $usuariosRoles
 * @property UsuariosActividadTipologia[] $usuariosActividadTipologias
 * @property Inhabilidad[] $inhabilidads
 * @property Inhabilidad[] $inhabilidads1
 * @property Inhabilidad[] $inhabilidads2
 * @property AusenteTrazabilidad[] $ausenteTrazabilidads
 */
class Usuario extends CActiveRecord
{
	public $valida_contrasena;
	public $repetir;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, nombres, contraseña, repetir, apellidos, correo, cargo', 'required','except'=>'inhabilitar'),
			array('usuario','unique'),
			array('contraseña', 'length', 'min'=>10),
			array('contraseña', 'match', 'pattern'=>'/\d/', 'message'=>'Contraseña debe contener por lo menos un número.','except'=>'inhabilitar'),
			array('contraseña', 'match', 'pattern'=>'/\W/', 'message'=>'Contraseña debe contener por lo menos un caracter especial.', 'except'=>'listo_guardar, inhabilitar'),
			array('cargo, usuario', 'numerical', 'integerOnly'=>true),
			array('apellidos, activo, bloqueado,tipo_inhabilidad, fecha_fin_licencia', 'safe'),
			array('correo','email'),
			array('repetir', 'compare', 'compareAttribute'=>'contraseña','except'=>'inhabilitar'),
			array('repetir, tipo_inhabilidad', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, usuario, nombres, apellidos, correo, activo, bloqueado, fecha_creacion, usuario_creacion, contraseña, cargo, valida_contrasena', 'safe', 'on'=>'search'),
			//Cambio de contraseña
			array('valida_contrasena', 'comparaAnterior', 'on'=>'cambio_pass'),
			//Para inhabilitar
			array('tipo_inhabilidad', 'required', 'on'=>'inhabilitar'),
			array('fecha_fin_licencia', 'validarFecha', 'on'=>'inhabilitar'),
			array('usuario','validarUsuario'),
		);
	}

	/**
	 * @return array relational rules.
	 */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'observacionesTrazabilidads' => array(self::HAS_MANY, 'ObservacionesTrazabilidad', 'usuario'),
            'cargo0' => array(self::BELONGS_TO, 'Cargos', 'cargo'),
            'usuariosFlujos' => array(self::HAS_MANY, 'UsuariosFlujo', 'usuario'),
            'recepcions' => array(self::HAS_MANY, 'Recepcion', 'user_recepcion'),
            'trazabilidads' => array(self::HAS_MANY, 'Trazabilidad', 'user_asign'),
            'adjuntosTrazabilidads' => array(self::HAS_MANY, 'AdjuntosTrazabilidad', 'usuario'),
            'usuariosAreases' => array(self::HAS_MANY, 'UsuariosAreas', 'usuario'),
            'usuariosRoles' => array(self::HAS_MANY, 'UsuariosRoles', 'id_usuario'),
            'usuariosActividadTipologias' => array(self::HAS_MANY, 'UsuariosActividadTipologia', 'usuario'),
            'inhabilidads' => array(self::HAS_MANY, 'Inhabilidad', 'usuario'),
            'inhabilidads1' => array(self::HAS_MANY, 'Inhabilidad', 'reemplazo'),
            'inhabilidads2' => array(self::HAS_MANY, 'Inhabilidad', 'usuario_inhabilita'),
            'ausenteTrazabilidads' => array(self::HAS_MANY, 'AusenteTrazabilidad', 'usuario'),
        );
    }
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario' => 'Documento (Usuario)',
			'nombres' => 'Nombres',
			'apellidos' => 'Apellidos',
			'correo' => 'Correo',
			'activo' => 'Activo',
			'bloqueado' => 'Bloqueado',
			'fecha_creacion' => 'Fecha Creación',
			'usuario_creacion' => 'Usuario Creacion',
			'contraseña' => ($this->getScenario() == 'cambio_pass') ? 'Contraseña Nueva' : 'Contraseña',
			'cargo' => 'Cargo',
			//'area' => 'Área',
			'repetir' => 'Confirmar Contraseña',
			'valida_contrasena'=>'Contraseña Anterior'
		);
	}

	public function tipoInabilidadSpan($tipo){

		return "<br/><span class='label label-warning'>".Usuario::model()->tiposInabilidadById($tipo)."</span>";
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->addCondition("t.id <> '3'");
		//$criteria->compare('usuario',$this->usuario,true);
		//$criteria->compare('nombres',$this->nombres,true);
		//$criteria->compare('apellidos',$this->apellidos,true);//Pendiente
		/*$criteria->compare('cargo',$this->cargo);*/
		/*$criteria->compare('area',$this->area);*/
		//$criteria->with = array('area0','cargo0');

		if(!empty($this->usuario)){
			
		}
		if(!empty($this->usuario)){
			$criteria->addCondition("usuario in (select usuario from usuario where usuario = '".$this->usuario."')");
		}
		if(!empty($this->nombres)){
			$criteria->addCondition("nombres in (select nombres from usuario where nombres ilike '%".$this->nombres."%')");
		}
		if(!empty($this->apellidos)){
			$criteria->addCondition("apellidos in (select apellidos from usuario where apellidos ilike '%".$this->apellidos."%')");
		}
		if(!empty($this->cargo)){
			$criteria->addCondition(array('"cargo0"."cargo" ilike \'%'.$this->cargo.'%\''));

		}
		/*if(!empty($this->area)){
			$criteria->addCondition(array('"area0"."area" ilike \'%'.$this->area.'%\''));
		}*/
		if(!empty($this->fecha_creacion)){
			
			//$this->fecha_creacion = date("Y/m/d", strtotime($this->fecha_creacion));
			$criteria->addCondition("fecha_creacion in (select fecha_creacion from usuario where fecha_creacion::date = TO_DATE('".$this->fecha_creacion."', 'DD/MM/YYYY'))"); 
		}
		$criteria->compare('correo',$this->correo,true);
		//$criteria->compare('activo',1);
		$criteria->compare('bloqueado',$this->bloqueado);

		$criteria->compare('usuario_creacion',$this->usuario_creacion,true);
		$criteria->compare('contraseña',$this->contraseña,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'t.id ASC',
			)
		));
	}
	
	/*public function cargarUsuarios(){
		$model = $this->findAll();
		return CHtml::listData($model, 'usuario', 'nombres');
	}*/

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function cargarUsuarios(){
		$consulta_Usuarios = Yii::app()->db->createCommand("SELECT usuario, INITCAP(nombres) || ' ' || INITCAP(apellidos) AS nombres FROM usuario WHERE activo = TRUE ORDER BY nombres")->queryAll();
		$usuarios = CHtml::listData($consulta_Usuarios,'usuario', 'nombres');
	 	return $usuarios;
	}

	public function cargarUsuariosReemplazantes($usuario){
		$consulta_Usuarios = Yii::app()->db->createCommand(" SELECT usu.usuario, INITCAP(usu.nombres) || ' ' || INITCAP(usu.apellidos) AS nombres 
															 FROM usuario AS usu 
															 INNER JOIN usuarios_areas AS areas ON usu.usuario = areas.usuario
															 WHERE usu.activo = TRUE 
															 AND usu.usuario <> '$usuario'
															 AND usu.usuario <> '1'
															 AND areas.id_area = (SELECT id_area FROM usuarios_areas WHERE usuario = '$usuario')
															 ORDER BY nombres ")->queryAll();
		$usuarios = CHtml::listData($consulta_Usuarios,'usuario', 'nombres');
	 	return $usuarios;
	}

	public function nombres($documento){
		$usuario = Usuario::model()->findByAttributes(array("usuario"=>$documento));
		return ucwords(strtolower($usuario->nombres.' '.$usuario->apellidos));
	}
	//Validaciones Adicionales
	public function comparaAnterior(){
		$contra_ante = $this->model()->findByPk($this->id)->contraseña;
		if($contra_ante != md5($this->valida_contrasena)){
            $this->addError("valida_contrasena", "Contraseña Anterior no es correcta");
		}
	}

	public function validarFecha($attribute, $params){
		if($this->tipo_inhabilidad == 1 || $this->tipo_inhabilidad == 2){

			if($this->$attribute == ""){
	            $this->addError($attribute, $this->getAttributeLabel($attribute) . " no puede ser nulo.");
			}
		}
	}
	public function validarUsuario(){
		if($this->usuario == "0"){
			$this->addError("usuario", $this->getAttributeLabel('usuario')." No pueden ser 0.");
		}
	}
	public function nombreUsuario($usuario){
		$consulta = Usuario::model()->findByAttributes(array("usuario"=>$usuario));
		return ucwords(strtolower($consulta->nombres." ".$consulta->apellidos));
	}
	public function linkUsuario($usuario){
		$rows = UsuariosActividadTipologia::model()->countByAttributes(array("usuario"=>$usuario));
		if($rows > 0){
			return CHtml::link('<u>'.$usuario.'</u>', array('usuario/actividadTipologia','usuario'=>base64_encode($usuario)));
		}else{
			return $usuario;
		}
	}
	public static function envioNotificacionMail($nombres,$cuerpo)
	{	
		$img = '<img src="cid:alfa_encabezado" align="right">';
		//$img2 = '<h1 align="left"><img src="cid:alfa"></h1>';
		$mail = Usuario::model()->findByAttributes(array("usuario"=>Yii::app()->user->usuario));
		$meses = array('01'=>'Enero', '02'=>'Febrero', '03'=>'Marzo', '04'=>'Abril', '05'=>'Mayo', '06'=>'Junio', '07'=>'Julio', '08'=>'Agosto', '09'=>'Septiembre', '10'=>'Octubre', '11'=>'Noviembre', '12'=>'Diciembre');
		$mes = $meses[date("m")];
		$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
		//$mailer->Host = $_SERVER['HTTP_HOST'];
		$mailer->Host = "smtp.gmail.com";
		$mailer->Port = 587;
		$mailer->SMTPSecure = "tls";
		$mailer->SMTPAuth   = true;
		$mailer->IsSMTP();
		$mailer->From = 'pruebascorrespondencia@gmail.com';
		$mailer->Username   = "pruebascorrespondencia@gmail.com";
		$mailer->Password   = "imagine2017*";
		$mailer->AddAddress($mail->correo);
		$mailer->FromName = 'Seguros Alfa';
		$mailer->Priority = 1;
		$mailer->CharSet = 'UTF-8';
		$mailer->Subject = 'Detalle casos pendientes de tutela';
		//$mailer->AddEmbeddedImage('/var/www/html/correspondencia/images/seguros_alfa.jpg', 'alfa', 'seguros_alfa.jpg');
		$mailer->AddEmbeddedImage('/var/www/html/correspondencia/images/alfa_encabezado.png', 'alfa_encabezado', 'alfa_encabezado.png');
		$mailer->MsgHTML($img."<p><font><font>Bogot&aacute;, ".date('d')." de ".$mes." del ".date('Y')."</font></font></p>
    					  <p>&nbsp;</p><p><br/><br/><font><font>Se&ntilde;or (a):</font></font></p>
    					  <p><font><font>".$nombres."</font></font></p><p>&nbsp;</p><p>&nbsp;</p>
    					  <p><font><font>Reciba un cordial saludo del Sistema de Correspondencia.</font></font></p><p><font>
    					  <font>Se le han asignado casos de tutela los cuales debe gestionar lo mas pronto posible, 
    					  para gestionar haga click </font></font><a href='http://".$_SERVER['HTTP_HOST']."/index.php/trazabilidad/pendientes'>
    					  <font><font>aqui</font></font></a>,<p>&nbsp;<br></p><strong>Detalle de casos:</strong></p>".$cuerpo."
    					  <p>&nbsp;</p><p><br/><strong><font><font>Cordialmente</font></font></strong></p><p>&nbsp;</p><p>
    					  <font>Seguros Alfa ARL.</font></p><br><br><br>");
		$mailer->Send();
		return true;
	}
	public static function encabezadoTabla()
	{	
		return "<table border cellpadding=10 cellspacing=0 width='62%'>
			       <tr style='color:#04B486;' align='center'>
			         <td><strong>Caso</strong></td>
			         <td><strong>Fecha de Asignación</strong></td>
			         <td><strong>Actividad</strong></td>
			       </tr>";
	}
	public static function cuerpoTabla($id)
	{	
		$model = $mail = Trazabilidad::model()->findByAttributes(array("id"=>$id));
		return "<tr align='center'><td>".$model->na."</td>
         			<td>".date("d/m/Y"." - "."h:i:s a", strtotime($model->fecha_asign))."</td>
         			<td>".ucwords(strtolower($model->actividad0->idActividad->actividad))."</td>
         		</tr>";
		
	}
	public static function finalTabla($total)
	{	
		return "<tr align='center' style='color:#04B486;'>
		       		<td colspan='2'><strong>Total Casos</strong></td>
		       		<td><b>".$total."</b></td>
		       </tr></table>";
		
	}
}

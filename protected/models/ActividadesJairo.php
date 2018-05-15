<?php

/**
 * This is the model class for table "actividades".
 *
 * The followings are the available columns in table 'actividades':
 * @property integer $id
 * @property string $actividad
 * @property integer $tiempo_cliente
 * @property integer $tiempo_empresa
 *
 * The followings are the available model relations:
 * @property Flujo[] $flujos
 * @property Flujo[] $flujos1
 */
class ActividadesJairo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'actividades';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $buscar;
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('actividad', 'required'),
            array('tiempo_cliente, tiempo_empresa', 'numerical', 'integerOnly'=>true),
            //array('actividad','unique', 'message'=>'La actividad ya existe.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('buscar', 'safe'),
            array('id, actividad, tiempo_cliente, tiempo_empresa, buscar', 'safe', 'on'=>'search'),
            array('actividad', 'validaUnico'),
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
			'actividadTipologias' => array(self::HAS_MANY, 'ActividadTipologia', 'id_actividad'),
            'flujos' => array(self::HAS_MANY, 'Flujo', 'actividad'),
            'flujos1' => array(self::HAS_MANY, 'Flujo', 'sucesion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'actividad' => 'Actividad',
            'tiempo_cliente' => 'Tiempo Cliente',
            'tiempo_empresa' => 'Tiempo Empresa',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
        //$criteria->compare('actividad',$this->actividad,true);
        $criteria->compare('tiempo_cliente',$this->tiempo_cliente);
        $criteria->compare('tiempo_empresa',$this->tiempo_empresa);
        if(!empty($this->buscar)){
			$criteria->addCondition("actividad in (select actividad from actividades where actividad ilike '%".$this->buscar."%')");
		}


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Actividades the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function cargaActividades()
	{
	 	$actividades = CHtml::listData(Actividades::model()->findAll(array('order' => 'id')),'id','actividad');
	 	return $actividades;
	}
	public static function cierraActividad($trazabilidad)
	{
		//$model=Flujo::model()->findByPk($id);
		//$consulta = Trazabilidad::model()->findByAttributes(array("na"=>$na, "actividad"=>$flujo));
		$model=Trazabilidad::model()->findByPk($trazabilidad);
		$model->estado = "2";
		$model->user_cierre = Yii::app()->user->usuario;
		$model->fecha_cierre = "'now()'";
		if($model->save()){
			$delAusente = AusenteTrazabilidad::model()->deleteAllByAttributes(array("id_trazabilidad"=>$model->id));
			return $model->actividad;
		}else{
			return false;
		}
	}
	/*public static function abrirActividad($na,$flujo,$trazabilidad)
	{
	if(!$actividadesAbiertas = Actividades::actividadesAbiertas($na)){
			$sucesiones = Actividades::sucesionActividad($flujo);
			foreach ($sucesiones as $sucesion) {
					$model = new Trazabilidad;
					$model->user_asign = UsuariosActividadTipologia::asignacionUsuarioActividad($sucesion->hasta);
					$model->na = $na;
					$model->estado = "1";
					$model->actividad = $sucesion->hasta;
					$model->save();
			}	
		}
		return true;
	}*/
	public static function abrirActividad($na,$flujo,$trazabilidad){
		$devolucion = Devoluciones::model()->findByAttributes(array('hasta'=>$trazabilidad));
		if($devolucion){
			$traza = Trazabilidad::model()->findByPk($devolucion->desde);
			$traza->estado = "1";
			$traza->save();
			Actividades::notificacion($traza->id, $traza->user_asign);
			if($devolucion->delete()){
				return true;
			}
			else
				return false;
		}
		else {

			$sucesiones1 = Actividades::sucesionActividad($flujo);
			if($actividadesAbiertas = Actividades::actividadesAbiertas($na)){
				$aux = true;
				$aux2 = true;	
				$contador = 0;
				foreach ($sucesiones1 as $sucesion1) {
						foreach ($actividadesAbiertas as $actividad) {
							$sucesiones2 = Actividades::sucesionActividad($actividad->actividad);
							foreach ($sucesiones2 as $sucesion2) {
								if($sucesion1->hasta == $sucesion2->hasta){
									$contador ++;
								}
							}
						}				
				}
				if($contador > 0){
					$aux = false;
				}
				if($aux){
					$consultaAdicional = 0;
					foreach ($sucesiones1 as $sucesion3) {
						$consulta = Relaciones::model()->countByAttributes(array("hasta"=>$sucesion3->hasta));
						if($consulta > 1){
							$consultaAdicional ++;
						}
					}
					if($consultaAdicional > 0){
						$aux2 = false;
					}
				}
				if($aux && $aux2){
					$abreFlujo = Actividades::abreFlujo($sucesiones1,$na);
				}		
			}else{
				$abreFlujo = Actividades::abreFlujo($sucesiones1,$na);
			}
			return true;
		}
	}

	public function reabrirActividad($traza, $actividad){
		$trazabilidad = Trazabilidad::model()->findByAttributes(array('na'=>$traza->na, 'actividad'=>$actividad));
		$trazabilidad->estado = 1;
		$trazabilidad->user_cierre = null;
		$trazabilidad->fecha_cierre = null;
		$devolucion = new Devoluciones;
		$devolucion->desde = $traza->id;
		$devolucion->hasta = $trazabilidad->id;
		if($trazabilidad->save() && $devolucion->save()){
			return true;
			Actividades::notificacion($trazabilidad->id, $trazabilidad->user_asign);
		}
		else 
			return false;
	}

	public static function sucesionActividad($flujo)
	{
		return Relaciones::model()->findAllByAttributes(array("desde"=>$flujo));
	}
	public static function consultaActividad($flujo)
	{
		$actividad = Flujo::model()->findByAttributes(array("id"=>$flujo));
		return $flujo->actividad;
	}
	public static function actividadesAbiertas($na)
	{
		return Trazabilidad::model()->findAllByAttributes(array("na"=>$na, "estado"=>"1"));
	}
	public function validaUnico(){
		$permitidos = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ ";
		$aux = true;
		for ($i=0; $i<strlen($this->actividad); $i++){ 
	    	if (strpos($permitidos, substr($this->actividad,$i,1))===false){
	      		$aux = false;
	      	} 
	   	}
	   	if(!$aux){
	    	$this->addError("actividad", $this->getAttributeLabel('actividad')." no puede tener caracteres especiales.");	
	   	}else{
			$criteriaVal = new CDbCriteria;
			$criteriaVal->addCondition("TRIM(actividad) ILIKE '".trim($this->actividad)."'");
			if(!$this->isNewRecord){
				$criteriaVal->addNotInCondition('id', array($this->id));
			}

			$duplicados = Actividades::model()->findAll($criteriaVal);

			if($duplicados){
				$this->addError('actividad', 'La actividad ya existe en el sistema.');
			}
		}
	}
	public static function traerActividades($tipologia){
		return ActividadTipologia::model()->findAllByAttributes(array("id_tipologia"=>$tipologia, 'activo'=>true));	
	}
	public static function getActividad($id){
		$model=Actividades::model()->findByPk($id);
		return ucwords(strtolower($model->actividad));
	}
	public static function getActividades($na){
		return Trazabilidad::model()->findAllByAttributes(array("na"=>$na, "estado"=>"1"));
	}
	public static function traerAnterior($flujo){

		return Relaciones::model()->findAllByAttributes(array("hasta"=>$flujo));
	}
	public static function abreFlujo($sucesiones,$na){
		foreach ($sucesiones as $sucesion) {
				$model = new Trazabilidad;
				$model->user_asign = UsuariosActividadTipologia::asignacionUsuarioActividad($sucesion->hasta);
				$model->na = $na;
				$model->estado = "1";
				$model->actividad = $sucesion->hasta;
				$model->save();
				Actividades::notificacion($model->id, $model->user_asign);
		}
		return true;
	}
	public static function notificacion($id_trazabilidad, $usuario){
		$model = Yii::app()->db->createCommand("SELECT recep.na 
												FROM trazabilidad AS traza 
												INNER JOIN recepcion AS recep
												ON traza.na = recep.na
												INNER JOIN tipologias AS tipo
												ON recep.tipologia = tipo.id
												WHERE traza.id = ".$id_trazabilidad."
												AND tipo.tutela = true")->queryScalar();

		if($model){
			$tabla = Usuario::encabezadoTabla().Usuario::cuerpoTabla($id_trazabilidad);
			$img = '<img src="cid:alfa_encabezado" align="right">';
			$mail = Usuario::model()->findByAttributes(array("usuario"=>$usuario));
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
			$mailer->Subject = 'Notificación caso: [CASO - '.$model.']';
			$mailer->AddEmbeddedImage('/var/www/html/correspondencia/images/alfa_encabezado.png', 'alfa_encabezado', 'alfa_encabezado.png');
			$mailer->MsgHTML($img."<p><font><font>Bogot&aacute;, ".date('d')." de ".$mes." del ".date('Y')."</font></font></p>
	    					  <p>&nbsp;</p><p><br/><br/><font><font>Se&ntilde;or (a):</font></font></p>
	    					  <p><font><font>".ucwords(strtolower($mail->nombres." ".$mail->apellidos))."</font></font></p><p>&nbsp;</p><p>&nbsp;</p>
	    					  <p><font><font>Reciba un cordial saludo del Sistema de Correspondencia.</font></font></p><p><font>
	    					  <font>Se le ha asignado el caso ".$model." de tutela el cual debe gestionar lo mas pronto posible, 
	    					  para gestionar haga click </font></font><a href='http://".$_SERVER['HTTP_HOST']."/index.php/trazabilidad/index?na=".base64_encode($model)."'>
	    					  <font><font>aqui</font></font></a>,<p>&nbsp;<br></p><strong>Detalle del caso:</strong></p>".$tabla."</table>
    					  	  <p>&nbsp;</p><p><br/><strong><font><font>Cordialmente</font></font></strong></p><p>&nbsp;</p><p>
    					  	  <font>Seguros Alfa ARL.</font></p><br><br><br>");
			$mailer->Send();
		}
		return true;
	}

	public static function devolverActividad($trazabilidad)
	{
		//$model=Flujo::model()->findByPk($id);
		//$consulta = Trazabilidad::model()->findByAttributes(array("na"=>$na, "actividad"=>$flujo));
		$model=Trazabilidad::model()->findByPk($trazabilidad);
		$model->estado = "4";
		$model->user_cierre = Yii::app()->user->usuario;
		$model->fecha_cierre = "'now()'";
		if($model->save()){
			$delAusente = AusenteTrazabilidad::model()->deleteAllByAttributes(array("id_trazabilidad"=>$model->id));
			return $model->actividad;
		}else{
			return false;
		}
	}

}

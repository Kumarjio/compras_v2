<?php

/**
 * This is the model class for table "cartas".
 *
 * The followings are the available columns in table 'cartas':
 * @property string $id
 * @property string $na
 * @property integer $id_trazabilidad
 * @property integer $id_plantilla
 * @property string $carta
 * @property string $nombre_destinatario
 * @property integer $id_tipo_entrega
 * @property integer $id_proveedor
 * @property integer $punteo
 * @property integer $impreso
 * @property string $principal
 * @property integer $id_firma
 * @property string $direccion
 * @property string $id_ciudad
 * @property string $correo
 * @property string $telefono
 * @property string $fecha_respuesta
 * @property string $usuario_respuesta
 * @property string $fecha_impresion
 *
 * The followings are the available model relations:
 * @property Recepcion $na0
 * @property Trazabilidad $idTrazabilidad
 * @property PlantillasCartas $idPlantilla
 * @property TipoEntrega $idTipoEntrega
 * @property Proveedores $idProveedor
 * @property Firmas $idFirma
 * @property Ciudad $idCiudad
 * @property Usuario $usuarioRespuesta
 */
class Cartas extends CActiveRecord
{
	public $buscar;
	public $departamento;
	public $telefonoCarta;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cartas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('na, id_trazabilidad, id_plantilla, carta, nombre_destinatario, id_tipo_entrega, id_proveedor, fecha_respuesta, usuario_respuesta', 'required'),
			array('id_trazabilidad, id_plantilla, id_tipo_entrega, id_proveedor, punteo, impreso, id_firma', 'numerical', 'integerOnly'=>true),
			array('principal, direccion, id_ciudad, correo, telefono, departamento, fecha_impresion, buscar, telefonoCarta', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, na, id_trazabilidad, id_plantilla, carta, nombre_destinatario, id_tipo_entrega, id_proveedor, punteo, impreso, principal, id_firma, direccion, id_ciudad, correo, telefono, fecha_respuesta, usuario_respuesta, fecha_impresion, buscar', 'safe', 'on'=>'search'),
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
			'na0' => array(self::BELONGS_TO, 'Recepcion', 'na'),
			'idTrazabilidad' => array(self::BELONGS_TO, 'Trazabilidad', 'id_trazabilidad'),
			'idPlantilla' => array(self::BELONGS_TO, 'PlantillasCartas', 'id_plantilla'),
			'idTipoEntrega' => array(self::BELONGS_TO, 'TipoEntrega', 'id_tipo_entrega'),
			'idProveedor' => array(self::BELONGS_TO, 'Proveedores', 'id_proveedor'),
			'idFirma' => array(self::BELONGS_TO, 'Firmas', 'id_firma'),
			'idCiudad' => array(self::BELONGS_TO, 'Ciudad', 'id_ciudad'),
			'usuarioRespuesta' => array(self::BELONGS_TO, 'Usuario', 'usuario_respuesta'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'na' => 'No. Recepción',
			'id_trazabilidad' => 'Trazabilidad',
			'id_plantilla' => 'Plantilla',
			'carta' => 'Carta',
			'nombre_destinatario' => 'Nombre Destinatario',
			'id_tipo_entrega' => 'Tipo Entrega',
			'id_proveedor' => 'Proveedor',
			'punteo' => 'Punteo',
			'impreso' => 'Impreso',
			'principal' => 'Principal',
			'id_firma' => 'Firma',
			'direccion' => 'Dirección',
			'id_ciudad' => 'Ciudad',
			'correo' => 'Correo',
			'telefono' => 'Teléfono',
			'fecha_respuesta' => 'Fecha Respuesta',
			'usuario_respuesta' => 'Usuario Respuesta',
			'fecha_impresion' => 'Fecha Impresión',
			'buscar' => 'Buscar',
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

		$criteria->compare('id',$this->id,true);

		$criteria->compare('na',$this->na);
		$criteria->compare('id_trazabilidad',$this->id_trazabilidad);
		$criteria->compare('id_plantilla',$this->id_plantilla);
		$criteria->compare('carta',$this->carta,true);
		$criteria->compare('nombre_destinatario',$this->nombre_destinatario,true);
		$criteria->compare('id_tipo_entrega',$this->id_tipo_entrega);
		$criteria->compare('id_proveedor',$this->id_proveedor);
		//$criteria->compare('punteo',$this->punteo);
		//$criteria->compare('impreso',$this->impreso);
		//$criteria->compare('principal',$this->principal,true);
		$criteria->compare('id_firma',$this->id_firma);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('id_ciudad',$this->id_ciudad,true);
		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('fecha_respuesta',$this->fecha_respuesta,true);
		$criteria->compare('usuario_respuesta',$this->usuario_respuesta,true);
		$criteria->compare('fecha_impresion',$this->fecha_impresion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchFisicas()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('CAST(na AS TEXT)',$this->buscar, true);
		$criteria->compare('id_trazabilidad',$this->id_trazabilidad);
		$criteria->compare('id_plantilla',$this->id_plantilla);
		$criteria->compare('carta',$this->carta,true);
		$criteria->compare('nombre_destinatario',$this->nombre_destinatario,true);
		$criteria->compare('id_tipo_entrega', 2);
		$criteria->compare('id_proveedor',$this->id_proveedor);
		$criteria->compare('punteo', 1);
		//$criteria->compare('impreso',$this->impreso);
		//$criteria->compare('principal',$this->principal,true);
		$criteria->compare('id_firma', 2);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('id_ciudad',$this->id_ciudad,true);
		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('fecha_respuesta',$this->fecha_respuesta,true);
		$criteria->compare('usuario_respuesta',$this->usuario_respuesta,true);
		$criteria->compare('fecha_impresion',$this->fecha_impresion,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function search_impresion()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('CAST(na AS TEXT)',$this->buscar, true);
		$criteria->compare('id_trazabilidad',$this->id_trazabilidad);
		$criteria->compare('id_plantilla',$this->id_plantilla);
		$criteria->compare('carta',$this->carta,true);
		$criteria->compare('nombre_destinatario',$this->nombre_destinatario,true);
		$criteria->compare('id_tipo_entrega', 2);
		$criteria->compare('id_proveedor',$this->id_proveedor);
		//$criteria->compare('punteo', 1);
		$criteria->addCondition("t.punteo <> 0");
		//$criteria->compare('impreso', 0);
		$criteria->addInCondition('impreso', array(0, 1));
		//$criteria->compare('principal',$this->principal,true);
		//$criteria->compare('id_firma', 1);
		$criteria->addInCondition('id_firma', array(1, 3));
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('id_ciudad',$this->id_ciudad,true);
		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('fecha_respuesta',$this->fecha_respuesta,true);
		$criteria->compare('usuario_respuesta',$this->usuario_respuesta,true);
		//$criteria->compare('fecha_impresion',$this->fecha_impresion);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cartas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeValidate(){		
		$this->usuario_respuesta = Yii::app()->user->usuario;
		$this->fecha_respuesta = date("Y-m-d H:i:s");

		if($this->id_tipo_entrega == "1"){
			$this->validatorList->add(CValidator::createValidator('required', $this, 'correo'));
			$this->id_ciudad = null;
			$this->direccion = null;
			$this->telefono = null;
			$this->id_firma = null;
		}elseif($this->id_tipo_entrega == "2"){
			$this->validatorList->add(CValidator::createValidator('required', $this, 'departamento'));
			$this->validatorList->add(CValidator::createValidator('required', $this, 'id_ciudad'));
			$this->validatorList->add(CValidator::createValidator('required', $this, 'direccion'));
			//$this->validatorList->add(CValidator::createValidator('required', $this, 'telefono'));
			$this->validatorList->add(CValidator::createValidator('required', $this, 'id_firma'));
			$this->correo = null;
		}

		return parent::beforeValidate();
	}

	public static function actualizaCarta($na,$carta)
	{
		$actualiza = Cartas::model()->updateAll(array('carta'=>$carta),'na = '.$na.'');
		if($actualiza){
			return true;
		}else{
			return false;
		}
	}
	public static function clasificacionCarta($id_trazabilidad){
		$cartas = Cartas::model()->findAllByAttributes(array("id_trazabilidad"=>$id_trazabilidad));
    	foreach ($cartas as $carta){
			if($carta->id_tipo_entrega == "1"){
				$carta->envioCartasMail();
			}elseif($carta->id_tipo_entrega == "2"){
				$carta->punteo = 1;
				$carta->departamento = $carta->idCiudad->id_departamento;
				$carta->save();
			}
		}
		return true;
	}
	public static function actualizaCartas($id_trazabilidad, $mensaje){
		$cartas = Cartas::model()->findAllByAttributes(array("id_trazabilidad"=>$id_trazabilidad));
    	foreach ($cartas as $carta){
    		$carta->carta = $mensaje;
    		$carta->fecha_respuesta = date("Y-m-d H:i:s");
    		$carta->carta = $carta->encabezadosCartas().$carta->carta.$carta->finalCarta();
    		if($carta->id_tipo_entrega == "2"){
    			$carta->departamento = $carta->idCiudad->id_departamento;
    		}
			$carta->save();
		}
		return true;
	}

	public static function consultaExcel()
	{
		return Cartas::model()->findAllByAttributes(array("punteo"=>2, "id_tipo_entrega"=>2, "id_proveedor"=>2, "id_firma"=>2));
	}
	public static function actualizaPunteo($id)
	{	
		return Cartas::model()->updateAll(array('punteo'=>'3'),'id ='.$id);
	}
	public static function consultaExcel472()
	{
		return Cartas::model()->findAllByAttributes(array("punteo"=>2, "id_tipo_entrega"=>2, "id_proveedor"=>1, "id_firma"=>2));
	}
	public static function validaMail($mail)
	{
		if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    		return true;
		}else{
			return false;
		}
		
	}
	public static function guardaMail($mail,$id_cartas)
	{
		$model = new CartasMail;
		$model->id_cartas = $id_cartas;
		$model->mail = $mail;
		if($model->save()){
			return true;
		}else{
			print_r($model->getErrors());
			die;
			return false;
		}
	}
	public function envioCartasMail(){	
		$img = '<img src="cid:img_encabezado" align="right">';
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
		$mailer->AddAddress($this->correo);
		$mailer->FromName = 'ARL Alfa';
		$mailer->Priority = 1;
		$mailer->CharSet = 'UTF-8';
		$mailer->Subject = 'Respuesta caso: [CASO - '.$this->na.']';
		$mailer->AddEmbeddedImage('/var/www/html/correspondencia/images/alfa_encabezado.png', 'img_encabezado', 'alfa_encabezado.png');
		//Agregar adjuntos
		$adjuntos = AdjuntosRespuesta::model()->findAllByAttributes(array("id_trazabilidad"=>$this->id_trazabilidad));
    	foreach ($adjuntos as $adjunto){
    		$mailer->AddAttachment($adjunto->path_fisico, $adjunto->nombre_adjunto);
    	}
		$mailer->MsgHTML($img.$this->carta);
		return $mailer->Send();
	}
	public function creaPdf(){
		$imagen = dirname(__FILE__).'/../images/';

		$ruta = '/vol2/img04/archivos_tmp/';
		$nombre_archivo = 'tmp_'.$this->id.'.pdf';
		$mPDF1 = Yii::app()->ePdf->mpdf();
        $mPDF1->WriteHTML($this->encabezadosCartas().$this->carta.$this->finalCarta());
        $mPDF1->Output($ruta.$nombre_archivo, 'F');

		$path = 'http://'.$_SERVER['HTTP_HOST'].'/img04/archivos_tmp/'.$nombre_archivo;

		return CHtml::link('<img src="/images/pdf.png" width="27px" height="27px">',$path, array('class'=>'ficebox'));
	}
	public function encabezadosCartas(){
		$encabezado = EncabezadoFinalCartas::model()->findByAttributes(array("id_plantillas_cartas"=>$this->id_plantilla));

		$meses = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
		$mes = $meses[date("m")];

		$cartaFinal = $encabezado->encabezado;
		$cartaFinal = str_replace("[dia]", date("d"), $cartaFinal);
		$cartaFinal = str_replace("[mes]", $mes, $cartaFinal);
		$cartaFinal = str_replace("[ano]", date("Y"), $cartaFinal);

		$cartaFinal = str_replace("[nombre_destinatario]", ucwords(strtolower($this->nombre_destinatario)), $cartaFinal);
		$cartaFinal = str_replace("[direccion]", ucwords(strtolower($this->direccion)), $cartaFinal);
		$cartaFinal = str_replace("[ciudad]", ucwords(strtolower($this->idCiudad->nombre_ciudad)), $cartaFinal);
		$cartaFinal = str_replace("[departamento]", ucwords(strtolower($this->idCiudad->idDepartamento->nombre_departamento)), $cartaFinal);

		if(!empty($this->telefono)){
			$cartaFinal = str_replace("[telefono]", $this->telefono, $cartaFinal);
		}elseif(!empty($this->telefonoCarta)){
			$cartaFinal = str_replace("[telefono]", $this->telefonoCarta, $cartaFinal);
		}else{
			$cartaFinal = str_replace("[telefono]", "", $cartaFinal);
		}

		return $cartaFinal;
	}
	public function finalCarta(){
		$finalCarta = EncabezadoFinalCartas::model()->findByAttributes(array("id_plantillas_cartas"=>$this->id_plantilla));
		return $finalCarta->final;
	}
	public static function cartasComunes($id_trazabilidad, $na, $destinatario, $id_comun){
		$comun = CargueComun::model()->findByAttributes(array("id"=>$id_comun));
		$carta = PlantillasCartas::model()->findByAttributes(array("id"=>"2"));
		$model = new Cartas;
		$model->na = $na;
		$model->id_trazabilidad = $id_trazabilidad;
		$model->id_plantilla = $carta->id;
		$model->id_tipo_entrega = "2";
		$model->id_proveedor = "2";
		$model->punteo = "1";
		$model->id_firma = "3";
		$model->usuario_respuesta = Yii::app()->user->usuario;		

		$cuerpo = str_replace("[diagnostico]",ucwords(strtolower($comun->diagnostico)),$carta->plantilla);
		$final = $model->finalCarta();
		if($destinatario['principal']){
			$model->nombre_destinatario = ucwords(strtolower($comun->nombre));
			$model->principal = "Si";
			$model->direccion = $comun->direccion;
			$model->id_ciudad = $comun->ciudad;
			$model->departamento = $comun->ciudad0->id_departamento;
			$model->telefonoCarta = $comun->telefono;
			
			if(!empty($comun->telefono_empresa)){
				$final = str_replace("[telefono_empresa]",ucwords(strtolower($comun->telefono_empresa)),$final);
			}else{
				$final = str_replace("[telefono_empresa]","",$final);
			}
			if(!empty($comun->telefono_eps)){
				$final = str_replace("[telefono_eps]",ucwords(strtolower($comun->telefono_eps)),$final);
			}else{
				$final = str_replace("[telefono_eps]","",$final);
			}
			if(!empty($comun->telefono_afp)){
				$final = str_replace("[telefono_afp]",ucwords(strtolower($comun->telefono_afp)),$final);
			}else{
				$final = str_replace("[telefono_afp]","",$final);
			}
			$final = str_replace("[nombre_de_la_empresa]",ucwords(strtolower($comun->nombre_empresa)),$final);
			$final = str_replace("[direccion_empresa]",ucwords(strtolower($comun->direccion_empresa)),$final);
			$final = str_replace("[ciudad_empresa]",ucwords(strtolower($comun->ciudadEmpresa->nombre_ciudad)),$final);
			$final = str_replace("[eps]",ucwords(strtolower($comun->eps)),$final);
			$final = str_replace("[direccion_eps] ",ucwords(strtolower($comun->direccion_eps)),$final);
			$final = str_replace("[ciudad_eps]",ucwords(strtolower($comun->ciudadEps->nombre_ciudad)),$final);
			$final = str_replace("[afp]",ucwords(strtolower($comun->afp)),$final);
			$final = str_replace("[direccion_afp]",ucwords(strtolower($comun->direccion_afp)),$final);
			$final = str_replace("[ciudad_afp]",ucwords(strtolower($comun->ciudadAfp->nombre_ciudad)),$final);
			$final = str_replace("[siniestro]",ucwords(strtolower($comun->diagnostico)),$final);
			$final = str_replace("[usuario_creacion]",Usuario::model()->nombres(Yii::app()->user->usuario),$final);
		}else if($destinatario['empresa']){
			$model->nombre_destinatario = ucwords(strtolower($comun->nombre_empresa));
			$model->direccion = $comun->direccion_empresa;
			$model->id_ciudad = $comun->ciudad_empresa;
			$model->departamento = $comun->ciudadEmpresa->id_departamento;
			$model->telefonoCarta = $comun->telefono_empresa;

			$inicio = explode("c.c.", $final);
			$terminal = explode("[siniestro]", $final);
			$final = $inicio[0].$terminal[1];
			$final = str_replace("[usuario_creacion]",Usuario::model()->nombres(Yii::app()->user->usuario),$final);
		}else if($destinatario['eps']){
			$model->nombre_destinatario = ucwords(strtolower($comun->eps));
			$model->direccion = $comun->direccion_eps;
			$model->id_ciudad = $comun->ciudad_eps;
			$model->departamento = $comun->ciudadEps->id_departamento;
			$model->telefonoCarta = $comun->telefono_eps;

			$inicio = explode("c.c.", $final);
			$terminal = explode("[siniestro]", $final);
			$final = $inicio[0].$terminal[1];
			$final = str_replace("[usuario_creacion]",Usuario::model()->nombres(Yii::app()->user->usuario),$final);
		}else if($destinatario['afp']){
			$model->nombre_destinatario = ucwords(strtolower($comun->afp));
			$model->direccion = $comun->direccion_afp;
			$model->id_ciudad = $comun->ciudad_afp;
			$model->departamento = $comun->ciudadAfp->id_departamento;
			$model->telefonoCarta = $comun->telefono_afp;

			$inicio = explode("c.c.", $final);
			$terminal = explode("[siniestro]", $final);
			$final = $inicio[0].$terminal[1];
			$final = str_replace("[usuario_creacion]",Usuario::model()->nombres(Yii::app()->user->usuario),$final);
		}
		$encabezado = $model->encabezadosCartas();
		$model->carta =  $encabezado.$cuerpo.$final;
		$model->save();
		return true;
	}
	public static function cartasPcl($id_trazabilidad, $na, $destinatario, $id_pcl){
		$pcl = CarguePcl::model()->findByAttributes(array("id"=>$id_pcl));
		$carta = PlantillasCartas::model()->findByAttributes(array("id"=>"3"));
		$model = new Cartas;
		$model->na = $na;
		$model->id_trazabilidad = $id_trazabilidad;
		$model->id_plantilla = $carta->id;
		$model->id_tipo_entrega = "2";
		$model->id_proveedor = "2";
		$model->punteo = "1";
		$model->id_firma = "3";
		$model->usuario_respuesta = Yii::app()->user->usuario;

		$cuerpo = $carta->plantilla;
		$cuerpo = str_replace("[porcentaje]",ucwords(strtolower($pcl->porcentaje)),$cuerpo);
		$cuerpo = str_replace("[fecha_de_estructuracion]",ucwords(strtolower($pcl->fecha_estructuracion)),$cuerpo);
		$cuerpo = str_replace("[diagnostico]",ucwords(strtolower($pcl->diagnostico)),$cuerpo);
		$cuerpo = str_replace("[meses]",$pcl->meses,$cuerpo);
		$cuerpo = str_replace("[meses_en_letras]",ucwords(strtolower($pcl->meses_letras)),$cuerpo);

		$final = $model->finalCarta();
		if($destinatario['principal']){
			$model->nombre_destinatario = ucwords(strtolower($pcl->nombre));
			$model->principal = "Si";
			$model->direccion = $pcl->direccion;
			$model->id_ciudad = $pcl->ciudad;
			$model->departamento = $pcl->ciudad0->id_departamento;			
			$model->telefonoCarta = $pcl->telefono;

			if(!empty($pcl->telefono_empresa)){
				$final = str_replace("[telefono_empresa]",ucwords(strtolower($pcl->telefono_empresa)),$final);
			}else{
				$final = str_replace("[telefono_empresa]","",$final);
			}
			if(!empty($pcl->telefono_eps)){
				$final = str_replace("[telefono_eps]",ucwords(strtolower($pcl->telefono_eps)),$final);
			}else{
				$final = str_replace("[telefono_eps]","",$final);
			}
			if(!empty($pcl->telefono_afp)){
				$final = str_replace("[telefono_afp]",ucwords(strtolower($pcl->telefono_afp)),$final);
			}else{
				$final = str_replace("[telefono_afp]","",$final);
			}
			$final = str_replace("[nombre_de_la_empresa]",ucwords(strtolower($pcl->nombre_empresa)),$final);
			$final = str_replace("[direccion_empresa]",ucwords(strtolower($pcl->direccion_empresa)),$final);
			$final = str_replace("[ciudad_empresa]",ucwords(strtolower($pcl->ciudadEmpresa->nombre_ciudad)),$final);
			$final = str_replace("[eps]",ucwords(strtolower($pcl->eps)),$final);
			$final = str_replace("[direccion_eps] ",ucwords(strtolower($pcl->direccion_eps)),$final);
			$final = str_replace("[ciudad_eps]",ucwords(strtolower($pcl->ciudadEps->nombre_ciudad)),$final);
			$final = str_replace("[afp]",ucwords(strtolower($pcl->afp)),$final);
			$final = str_replace("[direccion_afp]",ucwords(strtolower($pcl->direccion_afp)),$final);
			$final = str_replace("[ciudad_afp]",ucwords(strtolower($pcl->ciudadAfp->nombre_ciudad)),$final);
			$final = str_replace("[siniestro]",ucwords(strtolower($pcl->diagnostico)),$final);
			$final = str_replace("[usuario_creacion]",Usuario::model()->nombres(Yii::app()->user->usuario),$final);
		}else if($destinatario['empresa']){
			$model->nombre_destinatario = ucwords(strtolower($pcl->nombre_empresa));
			$model->direccion = $pcl->direccion_empresa;
			$model->id_ciudad = $pcl->ciudad_empresa;
			$model->departamento = $pcl->ciudadEmpresa->id_departamento;
			$model->telefonoCarta = $pcl->telefono_empresa;

			$inicio = explode("c.c.", $final);
			$terminal = explode("[siniestro]", $final);
			$final = $inicio[0].$terminal[1];
			$final = str_replace("[usuario_creacion]",Usuario::model()->nombres(Yii::app()->user->usuario),$final);
		}else if($destinatario['eps']){
			$model->nombre_destinatario = ucwords(strtolower($pcl->eps));
			$model->direccion = $pcl->direccion_eps;
			$model->id_ciudad = $pcl->ciudad_eps;
			$model->departamento = $pcl->ciudadEps->id_departamento;
			$model->telefonoCarta = $pcl->telefono_eps;

			$inicio = explode("c.c.", $final);
			$terminal = explode("[siniestro]", $final);
			$final = $inicio[0].$terminal[1];
			$final = str_replace("[usuario_creacion]",Usuario::model()->nombres(Yii::app()->user->usuario),$final);
		}else if($destinatario['afp']){
			$model->nombre_destinatario = ucwords(strtolower($pcl->afp));
			$model->direccion = $pcl->direccion_afp;
			$model->id_ciudad = $pcl->ciudad_afp;
			$model->departamento = $pcl->ciudadAfp->id_departamento;
			$model->telefonoCarta = $pcl->telefono_afp;

			$inicio = explode("c.c.", $final);
			$terminal = explode("[siniestro]", $final);
			$final = $inicio[0].$terminal[1];
			$final = str_replace("[usuario_creacion]",Usuario::model()->nombres(Yii::app()->user->usuario),$final);
		}
		$encabezado = $model->encabezadosCartas();
		$model->carta =  $encabezado.$cuerpo.$final;
		$model->save();
		return true;
	} 
}

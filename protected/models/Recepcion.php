<?php
/**
 * This is the model class for table "recepcion".
 *
 * The followings are the available columns in table 'recepcion':
 * @property string $na
 * @property string $documento
 * @property integer $tipologia
 * @property string $ciudad
 * @property integer $tipo_documento
 * @property string $user_recepcion
 * @property string $fecha_recepcion
 * @property integer $fecha_entrega
 * @property string $hora_entrega
 * @property string $fecha_cliente
 * @property string $fecha_interna
 *
 * The followings are the available model relations:
 * @property ObservacionRecepcion $observacionRecepcion
 * @property ObservacionesTrazabilidad[] $observacionesTrazabilidads
 * @property SucursalRecepcion $sucursalRecepcion
 * @property Trazabilidad[] $trazabilidads
 * @property Tipologias $tipologia0
 * @property TipoDocumento $tipoDocumento
 * @property Usuario $userRecepcion
 * @property Ciudad $ciudad0
 * @property AdjuntosTrazabilidad[] $adjuntosTrazabilidads
 * @property MailRecepcion[] $mailRecepcions
 * @property Cartas[] $cartases
 */
class Recepcion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'recepcion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $area;
	public $departamento;
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('documento, area, tipologia, ciudad, tipo_documento, fecha_entrega, fecha_interna, fecha_cliente, hora_entrega, departamento', 'required'),
			array('na, documento, tipologia, area, ciudad, tipo_documento, fecha_entrega, departamento', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('na, user_recepcion, fecha_entrega, fecha_cliente, fecha_interna, departamento','safe'),
			array('tipo_documento','validarTipoDoc'),
			array('area','validarArea'),
			array('tipologia','validarTipologia'),
			array('ciudad','validarCiudad'),
			array('hora_entrega','validarHora'),
			array('fecha_entrega','validarFecha'),			
			array('na, documento, tipologia, ciudad, tipo_documento, user_recepcion, fecha_recepcion, fecha_entrega, hora_entrega, fecha_cliente, fecha_interna, departamento', 'safe', 'on'=>'search'),
			array('documento','validarDocumento'),
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
            'observacionRecepcion' => array(self::HAS_ONE, 'ObservacionRecepcion', 'na'),
            'observacionesTrazabilidads' => array(self::HAS_MANY, 'ObservacionesTrazabilidad', 'na'),
            'sucursalRecepcion' => array(self::HAS_ONE, 'SucursalRecepcion', 'na'),
            'adjuntosRecepcions' => array(self::HAS_MANY, 'AdjuntosRecepcion', 'na'),
            'ciudad0' => array(self::BELONGS_TO, 'Ciudad', 'ciudad'),
            'tipologia0' => array(self::BELONGS_TO, 'Tipologias', 'tipologia'),
            'tipoDocumento' => array(self::BELONGS_TO, 'TipoDocumento', 'tipo_documento'),
            'userRecepcion' => array(self::BELONGS_TO, 'Usuario', 'user_recepcion'),
            'trazabilidads' => array(self::HAS_MANY, 'Trazabilidad', 'na'),
            'cartases' => array(self::HAS_MANY, 'Cartas', 'na'),
            'adjuntosTrazabilidads' => array(self::HAS_MANY, 'AdjuntosTrazabilidad', 'na'),
            'mailRecepcions' => array(self::HAS_MANY, 'MailRecepcion', 'na'),
        );

    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'na' => 'Na',
			'documento' => 'Documento',
			'tipologia' => 'Tipología',
			'ciudad' => 'Ciudad',
			'tipo_documento' => 'Tipo Documento',
			'user_recepcion' => 'User Recepcion',
			'fecha_recepcion' => 'Fecha Recepcion',
			'fecha_entrega' => 'Fecha Entrega',
			'hora_entrega' => 'Hora Entrega',
			//'punteo_cor' => 'Punteo Cor',
			//'impreso' => 'Impreso',
			'area' => 'Área',
			'fecha_cliente' => 'Fecha Cliente',
			'fecha_interna' => 'Fecha Interna',
			'departamento'=>'Departamento',
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

		$criteria->compare('na',$this->na);
		$criteria->compare('documento',$this->documento,true);
		$criteria->compare('tipologia',$this->tipologia);
		$criteria->compare('ciudad',$this->ciudad);
		$criteria->compare('tipo_documento',$this->tipo_documento);
		$criteria->compare('user_recepcion',$this->user_recepcion,true);
		$criteria->compare('fecha_recepcion',$this->fecha_recepcion,true);
		$criteria->compare('fecha_entrega',$this->fecha_entrega);
		$criteria->compare('hora_entrega',$this->hora_entrega,true);
		$criteria->compare('fecha_cliente',$this->fecha_cliente,true);
		$criteria->compare('fecha_interna',$this->fecha_interna,true);
		//$criteria->compare('punteo_cor',$this->punteo_cor);
		//$criteria->compare('impreso',$this->impreso);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Recepcion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/*public function validarCampos(){
        if ($this->tipo_documento == 1){
	    	if(empty($this->label)){
	    		$this->addError("label", $this->getAttributeLabel('label')." no puede ser nulo.");
	    	}
	    	if(empty($this->fecha_sucursal)){
	    		$this->addError("fecha_sucursal", $this->getAttributeLabel('fecha_sucursal')." no puede ser nulo.");
	    	}
	    	if(empty($this->hora_sucursal)){
	    		$this->addError("hora_sucursal", $this->getAttributeLabel('hora_sucursal')." no puede ser nulo.");
	    	}
   		}
	}*/

	public function validarTipoDoc(){
		$tipoDoc = TipoDocumento::model()->findByPk($this->tipo_documento);
		if(!$tipoDoc){
			$this->addError("tipo_documento", $this->getAttributeLabel('tipo_documento')." no existe.");
		}

	}
	public function validarArea(){
		$valArea = Areas::model()->findByPk($this->area);
		if(!$valArea){
			$this->addError("area", $this->getAttributeLabel('area')." no existe.");
		}
	}

	public function validarTipologia(){
		$valTipologia = Tipologias::model()->findByPk($this->tipologia);
		if(!$valTipologia){
			$this->addError("tipologia", $this->getAttributeLabel('tipologia')." no existe.");
		}else{
			if(!$valTipologia->activa){
				$this->addError("tipologia", $this->getAttributeLabel('tipologia')." inactiva.");
			}elseif(!$valTipologia->operacion){
				$this->addError("tipologia", $this->getAttributeLabel('tipologia')." sin flujo.");
			}elseif($valTipologia->area != $this->area){
				$this->addError("tipologia", $this->getAttributeLabel('tipologia')." no pertenece a la ".$this->getAttributeLabel('area'));
			}
		}
	}

	public function validarCiudad(){
		$valCuidad = Ciudad::model()->findByPk($this->ciudad);
		if(!$valCuidad){
			$this->addError("ciudad", $this->getAttributeLabel('ciudad')." no existe.");
		}
	}
	public function validarHora(){
		if(strlen($this->hora_entrega) == 5){
			$hora = substr($this->hora_entrega, 0, 2);
			$min = substr($this->hora_entrega, 3, 2);
			if (is_numeric($hora) && is_numeric($min)){
				if(($hora < 1) && ($hora > 23)){
					$this->addError("hora_entrega", $this->getAttributeLabel('hora_entrega')." inválida.");
				}else{
					if(($min < 0) && ($min > 59)){
						$this->addError("hora_entrega", $this->getAttributeLabel('hora_entrega')." inválida.");
					}
				}
			}else{
				$this->addError("hora_entrega", $this->getAttributeLabel('hora_entrega')." inválida.");
			}
		}else{
			$this->addError("hora_entrega", $this->getAttributeLabel('hora_entrega')." inválida.");
		}
	}
	public function validarFecha(){
		if(strlen($this->fecha_entrega) == 8){
			$ano = substr($this->fecha_entrega, 0, 4);
			$mes = substr($this->fecha_entrega, 4, 2);
			$dia = substr($this->fecha_entrega, 6, 2);

			if (is_numeric($ano) && is_numeric($mes) && is_numeric($dia)){
				if(!checkdate($mes, $dia, $ano)){
					$this->addError("fecha_entrega", $this->getAttributeLabel('fecha_entrega')." invalida.");
		   		}
		   	}else{
		   		$this->addError("fecha_entrega", $this->getAttributeLabel('fecha_entrega')." invalida.");
		   	}
		}
	}
	public function informacionRecepcion($na)
	{
		$recepcion = Recepcion::model()->findByAttributes(array("na"=>$na));
		return $recepcion;
	}
	public static function iniciaRecepcion($na, $tipologia){
		$trazabilidad = new Trazabilidad;
		//$tipologia = Tipologias::model()->getTipologia($na);	
		//$flujo = Flujo::model()->findByAttributes(array("tipologia"=>$tipologia),array('order'=>'id'));
		$flujo = ActividadTipologia::model()->findByAttributes(array("id_tipologia"=>$tipologia,"id_actividad"=>"1"),array('order'=>'id'));
		$trazabilidad->na = $na;
		$trazabilidad->user_asign = Yii::app()->user->usuario;
		$trazabilidad->estado = "1";
		$trazabilidad->actividad = $flujo->id;
		if($trazabilidad->save()){
			return $trazabilidad->id;
		}else{
			return false;
		}
	}
	public static function fechaCliente($tipologia){
		if(!empty($tipologia)){
			$dias = Tipologias::traerTiempo($tipologia);
			for($i = 1; $i <= $dias; $i++){
				$fecha_consulta = date('Ymd', strtotime('+'.$i.' days', strtotime(date('Ymd'))));
				if(Festivos::traerDiaFestivo($fecha_consulta)){
					$dias++;
				}
			}
			$fecha_cliente = date('Y/m/d', strtotime($fecha_consulta));
		}
		if(empty($fecha_cliente)){
			$fecha_cliente = date('Y/m/d');
		}
		return $fecha_cliente;
	}
	public static function fechaInterna($tipologia){
		$contador = 0;
		if(!empty($tipologia)){
			foreach (Actividades::traerActividades($tipologia) as $actividad) {
				$dias = $actividad->tiempo + $dias;
			}
			for($i = 1; $i <= $dias; $i++){
				$fecha_consulta = date('Ymd', strtotime('+'.$i.' days', strtotime(date('Ymd'))));
				if(Festivos::traerDiaFestivo($fecha_consulta)){
					$dias++;
				}
			}
			$fecha_interna = date('Y/m/d', strtotime($fecha_consulta));
		}
		if(empty($fecha_interna)){
			$fecha_interna = date('Y/m/d');
		}
		return $fecha_interna;
	}
	public function validarDocumento(){
		if($this->documento == "0"){
			$this->addError("documento", $this->getAttributeLabel('documento')." No pueden ser 0.");
		}
	}
}

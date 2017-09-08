<?php

/**
 * This is the model class for table "recepcion".
 *
 * The followings are the available columns in table 'recepcion':
 * @property integer $na
 * @property string $documento
 * @property integer $tipologia
 * @property integer $ciudad
 * @property integer $tipo_documento
 * @property string $user_recepcion
 * @property string $fecha_recepcion
 * @property integer $fecha_entrega
 * @property string $hora_entrega
 * @property integer $punteo_cor
 * @property integer $impreso
 *
 * The followings are the available model relations:
 * @property Ciudades $ciudad0
 * @property Tipologias $tipologia0
 * @property TipoDocumento $tipoDocumento
 * @property SucursalRecepcion $sucursalRecepcion
 * @property ObservacionRecepcion $observacionRecepcion
 * @property AdjuntosRecepcion[] $adjuntosRecepcions
 * @property Trazabilidad[] $trazabilidads
 * @property Cartas[] $cartases
 * @property ObservacionesTrazabilidad[] $observacionesTrazabilidads
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
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('documento, area, tipologia, ciudad, tipo_documento, fecha_entrega, hora_entrega', 'required'),
			array('na, tipologia, area, ciudad, tipo_documento, fecha_entrega, punteo_cor, impreso', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_recepcion','safe'),
			//array('tipo_documento','validarCampos'),
			array('na, documento, tipologia, ciudad, tipo_documento, user_recepcion, fecha_recepcion, fecha_entrega, hora_entrega, punteo_cor, impreso', 'safe', 'on'=>'search'),
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
            'ciudad0' => array(self::BELONGS_TO, 'Ciudades', 'ciudad'),
            'tipologia0' => array(self::BELONGS_TO, 'Tipologias', 'tipologia'),
            'tipoDocumento' => array(self::BELONGS_TO, 'TipoDocumento', 'tipo_documento'),
            'sucursalRecepcion' => array(self::HAS_ONE, 'SucursalRecepcion', 'na'),
            'observacionRecepcion' => array(self::HAS_ONE, 'ObservacionRecepcion', 'na'),
            'adjuntosRecepcions' => array(self::HAS_MANY, 'AdjuntosRecepcion', 'na'),
            'trazabilidads' => array(self::HAS_MANY, 'Trazabilidad', 'na'),
            'cartases' => array(self::HAS_MANY, 'Cartas', 'na'),
            'observacionesTrazabilidads' => array(self::HAS_MANY, 'ObservacionesTrazabilidad', 'na'),
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
			'tipologia' => 'Tipologia',
			'ciudad' => 'Ciudad',
			'tipo_documento' => 'Tipo Documento',
			'user_recepcion' => 'User Recepcion',
			'fecha_recepcion' => 'Fecha Recepcion',
			'fecha_entrega' => 'Fecha Entrega',
			'hora_entrega' => 'Hora Entrega',
			'punteo_cor' => 'Punteo Cor',
			'impreso' => 'Impreso',
			'label' => 'Label',
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
		$criteria->compare('punteo_cor',$this->punteo_cor);
		$criteria->compare('impreso',$this->impreso);

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
	public function informacionRecepcion($na)
	{
		$recepcion = Recepcion::model()->findByAttributes(array("na"=>$na));
		return $recepcion;
	}
}

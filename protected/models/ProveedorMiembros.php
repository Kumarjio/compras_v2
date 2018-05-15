<?php

/**
 * This is the model class for table "proveedor_miembros".
 *
 * The followings are the available columns in table 'proveedor_miembros':
 * @property integer $id
 * @property integer $nit
 * @property string $tipo_documento
 * @property string $documento_identidad
 * @property string $nombre_completo
 * @property string $participacion
 *
 * The followings are the available model relations:
 * @property Proveedor $nit0
 */
class ProveedorMiembros extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProveedorMiembros the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'proveedor_miembros';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nit, tipo_documento, documento_identidad, nombre_completo, participacion, porcentaje_participacion', 'required'),
			array('nit', 'numerical', 'integerOnly'=>true),
			array('porcentaje_participacion', 'numerical', 'integerOnly'=>false, 'min' => 0, 'max' => 100),
			array('tipo_documento, documento_identidad, nombre_completo, participacion', 'length', 'max'=>255),
			array('numero_identificacion', 'unico'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nit, tipo_documento, documento_identidad, nombre_completo, participacion', 'safe', 'on'=>'search'),
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
			'nit0' => array(self::BELONGS_TO, 'Proveedor', 'nit'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nit' => 'Nit',
			'tipo_documento' => 'Tipo Documento',
			'documento_identidad' => 'Documento Identidad',
			'nombre_completo' => 'Nombre Completo',
			'participacion' => 'Participacion',
		);
	}

	public function getParticipacion(){
		return array(
			array('id' => 'Representante Legal', 'valor' => 'Representante Legal'),
			array('id' => 'Accionista', 'valor' => 'Accionista')
		);
	}

	public function getTipoDoc(){
		return array(
			array('id' => 'CC', 'valor' => 'CC')			
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($nit)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition = "nit = :n";
		$criteria->params = array('n' => $nit);

		$criteria->compare('id',$this->id);
		$criteria->compare('nit',$this->nit);
		$criteria->compare('LOWER(tipo_documento)',strtolower($this->tipo_documento),true);
		$criteria->compare('documento_identidad',$this->documento_identidad,true);
		$criteria->compare('LOWER(nombre_completo)',strtolower($this->nombre_completo),true);
		$criteria->compare('LOWER(participacion)',strtolower($this->participacion),true);
		$criteria->compare('porcentaje_participacion', $this->porcentaje_participacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function unico(){
		if($this->documento_identidad != null and $this->tipo_documento != null and $this->nit != null){
			$empleado = ProveedorMiembros::model()->findByAttributes(array('tipo_documento' => $this->tipo_documento, 'documento_identidad' => $this->documento_identidad, 'nit' => $this->nit));
			if($empleado != null and $empleado->id != $this->id){
				$this->addError('documento_identidad','Ya existe un usuario con el tipo de documento y documento de identidad ingresados para este proveedor.');
			}
		}
		if($this->participacion != null and $this->participacion == "Representante Legal"){
			$pm = ProveedorMiembros::model()->findByAttributes(array('nit' => $this->nit, 'participacion' => "Representante Legal"));
			if($pm != null and $this->id != $pm->id){
				$this->addError('participacion','El representante legal ya fué ingresado.');
			}
		}
	}
	
}
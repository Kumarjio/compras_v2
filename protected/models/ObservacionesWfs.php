<?php

/**
 * This is the model class for table "observacioneswfs".
 *
 * The followings are the available columns in table 'observacioneswfs':
 * @property integer $id
 * @property string $model
 * @property integer $idmodel
 * @property integer $usuario
 * @property string $estado_anterior
 * @property string $estado_nuevo
 * @property string $observacion
 * @property string $fecha
 */
class ObservacionesWfs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObservacionesWfs the static model class
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
		return 'observacioneswfs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idmodel, usuario', 'numerical', 'integerOnly'=>true),
			array('model, estado_anterior, estado_nuevo', 'length', 'max'=>255),
			array('observacion, fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, model, idmodel, usuario, estado_anterior, estado_nuevo, observacion, fecha', 'safe', 'on'=>'search'),
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
			'idUsuario' => array(self::BELONGS_TO, 'Empleados', 'usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'model' => 'Model',
			'idmodel' => 'Idmodel',
			'usuario' => 'Usuario',
			'estado_anterior' => 'Estado Anterior',
			'estado_nuevo' => 'Estado Nuevo',
			'observacion' => 'Observacion',
			'fecha' => 'Fecha',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($tipo, $modelo)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->condition = 'model = :m and idmodel = :id';
		$criteria->params = array(':m' => $tipo, ':id' => $modelo);

		$criteria->compare('id',$this->id);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('idmodel',$this->idmodel);
		$criteria->compare('usuario',$this->usuario);
		$criteria->compare('LOWER(estado_anterior)',strtolower($this->estado_anterior),true);
		$criteria->compare('LOWER(estado_nuevo)',strtolower($this->estado_nuevo),true);
		$criteria->compare('LOWER(observacion)',strtolower($this->observacion),true);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
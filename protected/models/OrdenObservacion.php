<?php

/**
 * This is the model class for table "orden_observacion".
 *
 * The followings are the available columns in table 'orden_observacion':
 * @property integer $id
 * @property integer $id_orden
 * @property string $observacion
 * @property string $usuario
 * @property string $paso_wf
 * @property string $creacion
 *
 * The followings are the available model relations:
 * @property Orden $idOrden
 */
class OrdenObservacion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdenObservacion the static model class
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
		return 'orden_observacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('observacion, usuario, paso_wf, creacion', 'required'),
			array('id_orden', 'numerical', 'integerOnly'=>true),
			array('usuario, paso_wf', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_orden, observacion, usuario, paso_wf, creacion', 'safe', 'on'=>'search'),
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
			'idOrden' => array(self::BELONGS_TO, 'Orden', 'id_orden'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_orden' => 'Id Orden',
			'observacion' => 'Observacion',
			'usuario' => 'Usuario',
			'paso_wf' => 'Paso Wf',
			'creacion' => 'Creacion',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden',$this->id_orden);
		$criteria->compare('observacion',$this->observacion,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('paso_wf',$this->paso_wf,true);
		$criteria->compare('creacion',$this->creacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "adjuntos_cotizacion".
 *
 * The followings are the available columns in table 'adjuntos_cotizacion':
 * @property integer $id
 * @property integer $cotizacion
 * @property integer $path
 * @property string $tipi
 *
 * The followings are the available model relations:
 * @property Cotizacion $cotizacion0
 */
class AdjuntosOrden extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdjuntosCotizacion the static model class
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
		return 'adjuntos_orden';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orden, path, tipi, nombre, usuario', 'required'),
			array('orden', 'numerical', 'integerOnly'=>true),
			array('tipi, path', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, orden, path, tipi, nombre', 'safe', 'on'=>'search'),
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
			'orden0' => array(self::BELONGS_TO, 'Orden', 'orden'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'orden' => 'Orden',
			'path' => 'Path',
			'tipi' => 'Tipo archivo',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($cot)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition = "orden = :c";
		$criteria->params = array(':c' => $cot);

		$criteria->compare('id',$this->id);
		$criteria->compare('orden',$this->orden);
		$criteria->compare('nombre',$this->nombre, true);
		$criteria->compare('path',$this->path);
		$criteria->compare('tipi',$this->tipi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
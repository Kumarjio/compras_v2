<?php

/**
 * This is the model class for table "om_adjuntos_cotizacion".
 *
 * The followings are the available columns in table 'om_adjuntos_cotizacion':
 * @property integer $id
 * @property integer $om_cotizacion
 * @property string $nombre
 * @property string $usuario
 * @property string $tipi
 * @property string $path
 *
 * The followings are the available model relations:
 * @property OmCotizacion $omCotizacion
 */
class OmAdjuntosCotizacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'om_adjuntos_cotizacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('om_cotizacion, nombre, usuario, tipi', 'required'),
			array('om_cotizacion', 'numerical', 'integerOnly'=>true),
			array('nombre, usuario, tipi, path', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, om_cotizacion, nombre, usuario, tipi, path', 'safe', 'on'=>'search'),
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
			'omCotizacion' => array(self::BELONGS_TO, 'OmCotizacion', 'om_cotizacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'om_cotizacion' => 'Om Cotizacion',
			'nombre' => 'Nombre',
			'usuario' => 'Usuario',
			'tipi' => 'Tipi',
			'path' => 'Path',
		);
	}

	public function search($cot)
	{
		
		$criteria=new CDbCriteria;
		$criteria->condition = "om_cotizacion = :c";
		$criteria->params = array(':c' => $cot);

		$criteria->compare('id',$this->id);
		$criteria->compare('om_cotizacion',$this->om_cotizacion);
		$criteria->compare('nombre',$this->nombre, true);
		$criteria->compare('path',$this->path);
		$criteria->compare('tipi',$this->tipi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "permisos".
 *
 * The followings are the available columns in table 'permisos':
 * @property integer $id
 * @property integer $controllador_accion
 * @property string $creacion
 * @property string $actualizacion
 */
class Permisos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Permisos the static model class
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
		return 'permisos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('controllador_accion', 'required'),
			array('controllador_accion', 'numerical', 'integerOnly'=>true),
			array('creacion, actualizacion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, controllador_accion, creacion, actualizacion', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'controllador_accion' => 'Controllador Accion',
			'creacion' => 'Creacion',
			'actualizacion' => 'Actualizacion',
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
		$criteria->compare('controllador_accion',$this->controllador_accion);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('actualizacion',$this->actualizacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "adjuntos_willies".
 *
 * The followings are the available columns in table 'adjuntos_willies':
 * @property integer $id
 * @property integer $id_willies
 * @property string $nombre
 * @property string $usuario
 * @property string $tipi
 * @property string $path
 */
class AdjuntosWillies extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdjuntosWillies the static model class
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
		return 'adjuntos_willies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_willies', 'numerical', 'integerOnly'=>true),
			array('nombre, usuario, tipi, path', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_willies, nombre, usuario, tipi, path', 'safe', 'on'=>'search'),
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
			'id_willies' => 'Id Willies',
			'nombre' => 'Nombre',
			'usuario' => 'Usuario',
			'tipi' => 'Tipo',
			'path' => 'Path',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id_w)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		 		
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('id_willies',$id_w);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('tipi',$this->tipi,true);
		$criteria->compare('path',$this->path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "adjuntos_vpj".
 *
 * The followings are the available columns in table 'adjuntos_vpj':
 * @property integer $id
 * @property integer $id_vpj
 * @property string $nombre
 * @property string $usuario
 * @property string $pipi
 * @property string $path
 */
class AdjuntosVpj extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdjuntosVpj the static model class
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
		return 'adjuntos_vpj';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_vpj, nombre, usuario, tipi, path', 'required'),
			array('id_vpj', 'numerical', 'integerOnly'=>true),
			array('nombre, usuario, tipi, path', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_vpj, nombre, usuario, tipi, path', 'safe', 'on'=>'search'),
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
			'vinculacion_proveedor_juridico' => array(self::BELONGS_TO, 'VinculacionProveedorJuridico', 'id_vpj'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_vpj' => 'Id Vpj',
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
	public function search($id_vpj)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition = "id_vpj = :c";
		$criteria->params = array(':c' => $id_vpj);
		$criteria->compare('id',$this->id);
		$criteria->compare('id_vpj',$this->id_vpj);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('tipi',$this->tipi,true);
		$criteria->compare('path',$this->path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "trazabiliadwfs".
 *
 * The followings are the available columns in table 'trazabiliadwfs':
 * @property integer $id
 * @property string $model
 * @property integer $idmodel
 * @property integer $usuario_anterior
 * @property integer $usuario_nuevo
 * @property string $estado_anterior
 * @property string $estado_nuevo
 * @property string $fecha
 */
class TrazabilidadWfs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TrazabilidadWfs the static model class
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
		return 'trazabiliadwfs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idmodel, usuario_anterior, usuario_nuevo', 'numerical', 'integerOnly'=>true),
			array('model, estado_anterior, estado_nuevo', 'length', 'max'=>255),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, model, idmodel, usuario_anterior, usuario_nuevo, estado_anterior, estado_nuevo, fecha', 'safe', 'on'=>'search'),
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
			'model' => 'Model',
			'idmodel' => 'Idmodel',
			'usuario_anterior' => 'Usuario Anterior',
			'usuario_nuevo' => 'Usuario Nuevo',
			'estado_anterior' => 'Estado Anterior',
			'estado_nuevo' => 'Estado Nuevo',
			'fecha' => 'Fecha',
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
		$criteria->compare('model',$this->model,true);
		$criteria->compare('idmodel',$this->idmodel);
		$criteria->compare('usuario_anterior',$this->usuario_anterior);
		$criteria->compare('usuario_nuevo',$this->usuario_nuevo);
		$criteria->compare('estado_anterior',$this->estado_anterior,true);
		$criteria->compare('estado_nuevo',$this->estado_nuevo,true);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_2($model, $idmodel)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('model',$model,true);
		$criteria->compare('idmodel',$idmodel);
		$criteria->compare('usuario_anterior',$this->usuario_anterior);
		$criteria->compare('usuario_nuevo',$this->usuario_nuevo);
		$criteria->compare('estado_anterior',$this->estado_anterior,true);
		$criteria->compare('estado_nuevo',$this->estado_nuevo,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->select = array(
                                  '(select nombre_completo from empleados where id = t.usuario_anterior) as usuario_anterior',
                                  '(select nombre_completo from empleados where id = t.usuario_nuevo) as usuario_nuevo',
                                  'fecha',
                                  'estado_anterior',
                                  'estado_nuevo'
                                  );


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination'=>array('pageSize'=>500),
		));

	}
}
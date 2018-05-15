<?php

/**
 * This is the model class for table "contratos".
 *
 * The followings are the available columns in table 'contratos':
 * @property integer $id
 * @property integer $id_cargo
 * @property integer $salario
 * @property integer $id_empleado
 * @property integer $id_empleador
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property integer $id_motivo_ingreso
 * @property integer $id_motivo_retiro
 * @property string $creacion
 * @property string $actualizacion
 *
 * The followings are the available model relations:
 * @property Cargos $idCargo
 * @property Empleados $idEmpleado
 */
class Contratos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Contratos the static model class
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
		return 'contratos';
	}



	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cargo, id_empleado, fecha_inicio', 'required'),
			array('id_cargo, salario, id_empleado, id_empleador, id_motivo_ingreso, id_motivo_retiro', 'numerical', 'integerOnly'=>true),
			array('fecha_fin, creacion, actualizacion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_cargo, salario, id_empleado, id_empleador, fecha_inicio, fecha_fin, id_motivo_ingreso, id_motivo_retiro, creacion, actualizacion', 'safe', 'on'=>'search'),
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
			'idCargo' => array(self::BELONGS_TO, 'Cargos', 'id_cargo'),
			'idEmpleado' => array(self::BELONGS_TO, 'Empleados', 'id_empleado'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_cargo' => 'Id Cargo',
			'salario' => 'Salario',
			'id_empleado' => 'Id Empleado',
			'id_empleador' => 'Id Empleador',
			'fecha_inicio' => 'Fecha Inicio',
			'fecha_fin' => 'Fecha Fin',
			'id_motivo_ingreso' => 'Id Motivo Ingreso',
			'id_motivo_retiro' => 'Id Motivo Retiro',
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
		$criteria->compare('id_cargo',$this->id_cargo);
		$criteria->compare('salario',$this->salario);
		$criteria->compare('id_empleado',$this->id_empleado);
		$criteria->compare('id_empleador',$this->id_empleador);
		$criteria->compare('fecha_inicio',$this->fecha_inicio,true);
		$criteria->compare('fecha_fin',$this->fecha_fin,true);
		$criteria->compare('id_motivo_ingreso',$this->id_motivo_ingreso);
		$criteria->compare('id_motivo_retiro',$this->id_motivo_retiro);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('actualizacion',$this->actualizacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
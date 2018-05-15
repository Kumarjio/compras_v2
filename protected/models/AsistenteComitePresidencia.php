<?php

/**
 * This is the model class for table "asistentes_comite_presidencia".
 *
 * The followings are the available columns in table 'asistentes_comite_presidencia':
 * @property integer $id
 * @property integer $id_empleado
 *
 * The followings are the available model relations:
 * @property Empleados $idEmpleado
 */
class AsistenteComitePresidencia extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsistenteComitePresidencia the static model class
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
		return 'asistentes_comite_presidencia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_empleado', 'required'),
			array('id_empleado', 'numerical', 'integerOnly'=>true),
			array('id_empleado', 'unique', 'message' => 'Este empleado ya se encuentra en la lista de asistentes usuales al comité depresidencia.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_empleado', 'safe', 'on'=>'search'),
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
			'empleado' => array(self::BELONGS_TO, 'Empleados', 'id_empleado'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_empleado' => 'Id Empleado',
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
		$criteria->compare('id_empleado',$this->id_empleado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}

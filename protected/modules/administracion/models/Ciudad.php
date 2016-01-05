<?php

/**
 * This is the model class for table "ciudad".
 *
 * The followings are the available columns in table 'ciudad':
 * @property string $id_ciudad
 * @property string $nombre_ciudad
 * @property string $id_departamento
 *
 * The followings are the available model relations:
 * @property Departamento $idDepartamento
 * @property Pacientes[] $pacientes
 * @property Pacientes[] $pacientes1
 */
class Ciudad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ciudad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_ciudad', 'required'),
			array('nombre_ciudad, id_departamento', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_ciudad, nombre_ciudad, id_departamento', 'safe', 'on'=>'search'),
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
			'idDepartamento' => array(self::BELONGS_TO, 'Departamento', 'id_departamento'),
			'pacientes' => array(self::HAS_MANY, 'Pacientes', 'id_ciudad'),
			'pacientes1' => array(self::HAS_MANY, 'Pacientes', 'id_ciudad_acompanante'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_ciudad' => 'Id Ciudad',
			'nombre_ciudad' => 'Nombre Ciudad',
			'id_departamento' => 'Id Departamento',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_ciudad',$this->id_ciudad,true);
		$criteria->compare('nombre_ciudad',$this->nombre_ciudad,true);
		$criteria->compare('id_departamento',$this->id_departamento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ciudad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

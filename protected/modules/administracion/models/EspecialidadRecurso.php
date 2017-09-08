<?php

/**
 * This is the model class for table "especialidad_recurso".
 *
 * The followings are the available columns in table 'especialidad_recurso':
 * @property integer $id_especialidad_recurso
 * @property integer $id_especialidad
 * @property integer $id_recurso
 *
 * The followings are the available model relations:
 * @property Especialidad $idEspecialidad
 * @property Recursos $idRecurso
 */
class EspecialidadRecurso extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'especialidad_recurso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_especialidad_recurso', 'required'),
			array('id_especialidad_recurso, id_especialidad, id_recurso', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_especialidad_recurso, id_especialidad, id_recurso', 'safe', 'on'=>'search'),
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
			'idEspecialidad' => array(self::BELONGS_TO, 'Especialidad', 'id_especialidad'),
			'idRecurso' => array(self::BELONGS_TO, 'Recursos', 'id_recurso'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_especialidad_recurso' => 'Id Especialidad Recurso',
			'id_especialidad' => 'Id Especialidad',
			'id_recurso' => 'Id Recurso',
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

		$criteria->compare('id_especialidad_recurso',$this->id_especialidad_recurso);
		$criteria->compare('id_especialidad',$this->id_especialidad);
		$criteria->compare('id_recurso',$this->id_recurso);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EspecialidadRecurso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

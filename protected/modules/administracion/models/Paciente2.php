<?php

/**
 * This is the model class for table "paciente".
 *
 * The followings are the available columns in table 'paciente':
 * @property string $nombre
 * @property integer $cedula
 * @property string $celular
 * @property string $telefono
 * @property string $correo
 * @property integer $id_paciente
 */
class Paciente2 extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'paciente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cedula', 'numerical', 'integerOnly'=>true),
			array('nombre, celular, telefono, correo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('nombre, cedula, celular, telefono, correo, id_paciente', 'safe', 'on'=>'search'),
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
			'nombre' => 'Nombre',
			'cedula' => 'Cedula',
			'celular' => 'Celular',
			'telefono' => 'Telefono',
			'correo' => 'Correo',
			'id_paciente' => 'Id Paciente',
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

		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('cedula',$this->cedula);
		$criteria->compare('celular',$this->celular,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('id_paciente',$this->id_paciente);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Paciente the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

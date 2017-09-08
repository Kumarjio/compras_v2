<?php

/**
 * This is the model class for table "ayuda_maquina".
 *
 * The followings are the available columns in table 'ayuda_maquina':
 * @property integer $id_ayuda_maquina
 * @property integer $id_ayuda_diagnostica
 * @property integer $id_maquina
 *
 * The followings are the available model relations:
 * @property AyudasDiagnosticas $idAyudaDiagnostica
 * @property Maquina $idMaquina
 */
class AyudaMaquina extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ayuda_maquina';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_ayuda_diagnostica, id_maquina', 'required'),
			array('id_ayuda_diagnostica, id_maquina', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_ayuda_maquina, id_ayuda_diagnostica, id_maquina', 'safe', 'on'=>'search'),
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
			'idAyudaDiagnostica' => array(self::BELONGS_TO, 'AyudasDiagnosticas', 'id_ayuda_diagnostica'),
			'idMaquina' => array(self::BELONGS_TO, 'Maquina', 'id_maquina'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_ayuda_maquina' => 'Id Ayuda Maquina',
			'id_ayuda_diagnostica' => 'Id Ayuda Diagnostica',
			'id_maquina' => 'Id Maquina',
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

		$criteria->compare('id_ayuda_maquina',$this->id_ayuda_maquina);
		$criteria->compare('id_ayuda_diagnostica',$this->id_ayuda_diagnostica);
		$criteria->compare('id_maquina',$this->id_maquina);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AyudaMaquina the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

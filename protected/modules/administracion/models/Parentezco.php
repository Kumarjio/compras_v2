<?php

/**
 * This is the model class for table "parentezco".
 *
 * The followings are the available columns in table 'parentezco':
 * @property integer $id_parentezco
 * @property string $nombre_parentezco
 *
 * The followings are the available model relations:
 * @property Pacientes[] $pacientes
 */
class Parentezco extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'parentezco';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_parentezco', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_parentezco, nombre_parentezco', 'safe', 'on'=>'search'),
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
			'pacientes' => array(self::HAS_MANY, 'Pacientes', 'id_parentezco'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_parentezco' => 'Id Parentezco',
			'nombre_parentezco' => 'Nombre Parentezco',
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

		$criteria->compare('id_parentezco',$this->id_parentezco);
		$criteria->compare('nombre_parentezco',$this->nombre_parentezco,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Parentezco the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "nivel_educativo".
 *
 * The followings are the available columns in table 'nivel_educativo':
 * @property integer $id_nivel_educativo
 * @property string $descripcion
 *
 * The followings are the available model relations:
 * @property Pacientes[] $pacientes
 */
class NivelEducativo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nivel_educativo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descripcion', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_nivel_educativo, descripcion', 'safe', 'on'=>'search'),
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
			'pacientes' => array(self::HAS_MANY, 'Pacientes', 'id_nivel_educativo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_nivel_educativo' => 'Id Nivel Educativo',
			'descripcion' => 'Descripcion',
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

		$criteria->compare('id_nivel_educativo',$this->id_nivel_educativo);
		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NivelEducativo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "entidad_categoria".
 *
 * The followings are the available columns in table 'entidad_categoria':
 * @property integer $id_entidad_categoria
 * @property integer $id_entidad
 * @property integer $id_categoria
 *
 * The followings are the available model relations:
 * @property Entidad $idEntidad
 * @property Categoria $idCategoria
 */
class EntidadCategoria extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'entidad_categoria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_entidad, id_categoria', 'required'),
			array('id_entidad, id_categoria', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_entidad_categoria, id_entidad, id_categoria', 'safe', 'on'=>'search'),
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
			'idEntidad' => array(self::BELONGS_TO, 'Entidad', 'id_entidad'),
			'idCategoria' => array(self::BELONGS_TO, 'Categoria', 'id_categoria'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_entidad_categoria' => 'Id Entidad Categoria',
			'id_entidad' => 'Id Entidad',
			'id_categoria' => 'Id Categoria',
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

		$criteria->compare('id_entidad_categoria',$this->id_entidad_categoria);
		$criteria->compare('id_entidad',$this->id_entidad);
		$criteria->compare('id_categoria',$this->id_categoria);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EntidadCategoria the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

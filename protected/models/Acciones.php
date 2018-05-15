<?php

/**
 * This is the model class for table "acciones".
 *
 * The followings are the available columns in table 'acciones':
 * @property integer $id_accion
 * @property string $nombre_accion
 * @property string $accion
 *
 * The followings are the available model relations:
 * @property PermisoAccion[] $permisoAccions
 */
class Acciones extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'acciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_accion, accion', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_accion, nombre_accion, accion', 'safe', 'on'=>'search'),
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
			'permisoAccions' => array(self::HAS_MANY, 'PermisoAccion', 'id_accion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_accion' => 'Id Accion',
			'nombre_accion' => 'Nombre Accion',
			'accion' => 'Accion',
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

		$criteria->compare('id_accion',$this->id_accion);
		$criteria->compare('nombre_accion',$this->nombre_accion,true);
		$criteria->compare('accion',$this->accion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Acciones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

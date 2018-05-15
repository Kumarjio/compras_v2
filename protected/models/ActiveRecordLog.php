<?php

/**
 * This is the model class for table "activerecordlog".
 *
 * The followings are the available columns in table 'activerecordlog':
 * @property integer $id
 * @property string $action
 * @property string $model
 * @property integer $idmodel
 * @property integer $iduser
 * @property string $field
 * @property string $username
 * @property string $description
 * @property string $description_new
 */
class ActiveRecordLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActiveRecordLog the static model class
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
		return 'activerecordlog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idmodel, iduser', 'numerical', 'integerOnly'=>true),
			array('action, model, field, username, description, description_new', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, action, model, idmodel, iduser, field, username, description, description_new', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'action' => 'Accion',
			'model' => 'Modelo',
			'idmodel' => 'Id Modelo',
			'iduser' => 'Usuario',
			'field' => 'Campo',
			'username' => 'Username',
			'description' => 'Valor anterior',
			'description_new' => 'Valor nuevo',
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
		$criteria->compare('action',$this->action,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('idmodel',$this->idmodel);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('field',$this->field,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('description_new',$this->description_new,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_2($model, $idmodel)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('model',$model,true);
		$criteria->compare('idmodel',$idmodel);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('field',$this->field,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('description_new',$this->description_new,true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination'=>array('pageSize'=>500),
		));
	}
}
<?php

/**
 * This is the model class for table "menu_permiso".
 *
 * The followings are the available columns in table 'menu_permiso':
 * @property integer $id_menu_permiso
 * @property integer $id_menu
 * @property integer $id_permiso
 *
 * The followings are the available model relations:
 * @property Menu $idMenu
 * @property Permisos $idPermiso
 */
class MenuPermiso extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'menu_permiso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_menu, id_permiso', 'required'),
			array('id_menu, id_permiso', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_menu_permiso, id_menu, id_permiso', 'safe', 'on'=>'search'),
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
			'idMenu' => array(self::BELONGS_TO, 'Menu', 'id_menu'),
			'idPermiso' => array(self::BELONGS_TO, 'Permisos', 'id_permiso'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_menu_permiso' => 'Id Menu Permiso',
			'id_menu' => 'Id Menu',
			'id_permiso' => 'Id Permiso',
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

		$criteria->compare('id_menu_permiso',$this->id_menu_permiso);
		$criteria->compare('id_menu',$this->id_menu);
		$criteria->compare('id_permiso',$this->id_permiso);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuPermiso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

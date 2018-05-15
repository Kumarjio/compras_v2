<?php

/**
 * This is the model class for table "menu".
 *
 * The followings are the available columns in table 'menu':
 * @property integer $id_menu
 * @property string $nombre_menu
 * @property string $accion_menu
 * @property integer $padre_menu
 * @property string $menu_icono
 *
 * The followings are the available model relations:
 * @property Menu $padreMenu
 * @property Menu[] $menus
 * @property MenuPermiso[] $menuPermisos
 */
class Menu extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_menu', 'required'),
			array('padre_menu', 'numerical', 'integerOnly'=>true),
			array('accion_menu, menu_icono', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_menu, nombre_menu, accion_menu, padre_menu, menu_icono', 'safe', 'on'=>'search'),
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
			'padreMenu' => array(self::BELONGS_TO, 'Menu', 'padre_menu'),
			'menus' => array(self::HAS_MANY, 'Menu', 'padre_menu'),
			'menuPermisos' => array(self::HAS_MANY, 'MenuPermiso', 'id_menu'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_menu' => 'Id Menu',
			'nombre_menu' => 'Nombre Menu',
			'accion_menu' => 'Accion Menu',
			'padre_menu' => 'Padre Menu',
			'menu_icono' => 'Menu Icono',
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

		$criteria->compare('id_menu',$this->id_menu);
		$criteria->compare('nombre_menu',$this->nombre_menu,true);
		$criteria->compare('accion_menu',$this->accion_menu,true);
		$criteria->compare('padre_menu',$this->padre_menu);
		$criteria->compare('menu_icono',$this->menu_icono,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Menu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

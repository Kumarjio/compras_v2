<?php

/**
 * This is the model class for table "permisos_roles".
 *
 * The followings are the available columns in table 'permisos_roles':
 * @property integer $id
 * @property string $id_permiso
 * @property string $id_rol
 *
 * The followings are the available model relations:
 * @property Roles $idRol
 * @property Permisos $idPermiso
 */
class PermisosRoles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'permisos_roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_permiso', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_permiso, id_rol', 'safe', 'on'=>'search'),
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
			'idRol' => array(self::BELONGS_TO, 'Roles', 'id_rol'),
			'idPermiso' => array(self::BELONGS_TO, 'Permisos', 'id_permiso'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_permiso' => 'Permisos',
			'id_rol' => 'Id Rol',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('id_permiso',$this->id_permiso,true);
		$criteria->compare('id_rol',$this->id_rol,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PermisosRoles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function search_detalle()
	{
		$criteria=new CDbCriteria;
		if(!empty($_POST['id'])){
			$criteria->compare('id_rol',$_POST['id']);
		}else if(!empty($_POST['PermisosRoles']['id_rol'])){
			$criteria->compare('id_rol',$_POST['PermisosRoles']['id_rol']);
		}else{
			$criteria->compare('id_rol',-1);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => false
		));
	}
}

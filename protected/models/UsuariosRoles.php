<?php

/**
 * This is the model class for table "usuarios_roles".
 *
 * The followings are the available columns in table 'usuarios_roles':
 * @property integer $id
 * @property string $id_usuario
 * @property string $id_rol
 *
 * The followings are the available model relations:
 * @property Usuario $idUsuario
 * @property Roles $idRol
 */
class UsuariosRoles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios_roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rol', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_usuario, id_rol', 'safe', 'on'=>'search'),
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
			'idUsuario' => array(self::BELONGS_TO, 'Usuario', 'id_usuario'),
			'idRol' => array(self::BELONGS_TO, 'Roles', 'id_rol'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_usuario' => 'Id Usuario',
			'id_rol' => 'Rol',
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
		$criteria->compare('id_usuario',$this->id_usuario,true);
		$criteria->compare('id_rol',$this->id_rol,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsuariosRoles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function search_detalle()
	{
		$criteria=new CDbCriteria;
		if(!empty($_POST['id'])){
			$criteria->compare('id_usuario',$_POST['id']);
		}else if(!empty($_POST['UsuariosRoles']['id_usuario'])){
			$criteria->compare('id_usuario',$_POST['UsuariosRoles']['id_usuario']);
		}else{
			$criteria->compare('id_usuario',-1);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => false
		));
	}
}

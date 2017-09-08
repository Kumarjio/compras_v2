<?php

/**
 * This is the model class for table "usuario_perfil".
 *
 * The followings are the available columns in table 'usuario_perfil':
 * @property integer $id_usuario_perfil
 * @property integer $id_usuario
 * @property integer $id_perfil
 *
 * The followings are the available model relations:
 * @property Perfiles $idPerfil
 * @property Usuarios $idUsuario
 */
class UsuarioPerfil extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario_perfil';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, id_perfil', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_usuario_perfil, id_usuario, id_perfil', 'safe', 'on'=>'search'),
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
			'idPerfil' => array(self::BELONGS_TO, 'Perfiles', 'id_perfil'),
			'idUsuario' => array(self::BELONGS_TO, 'Usuarios', 'id_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_usuario_perfil' => 'Id Usuario Perfil',
			'id_usuario' => 'Id Usuario',
			'id_perfil' => 'Id Perfil',
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

		$criteria->compare('id_usuario_perfil',$this->id_usuario_perfil);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('id_perfil',$this->id_perfil);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsuarioPerfil the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

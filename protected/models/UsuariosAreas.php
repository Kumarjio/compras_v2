<?php

/**
 * This is the model class for table "usuarios_areas".
 *
 * The followings are the available columns in table 'usuarios_areas':
 * @property string $id
 * @property string $usuario
 * @property integer $id_area
 *
 * The followings are the available model relations:
 * @property Usuario $usuario0
 * @property Areas $idArea
 */
class UsuariosAreas extends CActiveRecord
{
	public $nombre_completo;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios_areas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_area', 'required'),
			//array('id_area', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, usuario, id_area', 'safe', 'on'=>'search'),
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
			'usuario0' => array(self::BELONGS_TO, 'Usuario', 'usuario'),
			'idArea' => array(self::BELONGS_TO, 'Areas', 'id_area'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario' => 'Usuario',
			'id_area' => 'Area',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('id_area',$this->id_area);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsuariosAreas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function cargarUsuariosArea($tipologia){
		$tipologia = base64_decode($tipologia);	
		$consulta = Tipologias::model()->findByPk($tipologia);
		return CHtml::listData(UsuariosAreas::model()->findAll(array("condition"=>"id_area =  $consulta->area AND \"usuario0\".\"activo\" = true","select"=>"INITCAP(usuario0.nombres) || ' '|| INITCAP(usuario0.apellidos) AS nombre_completo",'order' => 'usuario0.nombres', 'with'=>'usuario0')),'usuario0.usuario',CHtml::encode('nombre_completo'),true);
	}
}

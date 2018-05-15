<?php

/**
 * This is the model class for table "contactos_proveedor".
 *
 * The followings are the available columns in table 'contactos_proveedor':
 * @property integer $id
 * @property string $nombre
 * @property string $telefono
 * @property integer $celular
 * @property string $email
 * @property string $ciduad
 * @property string $departamento
 * @property string $direccion
 */
class ContactoProveedor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ContactoProveedor the static model class
	 */
	public $nombre_completo;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contactos_proveedor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, apellido, telefono, email', 'required'),
			array('celular, telefono', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>100),
			array('telefono', 'length', 'max'=>30),
			array('email, ciudad, departamento, direccion', 'length', 'max'=>255),
			array('email', 'email', 'allowEmpty' => false),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, telefono, celular, email, ciudad, departamento, direccion', 'safe', 'on'=>'search'),
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
			'proveedor' => array(self::BELONGS_TO, 'Proveedor', 'nit'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombres',
			'apellido' => 'Apellidos',
			'telefono' => 'Telefono',
			'celular' => 'Celular',
			'email' => 'Email',
			'ciudad' => 'Ciudad',
			'departamento' => 'Departamento',
			'direccion' => 'Direccion',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($nit)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('proveedor');
		$criteria->condition = 'proveedor.nit='.$nit;
		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('celular',$this->celular);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('departamento',$this->departamento,true);
		$criteria->compare('direccion',$this->direccion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
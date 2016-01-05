<?php

/**
 * This is the model class for table "auxiliares".
 *
 * The followings are the available columns in table 'auxiliares':
 * @property integer $id_auxiliar
 * @property string $cedula
 * @property string $primer_nombre
 * @property string $segundo_nombre
 * @property string $primer_apellido
 * @property string $segundo_apellido
 * @property string $direccion
 * @property integer $telefono_fijo
 * @property string $ciudad
 * @property string $celular
 * @property string $correo
 * @property string $nro_cuenta_bancaria
 * @property string $entidad_bancaria
 * @property integer $estado
 */
class Auxiliares extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'auxiliares';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('telefono_fijo, estado', 'numerical', 'integerOnly'=>true),
			array('cedula, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, direccion, ciudad, celular, correo, nro_cuenta_bancaria, entidad_bancaria', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_auxiliar, cedula, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, direccion, telefono_fijo, ciudad, celular, correo, nro_cuenta_bancaria, entidad_bancaria, estado', 'safe', 'on'=>'search'),
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
			'id_auxiliar' => 'Id Auxiliar',
			'cedula' => 'Cedula',
			'primer_nombre' => 'Primer Nombre',
			'segundo_nombre' => 'Segundo Nombre',
			'primer_apellido' => 'Primer Apellido',
			'segundo_apellido' => 'Segundo Apellido',
			'direccion' => 'Direccion',
			'telefono_fijo' => 'Telefono Fijo',
			'ciudad' => 'Ciudad',
			'celular' => 'Celular',
			'correo' => 'Correo',
			'nro_cuenta_bancaria' => 'Nro Cuenta Bancaria',
			'entidad_bancaria' => 'Entidad Bancaria',
			'estado' => 'Estado',
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

		$criteria->compare('id_auxiliar',$this->id_auxiliar);
		$criteria->compare('cedula',$this->cedula,true);
		$criteria->compare('primer_nombre',$this->primer_nombre,true);
		$criteria->compare('segundo_nombre',$this->segundo_nombre,true);
		$criteria->compare('primer_apellido',$this->primer_apellido,true);
		$criteria->compare('segundo_apellido',$this->segundo_apellido,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('telefono_fijo',$this->telefono_fijo);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('celular',$this->celular,true);
		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('nro_cuenta_bancaria',$this->nro_cuenta_bancaria,true);
		$criteria->compare('entidad_bancaria',$this->entidad_bancaria,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Auxiliares the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "entidad".
 *
 * The followings are the available columns in table 'entidad':
 * @property integer $id_entidad
 * @property string $nombre_entidad
 * @property integer $id_categoria
 * @property string $codigo
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Pacientes[] $pacientes
 * @property DocumentoEntidad[] $documentoEntidads
 */
class Entidad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'entidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_entidad, id_categoria', 'required'),
			array('id_categoria, estado', 'numerical', 'integerOnly'=>true),
			array('codigo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_entidad, nombre_entidad, id_categoria, codigo, estado', 'safe', 'on'=>'search'),
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
			'pacientes' => array(self::HAS_MANY, 'Pacientes', 'id_entidad'),
			'documentoEntidads' => array(self::HAS_MANY, 'DocumentoEntidad', 'id_entidad'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_entidad' => 'Id Entidad',
			'nombre_entidad' => 'Nombre Entidad',
			'id_categoria' => 'Id Categoria',
			'codigo' => 'Codigo',
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

		$criteria->compare('id_entidad',$this->id_entidad);
		$criteria->compare('nombre_entidad',$this->nombre_entidad,true);
		$criteria->compare('id_categoria',$this->id_categoria);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Entidad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "facturacion.parametros".
 *
 * The followings are the available columns in table 'facturacion.parametros':
 * @property integer $id_parametro
 * @property integer $id_empl_listas
 * @property integer $id_empl_clientes
 */
class Parametros extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Parametros the static model class
	 */
        public $nombre_empl_listas;
        public $nombre_empl_clientes;
        public $nombre_empl_operaciones;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'facturacion.parametros';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_empl_listas, id_empl_clientes', 'numerical', 'integerOnly'=>true),
                        array('id_empl_listas, id_empl_clientes, id_empl_operaciones, nombre_empl_listas, nombre_empl_clientes, nombre_empl_operaciones','required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_parametro, id_empl_listas, id_empl_clientes, id_empl_operaciones, nombre_empl_listas, nombre_empl_clientes, nombre_empl_operaciones', 'safe', 'on'=>'search'),
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
			'id_parametro' => 'Id Parametro',
			'id_empl_listas' => 'Empleado Listas',
			'id_empl_clientes' => 'Empleado Clientes',
			'id_empl_operaciones' => 'Empleado Operaciones',
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

		$criteria->compare('id_parametro',$this->id_parametro);
		$criteria->compare('id_empl_listas',$this->id_empl_listas);
		$criteria->compare('id_empl_clientes',$this->id_empl_clientes);
		$criteria->compare('id_empl_operaciones',$this->id_empl_operaciones);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
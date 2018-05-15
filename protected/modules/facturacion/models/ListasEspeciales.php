<?php

/**
 * This is the model class for table "facturacion.listas_especiales".
 *
 * The followings are the available columns in table 'facturacion.listas_especiales':
 * @property integer $id_lista_especial
 * @property integer $id_factura
 * @property string $tipo_identificacion
 * @property string $numero_identificacion
 * @property string $razon_social
 * @property integer $indicador1
 * @property integer $indicador2
 * @property integer $indicador3
 * @property integer $indicador4
 */
class ListasEspeciales extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ListasEspeciales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'facturacion.listas_especiales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_factura, indicador1, indicador2, indicador3, indicador4', 'numerical', 'integerOnly'=>true),
			array('tipo_identificacion, numero_identificacion, razon_social', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_lista_especial, id_factura, tipo_identificacion, numero_identificacion, razon_social, indicador1, indicador2, indicador3, indicador4', 'safe', 'on'=>'search'),
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
                    'idFactura' => array(self::BELONGS_TO, 'Facturas', 'id_factura'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_lista_especial' => 'Id Lista Especial',
			'id_factura' => 'Id Factura',
			'tipo_identificacion' => 'Tipo Identificacion',
			'numero_identificacion' => 'Numero Identificacion',
			'razon_social' => 'Razon Social',
			'indicador1' => 'Indicador1',
			'indicador2' => 'Indicador2',
			'indicador3' => 'Indicador3',
			'indicador4' => 'Indicador4',
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

		$criteria->compare('id_lista_especial',$this->id_lista_especial);
		$criteria->compare('id_factura',$this->id_factura);
		$criteria->compare('tipo_identificacion',$this->tipo_identificacion,true);
		$criteria->compare('numero_identificacion',$this->numero_identificacion,true);
		$criteria->compare('razon_social',$this->razon_social,true);
		$criteria->compare('indicador1',$this->indicador1);
		$criteria->compare('indicador2',$this->indicador2);
		$criteria->compare('indicador3',$this->indicador3);
		$criteria->compare('indicador4',$this->indicador4);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
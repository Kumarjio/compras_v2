<?php

/**
 * This is the model class for table "facturacion.tipificadas_cuentas_facturas".
 *
 * The followings are the available columns in table 'facturacion.tipificadas_cuentas_facturas':
 * @property integer $id_tipificada_cuenta_factura
 * @property integer $id_cuenta_factura
 * @property string $codigo_tipificada
 * @property string $descripcion_tipificada
 */
class TipificadasCuentasFacturas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TipificadasCuentasFacturas the static model class
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
		return 'facturacion.tipificadas_cuentas_facturas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cuenta_factura', 'numerical', 'integerOnly'=>true),
			array('codigo_tipificada, descripcion_tipificada', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_tipificada_cuenta_factura, id_cuenta_factura, codigo_tipificada, descripcion_tipificada', 'safe', 'on'=>'search'),
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
                    'consecutivoTipificadases' => array(self::HAS_MANY, 'ConsecutivoTipificadas', 'id_tipificada_cuenta_factura'),
                    'idCuentaFactura' => array(self::BELONGS_TO, 'CuentasFacturas', 'id_cuenta_factura'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_tipificada_cuenta_factura' => 'Id Tipificada Cuenta Factura',
			'id_cuenta_factura' => 'Id Cuenta Factura',
			'codigo_tipificada' => 'Codigo Tipificada',
			'descripcion_tipificada' => 'Descripcion Tipificada',
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

		$criteria->compare('id_tipificada_cuenta_factura',$this->id_tipificada_cuenta_factura);
		$criteria->compare('id_cuenta_factura',$this->id_cuenta_factura);
		$criteria->compare('codigo_tipificada',$this->codigo_tipificada,true);
		$criteria->compare('descripcion_tipificada',$this->descripcion_tipificada,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
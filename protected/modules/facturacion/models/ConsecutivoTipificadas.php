<?php

/**
 * This is the model class for table "facturacion.consecutivo_tipificadas".
 *
 * The followings are the available columns in table 'facturacion.consecutivo_tipificadas':
 * @property integer $id_consecutivo_tipificada
 * @property integer $id_tipificada_cuenta_factura
 * @property string $consecutivo_valor
 * @property string $descripcion_valor
 * @property string $valor
 */
class ConsecutivoTipificadas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ConsecutivoTipificadas the static model class
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
		return 'facturacion.consecutivo_tipificadas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipificada_cuenta_factura', 'numerical', 'integerOnly'=>true),
			array('consecutivo_valor, descripcion_valor, valor', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_consecutivo_tipificada, id_tipificada_cuenta_factura, consecutivo_valor, descripcion_valor, valor', 'safe', 'on'=>'search'),
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
                    'idTipificadaCuentaFactura' => array(self::BELONGS_TO, 'TipificadasCuentasFacturas', 'id_tipificada_cuenta_factura'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_consecutivo_tipificada' => 'Id Consecutivo Tipificada',
			'id_tipificada_cuenta_factura' => 'Id Tipificada Cuenta Factura',
			'consecutivo_valor' => 'Consecutivo Valor',
			'descripcion_valor' => 'Descripcion Valor',
			'valor' => 'Valor',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id_factura)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                

		$criteria=new CDbCriteria;
                
                $criteria->join = 'inner join facturacion.tipificadas_cuentas_facturas tcf on t.id_tipificada_cuenta_factura = tcf.id_tipificada_cuenta_factura ';
                $criteria->join .= 'inner join facturacion.cuentas_facturas cf on cf.id_cuenta_factura = tcf.id_cuenta_factura ';
                $criteria->join .= 'inner join cuenta_contable cc on cc.id = cf.id_cuenta ';
                                
		
		$criteria->compare('cf.id_factura',$id_factura);
                $criteria->compare('id_consecutivo_tipificada',$this->id_consecutivo_tipificada);
		$criteria->compare('id_tipificada_cuenta_factura',$this->id_tipificada_cuenta_factura);
		$criteria->compare('consecutivo_valor',$this->consecutivo_valor,true);
		$criteria->compare('descripcion_valor',$this->descripcion_valor,true);
		$criteria->compare('valor',$this->valor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
//		$criteria=new CDbCriteria;
//
//		$criteria->compare('id_consecutivo_tipificada',$this->id_consecutivo_tipificada);
//		$criteria->compare('id_tipificada_cuenta_factura',$this->id_tipificada_cuenta_factura);
//		$criteria->compare('consecutivo_valor',$this->consecutivo_valor,true);
//		$criteria->compare('descripcion_valor',$this->descripcion_valor,true);
//		$criteria->compare('valor',$this->valor,true);
//
//		return new CActiveDataProvider($this, array(
//			'criteria'=>$criteria,
//		));
	}
}
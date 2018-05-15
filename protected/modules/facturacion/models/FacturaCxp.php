<?php

/**
 * This is the model class for table "facturacion.factura_cxp".
 *
 * The followings are the available columns in table 'facturacion.factura_cxp':
 * @property integer $id_factura_cxp
 * @property integer $id_factura
 * @property string $identificacion
 * @property string $razon_social
 * @property string $valor_aprobado
 * @property integer $estado
 * @property integer $fecha_limite_pago
 */
class FacturaCxp extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FacturaCxp the static model class
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
		return 'facturacion.factura_cxp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_factura, estado, fecha_limite_pago', 'numerical', 'integerOnly'=>true),
			array('identificacion, razon_social, valor_aprobado', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_factura_cxp, id_factura, identificacion, razon_social, valor_aprobado, estado, fecha_limite_pago', 'safe', 'on'=>'search'),
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
			'id_factura_cxp' => 'Id Factura Cxp',
			'id_factura' => 'Id Factura',
			'identificacion' => 'Identificacion',
			'razon_social' => 'Razon Social',
			'valor_aprobado' => 'Valor Aprobado',
			'estado' => 'Estado',
			'fecha_limite_pago' => 'Fecha Limite Pago',
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

		$criteria->compare('id_factura_cxp',$this->id_factura_cxp);
		$criteria->compare('id_factura',$this->id_factura);
		$criteria->compare('identificacion',$this->identificacion,true);
		$criteria->compare('razon_social',$this->razon_social,true);
		$criteria->compare('valor_aprobado',$this->valor_aprobado,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('fecha_limite_pago',$this->fecha_limite_pago);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
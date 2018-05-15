<?php

/**
 * This is the model class for table "orden_solicitud_proveedor".
 *
 * The followings are the available columns in table 'orden_solicitud_proveedor':
 * @property integer $id
 * @property integer $id_orden_solicitud
 * @property integer $nit
 * @property string $proveedor
 * @property integer $cantidad
 * @property string $valor_unitario
 * @property string $moneda
 * @property string $total_compra
 */
class OrdenSolicitudProveedor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdenSolicitudProveedor the static model class
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
		return 'orden_solicitud_proveedor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('proveedor, valor_unitario, total_compra, moneda', 'required', 'on' => "negociacion_directa_o_legalizacion"),
            array('nit', 'length', 'max' => 10),         
			array('id_orden_solicitud, nit, cantidad', 'numerical', 'integerOnly'=>true),
			array('proveedor, moneda', 'length', 'max'=>255),
			array('valor_unitario, total_compra', 'safe'),
			array('valor_unitario, total_compra', 'numerical', 'integerOnly'=>false),
			array('proveedor', 'length', 'max'=>255),
			array('total_compra', 'safe'),
			array('valor_unitario, total_compra', 'default', 'value'=>null),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_orden_solicitud, nit, proveedor, cantidad, valor_unitario, moneda, total_compra', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'id_orden_solicitud' => 'Id Orden Solicitud',
			'nit' => 'Nit',
			'proveedor' => 'Proveedor',
			'cantidad' => 'Cantidad',
			'valor_unitario' => 'Valor Unitario (Si lo conoce)',
			'moneda' => 'Moneda',
			'total_compra' => 'Total Compra',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id_orden_solicitud)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden_solicitud',$this->id_orden_solicitud);
		$criteria->compare('nit',$this->nit);
		$criteria->compare('proveedor',$this->proveedor,true);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('valor_unitario',$this->valor_unitario,true);
		$criteria->compare('moneda',$this->moneda,true);
		$criteria->compare('total_compra',$this->total_compra,true);
		$criteria->condition = 'id_orden_solicitud='.$id_orden_solicitud;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
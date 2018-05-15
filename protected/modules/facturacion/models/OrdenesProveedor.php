<?php

/**
 * This is the model class for table "facturacion.ordenes_proveedor".
 *
 * The followings are the available columns in table 'facturacion.ordenes_proveedor':
 * @property integer $id_orden
 * @property integer $nit
 * @property string $dato
 */
class OrdenesProveedor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdenesProveedor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * SELECT DISTINCT oc.id AS id_orden, c.nit, (o.nombre_compra::text || ' - '::text) || o.fecha_solicitud::date AS dato
            FROM cotizacion c
            JOIN producto_orden po ON po.id = c.producto_orden
            JOIN orden o ON o.id = po.orden
            JOIN orden_compra oc ON oc.id_orden = o.id
           WHERE o.paso_wf::text <> 'swOrden/cancelada'::text
           ORDER BY oc.id DESC;
         *Esta era la anterior vista antes de que se cambiara a ordenes sin aprobar.
	 */
	public function tableName()
	{
		return 'facturacion.ordenes_proveedor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_orden, nit', 'numerical', 'integerOnly'=>true),
			array('dato', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_orden, nit, dato', 'safe', 'on'=>'search'),
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
			'id_orden' => 'Id Orden',
			'nit' => 'Nit',
			'dato' => 'Dato',
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

		$criteria->compare('id_orden',$this->id_orden);
		$criteria->compare('nit',$this->nit);
		$criteria->compare('dato',$this->dato,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
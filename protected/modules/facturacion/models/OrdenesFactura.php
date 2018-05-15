<?php

/**
 * This is the model class for table "facturacion.ordenes_factura".
 *
 * The followings are the available columns in table 'facturacion.ordenes_factura':
 * @property integer $id_ordenes_factura
 * @property integer $id_factura
 * @property integer $id_orden
 */
class OrdenesFactura extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdenesFactura the static model class
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
		return 'facturacion.ordenes_factura';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_factura, id_orden', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_ordenes_factura, id_factura, id_orden', 'safe', 'on'=>'search'),
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
                    'idFactura'=> array(self::BELONGS_TO, 'Facturas', 'id_factura'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_ordenes_factura' => 'Id Ordenes Factura',
			'id_factura' => 'Id Factura',
			'id_orden' => 'Orden de Compra',
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

		$criteria->compare('id_ordenes_factura',$this->id_ordenes_factura);
		$criteria->compare('id_factura',$id_factura);
		$criteria->compare('id_orden',$this->id_orden);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function permitirEliminar() {
		
		if($this->idFactura->usuario_actual != Yii::app()->user->getState('id_empleado'))
			return false;
        return (($this->idFactura->paso_wf == 'swFacturas/causacion' || $this->idFactura->paso_wf == 'swFacturas/devolver_causacion') && !$this->idFactura->hasErrors()) || 
                    ($this->idFactura->paso_wf =='swFacturas/enviar_fra' && $this->idFactura->hasErrors()) || ($this->idFactura->paso_wf =='swFacturas/revisionanalista' && !$this->idFactura->hasErrors());
        }
        
        public function getCuentasContables() {
            $ccontable = Yii::app()->db->createCommand("select o.id, os.id, osc.*, cc.codigo, cc.nombre from orden as o  
                inner join orden_solicitud as os on o.id = os.id_orden
                inner join orden_solicitud_costos as osc on osc.id_orden_solicitud = os.id
                inner join cuenta_contable as cc on cc.id = osc.id_cuenta_contable 
                where o.id = $this->id_orden")->queryAll();
            $res = "";
            foreach ($ccontable as $c) {
                $res .= $c[codigo]." - ".$c[nombre]."<br>";
            }
            return $res;
        }
}
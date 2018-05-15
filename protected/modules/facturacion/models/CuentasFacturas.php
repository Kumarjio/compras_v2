<?php

/**
 * This is the model class for table "facturacion.cuentas_facturas".
 *
 * The followings are the available columns in table 'facturacion.cuentas_facturas':
 * @property integer $id_cuenta_factura
 * @property integer $id_factura
 * @property integer $id_cuenta
 */
class CuentasFacturas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CuentasFacturas the static model class
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
		return 'facturacion.cuentas_facturas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_factura, id_cuenta', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_cuenta_factura, id_factura, id_cuenta', 'safe', 'on'=>'search'),
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
                    'idCuentaContable' => array(self::BELONGS_TO, 'CuentaContable', 'id_cuenta'),
                    'idFactura'=> array(self::BELONGS_TO, 'Facturas', 'id_factura'),
                    'tipificadas' => array(self::HAS_MANY, 'TipificadasCuentasFacturas', 'id_cuenta_factura'),
		);
	}

	public function permitirEliminar() {
            return (($this->idFactura->paso_wf == 'swFacturas/revisionanalista' || $this->idFactura->paso_wf == 'swFacturas/devolver_revision_analista') && !$this->idFactura->hasErrors()) || 
            ($this->idFactura->paso_wf =='swFacturas/aprobar_jefe' && $this->idFactura->hasErrors());
        }
        
	public function permitirEliminarCaus() {
            return true;
            return (($this->idFactura->paso_wf == 'swFacturas/causacion' || $this->idFactura->paso_wf == 'swFacturas/devolver_causacion') && !$this->idFactura->hasErrors()) || 
            ($this->idFactura->paso_wf =='swFacturas/enviar_fra' && $this->idFactura->hasErrors());
        }
        
	public function attributeLabels()
	{
		return array(
			'id_cuenta_factura' => 'Id Cuenta Factura',
			'id_factura' => 'Id Factura',
			'id_cuenta' => 'Cuenta',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
        
	public function searchTipi($id_factura)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->join = 'inner join cuenta_contable as cc on cc.id = t.id_cuenta ';
                $criteria->join .= 'inner join facturacion.tipificadas_cuentas_facturas tcf on t.id_cuenta_factura = tcf.id_cuenta_factura ';
                $criteria->join .= 'inner join facturacion.consecutivo_tipificadas ct on ct.id_tipificada_cuenta_factura = tcf.id_tipificada_cuenta_factura';
                                
		$criteria->compare('id_cuenta_factura',$this->id_cuenta_factura);
		$criteria->compare('id_factura',$id_factura);
		$criteria->compare('id_cuenta',$this->id_cuenta);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function search($id_factura)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_cuenta_factura',$this->id_cuenta_factura);
		$criteria->compare('id_factura',$id_factura);
		$criteria->compare('id_cuenta',$this->id_cuenta);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
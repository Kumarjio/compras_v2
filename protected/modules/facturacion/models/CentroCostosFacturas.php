<?php

/**
 * This is the model class for table "facturacion.centro_costos_facturas".
 *
 * The followings are the available columns in table 'facturacion.centro_costos_facturas':
 * @property integer $id_centro_costos_factura
 * @property integer $id_factura
 * @property integer $id_centro_costos
 */
class CentroCostosFacturas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CentroCostosFacturas the static model class
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
		return 'facturacion.centro_costos_facturas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
        
        protected function beforeValidate()
	{		
	    
            $this->valor = (empty($this->valor))? null : str_replace(',', '', $this->valor);

            return parent::beforeValidate();
	}
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_factura, id_centro_costos', 'numerical', 'integerOnly'=>true),
                        array('valor', 'numerical', 'integerOnly'=>false, 'min'=>1 ),
                        array('valor', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_centro_costos_factura, id_factura, id_centro_costos', 'safe', 'on'=>'search'),
		);
	}

	        
	public function permitirEliminar() {
            return (($this->idFactura->paso_wf == 'swFacturas/revisionanalista' || $this->idFactura->paso_wf == 'swFacturas/devolver_revision_analista') && !$this->idFactura->hasErrors()) || 
            ($this->idFactura->paso_wf =='swFacturas/aprobar_jefe' && $this->idFactura->hasErrors());
        }
        
	public function permitirEliminarCaus() {
            return (($this->idFactura->paso_wf == 'swFacturas/causacion' || $this->idFactura->paso_wf == 'swFacturas/devolver_causacion') && !$this->idFactura->hasErrors()) || 
            ($this->idFactura->paso_wf =='swFacturas/enviar_fra' && $this->idFactura->hasErrors()) ||
            $this->idFactura->paso_wf =='swFacturas/generacion_lote'  || $this->idFactura->paso_wf =='swFacturas/generacion_devolver_lote';
        }
        
        
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'idFactura' => array(self::BELONGS_TO, 'Facturas', 'id_factura'),
                    'idCentroCostos' => array(self::BELONGS_TO, 'CentroCostos', 'id_centro_costos'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_centro_costos_factura' => 'Id Centro Costos Factura',
			'id_factura' => 'Id Factura',
			'id_centro_costos' => 'Centro Costos',
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

		$criteria->compare('id_centro_costos_factura',$this->id_centro_costos_factura);
		$criteria->compare('id_factura',$id_factura);
		$criteria->compare('id_centro_costos',$this->id_centro_costos);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
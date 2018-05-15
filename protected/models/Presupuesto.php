<?php

/**
 * This is the model class for table "presupuesto".
 *
 * The followings are the available columns in table 'presupuesto':
 * @property integer $id
 * @property integer $id_vice
 * @property integer $id_direccion
 * @property integer $id_producto
 * @property integer $id_centro_costo
 * @property integer $id_cuenta
 * @property string $valor
 *
 * The followings are the available model relations:
 * @property Vicepresidencias $idVice
 * @property Gerencias $idDireccion
 * @property Producto $idProducto
 * @property CentroCostos $idCentroCosto
 * @property CuentaContable $idCuenta
 */
class Presupuesto extends CActiveRecord
{
	
	
	public $nombre_centro;
	public $nombre_cuenta;

	public function tableName()
	{
		return 'presupuesto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_producto, id_centro_costo, id_cuenta, valor, anio', 'required'),
			array('id_vice, id_direccion, id_producto, id_centro_costo, id_cuenta', 'numerical', 'integerOnly'=>true),
			array('valor', 'numerical',  'integerOnly'=>false),
			array('valor, nombre_centro, nombre_cuenta, anio', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_vice, id_direccion, id_producto, id_centro_costo, id_cuenta, valor, anio', 'safe', 'on'=>'search'),
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
			'idVice' => array(self::BELONGS_TO, 'Vicepresidencias', 'id_vice'),
			'idDireccion' => array(self::BELONGS_TO, 'Gerencias', 'id_direccion'),
			'idProducto' => array(self::BELONGS_TO, 'Producto', 'id_producto'),
			'idCentroCosto' => array(self::BELONGS_TO, 'CentroCostos', 'id_centro_costo'),
			'idCuenta' => array(self::BELONGS_TO, 'CuentaContable', 'id_cuenta'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_vice' => 'Id Vice',
			'id_direccion' => 'Direccion',
			'id_producto' => 'Producto',
			'id_centro_costo' => 'Centro Costo',
			'id_cuenta' => 'Cuenta Contable',
			'valor' => 'Valor',
			'nombre_centro' => 'Centro Costo',
			'nombre_cuenta' => 'Cuenta Contable',
			'anio'=>'Año'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		if(!isset($_GET['Presupuesto']['anio']))
			$this->anio = date('Y', strtotime('+1 year', strtotime(date('Y'))));

		$contrato = Contratos::model()->findByAttributes(array('id_empleado' => Yii::app()->user->getState('id_empleado')));
		$area = Cargos::model()->findByPk($contrato->id_cargo);
		if($area->id_vice != "")
			$this->id_vice = $area->id_vice;
		elseif ($area->id_gerencia != "") 
			$this->id_direccion = $area->id_gerencia;
		

		$criteria->compare('id',$this->id);
		$criteria->compare('id_vice',$this->id_vice);
		$criteria->compare('id_direccion',$this->id_direccion);
		$criteria->compare('id_producto',$this->id_producto);
		$criteria->compare('id_centro_costo',$this->id_centro_costo);
		$criteria->compare('id_cuenta',$this->id_cuenta);
		$criteria->compare('anio',$this->anio);
		$criteria->compare('valor',$this->valor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function consumoProducto(){
		if($this->id_direccion != "")
			$consumo = ConsumoProductos::model()->findByAttributes(array('id_vicepresidencia'=>$this->id_vice, 'id_gerencia'=>$this->id_direccion, 'id_producto'=>$this->id_producto));
		else
			$consumo = ConsumoProductos::model()->findByAttributes(array('id_vicepresidencia'=>$this->id_vice, 'id_producto'=>$this->id_producto));
		return $consumo->consumo;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

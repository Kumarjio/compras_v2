<?php

/**
 * This is the model class for table "cotizacion".
 *
 * The followings are the available columns in table 'cotizacion':
 * @property integer $id
 * @property integer $producto_orden
 * @property integer $nit
 * @property integer $cantidad
 * @property integer $valor_unitario
 * @property integer $total_compra
 * @property string $descripcion
 * @property integer $elegido_compras
 * @property integer $elegido_usuario
 *
 * The followings are the available model relations:
 * @property ProductoOrden $productoOrden
 * @property Proveedor $nit0
 */
class Cotizacion extends CActiveRecord
{
	
	public $eleccion;
	public $razon_social;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cotizacion the static model class
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
		return 'cotizacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nit', 'existeProveedor'),
			array('razon_eleccion_usuario', 'required', 'on' => 'razon_eleccion_usuario'),
			array('razon_eleccion_compras', 'required', 'on' => 'razon_eleccion_compras'),
			array('razon_eleccion_comite', 'required', 'on' => 'razon_eleccion_comite'),
			array('producto_orden, nit, moneda, cantidad, valor_unitario, total_compra, contacto, numero', 'required'),
			array('producto_orden, nit, cantidad, elegido_compras, elegido_usuario, dias_pago_factura', 'numerical', 'integerOnly'=>true),
			array('trm, total_compra_pesos, porcentaje_descuento, valor_unitario, total_compra', 'numerical', 'integerOnly'=>false),
			array('calificacion', 'default', 'value' => 0),
			array('razon_eleccion_comite, contacto, descripcion, descuento_prontopago, porcentaje_descuento, dias_pago_factura, enviar_cotizacion_a_usuario, numero,referencia', 'safe'),
			array('porcentaje_descuento', 'porcentaje'),
			array('elegido_compras', 'elegido_si_seleccionado', 'on' => 'razon_eleccion_compras'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, producto_orden, nit, cantidad, valor_unitario, razon_social, moneda, calificacion, total_compra, descripcion, elegido_compras, elegido_usuario', 'safe', 'on'=>'search'),

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
			'adjuntosCotizacions' => array(self::HAS_MANY, 'AdjuntosCotizacion', 'cotizacion'),
			'productoOrden' => array(self::BELONGS_TO, 'ProductoOrden', 'producto_orden'),
            'idContacto' => array(self::BELONGS_TO, 'ContactoProveedor', 'contacto'),
			'nit0' => array(self::BELONGS_TO, 'Proveedor', 'nit'),
		);
	}

	public function adjuntos($adjuntos){
		$html = "";
		if(count($adjuntos) > 0){
			foreach ($adjuntos as $n => $adj) {
				$url = Yii::app()->createUrl("/adjuntosCotizacion/download", array("id" =>  $adj->id));
				$html .= '<a class="subir-archivos" rel="tooltip" href="'.$url.'" target="_blank" data-original-title="'.$adj->nombre.'"><i class="icon-file"></i></a>';
			}
			return $html;
		}else{
			return "Sin adjuntos";
		}
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'producto_orden' => 'Producto Orden',
			'nit' => 'NIT',
            'numero' => 'Numero de Cotización',
			'cantidad' => 'Cantidad',
			'valor_unitario' => 'Valor Unitario',
			'total_compra' => 'Total Compra',
			'descripcion' => 'Descripcion',
			'elegido_compras' => 'Elegido Compras',
			'elegido_usuario' => 'Elegido Usuario',
			'eleccion' => 'Elección',
			'trm' => 'TRM',
			'razon_social' => 'Razon Social',
			'descuento_prontopago' => 'Tiene Descuento por Pronto Pago?',
			'porcentaje_descuento' => '% del Descuento',
			'dias_pago_factura' => 'Dias Hábiles Para el Pago de la Factura',
			'enviar_cotizacion_a_usuario' => 'Enviar Cotizacion a Usuario'
		);
	}

	public function existeProveedor(){
		$existe = Proveedor::model()->findByPk($this->nit);
		if($existe == null){
			$this->addError("nit", "El nit ingresado no exíste");
		}
	}

	public function getMonedas(){
		$monedas = array('Peso', 'Dolar', 'Euro');
		$res = array();
		foreach ($monedas as $moneda) {
			array_push($res, array('id' => $moneda, 'nombre' => $moneda));
		}

		return $res;
	}

	public function getCalificaciones(){
		$calificaciones = array(1,2,3,4,5);
		$res = array();
		foreach ($calificaciones as $c) {
			array_push($res, array('id' => $c, 'nombre' => $c));
		}

		return $res;
	}
	
	public static function ahorro($id, $id_po){
		$cotizacion_actual = Cotizacion::model()->findByPk($id);
		$cotizaciones = Cotizacion::model()->findAllByattributes(array('producto_orden' => $id_po), array('order' => 'id ASC'));
		$total = 0;
		$primeras = array();
		//echo count($cotizaciones); exit;
		if(count($cotizaciones) > 0){
			foreach($cotizaciones as $c){
				if(!(in_array($c, $primeras))){
					$primeras[] = $c;
					$total += $c->total_compra_pesos;
				}
			}
			if( count($primeras) > 0 and $total > 0){
				$resultado = (($total/(count($primeras)) - $cotizacion_actual->total_compra_pesos)/($total/(count($primeras))));
			}else{
				$resultado = 0;
			}
		}else{
			return 0;
		}
	}

	public function urlGrid($tipo, $id){
		return Yii::app()->createUrl("cotizacion/$tipo", array('id' => $id, 'ajax' => 1));
	}

	public function urlEnviarUsuario($po, $id){
		return Yii::app()->createUrl("cotizacion/enviarUsuario", array('prodord' => $po, 'id' => $id));
	}

	public function getRazonSocial(){
		$this->razon_social = $this->nit0->razon_social;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($prod_orden)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$po = ProductoOrden::model()->findByPk($prod_orden);
		$orden = $po->orden0;
		$criteria=new CDbCriteria;
		/*
		//select c.id, c.producto_orden, c.nit, c.cantidad, c.valor_unitario, c.total_compra, c.descripcion from (select max(id) as id, nit from cotizacion group by nit) a inner join cotizacion c on (c.id = a.id);
		$criteria->select = "c.id, c.producto_orden, c.nit, c.cantidad, c.valor_unitario, c.total_compra, c.descripcion";
		$criteria->join = "inner join cotizacion c on (c.id = t.id)"
		$criteria->condition = "producto_orden = :po";
		$criteria->group = "nit, cantidad, valor_unitario, total_compra, descripcion";
		$criteria->params = array(':po' => $prod_orden);
		*/
		$criteria->with = array('nit0');
		/*
        $criteria->addCondition('id IN (select
										case when c.id is null then b.id else c.id end as def
										from
										(select 
										id,
										nit 
										from 
										cotizacion 
										where  (id,nit) IN (SELECT max(id) as id, nit FROM cotizacion WHERE producto_orden = :po group by nit)) b
											left join
												cotizacion c
										  	on (c.nit = b.nit and c.producto_orden = :po and c.enviar_a_usuario = 1))');
        */
        $criteria->addCondition('producto_orden = :po');
		$criteria->params = array(':po' => $prod_orden);
		if($orden->paso_wf != "swOrden/en_negociacion"){
			$criteria->addCondition('enviar_cotizacion_a_usuario = 1');
		}		
		$criteria->compare('id',$this->id);
		$criteria->compare('producto_orden',$this->producto_orden);
		$criteria->compare('nit',$this->nit);
		$criteria->compare('LOWER(nit0.razon_social)',strtolower($this->razon_social), true);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('valor_unitario',$this->valor_unitario);
		$criteria->compare('total_compra',$this->total_compra);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('elegido_compras',$this->elegido_compras);
		$criteria->compare('elegido_usuario',$this->elegido_usuario);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			        'attributes'=>array(
			            'razon_social'=>array(
			                'asc'=>'nit0.razon_social',
			                'desc'=>'nit0.razon_social DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}

	public function search_proveedor($prodord,$nit,$excluir)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		/*
		//select c.id, c.producto_orden, c.nit, c.cantidad, c.valor_unitario, c.total_compra, c.descripcion from (select max(id) as id, nit from cotizacion group by nit) a inner join cotizacion c on (c.id = a.id);
		$criteria->select = "c.id, c.producto_orden, c.nit, c.cantidad, c.valor_unitario, c.total_compra, c.descripcion";
		$criteria->join = "inner join cotizacion c on (c.id = t.id)"
		$criteria->condition = "producto_orden = :po";
		$criteria->group = "nit, cantidad, valor_unitario, total_compra, descripcion";
		$criteria->params = array(':po' => $prod_orden);
		*/
		$criteria=new CDbCriteria;
		//$criteria->condition = "producto_orden = :po and nit = :n and id != :e";
		//$criteria->params = array(':po' => $prodord, ':n' => $nit, ':e' => $excluir);
		$criteria->condition = "producto_orden = :po and nit = :n";
		$criteria->params = array(':po' => $prodord, ':n' => $nit);

		$criteria->compare('id',$this->id);
		$criteria->compare('producto_orden',$this->producto_orden);
		$criteria->compare('nit',$this->nit);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('valor_unitario',$this->valor_unitario);
		$criteria->compare('total_compra',$this->total_compra);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('elegido_compras',$this->elegido_compras);
		$criteria->compare('elegido_usuario',$this->elegido_usuario);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function porcentaje(){
		if($this->descuento_prontopago == "Si"){
			if($this->porcentaje_descuento == null or $this->porcentaje_descuento == ''){
				$this->addError("porcentaje_descuento", "Debe ingresar el porcentaje de descuento.");
			}else{
				if($this->porcentaje_descuento <= 0 ){
					$this->addError("porcentaje_descuento", "El porcentaje de descuento debe ser mayor que cero (0).");
				}else{
					if($this->porcentaje_descuento > 100 ){
						$this->addError("porcentaje_descuento", "El porcentaje de descuento debe ser menor que cien (100).");
					}
				}
			}
			if($this->dias_pago_factura == null or $this->dias_pago_factura == ''){
				$this->addError("dias_pago_factura", "Debe ingresar los días para el pago de la factura.");
			}else{
				if($this->dias_pago_factura <= 0 ){
					$this->addError("dias_pago_factura", "El número de días para el pago de la factura debe ser mayor a cero (0).");
				}else{
					
				}
			}
		}
		return true;
	}
	
	public function elegido_si_seleccionado(){
		if($this->enviar_cotizacion_a_usuario != 1){
			$this->addError("elegido_compras", "Debe marcar la cotizacion para enviar al usuario antes de poderla elegir.");
		}
	}
	
}

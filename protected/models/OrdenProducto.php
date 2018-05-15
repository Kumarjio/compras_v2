<?php

/**
 * This is the model class for table "orden_producto".
 *
 * The followings are the available columns in table 'orden_producto':
 * @property integer $id
 * @property integer $id_orden
 * @property integer $id_producto
 * @property integer $id_marco
 * @property integer $cantidad
 * @property string $detalle
 * @property string $fecha_entrega
 * @property string $responsable
 * @property string $direccion_entrega
 * @property string $ciudad
 * @property string $departamento
 * @property string $telefono
 * @property integer $id_centro_costos
 * @property integer $id_cuenta_contable
 *
 * The followings are the available model relations:
 * @property Orden $idOrden
 * @property Producto $idProducto
 * @property OrdenMarcoCompras $idMarco
 * @property CentroCostos $idCentroCostos
 * @property CuentaContable $idCuentaContable
 */
class OrdenProducto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $nombre_centro;
	public $nombre_cuenta;
	public $faltante;
	public function tableName()
	{
		return 'orden_producto';
	}

	

	protected function afterSave(){
	  	parent::afterSave();
	  	if($this->isNewRecord){
	  		if($this->id_marco_detalle != ''){
	  			$consumo = new ConsumoMarco;
	  			$consumo->id_marco_detalle = $this->id_marco_detalle;
	  			$consumo->cantidad = $this->cantidad;
	  			$consumo->id_orden_producto = $this->id;
	  			$consumo->estado = 'Solicitado';
	  			$consumo->save();
	  			if($this->faltante){
	  				$model_nuevo = new OrdenProducto; 
	  				$model_nuevo->attributes = $this->attributes;
	  				$model_nuevo->nombre_centro = "default";
	  				$model_nuevo->nombre_cuenta = "default";
	  				$disponible = DisponiblesMarcoCompras::model()->findByAttributes(array('producto'=>$this->id_producto),"disponible > 0");
	  				$model_nuevo->id_marco_detalle = $disponible->id_detalle_om;
	  				$model_nuevo->cantidad = $this->faltante;
	  				if($disponible->forma_negociacion == "valor"){
						$cotizacion = OmCotizacion::model()->findByAttributes(array('producto_detalle_om'=>$disponible->id_detalle_om));
						$cantidad_disp = $disponible->cant_valor / $cotizacion->valor_unitario;
					}	
					else {
						$cantidad_disp = $disponible->cant_valor;
					}
					if($model_nuevo->cantidad > $cantidad_disp){
						$model_nuevo->faltante = $model_nuevo->cantidad - $cantidad_disp;
						$model_nuevo->cantidad = $cantidad_disp;
					}
					if(!$model_nuevo->save())
						die(print_r($model_nuevo->getErrors(), true));
	  			}
	  		}
	  	}
		return true;

	}
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_producto, cantidad, fecha_entrega, responsable, direccion_entrega, ciudad, departamento, telefono, id_centro_costos, id_cuenta_contable, nombre_centro, nombre_cuenta', 'required', 'except'=>'razon_rechazo, aprobar_marco'),
			array('id_orden, id_producto, id_marco_detalle, cantidad, id_centro_costos, id_cuenta_contable', 'numerical', 'integerOnly'=>true),
			array('detalle', 'safe'),
			array('razon_rechazo', 'required', 'on'=>'razon_rechazo'),
			array('cantidad', 'validarCantidadMarco'),
			array('faltante, nombre_cuenta, nombre_centro','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_orden, id_producto, id_marco, cantidad, detalle, fecha_entrega, responsable, direccion_entrega, ciudad, departamento, telefono, id_centro_costos, id_cuenta_contable', 'safe', 'on'=>'search'),
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
			'consumoMarcos' => array(self::HAS_MANY, 'ConsumoMarco', 'id_orden_producto'),
			'idOrden' => array(self::BELONGS_TO, 'Orden', 'id_orden'),
			'idProducto' => array(self::BELONGS_TO, 'Producto', 'id_producto'),
			'idMarcoDetalle' => array(self::BELONGS_TO, 'OmProductoDetalle', 'id_marco_detalle'),
			'idCentroCostos' => array(self::BELONGS_TO, 'CentroCostos', 'id_centro_costos'),
			'idCuentaContable' => array(self::BELONGS_TO, 'CuentaContable', 'id_cuenta_contable'),
			'CotizacionsOp' => array(self::HAS_MANY, 'CotizacionOp', 'orden_producto'),
			'CotizacionsOpEnviadas' => array(self::HAS_MANY, 'CotizacionOp', 'orden_producto', 'condition'=>'"CotizacionsOpEnviadas"."enviar_cotizacion_a_usuario" = 1'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_orden' => 'Orden',
			'id_producto' => 'Producto',
			'id_marco_detalle' => 'Marco',
			'cantidad' => 'Cantidad',
			'detalle' => 'Detalle',
			'fecha_entrega' => 'Fecha Entrega',
			'responsable' => 'Responsable',
			'direccion_entrega' => 'Dirección Entrega',
			'ciudad' => 'Ciudad',
			'departamento' => 'Departamento',
			'telefono' => 'Telefono',
			'id_centro_costos' => 'Centro Costos',
			'id_cuenta_contable' => 'Cuenta Contable',
		);
	}

	public static function get_descripcion($desc, $id, $l){
		$nd = array();
		if(is_array($desc)){
			$arreglo = $desc;
			$desc = str_replace(PHP_EOL, '</br>', trim(CHtml::encode($arreglo['razon'])));
			$desc .= '</br><h3> Tipo de negociación:</h3> ' . $arreglo['tipo'];
			$desc .= '</br><h3> Valor o Cantidad:</h3> ' . $arreglo['cant_valor'];
		}
		else{
			$desc = CHtml::encode($desc);
			$desc = str_replace(PHP_EOL, '</ br>', trim($desc));
		}
		$resp = '<a onClick="bootbox.alert(\'<h3>Razon de Elección:</h3>'.$desc.'\');" style="cursor:pointer;color: #f7f7f7;">'.$l.'</a>';
		//$resp = '<a onClick="$(\'#razonEleccion .modal-body\').html($(\'#ver-mas-'.$id.$l.'\').html()); $(\'#razonEleccion\').modal(\'show\');" style="cursor:pointer;">'.$l.'</a><div id="ver-mas-'.$id.$l.'" style="display:none;">'.$desc.'</div>';
		return $resp;
	}
	
    public function getIdCotizacion(){
		$cot = CotizacionOp::model()->findByAttributes(array('orden_producto' => $this->id, 'elegido_comite' => 1));
		return $cot->id;
	}
	
    public function getIdCotizacionOm(){
		$cot = OmCotizacion::model()->findByAttributes(array('producto_detalle_om' => $this->id_marco_detalle, 'elegido_comite' => 1));
		return $cot->id;
	}
	
	public function cantidadDisponible(){
		$docs = DetalleOrdenCompraOp::model()->findAllByAttributes(array('id_orden_producto' => $this->id));
		if(count($docs) > 0){
			$total = 0;
			foreach($docs as $d){
				$total += $d->cantidad;	
			}
			return ($this->cantidad - $total);
		}else{
			return $this->cantidad;
		}
	}
	
	public function validarCantidadMarco(){
		if($this->id_marco_detalle != ""){
			$validacion = $this->buscarOrdenesMarcoAdicionales();
			if($validacion['faltantes'])
				$this->addError("cantidad", "No puede superar la cantidad de la orden marco, lo máximo posible para solicitar es " . floor ( $validacion['maximo']));
		}
	}

	public function buscarOrdenesMarcoAdicionales(){
		$disponible = DisponiblesMarcoCompras::model()->findByAttributes(array('id_detalle_om'=>$this->id_marco_detalle), "disponible > 0");
		$mas_disponibles = DisponiblesMarcoCompras::model()->findAllByAttributes(array('producto'=>$this->id_producto), "id_detalle_om <> :detalle and disponible > 0", array(':detalle'=>$this->id_marco_detalle));
		array_unshift($mas_disponibles, $disponible);
		$resp = array();
		$resp['faltantes'] = $this->cantidad;
		foreach ($mas_disponibles as $md) {
			if($md->forma_negociacion == "valor"){
				$cotizacion = OmCotizacion::model()->findByAttributes(array('producto_detalle_om'=>$md->id_detalle_om));
				$cantidad_disp = $md->disponible / $cotizacion->valor_unitario;
			}	
			else {
				$cantidad_disp = $md->disponible;
			}
			if($resp['faltantes'] > $cantidad_disp){
				$resp['faltantes'] -= $cantidad_disp;
				$resp['maximo']  += $cantidad_disp;
				array_push($resp, array('id_marco_detalle' => $md->id_detalle_om, 'cantidad'=>$cantidad_disp));

			}
			else {
				array_push($resp, array('id_marco_detalle' => $md->id_detalle_om, 'cantidad'=>$cantidad_disp - $resp['faltantes'] ));
				$resp['faltantes'] = 0;
			}

		}
		return $resp;
	}

	public function search($id_orden)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden',$id_orden);
		$criteria->compare('id_producto',$this->id_producto);
		$criteria->compare('id_marco_detalle',$this->id_marco_detalle);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('fecha_entrega',$this->fecha_entrega,true);
		$criteria->compare('responsable',$this->responsable,true);
		$criteria->compare('direccion_entrega',$this->direccion_entrega,true);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('departamento',$this->departamento,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('id_centro_costos',$this->id_centro_costos);
		$criteria->compare('id_cuenta_contable',$this->id_cuenta_contable);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

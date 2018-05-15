<?php

/**
 * This is the model class for table "orden_solicitud_costos".
 *
 * The followings are the available columns in table 'orden_solicitud_costos':
 * @property integer $id
 * @property integer $id_orden_solicitud
 * @property string $porcentaje_o_cantidad
 * @property string $numero
 * @property integer $id_centro_costos
 * @property integer $id_cuenta_contable
 * @property string $presupuestado
 * @property string $valor_presupuestado
 * @property string $mes_presupuestado
 * @property string $paso_wf
 *
 * The followings are the available model relations:
 * @property OrdenSolicitud $idOrdenSolicitud
 * @property CentroCostos $idCentroCostos
 * @property CuentaContable $idCuentaContable
 */
class OrdenSolicitudCostos extends CActiveRecord
{
	public $integerPattern='/^\s*[+-]?\d+\s*$/';
	public $nombre_centro;
	public $nombre_cuenta;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdenSolicitudCostos the static model class
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
		return 'orden_solicitud_costos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('numero, id_centro_costos, id_cuenta_contable, presupuestado', 'required'),
			array('id_orden_solicitud, id_centro_costos, id_cuenta_contable', 'numerical', 'integerOnly'=>true),
			array('numero', 'numerical', 'integerOnly'=>false),
			array('numero', 'number_if_cantidad'),
			array('numero', 'must_be_less_than_solicitud'),
			array('valor', 'required_if_presupuestado'),
			array('nombre_cuenta, nombre_centro', 'safe'),
			array('porcentaje_o_cantidad, presupuestado, valor_presupuestado, mes_presupuestado', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_orden_solicitud, porcentaje_o_cantidad, numero, id_centro_costos, id_cuenta_contable, presupuestado, valor_presupuestado, mes_presupuestado', 'safe', 'on'=>'search'),
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
			'orden_solicitud' => array(self::BELONGS_TO, 'OrdenSolicitud', 'id_orden_solicitud'),
			'idCentroCostos' => array(self::BELONGS_TO, 'CentroCostos', 'id_centro_costos'),
			'idCuentaContable' => array(self::BELONGS_TO, 'CuentaContable', 'id_cuenta_contable'),
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
			'porcentaje_o_cantidad' => 'Cantidad o Porcentaje',
			'numero' => 'Cantidad o Porcentaje',
			'id_centro_costos' => 'Centro Costos',
			'id_cuenta_contable' => 'Cuenta Contable',
			'presupuestado' => 'Presupuestado o Estimado?',
			'valor_presupuestado' => 'Valor en pesos',
			'mes_presupuestado' => 'Mes Presupuestado',
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
		$criteria->compare('porcentaje_o_cantidad',$this->porcentaje_o_cantidad,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('id_centro_costos',$this->id_centro_costos);
		$criteria->compare('id_cuenta_contable',$this->id_cuenta_contable);
		$criteria->compare('presupuestado',$this->presupuestado,true);
		$criteria->compare('valor_presupuestado',$this->valor_presupuestado,true);
		$criteria->compare('mes_presupuestado',$this->mes_presupuestado,true);
		$criteria->condition = 'id_orden_solicitud='.$id_orden_solicitud;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function number_if_cantidad()
	{
		if($this->porcentaje_o_cantidad == "Cantidad"){
			if(!preg_match($this->integerPattern,$this->numero)){
				$this->addError('numero','Las cantidades deben ser números enteros.');
			}else{
				if($this->numero == 0){
					$this->addError('numero','La cantidad debe ser mínimo uno (1).');
				}
			}
		}else{
			if($this->numero > 100){
				$this->addError('numero','El porcentaje no puede ser mayor que 100.');
			}else{
				if(!($this->numero > 0)){
					$this->addError('numero','El porcentaje debe mayor que cero (0).');
				}
			}
		}
	}
	
	public function required_if_presupuestado()
	{
		if($this->presupuestado == "Presupuestado"){
			if($this->valor_presupuestado == "" or $this->valor_presupuestado == null){
				$this->addError('valor_presupuestado','Debe ingresar el valor presupuestado.');
			}
			if($this->mes_presupuestado == "" or $this->mes_presupuestado == null){
				$this->addError('mes_presupuestado','Debe ingresar el mes presupuestado.'.$this->mes_presupuestado);
			}
		}else{
			if($this->presupuestado == "Estimado"){
				if($this->valor_presupuestado == "" or $this->valor_presupuestado == null){
					$this->addError('valor_presupuestado','Debe ingresar el valor presupuestado.');
				}
			}
		}
	}
	
	public function must_be_less_than_solicitud(){
		$costos = OrdenSolicitudCostos::model()->findAllByAttributes(array('id_orden_solicitud' => $this->id_orden_solicitud));
		$cant = 0;
		$allcant = true;
		if(count($costos) > 0){
			foreach($costos as $d){
				if($d->porcentaje_o_cantidad == "Porcentaje"){
					$allcant = false;
				}
				if($this->isNewRecord == false and $d->id == $this->id){
					
				}else{
					$cant += $d->numero;
				}
			}
		}
		if($allcant and (($cant + $this->numero) > $this->orden_solicitud->cantidad) and $this->porcentaje_o_cantidad == "Cantidad"){
			$this->addError('cantidad','La cantidad total exede la cantidad solicitada del producto.');
		}
	}
	
}
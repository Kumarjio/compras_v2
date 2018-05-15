<?php

/**
 * This is the model class for table "orden_solicitud_direccion".
 *
 * The followings are the available columns in table 'orden_solicitud_direccion':
 * @property integer $id
 * @property integer $id_orden_solicitud
 * @property integer $cantidad
 * @property string $direccion_entrega
 * @property string $responsable
 * @property string $ciudad
 * @property string $departamento
 * @property string $telefono
 */
class OrdenSolicitudDireccion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdenSolicitudDireccion the static model class
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
		return 'orden_solicitud_direccion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cantidad, direccion_entrega, ciudad, responsable, departamento, telefono', 'required'),
			array('id_orden_solicitud', 'numerical', 'integerOnly'=>true),
			array('cantidad', 'numerical', 'integerOnly'=>true, 'min' => 1),
			array('direccion_entrega, responsable, ciudad, departamento, telefono', 'length', 'max'=>255),
			array('cantidad', 'default', 'value' => null),
			array('cantidad', 'must_be_less_than_solicitud'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_orden_solicitud, cantidad, direccion_entrega, responsable, ciudad, departamento, telefono', 'safe', 'on'=>'search'),
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
			'cantidad' => 'Cantidad',
			'direccion_entrega' => 'Direccion Entrega',
			'responsable' => 'Responsable',
			'ciudad' => 'Ciudad',
			'departamento' => 'Departamento',
			'telefono' => 'Telefono',
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
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('direccion_entrega',$this->direccion_entrega,true);
		$criteria->compare('responsable',$this->responsable,true);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('departamento',$this->departamento,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->condition = 'id_orden_solicitud='.$id_orden_solicitud;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function must_be_less_than_solicitud(){
		$dirs = OrdenSolicitudDireccion::model()->findAllByAttributes(array('id_orden_solicitud' => $this->id_orden_solicitud));
		$cant = 0;
		if(count($dirs) > 0){
			foreach($dirs as $d){
				if($this->isNewRecord == false and $d->id == $this->id){
					
				}else{
					$cant += $d->cantidad;
				}
			}
		}
		if(($cant + $this->cantidad) > $this->orden_solicitud->cantidad){
			$this->addError('cantidad','La cantidad total exede la cantidad solicitada del producto.');
		}
	}
	
	public function cantidadDisponible(){
		$docs = DetalleOrdenCompra::model()->findAllByAttributes(array('id_direccion' => $this->id));
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
}
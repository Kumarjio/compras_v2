<?php

/**
 * This is the model class for table "orden_compra".
 *
 * The followings are the available columns in table 'orden_compra':
 * @property integer $id
 * @property integer $id_usuario
 * @property string $creacion
 */
class OrdenCompra extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdenCompra the static model class
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
		return 'orden_compra';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, id_orden', 'numerical', 'integerOnly'=>true),
			array('creacion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_usuario, creacion', 'safe', 'on'=>'search'),
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
			'orden' => array(self::BELONGS_TO, 'Orden', 'id_orden'),
			'usuario' => array(self::BELONGS_TO, 'Empleados', 'id_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_usuario' => 'Id Usuario',
			'creacion' => 'Creacion',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id_orden)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('id_orden',$id_orden);
		$criteria->compare('creacion',$this->creacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getNit(){
		$detalle = DetalleOrdenCompraOp::model()->findByAttributes(array('id_orden_compra' => $this->id));
		if($detalle != null){
			$razon_social = $detalle->idProveedor->razon_social;
			return $detalle->id_proveedor;
		}else{
			return '';
		}
	}

	public function getRazonSocial(){
		$detalle = DetalleOrdenCompraOp::model()->findByAttributes(array('id_orden_compra' => $this->id));
		if($detalle != null){
			return $detalle->idProveedor->razon_social;
		}else{
			return '';
		}
	}
}

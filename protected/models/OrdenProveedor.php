<?php

/**
 * This is the model class for table "orden_proveedor".
 *
 * The followings are the available columns in table 'orden_proveedor':
 * @property integer $id
 * @property integer $id_orden
 * @property integer $nit
 * @property integer $proveedor
 * @property integer $cantidad
 * @property string $valor_unitario
 * @property string $total_compra
 * @property string $path_adjunto
 * @property string $observaciones
 *
 * The followings are the available model relations:
 * @property Orden $idOrden
 */
class OrdenProveedor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdenProveedor the static model class
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
		return 'orden_proveedor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_orden, proveedor', 'required'),
			array('cantidad, valor_unitario, total_compra', 'numerical', 'integerOnly'=>true),
			array('proveedor,nit', 'safe'),
			array('path_adjunto, observaciones', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_orden, nit, proveedor, cantidad, valor_unitario, total_compra, path_adjunto, observaciones', 'safe', 'on'=>'search'),
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
			'idOrden' => array(self::BELONGS_TO, 'Orden', 'id_orden'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_orden' => 'Id Orden',
			'nit' => 'Nit',
			'proveedor' => 'Proveedor',
			'cantidad' => 'Cantidad',
			'valor_unitario' => 'Valor Unitario',
			'total_compra' => 'Total Compra',
			'path_adjunto' => 'Path Adjunto',
			'observaciones' => 'Observaciones',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($orden)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->condition = "id_orden = :o";
		$criteria->params = array(':o' => $orden);

		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden',$this->id_orden);
		$criteria->compare('nit',$this->nit);
		$criteria->compare('proveedor',$this->proveedor);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('valor_unitario',$this->valor_unitario,true);
		$criteria->compare('total_compra',$this->total_compra,true);
		$criteria->compare('path_adjunto',$this->path_adjunto,true);
		$criteria->compare('observaciones',$this->observaciones,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
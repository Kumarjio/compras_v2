<?php

/**
 * This is the model class for table "producto".
 *
 * The followings are the available columns in table 'producto':
 * @property integer $id
 * @property string $nombre
 *
 * The followings are the available model relations:
 * @property ProductoOrden[] $productoOrdens
 */
class Producto extends CActiveRecord
{
	public $orden;
	public $nombre_familia_search;
	public $nombre_categoria_search;
	public $id_categoria;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Producto the static model class
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
		return 'producto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, id_familia, id_categoria', 'required'),
			array('nombre', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, nombre_familia_search, id_categoria, id_familia', 'safe', 'on'=>'search'),
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
			'productoOrdens' => array(self::HAS_MANY, 'ProductoOrden', 'producto'),
			'familia' => array(self::BELONGS_TO, 'FamiliaProducto', 'id_familia'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'id_familia' => 'Familia',
			'id_categoria'=>'Categoria'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('familia');
		$criteria->compare('id',$this->id);
		$criteria->compare('LOWER(t.nombre)',strtolower($this->nombre),true);
		$criteria->compare('id_familia', $this->id_familia);
		$criteria->compare('familia.id_categoria', $this->id_categoria);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			        'attributes'=>array(
			            'nombre_familia_search'=>array(
			                'asc'=>'familia.nombre',
			                'desc'=>'familia.nombre DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}
	
	public function search_solicitud($id_orden)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$orden = Orden::model()->findByPk($id_orden);
		if($orden->id_vicepresidencia){
			if($orden->id_gerencia)
				$where = "((id_vice = $orden->id_vicepresidencia and id_direccion = $orden->id_gerencia) or (id_vice = $orden->id_vicepresidencia and id_direccion is null))";
			else
				$where = "(id_vice = $orden->id_vicepresidencia and id_direccion is null)";
		}
		else {
			if($orden->id_gerencia)
				$where = "id_direccion = $orden->id_gerencia";
		}
		$criteria=new CDbCriteria;
		$criteria->with = array('familia');
		$anio = date('Y');
		$criteria->addCondition('"t"."id" in (select id_producto from presupuesto where anio = '.$anio.' and '.$where.')');
		$criteria->compare('id',$this->id);
		$criteria->compare('LOWER(t.nombre)',strtolower($this->nombre),true);
		$criteria->compare('id_familia', $this->id_familia);
		$criteria->compare('familia.id_categoria', $this->id_categoria);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			        'attributes'=>array(
			            'nombre_familia_search'=>array(
			                'asc'=>'familia.nombre',
			                'desc'=>'familia.nombre DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}

	public function search_presupuesto()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('familia');
		//$criteria->with = array('familia.idCategoria');
		$criteria->compare('id',$this->id);
		$criteria->compare('LOWER(t.nombre)',strtolower($this->nombre),true);
		$criteria->compare('id_familia', $this->id_familia);
		$criteria->compare('familia.id_categoria', $this->id_categoria);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
					'pageSize'=>'5',
			), 
			'sort'=>array(
			        'attributes'=>array(
			            'nombre_familia_search'=>array(
			                'asc'=>'familia.nombre',
			                'desc'=>'familia.nombre DESC',
			            ),
			            '*',
			        ),
			    ),
		));
	}

	public function buscarProductosMarco(){
		$disponibilidad = DisponiblesMarcoCompras::model()->findAllByAttributes(array('producto'=>$this->id),"disponible > 0");
		if($disponibilidad){
			$cantidad = 0;
			$valor = 0;
			foreach ($disponibilidad as $d) {
				if($d->forma_negociacion == 'cantidad')
					$cantidad += $d->disponible;
				else
					$valor += $d->disponible;
			}
			$texto = "";
			if ($cantidad) {
				$texto .= Yii::app()->format->formatNumber($cantidad) . ' uds. <br>'; 
			}
			if ($valor) {
				$texto .= '$' . Yii::app()->format->formatNumber($valor);
			}
			return '<span class="badge bg-green">'. $texto . '</span>';
		}
		return '';
	}

	public function buscarProductosMarcoIdDetalle(){
		$disponibilidad = DisponiblesMarcoCompras::model()->findByAttributes(array('producto'=>$this->id));
		if($disponibilidad){
			return $disponibilidad->id_detalle_om;
		}
		return '';
	}

	public function buscarProductoPresupuesto($id_orden){
		$orden = Orden::model()->findByPk($id_orden);
		if($orden->id_vicepresidencia != ''){
			$presupuesto = Presupuesto::model()->findAllByAttributes(array('id_producto'=>$this->id, 'id_vice'=>$orden->id_vicepresidencia, 'anio' => date('Y')),"id_direccion = $orden->id_gerencia or id_direccion is null");
		}
		else
			$presupuesto = Presupuesto::model()->findAllByAttributes(array('id_producto'=>$this->id, 'id_direccion'=>$orden->id_gerencia, 'anio' => date('Y')));

		$valor = 0;
		foreach ($presupuesto as $p) {
			$valor += $p->valor;
		}

		if($valor){
			return '<span class="badge bg-green">'.Yii::app()->format->formatNumber($valor).'</span>';
		}
		return '';
	}

}
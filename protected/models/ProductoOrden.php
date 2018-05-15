<?php

/**
 * This is the model class for table "producto_orden".
 *
 * The followings are the available columns in table 'producto_orden':
 * @property integer $id
 * @property integer $orden
 * @property integer $producto
 *
 * The followings are the available model relations:
 * @property Cotizacion[] $cotizacions
 * @property Producto $producto0
 * @property Orden $orden0
 */
class ProductoOrden extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductoOrden the static model class
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
		return 'producto_orden';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orden', 'required'),
			array('razon_rechazo', 'required', 'on' => 'razon_rechazo'),
			array('orden, producto, usuario_rechazo', 'numerical', 'integerOnly'=>true),
            array('fecha_rechazo, rechazado', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, orden, producto', 'safe', 'on'=>'search'),
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
			'cotizacions' => array(self::HAS_MANY, 'Cotizacion', 'producto_orden'),
            'cotizacion_elegida' => array(self::HAS_MANY, 'Cotizacion', 'producto_orden', 
                                          "condition" => "elegido_comite = :ec",
                                          'params' => array(':ec' => 1)),
			'producto0' => array(self::BELONGS_TO, 'Producto', 'producto'),
			'orden0' => array(self::BELONGS_TO, 'Orden', 'orden'),
			'orden_solicitud0' => array(self::BELONGS_TO, 'OrdenSolicitud', 'orden_solicitud'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'orden' => 'Orden',
			'producto' => 'Producto',
		);
	}
	
	
	public static function get_descripcion($desc, $id, $l){
		$nd = array();
		$desc = CHtml::encode($desc);
		$desc = str_replace(PHP_EOL, '<br/>', $desc);
		$resp = '<a onClick="$(\'#razonEleccion .modal-body\').html($(\'#ver-mas-'.$id.$l.'\').html()); $(\'#ver-mas-modal\').modal(\'show\');" style="cursor:pointer;">'.$l.'</a><div id="ver-mas-'.$id.$l.'" style="display:none;">'.$desc.'</div>';
		return $resp;
	}
	
	public static function get_descripcion_2($desc, $id, $l){
		$nd = array();
		$desc = CHtml::encode($desc);
		if(strlen($desc) > 200){
			$nd[] = substr($desc,0,200);
			$nd[] = substr($desc,201);
			$desc = str_replace(PHP_EOL, '<br/>', $desc);
			$resp = $nd[0].'... <a onClick="$(\'#ver-mas-modal-content\').html($(\'#ver-mas-'.$id.$l.'\').html()); $(\'#ver-mas-modal\').modal(\'show\');" style="cursor:pointer;">ver mas (+)</a><div id="ver-mas-'.$id.$l.'" style="display:none;">'.$desc.'</div>';
			//$resp = $nd[0].'<div id="ver-mas-'.$id.$l.'" style="display:none;">'.$nd[1].'</div><div id="pp-'.$id.$l.'" style="display:block;">...<a  onClick="$(\'#ver-mas-'.$id.$l.'\').slideDown(); $(\'#pp-'.$id.$l.'\').slideUp(); $(\'#vm-'.$id.$l.'\').slideDown();" style="cursor:pointer;">ver mas (+)</a></div><div id="vm-'.$id.$l.'" style="display:none;"><a  onClick="$(\'#ver-mas-'.$id.$l.'\').slideUp(); $(\'#vm-'.$id.$l.'\').slideUp(); $(\'#pp-'.$id.$l.'\').slideDown();" style="cursor:pointer;">ver menos (-)</a></div>';
		}else{
			$resp = $desc;
		}
		return $resp;
	}
	
	public static function get_descripcion_3($desc, $id, $l){
		$nd = array();
		$desc = CHtml::encode($desc);
		if(strlen($desc) > 200){
			$nd[] = substr($desc,0,200);
			$nd[] = substr($desc,201);
			$resp = $nd[0].'<div id="ver-mas-'.$id.$l.'" style="display:none;">'.$nd[1].'</div><div id="pp-'.$id.$l.'" style="display:block;">...<a  onClick="$(\'#ver-mas-'.$id.$l.'\').slideDown(); $(\'#pp-'.$id.$l.'\').slideUp(); $(\'#vm-'.$id.$l.'\').slideDown();" style="cursor:pointer;">ver mas (+)</a></div><div id="vm-'.$id.$l.'" style="display:none;"><a  onClick="$(\'#ver-mas-'.$id.$l.'\').slideUp(); $(\'#vm-'.$id.$l.'\').slideUp(); $(\'#pp-'.$id.$l.'\').slideDown();" style="cursor:pointer;">ver menos (-)</a></div>';
		}else{
			$resp = $desc;
		}
		return $resp;
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

		$criteria->compare('id',$this->id);
		$criteria->compare('orden',$this->orden);
		$criteria->compare('producto',$this->producto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
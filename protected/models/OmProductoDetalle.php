<?php

/**
 * This is the model class for table "om_producto_detalle".
 *
 * The followings are the available columns in table 'om_producto_detalle':
 * @property integer $id
 * @property integer $id_orden_marco
 * @property integer $producto
 * @property boolean $rechazado
 * @property integer $usuario_rechazo
 * @property string $fecha_rechazo
 * @property string $razon_rechazo
 *
 * The followings are the available model relations:
 * @property OrdenMarcoCompras $idOrdenMarco
 * @property Producto $producto0
 * @property OmCotizacion[] $omCotizacions
 */
class OmProductoDetalle extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'om_producto_detalle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_orden_marco', 'required'),
			array('id_orden_marco, producto, usuario_rechazo', 'numerical', 'integerOnly'=>true),
			array('razon_rechazo', 'length', 'max'=>255),
			array('rechazado, fecha_rechazo', 'safe'),
			array('razon_rechazo', 'required', 'on'=>'razon_rechazo'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_orden_marco, producto, rechazado, usuario_rechazo, fecha_rechazo, razon_rechazo', 'safe', 'on'=>'search'),
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
			'idOrdenMarco' => array(self::BELONGS_TO, 'OrdenMarcoCompras', 'id_orden_marco'),
			'producto0' => array(self::BELONGS_TO, 'Producto', 'producto'),
			'omCotizacions' => array(self::HAS_MANY, 'OmCotizacion', 'producto_detalle_om'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_orden_marco' => 'Id Orden Marco',
			'producto' => 'Producto',
			'rechazado' => 'Rechazado',
			'usuario_rechazo' => 'Usuario Rechazo',
			'fecha_rechazo' => 'Fecha Rechazo',
			'razon_rechazo' => 'Razon Rechazo',
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

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden_marco',$this->id_orden_marco);
		$criteria->compare('producto',$this->producto);
		$criteria->compare('rechazado',$this->rechazado);
		$criteria->compare('usuario_rechazo',$this->usuario_rechazo);
		$criteria->compare('fecha_rechazo',$this->fecha_rechazo,true);
		$criteria->compare('razon_rechazo',$this->razon_rechazo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_om($id_marco)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_orden_marco',$id_marco);
		$criteria->compare('producto',$this->producto);
		$criteria->compare('rechazado',$this->rechazado);
		$criteria->compare('usuario_rechazo',$this->usuario_rechazo);
		$criteria->compare('fecha_rechazo',$this->fecha_rechazo,true);
		$criteria->compare('razon_rechazo',$this->razon_rechazo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OmProductoDetalle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

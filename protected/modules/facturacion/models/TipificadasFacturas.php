<?php

/**
 * This is the model class for table "facturacion.tipificadas_facturas".
 *
 * The followings are the available columns in table 'facturacion.tipificadas_facturas':
 * @property integer $id_tipificadas_facturas
 * @property integer $id_factura
 * @property string $cuenta
 * @property string $codigo_tipificada
 * @property string $descripcion_tipificada
 * @property string $consecutivo_valor
 * @property string $descripcion_valor
 * @property string $valor
 */
class TipificadasFacturas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TipificadasFacturas the static model class
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
		return 'facturacion.tipificadas_facturas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_factura', 'numerical', 'integerOnly'=>true),
			array('cuenta, codigo_tipificada, descripcion_tipificada, consecutivo_valor, descripcion_valor, valor, agencia, centro_costos', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_tipificadas_facturas, id_factura, cuenta, codigo_tipificada, descripcion_tipificada, consecutivo_valor, descripcion_valor, valor, agencia, centro_costos', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_tipificadas_facturas' => 'Id Tipificadas Facturas',
			'id_factura' => 'Id Factura',
			'cuenta' => 'Cuenta',
			'codigo_tipificada' => 'Código Tipificada',
			'descripcion_tipificada' => 'Descripción Tipificada',
			'consecutivo_valor' => 'Consecutivo Valor',
			'descripcion_valor' => 'Descripción Valor',
			'valor' => 'Valor',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
        public function search_detalle($cuenta, $tipificada, $factura) {
            
            $criteria=new CDbCriteria;

//		$criteria->compare('id_tipificadas_facturas',$this->id_tipificadas_facturas);
		$criteria->compare('cuenta',$cuenta,true);
		$criteria->compare('codigo_tipificada',$tipificada,true);
//		$criteria->compare('consecutivo_valor',$this->consecutivo_valor,true);
//		$criteria->compare('descripcion_valor',$this->descripcion_valor,true);
//		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('id_factura',$factura);
                
//                $criteria->select = 'cuenta, codigo_tipificada,descripcion_tipificada';
//                $criteria->group = '1,2,3';
                
		if(!isset($_GET['TipificadasFacturas_sort']))
		  $criteria->order = "t.consecutivo_valor::integer";
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>FALSE
		));
        }
        
        public function search_lote_generado($factura) {
            
                $criteria=new CDbCriteria;

//		$criteria->compare('id_tipificadas_facturas',$this->id_tipificadas_facturas);
//		$criteria->compare('cuenta',$cuenta,true);
		$criteria->compare('codigo_tipificada::integer',$tipificada);
		$criteria->compare('consecutivo_valor::integer',$this->consecutivo_valor);
//		$criteria->compare('descripcion_valor',$this->descripcion_valor,true);
//		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('id_factura',$factura);
                $criteria->addCondition("(vr_codigo_cuentas <> '' or valor <> '')");
                
//                $criteria->select = 'cuenta, codigo_tipificada,descripcion_tipificada';
//                $criteria->group = '1,2,3';
                
		if(!isset($_GET['TipificadasFacturas_sort']))
		  $criteria->order = "t.codigo_tipificada asc, t.consecutivo_valor asc";
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>FALSE
		));
        }
        
	public function search($factura)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

//		$criteria->compare('id_tipificadas_facturas',$this->id_tipificadas_facturas);
//		$criteria->compare('cuenta',$this->cuenta,true);
//		$criteria->compare('codigo_tipificada',$this->codigo_tipificada,true);
//		$criteria->compare('codigo_tipificada',$this->descripcion_tipificada,true);
//		$criteria->compare('consecutivo_valor',$this->consecutivo_valor,true);
//		$criteria->compare('descripcion_valor',$this->descripcion_valor,true);
//		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('id_factura',$factura);
                
                $criteria->select = 'id_factura, cuenta, codigo_tipificada,descripcion_tipificada';
                $criteria->group = '1,2,3,4';
                
		if(!isset($_GET['TipificadasFacturas_sort']))
		  $criteria->order = "t.cuenta, t.codigo_tipificada";
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>FALSE
		));
	}
        
        public function traerCampo() {
            return CBaseController::widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model'=>$this,
                'attribute'=>'nombre_analista',
                'name'=>'nombre_analista',
                'source'=>array_map(function($key, $value) {
                    $algo = explode(' - ', $value);
                   return array('label' => $value, 'value' => $algo[1], 'key'=>  $key);
                }, 
                array_keys(Facturas::model()->getAnalista()), 
                Facturas::model()->getAnalista()),
                'htmlOptions'=>array(
                    'class'=>'span5',
                ),
                'options'=> array(
                    'select'=>"js:function(event, ui) { 
                        $('#Facturas_analista_encargado').val(ui.item.key); 
                    }",
                    'response'=>"js:function(event, ui) { 
                        console.log('HL close');
                    }"
                ),
            ));
        }
}
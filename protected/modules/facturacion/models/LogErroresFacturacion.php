<?php

/**
 * This is the model class for table "facturacion.log_errores_facturacion".
 *
 * The followings are the available columns in table 'facturacion.log_errores_facturacion':
 * @property integer $id_log_errores_facturacion
 * @property integer $id_factura
 * @property string $cod_error
 * @property string $descripcion_error
 * @property string $pagina
 */
class LogErroresFacturacion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogErroresFacturacion the static model class
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
		return 'facturacion.log_errores_facturacion';
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
			array('cod_error, descripcion_error, pagina, fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_log_errores_facturacion, id_factura, cod_error, descripcion_error, pagina, fecha', 'safe', 'on'=>'search'),
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
			'id_log_errores_facturacion' => 'Id Log Errores Facturacion',
			'id_factura' => 'Id Factura',
			'cod_error' => 'Cod Error',
			'descripcion_error' => 'Descripcion Error',
			'pagina' => 'Pagina',
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

		$criteria->compare('id_log_errores_facturacion',$this->id_log_errores_facturacion);
		$criteria->compare('id_factura',$this->id_factura);
		$criteria->compare('cod_error',$this->cod_error,true);
		$criteria->compare('descripcion_error',$this->descripcion_error,true);
		$criteria->compare('pagina',$this->pagina,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
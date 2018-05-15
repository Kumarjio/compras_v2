<?php

/**
 * This is the model class for table "documento_proveedor_trazabilidad".
 *
 * The followings are the available columns in table 'documento_proveedor_trazabilidad':
 * @property integer $id_trazabilidad
 * @property integer $id_docpro
 * @property string $user_insert
 * @property string $fecha_insert
 * @property integer $estado
 */
class DocumentoProveedorTrazabilidad extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DocumentoProveedorTrazabilidad the static model class
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
		return 'documento_proveedor_trazabilidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_docpro, estado', 'numerical', 'integerOnly'=>true),
			array('user_insert, fecha_insert, observacion', 'safe'),
			array('observacion','required','on'=>'devolver'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_trazabilidad, id_docpro, user_insert, fecha_insert, estado', 'safe', 'on'=>'search'),
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
			'estado_rel' => array(self::BELONGS_TO, 'DocumentoProveedorEstado', 'estado'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_trazabilidad' => 'Id Trazabilidad',
			'id_docpro' => 'Id Docpro',
			'user_insert' => 'Usuario',
			'fecha_insert' => 'Fecha',
			'estado' => 'Estado',
			'observacion' => 'Observación'
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

		$criteria->compare('id_trazabilidad',$this->id_trazabilidad);
		$criteria->compare('id_docpro',$this->id_docpro);
		$criteria->compare('user_insert',$this->user_insert,true);
		$criteria->compare('fecha_insert',$this->fecha_insert,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search_traza($id_docpro)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_trazabilidad',$this->id_trazabilidad);
		$criteria->compare('id_docpro',$id_docpro);
		$criteria->compare('user_insert',$this->user_insert,true);
		$criteria->compare('fecha_insert',$this->fecha_insert,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
				'pagination'=>false,
				'sort'=>false
		));
	}
	
	public static function insertarTrazabilidad($estado, $id_docpro, $observacion=null){
		$model= new DocumentoProveedorTrazabilidad();
		if($estado==3){
			$model->setScenario('devolver');
		}
	    $model->user_insert=Yii::app()->user->id;
		$model->estado=$estado;
		$model->id_docpro=$id_docpro;
		$model->observacion=$observacion;
		$model->save();
	}
	
}
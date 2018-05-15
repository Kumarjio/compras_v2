<?php

/**
 * This is the model class for table "poliza_documento".
 *
 * The followings are the available columns in table 'poliza_documento':
 * @property integer $id_poldoc
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property boolean $fecha_fin_ind
 * @property integer $id_tipo_poliza
 */
class PolizaDocumento extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PolizaDocumento the static model class
	 */
	public $tiempo_pre_anio;
	public $tiempo_pre_mes;
	public $tiempo_pre_dia;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'poliza_documento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipo_poliza, id_docpro', 'numerical', 'integerOnly'=>true),
			array('fecha_inicio, fecha_fin, fecha_fin_ind, id_docpro', 'safe'),
                        array('fecha_inicio, id_tipo_poliza, id_docpro', 'required'),
                        array('fecha_inicio, fecha_fin', 'date', 'format'=>'yyyy-mm-dd','message'=>'Formato incorrecto para {attribute}, debe ser yyyy-mm-dd'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_poldoc, fecha_inicio, fecha_fin, fecha_fin_ind, id_tipo_poliza', 'safe', 'on'=>'search'),
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
			'tipoPoliza' => array(self::BELONGS_TO, 'TipoPoliza', 'id_tipo_poliza'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_poldoc' => 'Id Poldoc',
			'fecha_inicio' => 'Fecha Inicio',
			'fecha_fin' => 'Fecha Fin',
			'fecha_fin_ind' => 'Fecha Fin Ind',
			'id_tipo_poliza' => 'Tipo Poliza',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id_docpro)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->compare('id_docpro',$id_docpro);
		$criteria->compare('id_poldoc',$this->id_poldoc);
		$criteria->compare('fecha_inicio',$this->fecha_inicio,true);
		$criteria->compare('fecha_fin',$this->fecha_fin,true);
		$criteria->compare('fecha_fin_ind',$this->fecha_fin_ind);
		$criteria->compare('id_tipo_poliza',$this->id_tipo_poliza);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
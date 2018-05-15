<?php

/**
 * This is the model class for table "tipo_inhabilidad".
 *
 * The followings are the available columns in table 'tipo_inhabilidad':
 * @property integer $id_tipo_inhabilidad
 * @property string $nombre_inhabilidad
 * @property string $descripcion_inhabilidad
 * @property boolean $fecha_inicio
 * @property boolean $fecha_fin
 * @property boolean $reemplazo
 * @property boolean $estado
 *
 * The followings are the available model relations:
 * @property Inhabilidad[] $inhabilidads
 */
class TipoInhabilidad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tipo_inhabilidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_inhabilidad, descripcion_inhabilidad', 'required'),
			array('fecha_inicio, fecha_fin, reemplazo, estado', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_tipo_inhabilidad, nombre_inhabilidad, descripcion_inhabilidad, fecha_inicio, fecha_fin, reemplazo, estado', 'safe', 'on'=>'search'),
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
			'inhabilidads' => array(self::HAS_MANY, 'Inhabilidad', 'id_tipo_inhabilidad'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_tipo_inhabilidad' => 'Tipo Inhabilidad',
			'nombre_inhabilidad' => 'Nombre Inhabilidad',
			'descripcion_inhabilidad' => 'Descripcion Inhabilidad',
			'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'reemplazo' => 'Reemplazo',
			'estado' => 'Estado',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_tipo_inhabilidad',$this->id_tipo_inhabilidad);
		$criteria->compare('nombre_inhabilidad',$this->nombre_inhabilidad,true);
		$criteria->compare('descripcion_inhabilidad',$this->descripcion_inhabilidad,true);
		$criteria->compare('fecha_inicio',$this->fecha_inicio);
        $criteria->compare('fecha_fin',$this->fecha_fin);
        $criteria->compare('reemplazo',$this->reemplazo);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TipoInhabilidad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

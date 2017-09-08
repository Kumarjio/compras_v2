<?php

/**
 * This is the model class for table "observaciones_trazabilidad".
 *
 * The followings are the available columns in table 'observaciones_trazabilidad':
 * @property integer $id
 * @property string $id_trazabilidad
 * @property string $na
 * @property string $observacion
 * @property string $fecha
 * @property string $usuario
 *
 * The followings are the available model relations:
 * @property Trazabilidad $idTrazabilidad
 * @property Usuario $usuario0
 */
class ObservacionesTrazabilidad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'observaciones_trazabilidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_trazabilidad, observacion, usuario, na', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_trazabilidad, na, observacion, fecha, usuario', 'safe', 'on'=>'search'),
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
			'idTrazabilidad' => array(self::BELONGS_TO, 'Trazabilidad', 'id_trazabilidad'),
			'usuario0' => array(self::BELONGS_TO, 'Usuario', 'usuario'),
			'na0' => array(self::BELONGS_TO, 'Recepcion', 'na'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_trazabilidad' => 'Id Trazabilidad',
			'observacion' => 'Observacion',
			'fecha' => 'Fecha',
			'usuario' => 'Usuario',
			'na' => 'Na',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('id_trazabilidad',$this->id_trazabilidad,true);
		$criteria->compare('observacion',$this->observacion,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('na',$this->na,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ObservacionesTrazabilidad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function search_detalle()
	{
		$criteria=new CDbCriteria;
		if(!empty($_POST['id'])){
			$criteria->compare('id_trazabilidad',$_POST['id']);
		}else if(!empty($_POST['ObservacionesTrazabilidad']['id_trazabilidad'])){
			$criteria->compare('id_trazabilidad',$_POST['ObservacionesTrazabilidad']['id_trazabilidad']);
		}else{
			$criteria->compare('id_trazabilidad',-1);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => false
		));
	}
}

<?php

/**
 * This is the model class for table "actividades".
 *
 * The followings are the available columns in table 'actividades':
 * @property integer $id
 * @property string $actividad
 *
 * The followings are the available model relations:
 * @property Flujo[] $flujos
 * @property Flujo[] $flujos1
 */
class Actividades extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'actividades';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('actividad', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, actividad', 'safe', 'on'=>'search'),
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
			'flujos' => array(self::HAS_MANY, 'Flujo', 'actividad'),
			'flujos1' => array(self::HAS_MANY, 'Flujo', 'sucesion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'actividad' => 'Actividad',
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
		$criteria->compare('actividad',$this->actividad,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Actividades the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function cargaActividades()
	{
	 	$actividades = CHtml::listData(Actividades::model()->findAll(array('order' => 'id')),'id','actividad');
	 	return $actividades;
	}
	public static function cierraActividad($na,$flujo)
	{
		$hoy = date("d/m/Y"." "."H:i:s");
		$consulta = Trazabilidad::model()->findByAttributes(array("na"=>$na, "actividad"=>$flujo));
		$model=Trazabilidad::model()->findByPk($consulta->id);
		$model->estado = "2";
		$model->user_cierre = Yii::app()->user->usuario;
		$model->fecha_cierre = $hoy;
		$model->save();
		return true;
	}
	public static function abrirActividad($na,$flujo)
	{
		$trazabilidad = new Trazabilidad;
		$sucesion = Actividades::model()->sucesionActividad($na,$flujo);
		$user_asign = UsuariosFlujo::model()->asignacionUsuario($sucesion);
		$trazabilidad->na = $na;
		$trazabilidad->user_asign = $user_asign;
		$trazabilidad->estado = "1";
		$trazabilidad->actividad = $sucesion;
		$trazabilidad->save();
		return true;
	}
	public static function sucesionActividad($na,$flujo)
	{
		$tipologia = Tipologias::model()->getTipologia($na);
		$consulta_sucesion = Flujo::model()->findByAttributes(array("tipologia"=>$tipologia, "id"=>$flujo));
		$flujo = Flujo::model()->findByAttributes(array("tipologia"=>$tipologia, "actividad"=>$consulta_sucesion->sucesion));
		return $flujo->id;
	}
	public static function consultaActividad($flujo)
	{
		$actividad = Flujo::model()->findByAttributes(array("id"=>$flujo));
		return $flujo->actividad;
	}
}

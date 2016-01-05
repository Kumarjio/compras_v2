<?php

/**
 * This is the model class for table "disponibilidad".
 *
 * The followings are the available columns in table 'disponibilidad':
 * @property integer $id_disponibilidad
 * @property integer $id_tipo_consulta
 * @property string $fecha
 * @property string $inicio
 * @property string $fin
 * @property integer $id_recurso
 * @property integer $id_procedimiento
 * @property integer $id_maquina
 * @property integer $estado
 */
class Disponibilidad extends CActiveRecord
{
	public $fecha_inicio;
	public $hora_inicio;
	public $fecha_fin;
	public $hora_fin;
	public $especialidad;
	public $examen;
	public $id_tipo_consulta;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'disponibilidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipo_consulta, id_recurso, estado, id_procedimiento, id_maquina', 'numerical', 'integerOnly'=>true),
			array('id_tipo_consulta, id_recurso, id_procedimiento, fecha_inicio, hora_inicio, fecha_fin, hora_fin', 'required', 'on' =>'creaDisp'),
			array('fecha, inicio, fin', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_tipo_consulta, id_disponibilidad, fecha, inicio, fin, id_recurso, id_procedimiento, id_maquina, estado, fecha_inicio, hora_inicio, fecha_fin, hora_fin', 'safe', 'on'=>'search'),
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
                    'idRecurso' => array(self::BELONGS_TO, 'Recursos', 'id_recurso'),
		);
	}

	private function conditionalValidations(){	

		if(!empty($this->id_procedimiento)){
			$sqlPro = "SELECT id_tipo_prestacion FROM procedimientos WHERE id_procedimiento = '".$this->id_procedimiento."'";
        	$tipo = Yii::app()->db->createCommand($sqlPro)->queryScalar();
        	if($tipo == "2")
				$this->validatorList->add(CValidator::createValidator('required', $this, 'id_maquina', array('on' =>array('creaDisp'))));	
		}
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_disponibilidad' => 'Id Disponibilidad',
			'id_tipo_consulta' => 'Tipo Consulta',
			'fecha' => 'Fecha',
			'inicio' => 'Inicio',
			'fin' => 'Fin',
			'id_recurso' => 'Recurso',
			'id_procedimiento' => 'Procedimiento',
			'id_maquina' => 'Máquina',
			'estado' => 'Estado',
			'fecha_inicio' => 'Fecha Inicio',
			'hora_inicio' => 'Hora Inicio',
			'fecha_fin' => 'Fecha Fin',
			'hora_fin' => 'Hora Fin',
			'especialidad' => 'Especialidad',
			'examen' => 'Exámen',
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
	//public function search($id_recurso)
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_disponibilidad',$this->id_disponibilidad);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('fin',$this->fin,true);
		$criteria->compare('id_recurso',$this->id_recurso);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeValidate()
	{		
		$this->conditionalValidations();		
		return parent::beforeValidate();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Disponibilidad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

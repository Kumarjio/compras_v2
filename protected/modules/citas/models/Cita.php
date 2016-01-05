<?php

/**
 * This is the model class for table "cita".
 *
 * The followings are the available columns in table 'cita':
 * @property integer $id_cita
 * @property integer $id_paciente
 * @property integer $id_disponibilidad
 */
class Cita extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cita';
	}
        
        
        public function behaviors()
	{
		return array(
                    'swBehavior'=>array(
                        'class' => 'application.components.behavior.MySimpleWorkflow'
                    ),

//                    'fechaRegistro' => array(
//                            'class' => 'application.components.behavior.FechaRegistroBehavior'
//                    ),

//                    'WorkflowObservaciones'=>array(
//                        'class' => 'application.components.behavior.WorkflowObservaciones',
//                    ),
                    'WorkflowTrazabilidad'=>array(
                        'class' => 'application.components.behavior.WorkflowTrazabilidadCita',
                    ),
//                    'ActiveRecordLogableBehavior'=>array(
//                        'class' => 'application.components.behavior.ActiveRecordLogableBehavior',
//                    ),

                    
		);
	}
        
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_paciente, id_disponibilidad, id_especialidad', 'numerical', 'integerOnly'=>true),
                        array('id_especialidad, paso_wf','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_cita, id_paciente, id_disponibilidad', 'safe', 'on'=>'search'),
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
                    'idDisponibilidad' => array(self::BELONGS_TO, 'Disponibilidad', 'id_disponibilidad'),
                    'idEspecialidad' => array(self::BELONGS_TO, 'Especialidad', 'id_especialidad'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_cita' => 'Id Cita',
			'id_paciente' => 'Id Paciente',
			'id_disponibilidad' => 'Id Disponibilidad',
                        'id_especialidad'=>'Especialidad'
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
	public function search_tipo_1($id_paciente)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->join = 'inner join disponibilidad on disponibilidad.id_disponibilidad = t.id_disponibilidad ';
                $criteria->join .= 'inner join recursos on recursos.id_recurso = disponibilidad.id_recurso ';
                $criteria->addCondition("recursos.id_tipo_recurso = 1");
		$criteria->compare('id_cita',$this->id_cita);
		$criteria->compare('id_paciente',$id_paciente);
		$criteria->compare('id_disponibilidad',$this->id_disponibilidad);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
	public function search_tipo_2($id_paciente)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->join = 'inner join disponibilidad on disponibilidad.id_disponibilidad = t.id_disponibilidad ';
                $criteria->join .= 'inner join recursos on recursos.id_recurso = disponibilidad.id_recurso ';
                $criteria->addCondition("recursos.id_tipo_recurso = 2");
		$criteria->compare('id_cita',$this->id_cita);
		$criteria->compare('id_paciente',$id_paciente);
		$criteria->compare('id_disponibilidad',$this->id_disponibilidad);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cita the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

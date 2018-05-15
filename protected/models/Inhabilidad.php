<?php

/**
 * This is the model class for table "inhabilidad".
 *
 * The followings are the available columns in table 'inhabilidad':
 * @property string $id_inhabilidad
 * @property string $usuario
 * @property integer $id_tipo_inhabilidad
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property string $reemplazo
 * @property boolean $activa
 * @property string $usuario_inhabilita
 * @property string $fecha_inhabilita
 *
 * The followings are the available model relations:
 * @property Usuario $usuario0
 * @property TipoInhabilidad $idTipoInhabilidad
 * @property Usuario $reemplazo0
 * @property Usuario $usuarioInhabilita
 */
class Inhabilidad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'inhabilidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, id_tipo_inhabilidad, usuario_inhabilita', 'required'),
			array('id_tipo_inhabilidad', 'numerical', 'integerOnly'=>true),
			array('id_inhabilidad, usuario, id_tipo_inhabilidad, fecha_inicio, fecha_fin, reemplazo, activa, usuario_inhabilita, fecha_inhabilita', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_inhabilidad, usuario, id_tipo_inhabilidad, fecha_inicio, fecha_fin, reemplazo, activa, usuario_inhabilita, fecha_inhabilita', 'safe', 'on'=>'search'),
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
			'usuario0' => array(self::BELONGS_TO, 'Usuario', 'usuario'),
			'idTipoInhabilidad' => array(self::BELONGS_TO, 'TipoInhabilidad', 'id_tipo_inhabilidad'),
			'reemplazo0' => array(self::BELONGS_TO, 'Usuario', 'reemplazo'),
			'usuarioInhabilita' => array(self::BELONGS_TO, 'Usuario', 'usuario_inhabilita'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_inhabilidad' => 'Inhabilidad',
			'usuario' => 'Usuario',
			'id_tipo_inhabilidad' => 'Tipo Inhabilidad',
			'fecha_inicio' => 'Fecha Inicio',
			'fecha_fin' => 'Fecha Fin',
			'reemplazo' => 'Reemplazo',
			'activa' => 'Activa',
			'usuario_inhabilita' => 'Usuario Inhabilita',
			'fecha_inhabilita' => 'Fecha Inhabilita',
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

		$criteria->compare('id_inhabilidad',$this->id_inhabilidad,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('id_tipo_inhabilidad',$this->id_tipo_inhabilidad);
		$criteria->compare('fecha_inicio',$this->fecha_inicio,true);
		$criteria->compare('fecha_fin',$this->fecha_fin,true);
		$criteria->compare('reemplazo',$this->reemplazo,true);
		$criteria->compare('activa',$this->activa);
		$criteria->compare('usuario_inhabilita',$this->usuario_inhabilita,true);
		$criteria->compare('fecha_inhabilita',$this->fecha_inhabilita,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeValidate(){
		
		$this->usuario_inhabilita = Yii::app()->user->usuario;
		//Crea regla de validación para fecha inicio de aplicar 
		if(!empty($this->id_tipo_inhabilidad)){
			if($this->idTipoInhabilidad->fecha_inicio){
				$this->validatorList->add(CValidator::createValidator('required', $this, 'fecha_inicio'));	
			}
			if($this->idTipoInhabilidad->fecha_fin){
				$this->validatorList->add(CValidator::createValidator('required', $this, 'fecha_fin'));	
			}
			if($this->idTipoInhabilidad->reemplazo){
				//Crea regla de validación si aplica reemplazo 
				$totalCasos = Trazabilidad::model()->countByAttributes(array("user_asign"=>$this->usuario, "estado"=>"1"));
				if($totalCasos > 0){
					$this->validatorList->add(CValidator::createValidator('required', $this, 'reemplazo'));
				}
			}
		}

		return parent::beforeValidate();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inhabilidad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function generaReemplazo(){
		//Valida si inhabilidad requiere reemplazo
		if( $this->idTipoInhabilidad->reemplazo ){
			//Valida si inhabilidad solicita fecha inicio
			if( $this->idTipoInhabilidad->fecha_inicio ){
				//Valida fecha inicio igual a hoy
				if( strtotime($this->fecha_inicio) == strtotime(date("Y-m-d")) ){
					$casos = Trazabilidad::model()->findAllByAttributes(array("user_asign"=>$this->usuario, "estado"=>"1"));
					if($casos){
						foreach ($casos as $traza){
							$modelAusente = new AusenteTrazabilidad;
							$modelAusente->usuario = $this->usuario;
			        		$modelAusente->id_trazabilidad = $traza->id;
			        		if($modelAusente->save()){
			        			$traza->user_asign = $this->reemplazo;
			        			$traza->update();
			        		}
			        		$observacion_traza = new ObservacionesTrazabilidad;
			        		$observacion_traza->id_trazabilidad = $traza->id;
			        		$observacion_traza->observacion = "Caso reasignado por inhabilidad de usuario";
			        		$observacion_traza->usuario = Yii::app()->user->usuario;
			        		$observacion_traza->na = $traza->na;
			        		$observacion_traza->save();
						}
					}
				}			
			}else if(empty($this->idTipoInhabilidad->fecha_inicio) && $this->id_tipo_inhabilidad == "4"){
				$casos = Trazabilidad::model()->findAllByAttributes(array("user_asign"=>$this->usuario, "estado"=>"1"));
				if($casos){
					foreach ($casos as $traza){
						$modelAusente = new AusenteTrazabilidad;
						$modelAusente->usuario = $this->usuario;
		        		$modelAusente->id_trazabilidad = $traza->id;
		        		if($modelAusente->save()){
		        			$traza->user_asign = $this->reemplazo;
		        			$traza->update();
		        		}
		        		$observacion_traza = new ObservacionesTrazabilidad;
		        		$observacion_traza->id_trazabilidad = $traza->id;
		        		$observacion_traza->observacion = "Caso reasignado por inhabilidad de usuario";
		        		$observacion_traza->usuario = Yii::app()->user->usuario;
		        		$observacion_traza->na = $traza->na;
		        		$observacion_traza->save();
					}
				}
			}
		}
	}
}

<?php
/**
 * This is the model class for table "trazabilidad".
 *
 * The followings are the available columns in table 'trazabilidad':
 * @property string $id
 * @property string $na
 * @property string $user_asign
 * @property string $fecha_asign
 * @property integer $estado
 * @property integer $actividad
 * @property string $user_cierre
 * @property string $fecha_cierre
 *
 * The followings are the available model relations:
 * @property ObservacionesTrazabilidad[] $observacionesTrazabilidads
 * @property Recepcion $na0
 * @property Estados $estado0
 * @property Usuario $userAsign
 * @property ActividadTipologia $actividad0
 * @property AdjuntosTrazabilidad[] $adjuntosTrazabilidads
 */
class Trazabilidad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'trazabilidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $buscar;
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('na, user_asign, estado, actividad', 'required'),
			array('estado, actividad', 'numerical', 'integerOnly'=>true),
			array('user_cierre, fecha_cierre, user_asign, buscar', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, na, user_asign, fecha_asign, estado, actividad, user_cierre, fecha_cierre, buscar', 'safe', 'on'=>'search'),
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
            'observacionesTrazabilidads' => array(self::HAS_MANY, 'ObservacionesTrazabilidad', 'id_trazabilidad'),
            'na0' => array(self::BELONGS_TO, 'Recepcion', 'na'),
            'estado0' => array(self::BELONGS_TO, 'Estados', 'estado'),
            'userAsign' => array(self::BELONGS_TO, 'Usuario', 'user_asign'),
            'actividad0' => array(self::BELONGS_TO, 'ActividadTipologia', 'actividad'),
            'adjuntosTrazabilidads' => array(self::HAS_MANY, 'AdjuntosTrazabilidad', 'id_trazabilidad'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'na' => 'Na',
			'user_asign' => 'Usuario',
			'fecha_asign' => 'Fecha Asign',
			'estado' => 'Estado',
			'actividad' => 'Actividad',
			'user_cierre' => 'User Cierre',
			'fecha_cierre' => 'Fecha Cierre',
			'buscar' => 'Buscar',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('na',$this->na,true);
		$criteria->compare('user_asign',$this->user_asign,true);
		$criteria->compare('fecha_asign',$this->fecha_asign,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('actividad',$this->actividad);
		$criteria->compare('user_cierre',$this->user_cierre,true);
		$criteria->compare('fecha_cierre',$this->fecha_cierre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Trazabilidad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function informacionTrazabilidad($na)
	{
		$trazabilidad = Trazabilidad::model()->findByAttributes(array("na"=>$na),array('order'=>'id DESC'));
		return $trazabilidad;
	}
	public function search_detalle()
	{
		$criteria=new CDbCriteria;
		if(!empty($_GET['na'])){
			$criteria->compare('na',base64_decode($_GET['na']));
		}else{
			$criteria->compare('na',-1);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			    'defaultOrder'=>'id ASC',
			  )
		));
	}
	/*public function search_adjuntos()
	{
		$sql = " SELECT ROW_NUMBER() OVER() AS no, adjunto.fecha, adjunto.nombres,  adjunto.path  FROM (
				 SELECT adj.path, recep.fecha_recepcion AS fecha,  usu.nombres || ' ' || usu.apellidos AS nombres 
				 FROM adjuntos_recepcion  AS adj
				 INNER JOIN recepcion AS recep
				 ON adj.na = recep.na
				 INNER JOIN usuario AS usu
				 ON recep.user_recepcion = usu.usuario
				 WHERE adj.na = ".$_POST['na']."
				 UNION
				 SELECT tra.path, tra.fecha, users.nombres || ' ' || users.apellidos AS nombres
				 FROM adjuntos_trazabilidad AS tra
				 INNER JOIN usuario AS users
				 ON tra.usuario = users.usuario
				 WHERE na = ".$_POST['na']."
				 ) AS adjunto "; 
		$rawData = Yii::app()->db->createCommand($sql);
		$count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') AS total')->queryScalar();
		return new CSqlDataProvider($rawData, array('totalItemCount' => $count));
	}*/
	public function search_pendientes()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		//$criteria->compare('na',$this->na,true);
		$criteria->compare('CAST(na AS TEXT)',$this->buscar,true);
		$criteria->compare('user_asign',Yii::app()->user->usuario);
		$criteria->compare('fecha_asign',$this->fecha_asign,true);
		$criteria->compare('estado', '1');
		$criteria->compare('actividad',$this->actividad);
		$criteria->compare('user_cierre',$this->user_cierre,true);
		$criteria->compare('fecha_cierre',$this->fecha_cierre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			    'defaultOrder'=>'id ASC',
			  )
		));
	}
	public function estado($trazabilidad, $actividad){
		$imagesDir = dirname(__FILE__).'/../images/';
		$model=Trazabilidad::model()->findByPk($trazabilidad);
		$actividad = ActividadTipologia::model()->findByPk($actividad);
		$fechaLimite = date('Ymd', strtotime('+'.$actividad->tiempo.' days', strtotime($model->fecha_asign)));
		$fechaLimite = $fechaLimite - date("Ymd");
		if($fechaLimite == "0"){
			return CHtml::image(Yii::app()->assetManager->publish($imagesDir.'circle_yellow.png'),"",array("style"=>"width:20px;height:20px;"));
		}elseif($fechaLimite > "0"){
			return CHtml::image(Yii::app()->assetManager->publish($imagesDir.'circle_green.png'),"",array("style"=>"width:20px;height:20px;"));
		}else{
			return CHtml::image(Yii::app()->assetManager->publish($imagesDir.'circle_red.png'),"",array("style"=>"width:20px;height:20px;"));
		}	
	}
	public function estadoUsuario($trazabilidad, $actividad){

		$model=Trazabilidad::model()->findByPk($trazabilidad);
		$actividad = ActividadTipologia::model()->findByPk($actividad);
		$fechaLimite = date('Ymd', strtotime('+'.$actividad->tiempo.' days', strtotime($model->fecha_asign)));
		$fechaLimite = $fechaLimite - date("Ymd");
		return $fechaLimite;
	}
	public function estadoCasoCliente($na){
		$model = Recepcion::model()->findByPk($na);
		$fecha = (strtotime($model->fecha_cliente) - strtotime(date("Y-m-d")) ) / 86400;
		if($fecha == "0"){
			//return "<span id='fecha_cliente' class='label label-warning hand'>Cliente ".date("d/m/Y",strtotime($model->fecha_cliente))."</span>";
			return "<span class='label label-warning'>Cliente ".date("d/m/Y",strtotime($model->fecha_cliente))."</span>";
		}else if($fecha > "0"){
			//return "<span id='fecha_cliente' class='label label-success hand'>Cliente ".date("d/m/Y",strtotime($model->fecha_cliente))."</span>";
			return "<span class='label label-success'>Cliente ".date("d/m/Y",strtotime($model->fecha_cliente))."</span>";
		}else{
			//return "<span id='fecha_cliente' class='label label-danger hand'>Cliente ".date("d/m/Y",strtotime($model->fecha_cliente))."</span>";
			return "<span class='label label-danger'>Cliente ".date("d/m/Y",strtotime($model->fecha_cliente))."</span>";
		}
	}
	public function estadoCasoInterna($na){
		$model = Recepcion::model()->findByPk($na);
		$fecha = (strtotime($model->fecha_interna) - strtotime(date("Y-m-d")) ) / 86400;
		if($fecha == "0"){
			return "<span class='label label-warning'>Interna ".date("d/m/Y",strtotime($model->fecha_interna))."</span>";
		}else if($fecha > "0"){
			return "<span class='label label-success'>Interna ".date("d/m/Y",strtotime($model->fecha_interna))."</span>";
		}else{
			return "<span class='label label-danger'>Interna ".date("d/m/Y",strtotime($model->fecha_interna))."</span>";
		}
	}
	public function linkCaso($na){
		return CHtml::link('<u>'.$na.'</u>', array('trazabilidad/index','na'=>base64_encode($na)));
	}
	public function estadoActividad($trazabilidad, $actividad){
		$model=Trazabilidad::model()->findByPk($trazabilidad);
		$actividad = ActividadTipologia::model()->findByPk($actividad);
		//return $actividad->tiempo;
		for($i = 0; $i <= $actividad->tiempo; $i++){
			$fecha_consulta = date('Ymd', strtotime('+'.$i.' days', strtotime(date("Ymd",strtotime($model->fecha_asign)))));
			if(Festivos::traerDiaFestivo($fecha_consulta)){
				$actividad->tiempo++;
			}
		}
		$fechaLimite = $fecha_consulta - date("Ymd");
		if($fechaLimite == "0"){
			return "<span class='label label-warning'>".date("d/m/Y",strtotime($fecha_consulta))."</span>";
		}else if($fechaLimite > "0"){
			return "<span class='label label-success'>".date("d/m/Y",strtotime($fecha_consulta))."</span>";
		}else{
			return "<span class='label label-danger'>".date("d/m/Y",strtotime($fecha_consulta))."</span>";
		}
	}
	public function validaReasignacion($id_trazabilidad){
		$model=Trazabilidad::model()->findByPk($id_trazabilidad);
		$cantidad = count(UsuariosActividadTipologia::model()->findAll(array("condition"=>"id_actividad_tipologia =  $model->actividad AND \"usuario0\".\"activo\" = true",'with'=>'usuario0')));
		if($cantidad > "1"){
			return true;
		}else{
			return false;
		}
	}
	public static function estadoActual($na)
	{
		if(Trazabilidad::model()->findByAttributes(array("na"=>$na,"estado"=>"1"))){
			return "En Proceso";
		}else{
			return "Cerrado";
		}
	}
	public function validaRetomar($id_actividad)
	{
		return UsuariosActividadTipologia::model()->findByAttributes(array("id_actividad_tipologia"=>$id_actividad,"usuario"=>Yii::app()->user->usuario));
	}
}

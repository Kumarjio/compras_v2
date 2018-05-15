<?php

/**
 * This is the model class for table "actividad_tipologia".
 *
 * The followings are the available columns in table 'actividad_tipologia':
 * @property string $id
 * @property string $id_actividad
 * @property string $id_tipologia
 * @property boolean $activo
 * @property integer $tiempo
 *
 * The followings are the available model relations:
 * @property Actividades $idActividad
 * @property Tipologias $idTipologia
 * @property Relaciones[] $relaciones
 * @property Relaciones[] $relaciones1
 * @property Trazabilidad[] $trazabilidads
 * @property UsuariosActividadTipologia[] $usuariosActividadTipologias
 */
class ActividadTipologia extends CActiveRecord
{
	public $actTipUser;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'actividad_tipologia';
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
			array('id_actividad, id_tipologia, tiempo', 'required'),
			array('tiempo', 'numerical', 'integerOnly'=>true),
			array('activo, actTipUser, buscar', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_actividad, id_tipologia, activo, tiempo, actTipUser, buscar', 'safe', 'on'=>'search'),
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
            'idActividad' => array(self::BELONGS_TO, 'Actividades', 'id_actividad'),
            'idTipologia' => array(self::BELONGS_TO, 'Tipologias', 'id_tipologia'),
            'relaciones' => array(self::HAS_MANY, 'Relaciones', 'desde'),
            'relaciones1' => array(self::HAS_MANY, 'Relaciones', 'hasta'),
            'trazabilidads' => array(self::HAS_MANY, 'Trazabilidad', 'actividad'),
            'usuariosFlujo' => array(self::HAS_MANY, 'UsuariosActividadTipologia', 'id_actividad_tipologia'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'id_actividad' => 'Id Actividad',
            'id_tipologia' => 'Id Tipologia',
            'activo' => 'Activo',
            'tiempo' => 'Tiempo Gestión',
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
		$criteria->compare('id_actividad',$this->buscar);
		$criteria->compare('id_tipologia',$this->id_tipologia);
		$criteria->compare('activo',1);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_detalle()
	{
		
		$criteria=new CDbCriteria;

		$criteria->select = 't.id_tipologia';
		$criteria->addInCondition('id', $this->actTipUser);

        $criteria->group = 't.id_tipologia';
        $criteria->order = 't.id_tipologia ASC';

		//$criteria->compare('id',$this->id,true);
		//$criteria->compare('id_actividad',$this->id_actividad);
		//$criteria->compare('id_tipologia',$this->id_tipologia);
		$criteria->compare('activo',1);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ActividadTipologia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function cargaUsuario($usuario, $id){
		$usuarioActividad = UsuariosActividadTipologia::model()->findByAttributes(array('usuario'=>$usuario, 'id_actividad_tipologia'=>$id));
		if($usuarioActividad){
			return true;
		}else{
			$usuarioActividad = new UsuariosActividadTipologia;
			$usuarioActividad->usuario = $usuario;
			$usuarioActividad->id_actividad_tipologia = $id;
			return $usuarioActividad->save();
		}
	}

	public static function insertaActividades($tipologia, $actividades)
	{
		try {
			$cambios_nodos = array();
			foreach ($actividades as  $a) {
				if(isset($a['value'])){
					if($a['nuevo'] == 'Si')
						$act_tipo = new ActividadTipologia;
					elseif ($a['editado'] == 'Si') 
						$act_tipo = ActividadTipologia::model()->findByPk($a['id']);
					
					$act_tipo->id_tipologia = $tipologia;
					$act_tipo->id_actividad = $a['value'];
					$act_tipo->activo = true;
					if($act_tipo->isNewRecord){
						$act_tipo->save();
						foreach ($a['usuario'] as $usuario) {
							$usuarios = new UsuariosActividadTipologia;
							$usuarios->id_actividad_tipologia = $act_tipo->id;
							$usuarios->usuario = $usuario;
							$usuarios->save();
						}
						array_push($cambios_nodos, array('antes'=>$a['id'], 'ahora'=>$act_tipo->id));
					}else{
						$act_tipo->save();	
						$users = UsuariosActividadTipologia::model()->deleteAllByAttributes(array("id_actividad_tipologia"=>$act_tipo->id));
						foreach ($a['usuario'] as $usuario) {
							$usuarios = new UsuariosActividadTipologia;
							$usuarios->id_actividad_tipologia = $act_tipo->id;
							$usuarios->usuario = $usuario;
							$usuarios->save();
						}
					}
				}
			}
			return $cambios_nodos;
		} catch (Exception $e) {
			return "error";
		}
	}
	public static function insertaRelaciones($tipologia, $relaciones)
	{
		try {
			$cuantos = Relaciones::model()->deleteAll("desde in (select id from actividad_tipologia where id_tipologia = :t) or hasta  in (select id from actividad_tipologia where id_tipologia = :t)", array(':t'=>$tipologia));
			foreach ($relaciones as $r) {
				
				$rela = new Relaciones;
				$rela->desde = $r['from'];
				$rela->hasta = $r['to'];
				$rela->save();
			}
			return true;
		} catch (Exception $e) {
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";	
			return false;
		}
	}
	public static function validaCierreFlujo($tipologia)
	{
		$i = false;
		$j = false;
		$consulta = ActividadTipologia::model()->findAllByAttributes(array('id_tipologia'=>$tipologia, 'activo'=>true));
		if($consulta){
			foreach ($consulta as $valida) {
				if($valida->id_actividad == "1" ){
					$j = true;
				}elseif($valida->id_actividad == "20"){
					$i = true;
				}
			}
		}
		if( $i  && $j ){
			return $consulta;
		}else{
			return false;
		}
	}
	public static function validaAristasFlujo($data, $tipologia)
	{
		$rows = ActividadTipologia::model()->countByAttributes(array('id_tipologia'=>$tipologia, 'activo'=>true));
		$i = 1;
		foreach ($data as $valida) {
			$consulta = Relaciones::model()->findAllByAttributes(array('desde'=>$valida->id));
			if($consulta){
				$i++;
			}
		}
		if($rows == $i){
			return true;
		}else{
			return false;
		}
	}

	/*public static function es_circular($desde, $hasta)
	{

		for(select relaciones desde = $hasta){

		}

	}
	public static function validaFlujoCircular($data)
	{
		foreach ($data as $valida) {
			$consulta = Relaciones::model()->findAllByAttributes(array('desde'=>$valida->id));
			if($consulta){
				$i++;
			}
		}

		function es_circular(aguja, item){
	      var result = false;
	      if(item.from == aguja){
	              console.log("item problema es circular",item);
	              return true;
	            }
	      var anteriores = getObjects(data.edges.get(), "to", item.from);
	      if(anteriores.length == 0)
	        return false;
	      $.each(anteriores, function(i, item) {
	        result =  result || es_circular(aguja, item);
	      });
	      return result;

	    }




		foreach ($data as $valida) {

		}
		return true;
	}*/
	public static function guardaEstado($estado, $tipologia, $tiempos)
	{
		$estado_tipologia=Tipologias::model()->findByPk($tipologia);
		$estado_tipologia->en_espera = $estado;
		$estado_tipologia->tiempo_cliente = $tiempos;
		if($estado_tipologia->save()){
			return true;
		}else{
			return false;
		}
	}

	public function getCantidadUsuarios(){
		//$totalUser = UsuariosActividadTipologia::model()->countByAttributes(array("id_actividad_tipologia"=>$this->id));
		$consulta = UsuariosActividadTipologia::model()->findAll(array("condition"=>"id_actividad_tipologia =  $this->id AND \"usuario0\".\"activo\" = true",'with'=>'usuario0'));
		$totalUser = count($consulta);
		return $totalUser;
	}
	public function getUsuariosActividad(){
		$usuarios = array();
		foreach ($this->usuariosFlujo as $p) {
			if($p->usuario0->activo){
				array_push($usuarios, ucwords(strtolower($p->usuario0->nombres." ".$p->usuario0->apellidos)));
			}
		}
		if(sizeof($usuarios) == 0)
			return "";
		return "<ul><li>".implode("</li><li>", $usuarios)."</li></ul>";
	}
	public function getActividades($tipologia, $usuario){

		$aux = array();
		$consulta = UsuariosActividadTipologia::model()->findAllByAttributes(array("usuario"=>$usuario));
		//$consulta = UsuariosActividadTipologia::model()->findAll(array("condition"=>"usuario =  $usuario AND \"idTipologia\".\"activa\" = true AND \"idTipologia\".\"operacion\" = true",'with'=>'idActividadTipologia'));

		foreach ($consulta as $key => $value) {
			$aux[] = $value->id_actividad_tipologia;
		}

		$actividades = array();
		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', $aux);
		$criteria->addCondition('id_tipologia = '.$tipologia);
		$consulta = ActividadTipologia::model()->findAll($criteria);
		foreach ($consulta as $actividad) {
			array_push($actividades, ucwords(strtolower($actividad->idActividad->actividad)));
		}
		if(sizeof($actividades) == 0)
			return "";
		return "<ul><li>".implode("</li><li>", $actividades)."</li></ul>";
	
	}
}

<?php

/**
 * This is the model class for table "pacientes".
 *
 * The followings are the available columns in table 'pacientes':
 * @property integer $id_paciente
 * @property string $cedula
 * @property string $primer_nombre
 * @property string $segundo_nombre
 * @property string $primer_apellido
 * @property string $segundo_apellido
 * @property string $sexo
 * @property string $fecha_nacimiento
 * @property integer $id_estado_civil
 * @property string $id_ciudad
 * @property string $barrio
 * @property string $direccion
 * @property string $telefono
 * @property string $celular
 * @property string $correo
 * @property integer $id_grupo_poblacion
 * @property integer $id_clasificacion
 * @property integer $id_grupo_etnico
 * @property integer $id_categoria
 * @property integer $id_tipo_afiliado
 * @property integer $id_eps
 * @property integer $id_ocupacion
 * @property integer $id_nivel_educativo
 * @property string $nombre_acompanante
 * @property string $cc_acompanante
 * @property string $id_ciudad_acompanante
 * @property string $telefono_acompanante
 * @property integer $id_parentezco
 * @property string $fecha_ingreso
 *
 * The followings are the available model relations:
 * @property EstadoCivil $idEstadoCivil
 * @property Ciudad $idCiudad
 * @property GrupoPoblacion $idGrupoPoblacion
 * @property Clasificacion $idClasificacion
 * @property GrupoEtnico $idGrupoEtnico
 * @property Categoria $idCategoria
 * @property TipoAfiliado $idTipoAfiliado
 * @property Eps $idEps
 * @property Ocupacion $idOcupacion
 * @property NivelEducativo $idNivelEducativo
 * @property Ciudad $idCiudadAcompanante
 * @property Parentezco $idParentezco
 */
class Pacientes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pacientes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cedula, primer_nombre, primer_apellido, sexo, fecha_ingreso', 'required'),
			array('id_estado_civil, id_grupo_poblacion, id_clasificacion, id_grupo_etnico, id_categoria, id_tipo_afiliado, id_eps, id_ocupacion, id_nivel_educativo, id_parentezco', 'numerical', 'integerOnly'=>true),
			array('cedula', 'length', 'max'=>15),
			array('sexo', 'length', 'max'=>1),
			array('segundo_nombre, segundo_apellido, fecha_nacimiento, id_ciudad, barrio, direccion, telefono, celular, correo, nombre_acompanante, cc_acompanante, id_ciudad_acompanante, telefono_acompanante', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_paciente, cedula, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, sexo, fecha_nacimiento, id_estado_civil, id_ciudad, barrio, direccion, telefono, celular, correo, id_grupo_poblacion, id_clasificacion, id_grupo_etnico, id_categoria, id_tipo_afiliado, id_eps, id_ocupacion, id_nivel_educativo, nombre_acompanante, cc_acompanante, id_ciudad_acompanante, telefono_acompanante, id_parentezco, fecha_ingreso', 'safe', 'on'=>'search'),
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
			'idEstadoCivil' => array(self::BELONGS_TO, 'EstadoCivil', 'id_estado_civil'),
			'idCiudad' => array(self::BELONGS_TO, 'Ciudad', 'id_ciudad'),
			'idGrupoPoblacion' => array(self::BELONGS_TO, 'GrupoPoblacion', 'id_grupo_poblacion'),
			'idClasificacion' => array(self::BELONGS_TO, 'Clasificacion', 'id_clasificacion'),
			'idGrupoEtnico' => array(self::BELONGS_TO, 'GrupoEtnico', 'id_grupo_etnico'),
			'idCategoria' => array(self::BELONGS_TO, 'Categoria', 'id_categoria'),
			'idTipoAfiliado' => array(self::BELONGS_TO, 'TipoAfiliado', 'id_tipo_afiliado'),
			'idEps' => array(self::BELONGS_TO, 'Eps', 'id_eps'),
			'idOcupacion' => array(self::BELONGS_TO, 'Ocupacion', 'id_ocupacion'),
			'idNivelEducativo' => array(self::BELONGS_TO, 'NivelEducativo', 'id_nivel_educativo'),
			'idCiudadAcompanante' => array(self::BELONGS_TO, 'Ciudad', 'id_ciudad_acompanante'),
			'idParentezco' => array(self::BELONGS_TO, 'Parentezco', 'id_parentezco'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_paciente' => 'Id Paciente',
			'cedula' => 'Cedula',
			'primer_nombre' => 'Primer Nombre',
			'segundo_nombre' => 'Segundo Nombre',
			'primer_apellido' => 'Primer Apellido',
			'segundo_apellido' => 'Segundo Apellido',
			'sexo' => 'Sexo',
			'fecha_nacimiento' => 'Fecha Nacimiento',
			'id_estado_civil' => 'Id Estado Civil',
			'id_ciudad' => 'Id Ciudad',
			'barrio' => 'Barrio',
			'direccion' => 'Direccion',
			'telefono' => 'Telefono',
			'celular' => 'Celular',
			'correo' => 'Correo',
			'id_grupo_poblacion' => 'Id Grupo Poblacion',
			'id_clasificacion' => 'Id Clasificacion',
			'id_grupo_etnico' => 'Id Grupo Etnico',
			'id_categoria' => 'Id Categoria',
			'id_tipo_afiliado' => 'Id Tipo Afiliado',
			'id_eps' => 'Id Eps',
			'id_ocupacion' => 'Id Ocupacion',
			'id_nivel_educativo' => 'Id Nivel Educativo',
			'nombre_acompanante' => 'Nombre Acompanante',
			'cc_acompanante' => 'Cc Acompanante',
			'id_ciudad_acompanante' => 'Id Ciudad Acompanante',
			'telefono_acompanante' => 'Telefono Acompanante',
			'id_parentezco' => 'Id Parentezco',
			'fecha_ingreso' => 'Fecha Ingreso',
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

		$criteria->compare('id_paciente',$this->id_paciente);
		$criteria->compare('cedula',$this->cedula,true);
		$criteria->compare('primer_nombre',$this->primer_nombre,true);
		$criteria->compare('segundo_nombre',$this->segundo_nombre,true);
		$criteria->compare('primer_apellido',$this->primer_apellido,true);
		$criteria->compare('segundo_apellido',$this->segundo_apellido,true);
		$criteria->compare('sexo',$this->sexo,true);
		$criteria->compare('fecha_nacimiento',$this->fecha_nacimiento,true);
		$criteria->compare('id_estado_civil',$this->id_estado_civil);
		$criteria->compare('id_ciudad',$this->id_ciudad,true);
		$criteria->compare('barrio',$this->barrio,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('celular',$this->celular,true);
		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('id_grupo_poblacion',$this->id_grupo_poblacion);
		$criteria->compare('id_clasificacion',$this->id_clasificacion);
		$criteria->compare('id_grupo_etnico',$this->id_grupo_etnico);
		$criteria->compare('id_categoria',$this->id_categoria);
		$criteria->compare('id_tipo_afiliado',$this->id_tipo_afiliado);
		$criteria->compare('id_eps',$this->id_eps);
		$criteria->compare('id_ocupacion',$this->id_ocupacion);
		$criteria->compare('id_nivel_educativo',$this->id_nivel_educativo);
		$criteria->compare('nombre_acompanante',$this->nombre_acompanante,true);
		$criteria->compare('cc_acompanante',$this->cc_acompanante,true);
		$criteria->compare('id_ciudad_acompanante',$this->id_ciudad_acompanante,true);
		$criteria->compare('telefono_acompanante',$this->telefono_acompanante,true);
		$criteria->compare('id_parentezco',$this->id_parentezco);
		$criteria->compare('fecha_ingreso',$this->fecha_ingreso,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pacientes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

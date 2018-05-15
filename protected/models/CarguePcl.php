<?php
/**
 * This is the model class for table "cargue_pcl".
 *
 * The followings are the available columns in table 'cargue_pcl':
 * @property string $id
 * @property string $siniestro
 * @property string $nombre
 * @property string $direccion
 * @property string $telefono
 * @property string $ciudad
 * @property string $departamento
 * @property string $porcentaje
 * @property string $fecha_estructuracion
 * @property string $diagnostico
 * @property string $meses
 * @property string $meses_letras
 * @property string $nombre_empresa
 * @property string $direccion_empresa
 * @property string $telefono_empresa
 * @property string $ciudad_empresa
 * @property string $eps
 * @property string $direccion_eps
 * @property string $telefono_eps
 * @property string $ciudad_eps
 * @property string $afp
 * @property string $direccion_afp
 * @property string $telefono_afp
 * @property string $ciudad_afp
 * @property string $fecha_cargue
 * @property string $usuario_cargue
 * @property string $na
 *
 * The followings are the available model relations:
 * @property Usuario $usuarioCargue
 * @property Ciudad $ciudad0
 * @property Ciudad $ciudadEmpresa
 * @property Ciudad $ciudadEps
 * @property Ciudad $ciudadAfp
 */
class CarguePcl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cargue_pcl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('siniestro, nombre, direccion, ciudad, porcentaje, fecha_estructuracion, diagnostico, meses, meses_letras, nombre_empresa, direccion_empresa, ciudad_empresa, eps, direccion_eps, ciudad_eps, afp, direccion_afp, ciudad_afp, usuario_cargue', 'required'),
			array('telefono, departamento, telefono_empresa, telefono_eps, telefono_afp, na', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, siniestro, nombre, direccion, telefono, ciudad, departamento, porcentaje, fecha_estructuracion, diagnostico, meses, meses_letras, nombre_empresa, direccion_empresa, telefono_empresa, ciudad_empresa, eps, direccion_eps, telefono_eps, ciudad_eps, afp, direccion_afp, telefono_afp, ciudad_afp, fecha_cargue, usuario_cargue, na', 'safe', 'on'=>'search'),
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
            'usuarioCargue' => array(self::BELONGS_TO, 'Usuario', 'usuario_cargue'),
            'ciudad0' => array(self::BELONGS_TO, 'Ciudad', 'ciudad'),
            'ciudadEmpresa' => array(self::BELONGS_TO, 'Ciudad', 'ciudad_empresa'),
            'ciudadEps' => array(self::BELONGS_TO, 'Ciudad', 'ciudad_eps'),
            'ciudadAfp' => array(self::BELONGS_TO, 'Ciudad', 'ciudad_afp'),
        );
    }
    /**
     * @return array customized attribute labels (name=>label)
     */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'siniestro' => 'Siniestro',
			'nombre' => 'Nombre',
			'direccion' => 'Direccion',
			'telefono' => 'Telefono',
			'ciudad' => 'Ciudad',
			'departamento' => 'Departamento',
			'porcentaje' => 'Porcentaje',
			'fecha_estructuracion' => 'Fecha Estructuracion',
			'diagnostico' => 'Diagnostico',
			'meses' => 'Meses',
			'meses_letras' => 'Meses Letras',
			'nombre_empresa' => 'Nombre Empresa',
			'direccion_empresa' => 'Direccion Empresa',
			'telefono_empresa' => 'Telefono Empresa',
			'ciudad_empresa' => 'Ciudad Empresa',
			'eps' => 'Eps',
			'direccion_eps' => 'Direccion Eps',
			'telefono_eps' => 'Telefono Eps',
			'ciudad_eps' => 'Ciudad Eps',
			'afp' => 'Afp',
			'direccion_afp' => 'Direccion Afp',
			'telefono_afp' => 'Telefono Afp',
			'ciudad_afp' => 'Ciudad Afp',
			'fecha_cargue' => 'Fecha Cargue',
			'usuario_cargue' => 'Usuario Cargue',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('siniestro',$this->siniestro,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('departamento',$this->departamento,true);
		$criteria->compare('porcentaje',$this->porcentaje,true);
		$criteria->compare('fecha_estructuracion',$this->fecha_estructuracion,true);
		$criteria->compare('diagnostico',$this->diagnostico,true);
		$criteria->compare('meses',$this->meses,true);
		$criteria->compare('meses_letras',$this->meses_letras,true);
		$criteria->compare('nombre_empresa',$this->nombre_empresa,true);
		$criteria->compare('direccion_empresa',$this->direccion_empresa,true);
		$criteria->compare('telefono_empresa',$this->telefono_empresa,true);
		$criteria->compare('ciudad_empresa',$this->ciudad_empresa,true);
		$criteria->compare('eps',$this->eps,true);
		$criteria->compare('direccion_eps',$this->direccion_eps,true);
		$criteria->compare('telefono_eps',$this->telefono_eps,true);
		$criteria->compare('ciudad_eps',$this->ciudad_eps,true);
		$criteria->compare('afp',$this->afp,true);
		$criteria->compare('direccion_afp',$this->direccion_afp,true);
		$criteria->compare('telefono_afp',$this->telefono_afp,true);
		$criteria->compare('ciudad_afp',$this->ciudad_afp,true);
		$criteria->compare('fecha_cargue',$this->fecha_cargue,true);
		$criteria->compare('usuario_cargue',$this->usuario_cargue,true);
		$criteria->compare('na',$this->na,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CarguePcl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

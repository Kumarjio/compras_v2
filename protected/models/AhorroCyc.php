<?php

/**
 * This is the model class for table "ahorro_cyc".
 *
 * The followings are the available columns in table 'ahorro_cyc':
 * @property integer $orden
 * @property integer $producto_orden
 * @property string $selecionada
 * @property string $promedio
 * @property string $ahorro
 * @property string $porcentaje
 * @property string $fecha
 */
class AhorroCyc extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AhorroCyc the static model class
     */
    public $nombre;
        
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'ahorro_cyc';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('orden, producto_orden', 'numerical', 'integerOnly'=>true),
            array('selecionada, promedio, ahorro, porcentaje, fecha, nombre', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('orden, producto_orden, selecionada, promedio, ahorro, porcentaje, fecha, nombre', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'orden' => 'Orden',
            'producto_orden' => 'Producto Orden',
            'selecionada' => 'Barata',
            'promedio' => 'Promedio',
            'ahorro' => 'Ahorro',
            'porcentaje' => 'Porcentaje',
            'fecha' => 'Fecha',
            'nombre'=>'Nombre Producto'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        if($_GET['AhorroCyc']['nombre'] != ''){
            $nombre = strtoupper($_GET['AhorroCyc']['nombre']);
            $criteria->addCondition("producto_orden in (select id from producto_orden where orden_solicitud in (select id from orden_solicitud where upper(nombre) like '%$nombre%'))");
        }
        
        $criteria->compare('orden',$this->orden);
        $criteria->compare('producto_orden',$this->producto_orden);
        $criteria->compare('selecionada',$this->selecionada,true);
        $criteria->compare('promedio',$this->promedio,true);
        $criteria->compare('ahorro',$this->ahorro,true);
        $criteria->compare('porcentaje',$this->porcentaje,true);
        $criteria->compare('fecha',$this->fecha,true);

        Yii::app()->user->setState('criteria_cyc',$criteria);
                
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
        
    public function search_excel()
    {

        $criteria= Yii::app()->user->getState('criteria_cyc');

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false
        ));
    }
    public function getNombre() {
        $os = ProductoOrden::model()->findByPk($this->producto_orden);
        
        return OrdenSolicitud::model()->findByPk($os->orden_solicitud)->nombre ;
        
       
    }
    
    public function search_avanzado($informeGlobal)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.


        $criteria=new CDbCriteria;

        $criteria->addCondition("fecha between '".$informeGlobal->fecha_inicio."' and '".$informeGlobal->fecha_fin."'");
        if($informeGlobal->tipo_negociacion != ''){
            $tipos_wh = implode(',', $informeGlobal->tipo_negociacion);
            $criteria->addCondition("negociacion_directa in ($tipos_wh)");
        }
        $criteria->compare('orden',$this->orden);
        $criteria->compare('producto_orden',$this->producto_orden);
        $criteria->compare('selecionada',$this->selecionada,true);
        $criteria->compare('promedio',$this->promedio,true);
        $criteria->compare('ahorro',$this->ahorro,true);
        $criteria->compare('porcentaje',$this->porcentaje,true);
        $criteria->compare('fecha',$this->fecha,true);
        $negociante = Empleados::model()->findByPk($informeGlobal->negociador);
        $criteria->compare('negociante',$negociante->nombre_completo,true);

        Yii::app()->user->setState('criteria_cyc',$criteria);
        
        $pages = new CPagination;
        $pages->params = array('InformeGlobalForm'=>$informeGlobal->attributes);        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>$pages
        ));
    }
}

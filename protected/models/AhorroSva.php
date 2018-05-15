<?php

/**
 * This is the model class for table "ahorro_sva".
 *
 * The followings are the available columns in table 'ahorro_sva':
 * @property integer $nit
 * @property integer $orden
 * @property integer $producto_orden
 * @property string $selecionada
 * @property string $alta
 * @property string $ahorro
 * @property string $porcentaje
 */
class AhorroSva extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AhorroSva the static model class
     */
    
    public $proveedor;
        
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'ahorro_sva';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nit, orden, producto_orden', 'numerical', 'integerOnly'=>true),
            array('selecionada, alta, ahorro, porcentaje', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nit, orden, producto_orden, selecionada, alta, ahorro, porcentaje, fecha', 'safe', 'on'=>'search'),
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
            'nit' => 'Nit',
            'orden' => 'Orden',
            'producto_orden' => 'Producto Orden',
            'selecionada' => 'Selecionada',
            'alta' => 'Alta',
            'ahorro' => 'Ahorro',
            'porcentaje' => 'Porcentaje',
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
        
        if($_GET['AhorroCyc']['proveedor'] != ''){
            $nombre = strtoupper($_GET['AhorroCyc']['proveedor']);
            $criteria->addCondition("nit in (select nit from proveedor where upper(razon_social) like '%$nombre%')");
        }

        $criteria->addCondition('ahorro > 0');
        $criteria->compare('nit',$this->nit);
        $criteria->compare('orden',$this->orden);
        $criteria->compare('producto_orden',$this->producto_orden);
        $criteria->compare('selecionada',$this->selecionada,true);
        $criteria->compare('alta',$this->alta,true);
        $criteria->compare('ahorro',$this->ahorro,true);
        $criteria->compare('porcentaje',$this->porcentaje,true);
        $criteria->compare('fecha',$this->fecha,true);

        Yii::app()->user->setState('criteria_sva',$criteria);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
      
    
    public function search_todos()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
        if($_GET['AhorroCyc']['proveedor'] != ''){
            $nombre = strtoupper($_GET['AhorroCyc']['proveedor']);
            $criteria->addCondition("nit in (select nit from proveedor where upper(razon_social) like '%$nombre%')");
        }
        
        $criteria->compare('nit',$this->nit);
        $criteria->compare('orden',$this->orden);
        $criteria->compare('producto_orden',$this->producto_orden);
        $criteria->compare('selecionada',$this->selecionada,true);
        $criteria->compare('alta',$this->alta,true);
        $criteria->compare('ahorro',$this->ahorro,true);
        $criteria->compare('porcentaje',$this->porcentaje,true);
        $criteria->compare('fecha',$this->fecha,true);

        Yii::app()->user->setState('criteria_sva',$criteria);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
       
    public function search_excel()
    {

            $criteria= Yii::app()->user->getState('criteria_sva');

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false
            ));
    }  
    
    public function getProveedor() {
        return Proveedor::model()->findByPk($this->nit)->razon_social;
    }

    public function search_avanzado($informeGlobal)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
        $criteria->addCondition('ahorro > 0');
        $criteria->addCondition("fecha between '".$informeGlobal->fecha_inicio."' and '".$informeGlobal->fecha_fin."'");
        if($informeGlobal->tipo_negociacion != ''){
            $tipos_wh = implode(',', $informeGlobal->tipo_negociacion);
            $criteria->addCondition("negociacion_directa in ($tipos_wh)");
        }
        $criteria->compare('nit',$this->nit);
        $criteria->compare('orden',$this->orden);
        $criteria->compare('producto_orden',$this->producto_orden);
        $criteria->compare('selecionada',$this->selecionada,true);
        $criteria->compare('alta',$this->alta,true);
        $criteria->compare('ahorro',$this->ahorro,true);
        $criteria->compare('porcentaje',$this->porcentaje,true);
        $criteria->compare('fecha',$this->fecha,true);
        $negociante = Empleados::model()->findByPk($informeGlobal->negociador);
        $criteria->compare('negociante',$negociante->nombre_completo,true);

        Yii::app()->user->setState('criteria_sva',$criteria);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
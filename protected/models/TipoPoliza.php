 <?php

/**
 * This is the model class for table "tipo_poliza".
 *
 * The followings are the available columns in table 'tipo_poliza':
 * @property integer $id_tipo_poliza
 * @property string $tipo_poliza
 */
class TipoPoliza extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TipoPoliza the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tipo_poliza';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tipo_poliza', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_tipo_poliza, tipo_poliza', 'safe', 'on'=>'search'),
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
            'id_tipo_poliza' => 'Id Tipo Poliza',
            'tipo_poliza' => 'Tipo Poliza',
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

        $criteria->compare('id_tipo_poliza',$this->id_tipo_poliza);
        $criteria->compare('tipo_poliza',$this->tipo_poliza,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
} 
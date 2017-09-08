<?php Yii::app()->clientScript->registerCoreScript('yiiactiveform'); ?>
<?php $form = $this->beginWidget('CActiveForm', array(
                'id'=>'prueba-form',
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'clientOptions'=>array(
                        'validateOnChange'=>true,
                        'validateOnSubmit'=>true
))); ?>
<?php $this->widget(
    'booster.widgets.TbCKEditor',
    array(
        'name' => 'some_random_text_field',
        'editorOptions' => array(
            // From basic `build-config.js` minus 'undo', 'clipboard' and 'about'
            'plugins' => 'basicstyles,toolbar,enterkey,entities,floatingspace,wysiwygarea,indentlist,link,list,dialog,dialogui,button,indent,fakeobjects'
        )
    )
); ?>
<div class='col-md-1'>
    <div class="form-actions"> 
        <?php $this->widget('bootstrap.widgets.BootButton', array( 
            'buttonType'=>'submit', 
            'type'=>'success', 
            'label'=>$model->isNewRecord ? 'Guardar' : 'Guardar', 
        )); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

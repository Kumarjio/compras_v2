<!DOCTYPE html>
<html>
<head>
    <title>Correspondencia</title>
    <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/correspondencia/css/ie.css" media="screen, projection" />
        <?php Yii::app()->clientScript->registerScriptFile('/correspondencia/static/js/respond.js'); ?>
    <![endif]-->
</head>
    <body>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container" style="margin-top:40px">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php echo CHtml::beginForm("", "post",array('id'=>'LoginForm')); ?>  
                        <?php echo CHtml::errorSummary($form); ?>
                            <fieldset>   
                                <div class="row">
                                    <div class="center-block" align="center">
                                    <br>
                                        <!--<img class="profile-img" src="../../images/bolivar.png" width="250" alt="">-->
                                        <img class="profile-img" src="../../images/alfa.png" width="300" alt="">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-user"></i>
                                                </span>
                                                <?php echo CHtml::activeTextField($form,'username',array('class'=>'form-control',
                                                'placeholder'=>'Usuario', 'onKeypress'=>'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;')); ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-lock"></i>
                                                </span>
                                                <?php echo CHtml::activePasswordField($form,'password',array('class'=>'form-control',
                                                'placeholder'=>'Contraseña')); ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-actions" align="center"> 
                                            <?php $this->widget('bootstrap.widgets.BootButton', array( 
                                                'buttonType'=>'submit',
                                                'icon'=>'glyphicon glyphicon-send', 
                                                'type'=>'success', 
                                                'label'=>$model->isNewRecord ? 'Iniciar Sesion' : 'Iniciar Sesion',
                                                'htmlOptions' => 
                                                    array(
                                                        'style'=>'background:#04B486',
                                                    ),
                                            )); ?>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>
                        <?php echo CHtml::endForm("", "post") ?>  
                    </div>
                    <br>
                    <div class="panel-footer" align="center">
                        Sistema de Correspondencia
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
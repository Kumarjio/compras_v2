
<!DOCTYPE html>
<html>
<head>
    <?php $this->pageTitle=Yii::app()->name . ' - Ingreso al sistema'; ?>
    <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/correspondencia/css/ie.css" media="screen, projection" />
        <?php Yii::app()->clientScript->registerScriptFile('/static/js/respond.js'); ?>
    <![endif]-->
</head>
    <body>
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
                                        <img class="profile-img" src="../../images/tuya_logo.jpg" width="100" alt="">
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
                                                <?php echo CHtml::activeDropDownList($form,'user_and_role',CHtml::listData(LoginFormDev::usuarioRol(), "id", "nombre"), array('class'=>'form-control')) ?>
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
                                            <!--form action="<? //echo Yii::app()->params->cambioclave; ?>" method="post" id="seguridad">
                                                </div>
                                                <?php //$http = "https://" . $_SERVER['HTTP_HOST'] . "/index.php/site/login"; ?>
                                                <input type="hidden" name="URLRetorno" value="<?php //echo $http; ?>" />

                                                <?php //echo CHtml::link("Cambiar Clave","javascript:void(0)",array("onclick"=>"$('#seguridad').submit()")); ?>

                                            </form-->
                                        </div>

                                    </div>
                                </div>
                            </fieldset>
                        <?php echo CHtml::endForm("", "post") ?>  
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
    </body>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#LoginForm_username').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });
      });
    </script>
</html>
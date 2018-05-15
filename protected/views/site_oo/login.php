<?php $this->pageTitle=Yii::app()->name . ' - Ingreso al sistema'; ?>

<?php if(count($auth) == 0 || $auth['AutenticarUsuarioResult'] == 3): ?>

<div class="well">
<h1>Ingreso al sistema</h1>
<div class="form">

<?php echo CHtml::form(); ?>

<?php echo CHtml::errorSummary($form); ?>

<div class="row" style="margin:15px 0 0 0;">
<?php echo CHtml::activeLabel($form,'username'); ?>
<?php echo CHtml::activeTextField($form,'username',array('class'=>'text')) ?>
</div>
<div class="row" style="margin:15px 0 0 0;>
<?php echo CHtml::activeLabel($form,'password'); ?><br />
<?php echo CHtml::activePasswordField($form,'password',array('class'=>'text')) ?>
</div>
<div class="row buttons" style="margin:10px 0 0 0;">
<?php echo CHtml::submitButton('Iniciar Sesion', array('class' => 'btn btn-primary')); ?></form> 
<form action="<? echo Yii::app()->params->cambioclave; ?>" method="post" id="seguridad">
</div>
<?php $http = "https://" . $_SERVER['HTTP_HOST'] . "/index.php/site/login"; ?>
<input type="hidden" name="URLRetorno" value="<?php echo $http; ?>" />

<?php echo CHtml::link("Cambiar Clave","javascript:void(0)",array("onclick"=>"$('#seguridad').submit()")); ?>

</form>
</div>
       
</div>

<?php else: ?>
<div class="well">

<h1>Información del sistema de autorización</h1>
<?php $http = $_SERVER['HTTP_ORIGIN'] . "/index.php/site/login"; ?>

<form action="<? echo Yii::app()->params->cambioclave; ?>" method="post" id="seguridad" >

<?php $http = "http://compras.tuya.corp/index.php/site/login"; ?>
<input type="hidden" name="TokenSeguridad" value="<?php echo $auth['p_strTokenSeguridad']; ?>" />
<input type="hidden" name="URLRetorno" value="<?php echo $http; ?>" />


<div class="<?php  echo ($auth['AutenticarUsuarioResult'] == 1)?'notice':'errorSummary';?>"><?php echo $auth['p_strMensaje']; ?></div>




</form>

<?php echo CHtml::link("<i class='icon-retweet icon-white'></i> Cambiar Clave","javascript:void(0)",array("onclick"=>"$('#seguridad').submit()", "class" => "btn btn-primary", style => 'margin-right:10px;')); ?>
<?php if($auth['AutenticarUsuarioResult'] == 1): ?>
<?php echo CHtml::link("Continuar al Workflow", !isset(Yii::app()->user->returnUrl) ? $this->createUrl("/") : Yii::app()->user->returnUrl, array('class' => 'btn btn-danger')); ?>		
<?php endif ?>


</div>
</div>

</div>

<?php endif ?>

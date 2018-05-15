<?php $this->pageTitle=Yii::app()->name . ' - Ingreso al sistema'; ?>

<?php if(count($auth) == 0 || $auth['AutenticarUsuarioResult'] == 3): ?>

<div class="well">
<h1>Ingreso al sistema</h1>
<div class="form">

<?php echo CHtml::form(); ?>

<?php echo CHtml::errorSummary($form); ?>

<div class="row" style="margin:15px 0 0 0;">
<?php echo CHtml::activeLabel($form,'user_and_role'); ?>
<?php echo CHtml::activeDropDownList($form,'user_and_role',CHtml::listData(LoginFormDev::usuarioRol(), "id", "nombre"), array('class'=>'text')) ?>
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



<?php endif ?>
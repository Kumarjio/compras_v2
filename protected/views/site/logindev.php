<?php $this->pageTitle=Yii::app()->name . ' - Ingreso al sistema'; ?>

<?php if(count($auth) == 0 || $auth['AutenticarUsuarioResult'] == 3): ?>


<div class="panel panel-yellow margin-bottom-40">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon-tasks"></i> Ingreso al sistema de viajes</h3>
    </div>
    <div class="panel-body">      
    	<?php echo CHtml::beginForm("", "post") ?>  

    		<?php echo CHtml::errorSummary($form); ?>                                              
            <div class="form-group">
                <?php echo CHtml::activeLabel($form,'user_and_role'); ?>
				<?php echo CHtml::activeDropDownList($form,'user_and_role',CHtml::listData(LoginFormDev::usuarioRol(), "id", "nombre"), array('class'=>'form-control')) ?>
            </div>
            
            <?php echo CHtml::submitButton('Iniciar Sesion', array('class' => 'btn-u btn-u-default')); ?>

        <?php echo CHtml::endForm("", "post") ?>       
        
  </div>
</div>



<?php endif ?>
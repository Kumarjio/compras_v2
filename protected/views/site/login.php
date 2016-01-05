<?php $this->pageTitle=Yii::app()->name . ' - Ingreso al sistema'; ?>




        <div class="panel panel-blue margin-bottom-40">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="icon-tasks"></i> Ingreso al sistema Clinica San Diego</h3>
                </div>
                <div class="panel-body">      
                	<?php echo CHtml::beginForm("", "post") ?>  

                		<?php echo CHtml::errorSummary($form); ?>                                              
                        <div class="form-group">
                            <?php echo CHtml::activeLabel($form,'username'); ?>
                            <?php echo CHtml::activeTextField($form,'username',array('class'=>'form-control')) ?>
                        </div>
                        <div class="form-group">
                            <?php echo CHtml::activeLabel($form,'password'); ?>
                            <?php echo CHtml::activePasswordField($form,'password',array('class'=>'form-control')) ?>
                        </div>
                        
                        <?php echo CHtml::submitButton('Iniciar Sesion', array('class' => 'btn-u btn-u-default')); ?>

                    <?php echo CHtml::endForm("", "post") ?>       

            </div>



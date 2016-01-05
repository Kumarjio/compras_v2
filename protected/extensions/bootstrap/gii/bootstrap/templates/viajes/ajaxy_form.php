<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>

<div class="panel panel-blue margin-bottom-40">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon-tasks"></i> Informarción del <?php echo $this->modelClass; ?></h3>
    </div>
    <div class="panel-body">

		<?php echo "<?php \$form=\$this->beginWidget('CActiveForm',array(
			'id'=>'".$this->class2id($this->modelClass)."-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('onSubmit' => 'return false')
		)); ?>\n"; ?>

		<p class="note">Campos marcados con <span class="required">*</span> son requeridos.</p>

		<?php echo "<?php echo \$this->renderPartial('_form', array('form' => \$form,'model' => \$model)); ?>\n"; ?>

		<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

	</div>
</div>


<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->modelClass;
echo "\$this->breadcrumbs=array(
	'$label'=>array('admin'),
	'Actualizar Registro',
);\n";

echo "\$this->setPageTitle('Actualización de ".$this->modelClass."');\n";

?>

?>

<div class="panel panel-blue margin-bottom-40">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon-tasks"></i> Informarción del <?php echo $this->modelClass; ?></h3>
    </div>
    <div class="panel-body">

		<?php echo "<?php \$form=\$this->beginWidget('CActiveForm',array(
			'id'=>'".$this->class2id($this->modelClass)."-form',
			'enableAjaxValidation'=>false
		)); ?>\n"; ?>

		<?php echo "<?php echo \$this->renderPartial('_form',array('form' => \$form,'model'=>\$model)); ?>"; ?>

		<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
	</div>
</div>

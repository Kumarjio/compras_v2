<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('admin'),
	'Administrar',
);\n";

echo "\$this->setPageTitle('Administración de ".$this->modelClass."');\n";

echo "?>";
?>

<div class="col-lr-12">
    <p><a href="<?php echo "<?php echo \$this->createUrl('".$this->modelClass."/create')?>";?>" class="btn-u btn-u-md btn-u-default"><i class="icon-cloud-download"></i> Crear nuevo <?php echo $this->modelClass ?></a></p>
</div>

<div class="panel panel-blue margin-bottom-40">
	<div class="panel-heading">
	    <h3 class="panel-title"><i class="icon-tasks"></i> Lista de <?php echo $this->modelClass; ?></h3>
	</div>
	<div class="panel-body"> 
		<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
		<?php
		$count=0;
		foreach($this->tableSchema->columns as $column)
		{
			if(++$count==7)
				echo "\t\t/*\n";
			echo "\t\t'".$column->name."',\n";
		}
		if($count>=7)
			echo "\t\t*/\n";
		?>
				array(
					'class'=>'bootstrap.widgets.BootButtonColumn',
				),
			),
		)); ?>
	</div>
</div>

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.BootGridView',array(
			'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
			'dataProvider'=>$model->search(),
			'enableSorting' => false,
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
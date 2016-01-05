<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
?>
	<div class="form-group">
		<?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
		<?php echo "<?php echo ".$this->generateActiveRow($this->modelClass,$column)."; ?>\n"; ?>
		<?php echo "<?php echo ".$this->generateActiveError($this->modelClass,$column)."; ?>\n"; ?>
	</div>

<?php
}
?>
	
	<div class="form-group">
		<?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? 'Crear' : 'Actualizar', array('class' => 'btn-u btn-u-blue')); ?>\n"; ?>
	</div>

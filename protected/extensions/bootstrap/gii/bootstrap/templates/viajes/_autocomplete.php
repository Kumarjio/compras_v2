<?php echo "<?php if(\$total == 0): ?>\n"; ?>

<div class="panel panel-blue margin-bottom-40">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon-tasks"></i> Búsqueda de <?php echo $this->modelClass; ?></h3>
    </div>
    <div class="panel-body">
			
				<div class="form-group">
			        <?php echo "<?php echo CHtml::label('Nombre o código', 'search', array('class' => 'control-label')); ?>\n"; ?>
			        <?php echo "<?php echo CHtml::textField('search', '', array('class' => 'form-control auto-search',
			            										    'data-url' => \$this->createUrl('".$this->modelClass."/search'))) ?>\n"; ?>
			    </div>

			    <p class="results"></p>
	</div>
</div>

<?php echo "<?php else: ?>\n"; ?>

<?php echo "<?php foreach(\$total as \$e): ?>\n"; ?>

	<p><a href="#" class="auto-link" data-complete="xxxx-yyyyy" data-visible="id_visible_field" data-hidden="if_hidden_field">Result here</a></p>

<?php echo "<?php endforeach ?>"; ?>

<?php echo "<? endif ?>"; ?>
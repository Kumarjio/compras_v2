<?php if($total == 0): ?>

<div class="panel panel-blue margin-bottom-40">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon-tasks"></i> Búsqueda de Documentos</h3>
    </div>
    <div class="panel-body">
			
				<div class="form-group">
			        <?php echo CHtml::label('Nombre o código', 'search', array('class' => 'control-label')); ?>
			        <?php echo CHtml::textField('search', '', array('class' => 'form-control auto-search',
			            										    'data-url' => $this->createUrl('Documentos/search'))) ?>
			    </div>

			    <p class="results"></p>
	</div>
</div>

<?php else: ?>

<?php foreach($total as $e): ?>

	<p><a href="#" class="auto-link" data-complete="xxxx-yyyyy" data-visible="id_visible_field" data-hidden="if_hidden_field">Result here</a></p>

<?php endforeach ?>
<? endif ?>
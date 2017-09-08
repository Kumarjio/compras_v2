<?php
/* @var $this DefaultController */
$this->breadcrumbs=array(
	$this->module->id,
);
?>
<div class="panel panel-blue margin-bottom-40">

	<div class="panel-heading">
    	<h3 class="panel-title"><i class="glyphicon glyphicon-cog"></i> Administración</h3>
  	</div>
	<div class="panel-body">
		<div align="right"> 
			<div class="btn-group">
				<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Generar Plano <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" align="left">
					<li><a href="#" onclick="generarPlano();">Pacientes</a></li>
					<li><a href="#" onclick="generarPlanoEnt();">Entidades</a></li>
				</ul>
			</div>
		</div>
		<br />

		<div class="row">
			<div class="col-sm-2 col-md-4">
			    <div class="list-group">
				  	<a href="#" class="list-group-item active">
				  		<center>
				  		<p>&nbsp;</p>
				    	<h3 class="list-group-item-heading"><i class="glyphicon glyphicon-dashboard"></i> Administración de Médicos</h3>
				    	<p>&nbsp;</p>
			        	</center>
				  	</a>
				</div>
			</div>
			<div class="col-sm-2 col-md-4">
			    <div class="list-group">
				  	<a href="#<?// echo Yii::app()->createUrl('callcenter/listaEspera/listaTodo')?>" class="list-group-item active">
				  		<center>
				  		<p>&nbsp;</p>
				    	<h3 class="list-group-item-heading"><i class="glyphicon glyphicon-user"></i> Administración de Usuarios</h3>
				    	<p>&nbsp;</p>
			        	</center>
				  	</a>
				</div>
			</div>
			<div class="col-sm-2 col-md-4">
			    <div class="list-group">
				  	<a href="#<?// echo Yii::app()->createUrl('citas/documento/validaDocumentos')?>" class="list-group-item active">
				  		<center>
				  		<p>&nbsp;</p>
				    	<h3 class="list-group-item-heading"><i class="glyphicon glyphicon-calendar"></i> Administración de Disponibilidad</h3>
				    	<p>&nbsp;</p>
			        	</center>
				  	</a>
				</div>
			</div>
		</div>

	</div>
</div>
<script type="text/javascript">
    function generarPlano(){
    	//alert();
    	location.href="<?=Yii::app()->getBaseUrl(true).Yii::app()->getHomeUrl()?>/administracion/default/plano";
	}
	function generarPlanoEnt(){
    	//alert();
    	location.href="<?=Yii::app()->getBaseUrl(true).Yii::app()->getHomeUrl()?>/administracion/default/planoEnt";
	}
</script>
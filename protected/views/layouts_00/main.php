<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<?php Yii::app()->clientScript->registerCssFile('/css/efectividad.css'); ?>
	<?php Yii::app()->clientScript->registerCssFile('/css/jquery-ui.css'); ?>
   	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/fileuploader.css'); ?>
   	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/utils.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/fileuploader.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery-ui.min.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery-ui-i18n.min.js'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl .'/css/jquery-ui.css'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.multiple.select.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/notify.js'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl .'/css/multiple-select.css'); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<style>
	.derecha{
		float:right;
	}
	</style>
</head>

<body data-spy="scroll" data-target=".subnav">


<div class="navbar">
   <div class="navbar-inner">
   
     <div class="container">
       <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </a>
       <a class="brand" href="/">Workflow</a>

       <div class="btn-toolbar pull-right">
       	<?php if(!Yii::app()->user->isGuest){ 
		
	    if( ( substr( Yii::app()->user->name,0,4) == 'cyc1') or ( substr( Yii::app()->user->name,0,4) == 'CYC1') or substr( Yii::app()->user->name,0,3)=='511' )  { 
		?>	<div class="btn-group">
				<button class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Configuración <span class="caret"></span></button>
				<ul class="dropdown-menu">
                    <li><a href="<?php echo $this->createUrl('/empleados'); ?>">Empleados</a></li>
                    <li><a href="<?php echo $this->createUrl('/empleados/ausentismo'); ?>">Reemplazos</a></li>
					<li><a href="<?php echo $this->createUrl('/centroCostos'); ?>">Centros de Costos</a></li>
					<li><a href="<?php echo $this->createUrl('/cuentaContable'); ?>">Cuentas Contables</a></li>
					<li><a href="<?php echo $this->createUrl('/producto'); ?>">Productos</a></li>
					<li><a href="<?php echo $this->createUrl('/proveedor'); ?>">Proveedores</a></li>
					<li><a href="<?php echo $this->createUrl('/familiaProducto'); ?>">Familias de Productos</a></li>
					<li><a href="<?php echo $this->createUrl('/tipoCompra'); ?>">Tipos de Compra</a></li>
					<li><a href="<?php echo $this->createUrl('/AsistenteComiteCompras'); ?>">Asistentes Habituales Comité Compras</a></li>
					<li><a href="<?php echo $this->createUrl('/AsistenteComitePresidencia'); ?>">Asistentes Habituales Comité de Presidencia</a></li>
				</ul>
			</div> 
			
		<!-- 	<div class="btn-group">
				<button class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Contratos <span class="caret"></span></button>
				<ul class="dropdown-menu">
				<li><a href="<?php echo $this->createUrl('/documentoProveedor/gestion'); ?>">Gestionar</a></li>
				<li><a href="<?php echo $this->createUrl('/documentoProveedor/consulta'); ?>">Consultar</a></li>
				<li><a href="<?php echo $this->createUrl('/documentoProveedor/eliminar'); ?>">Eliminar</a></li>
				<li><a href="<?php echo $this->createUrl('/documentoProveedor/editar'); ?>">Editar</a></li>
				</ul>
			</div><!-- /btn-group -->	
				
			<div class="btn-group">
				<button class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Informes <span class="caret"></span></button>
				<ul class="dropdown-menu">
                    <li><a href="<?php echo $this->createUrl('/orden/informeGastoAhorro'); ?>">Gastos y ahorro</a></li>
				</ul>
			</div><!-- /btn-group -->

	   <?php }  ?>
	   <?php if(array_intersect(array('CYC501','CYC502'),Yii::app()->user->permisos)) :?>
			<div class="btn-group">
				<button class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Informes 2 <span class="caret"></span></button>
				<ul class="dropdown-menu">
				<li><a href="<?php echo $this->createUrl('/ahorroCyc/admin'); ?>">Ahorro CYC</a></li>
				<li><a href="<?php echo $this->createUrl('/ahorroSva/admin'); ?>">Ahorro SVA</a></li>
				</ul>
			</div><!-- /btn-group -->	
        <?php endif; ?>
		<?php if( in_array('CYC998',Yii::app()->user->permisos) or substr( Yii::app()->user->name,0,3)=='592' ){ ?>   
		<div class="btn-group">
				<button class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Contratos <span class="caret"></span></button>
				<ul class="dropdown-menu">
				<li><a href="<?php echo $this->createUrl('/documentoProveedor/gestionJuridico'); ?>">Gestionar</a></li>
				</ul>
			</div><!-- /btn-group -->
		<?php   } ?>

		<?php if( array_intersect(array('CYC989','CYC994','CYC986','CYC987','CYC988'), Yii::app()->user->permisos) ){ ?>
		   <div class="btn-group">
				<button class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Contratos <span class="caret"></span></button>
				<ul class="dropdown-menu">
					<? if( array_intersect(array('CYC989','CYC994'), Yii::app()->user->permisos) ){ ?>
						<li><a href="<?php echo $this->createUrl('/documentoProveedor/gestion'); ?>">Gestionar</a></li>
					<? } if( array_intersect(array('CYC988','CYC989','CYC994'), Yii::app()->user->permisos) ){ ?>
						<li><a href="<?php echo $this->createUrl('/documentoProveedor/consulta'); ?>">Consultar</a></li>
					<? } if( array_intersect(array('CYC987'), Yii::app()->user->permisos) ){ ?>
						<li><a href="<?php echo $this->createUrl('/documentoProveedor/consulta'); ?>">Eliminar</a></li>
					<? } if( array_intersect(array('CYC986'), Yii::app()->user->permisos) ){ ?>
						<li><a href="<?php echo $this->createUrl('/documentoProveedor/consulta'); ?>">Editar</a></li>
					<? } ?>
				</ul>
			</div><!-- /btn-group -->
		<?php   } ?>
                <?php if( array_intersect(array('CYC400','CYC402','CYC401','CYC403','CYC404'), Yii::app()->user->permisos)  ){ ?>            
		   <div class="btn-group">
				<button class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Facturación <span class="caret"></span></button>
				<ul class="dropdown-menu">
                                    <? if(! array_intersect(array('CYC404'), Yii::app()->user->permisos) ){ ?>
                                    <li><a href="<?php echo $this->createUrl('/facturacion/facturas/admin') ?>">Gestionar</a></li>
                                    <? } if( array_intersect(array('CYC401'), Yii::app()->user->permisos) ){ ?>
                                    <li><a href="<?php echo $this->createUrl('/facturacion/facturas/causacion') ?>">Causación</a></li>
                                    <? } if( array_intersect(array('CYC402'), Yii::app()->user->permisos) ){ ?>
                                    <li><a href="<?php echo $this->createUrl('/facturacion/parametros/admin') ?>">Parámetros</a></li>
                                    <? } if( array_intersect(array('CYC404'), Yii::app()->user->permisos) ){ ?>
                                    <li><a href="<?php echo $this->createUrl('/facturacion/facturas/adminOperaciones') ?>">Operaciones</a></li>
                                    <? } if( array_intersect(array('CYC401'), Yii::app()->user->permisos) ){ ?>
                                    <li><a href="<?php echo $this->createUrl('/cuentaContable'); ?>">Cuentas Contables</a></li>
                                    <? }  ?>
				</ul>
			</div><!-- /btn-group -->
                <?php   } ?>

        <div class="btn-group">
          <button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"><?php echo Yii::app()->user->name; ?> <span class="caret"></span></button>
          <ul class="dropdown-menu">
          	
	            <li><a href="#">Mis Permisos</a></li>
	            <li><a href="<?php echo $this->createUrl('site/logout') ?>">Salida Segura</a></li>
            
          </ul>
        </div><!-- /btn-group -->

        <?php } ?>
      </div>

      
    </div>
  </div>
</div>


<div class="container" id="page">

	
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.BootBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	
	<?php if(isset($this->menu_izquierdo)):?>
	<div class="row derecha" >

		<?php $this->widget('bootstrap.widgets.BootMenu', array(
		'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
		'stacked'=>false, // whether this is a stacked menu
		'items'=>$this->menu_izquierdo
) ); ?>

</div> 

	<?php endif?>
	
	<?php echo $content; ?>

	<div class="clear"></div>

	

</div><!-- page -->

</body>
</html>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jqueryui/jquery-ui.css" />  

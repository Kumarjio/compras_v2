<?php 

$this->breadcrumbs=array(
	'Orden'=>array('admin'),
	'Home',
);


	$this->menu=array(
	  array('label'=>'Crear','url'=>array('create'), 'icon'=>'plus-sign'),
	  array('label'=>'Home','url'=>array('admin'),'icon'=>'home'),
	);


$this->renderPartial('print',array(
				      'orden' => $orden,
				      'productos_orden' => $productos_orden,
                      'pagos' => $pagos,
                      'elegida' => $elegida,
                      'tabla'=>$tabla,
                      'observaciones' => $observaciones,
                      'tablaordenes' => $tablaordenes,
                      'tablaReemp' => $tablaReemp
				 ));
?>



<?php if($orden->paso_wf != "swOrden/cancelada"){ ?>

<form method="post" id="formCancel">
<div class="alert alert-block alert-warning fade in">
	  <b>Observacion (Razón de cancelación o suspensión)</b><br />
	  <textarea name="observacion" id="observacion_in" class="span8" id="Orden_observacion" rows="6" cols="50"></textarea>
</div>

<div class="form-actions">

<button class="btn btn-primary accion" data-url="<?php echo $this->createUrl('suspender', array('id'=>$orden->id)); ?>" name="yt10" type="button">Suspender Solicitud</button>
<button class="btn btn-primary accion" data-url="<?php echo $this->createUrl('cancelar', array('id'=>$orden->id)); ?>" name="yt11" type="button">Cancelar Solicitud</button>

</div>
</form>

<?php } ?>

<script>
	  $(".accion").click(function(e){
	      if($("#observacion_in").val() == ""){
		alert("Por favor ingrese una observación");
	      }else{
		var url = $(this).attr("data-url");
		$("#formCancel").attr("action", url).submit();
	      }
	    });
</script>
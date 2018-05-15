
<div>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#mti" aria-controls="mti" role="tab" data-toggle="tab">Carga Masiva de MTI</a></li>
    <li role="presentation"><a href="#comun" aria-controls="comun" role="tab" data-toggle="tab">Carga Origen Común</a></li>
    <li role="presentation"><a href="#pcl" aria-controls="pcl" role="tab" data-toggle="tab">Carga PCL</a></li>
  </ul>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="mti">
    	<div class="col-md-12">
    		<?php $this->renderPartial('_masivoMTI', array('model' => $model)); ?>
    	</div>
    </div>
    <div role="tabpanel" class="tab-pane" id="comun">
        <div class="col-md-12">
            <?php $this->renderPartial('_cargueOrigenComun', array('model' => $modelOrigen)); ?>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="pcl">
        <div class="col-md-12">
            <?php $this->renderPartial('_carguePcl', array('model' => $modelPcl)); ?>
        </div>
    </div>
  </div>
</div>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div class="modal fade" id="alertaModal" tabindex="-1" role="dialog" aria-labelledby="alertaModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="glyphicon glyphicon-remove-sign"></i>Error al Cargar Archivo</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" id="alertOk">
                        <p align='justify'>
                            <big>
                                <?php echo Yii::app()->user->getFlash('error'); ?>
                            </big>
                        </p>
                    </div>
                    <div class="tag-box tag-box-v4">
                        <p align='justify'>
                            <span class="label label-danger">NOTA</span> Recuerde que el archivo debe tener al menos un registro (una fila aparte de las cabeceras) y un total de diecinueve (19) campos (columnas) los cuales van desde la columna "A" hasta la "R".
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= CHtml::button('Aceptar', array('name' => 'botonAcepta', 'id' => 'botonAcepta', 'class' => 'btn btn-success', 'data-dismiss' => 'modal')) ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('notifica')): ?>
    <div class="modal fade" id="cargueModal" tabindex="-1" role="dialog" aria-labelledby="cargueModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="glyphicon glyphicon-tags"></i> Detalles del Cargue</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" id="notificaOk">
                        <p align='justify'>
                            <big>
                                <?php echo Yii::app()->user->getFlash('notifica'); ?>
                            </big>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= CHtml::button('Aceptar', array('name' => 'botonCierra', 'id' => 'botonCierra', 'class' => 'btn btn-success', 'data-dismiss' => 'modal')) ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('errorComun')): ?>
    <div class="modal fade" id="alertaCargueOrigen" tabindex="-1" role="dialog" aria-labelledby="alertaCargueOrigenLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="glyphicon glyphicon-remove-sign"></i>Error al Cargar Archivo</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" id="alertOkCargue">
                        <p align='justify'>
                            <big>
                                <?php echo Yii::app()->user->getFlash('errorComun'); ?>
                            </big>
                        </p>
                    </div>
                    <div class="tag-box tag-box-v4">
                        <p align='justify'>
                            <span class="label label-danger">NOTA</span> Recuerde que el archivo debe tener al menos un registro (una fila aparte de las cabeceras) y un total de diecinueve (19) campos (columnas) los cuales van desde la columna "A" hasta la "S".
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php echo CHtml::button('Aceptar', array('name' => 'botonAceptaCargue', 'id' => 'botonAceptaCargue', 'class' => 'btn btn-success', 'data-dismiss' => 'modal')); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('notificaComun')): ?>
    <div class="modal fade" id="cargueModalOrigenComun" tabindex="-1" role="dialog" aria-labelledby="cargueModalOrigenComunLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="glyphicon glyphicon-tags"></i> Detalles del Cargue</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" id="notificaOkCargue">
                        <p align='justify'>
                            <big>
                                <?php echo Yii::app()->user->getFlash('notificaComun'); ?>
                            </big>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= CHtml::button('Aceptar', array('name' => 'botonCierraComun', 'id' => 'botonCierraComun', 'class' => 'btn btn-success', 'data-dismiss' => 'modal')) ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('errorPcl')): ?>
    <div class="modal fade" id="alertaCargueOrigen" tabindex="-1" role="dialog" aria-labelledby="alertaCargueOrigenLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="glyphicon glyphicon-remove-sign"></i>Error al Cargar Archivo</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" id="alertOkCargue">
                        <p align='justify'>
                            <big>
                                <?php echo Yii::app()->user->getFlash('errorPcl'); ?>
                            </big>
                        </p>
                    </div>
                    <div class="tag-box tag-box-v4">
                        <p align='justify'>
                            <span class="label label-danger">NOTA</span> Recuerde que el archivo debe tener al menos un registro (una fila aparte de las cabeceras) y un total de diecinueve (23) campos (columnas) los cuales van desde la columna "A" hasta la "W".
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php echo CHtml::button('Aceptar', array('name' => 'botonAceptaCarguePcl', 'id' => 'botonAceptaCarguePcl', 'class' => 'btn btn-success', 'data-dismiss' => 'modal')); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('notificaPcl')): ?>
    <div class="modal fade" id="cargueModalPcl" tabindex="-1" role="dialog" aria-labelledby="cargueModalOrigenComunLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="glyphicon glyphicon-tags"></i> Detalles del Cargue</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" id="notificaOkCargue">
                        <p align='justify'>
                            <big>
                                <?php echo Yii::app()->user->getFlash('notificaPcl'); ?>
                            </big>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= CHtml::button('Aceptar', array('name' => 'botonCierraPcl', 'id' => 'botonCierraPcl', 'class' => 'btn btn-success', 'data-dismiss' => 'modal')) ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<script type="text/javascript">
	$( document ).ready(function() {
	    setTimeout(
	    	function(){ 
	    		$(".qq-upload-button").removeClass('qq-upload-button').addClass('btn btn-lg btn-success btn-block prevent hide-me');
	    	}, 
	    	5
	    );
	});
    $(function(){
        $('#alertaModal').modal('toggle');
		$('#cargueModal').modal('toggle');
        
        $('#alertaCargueOrigen').modal('toggle');
        $('#cargueModalOrigenComun').modal('toggle');

        $('#alertaCarguePcl').modal('toggle');
        $('#cargueModalPcl').modal('toggle');

		$( "#linkInfo" ).click(function(){		  	
			if( $('#infoCargue').is(":visible") ){
			    $('#infoCargue').hide();
			}else{
			    $('#infoCargue').show();
			}		  	
		});

        $( "#linkInfoCargueOrigen" ).click(function(){          
            if( $('#infoCargueOrigen').is(":visible") ){
                $('#infoCargueOrigen').hide();
            }else{
                $('#infoCargueOrigen').show();
            }           
        });

        $( "#linkInfoCarguePcl" ).click(function(){          
            if( $('#infoCarguePcl').is(":visible") ){
                $('#infoCarguePcl').hide();
            }else{
                $('#infoCarguePcl').show();
            }           
        });
	});

    $("#alertaModal").on('hidden', function(){
		$('#CargaMasiva_adjunto').val('');
    });

    $("#cargueModal").on('hidden', function(){
    	$('#CargaMasiva_adjunto').val('');
    });

    $("#alertaCargueOrigen").on('hidden', function(){
        $('#CargaMasiva_adjunto').val('');
    });
    $("#cargueModalOrigenComun").on('hidden', function(){
        $('#CargaMasiva_adjunto').val('');
    });
    $("#alertaCarguePcl").on('hidden', function(){
        $('#CargaMasiva_adjunto').val('');
    });
    $("#cargueModalPcl").on('hidden', function(){
        $('#CargaMasiva_adjunto').val('');
    });
</script>
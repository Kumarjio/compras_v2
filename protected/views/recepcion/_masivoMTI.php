</br>
<?php $form = $this->beginWidget('CActiveForm', array(
                'id'=>'recepcion-masiva',
                'action'=>Yii::app()->createUrl('recepcion/masiva'),
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                        'validateOnChange'=>true,
                        'validateOnSubmit'=>true
))); ?>
<div class="panel panel-default margin-bottom-40">
	<div class="panel-heading">
    	<h3 class="panel-title"><i class="glyphicon glyphicon-upload"></i> Carga Masiva de MTI</h3>
  	</div>
  	<div class="panel-body">
		<center>
			<h4><i class="glyphicon glyphicon-import"></i> Carga de MTI</h4>
		</center>
		<br>
		<?php echo $form->errorSummary($model) ?>
		<div class="form-group" align="center">
			<div class="col-md-4"></div>
			<div class="col-md-4">
			  	<div class="form-group" align="center">
			  		<?php
				        $this->widget('ext.EFineUploader.EFineUploader',
				            array(
				                'id'=>"adjunto",
				                'config'=>array(
				                    'autoUpload'=>true,
				                    'request'=>array(
				                        'endpoint'=>$this->createUrl('uploadMasiva'),
				                        'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
				                    ),
				                    'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
				                    'callbacks'=>array(
				                        'onComplete'=>"js:function(id, name, response){ 
				                            $('#CargaMasiva_adjunto').val(response.filename);
				                            $('#adjunto').find('div.qq-uploader').find('ul.qq-upload-list').show();
					                        $('#CargaMasiva_adjunto_em_').hide();
				                        }",                                    
				                    ),
				                    'validation'=>array(
				                        'allowedExtensions'=>array('xls', 'xlsx'),
				                        'sizeLimit'=>2 * 1024 * 1024,//maximum file size in bytes
				                    ),
				                    'messages'=>array(
				                        'typeError'=>"El archivo {file} tiene una extensión incorrecta. Se permite solamente los archivos con las siguientes extensiones: {extensions}.",
				                        'sizeError'=>"Tamaño de archivo {file} es grande, el tamaño máximo de {sizeLimit}.",
				                        'minSizeError'=>"Tamaño de archivo {file} es pequeño, el tamaño mínimo {minSizeLimit}.",
				                        'emptyError'=>"{file} is empty, please select files again without it.",
				                        'onLeave'=>"Los archivos se están cargando, si te vas ahora la carga se cancelará."
				                    ),
				                )
				            )
				        );  
				    ?>
				    <br>
			   		<?= $form->hiddenField($model, 'adjunto')?>
			    </div>  
			</div>
			<div class="col-md-4"></div>
		</div>
		<br>
		<div class='col-md-12' align="center">
			<h4><a href="#" id="linkInfo" data-toggle="tooltip" title="Ver Ejemplo"><big><i class="glyphicon glyphicon-info-sign"></i></big> Ayuda</a></h4>
		</div>
		<div class='col-md-12 oculto' align="center" id="infoCargue">
			<div class="alert alert-default" role="alert" align="center">
				<p align='justify'>
	        		<span class="label label-danger">NOTA</span> Recuerde que el archivo debe tener al menos un registro (una fila aparte de las cabeceras) y un total de diecinueve (19) campos (columnas) los cuales van desde la columna "A" hasta la "R". Ejemplo: <br><br>
	        	</p>
	        	<small>
		        	<div class="table-responsive">
			        	<table class="items table table-bordered">
					        <tbody>
					        	<tr class="odd active">
					                <th>-</th><th>A</th><th>B</th><th>C</th><th>E</th><th>F</th><th>G</th><th>H</th><th>I</th><th>J</th><th>K</th><th>L</th>
					                <th>N</th><th>P</th><th>Q</th>
					            </tr>
					            <tr class="odd">
					            	<th class="active">5</th>
						            <td class="success">CONSECUTIVO</td>
						            <td class="success">CODBAR</td>
						            <td class="success">EMPRESA_REMITENTE</td>
						            <td class="success">REMITENTE</td>
						            <td class="success">TIPO_DOCUMENTO</td>
						            <td class="success">TIPO_DE_COMUNICACION</td>
						            <td class="success">ASUNTO</td>
						            <td class="success">NOMBRE_DESTINATARIO</td>
						            <td class="success">DEPENDENCIA_DESTINATARIO</td>
						            <td class="success">ESTADO</td>
						            <td class="success">PRIORIDAD</td>
						            <td class="success">USUARIO_RADICACION</td>
						            <td class="success">TIENE_IMAGEN</td>
						            <td class="success">FECHA_RADICACION</td>							                              
					            </tr>
					            <tr class="odd">
					                <th class="active">6</th><td>11951</td><td title="RBOG201700000132839">RBOG2017...</td><td>PEPITO PEREZ</td><td title="PEPITO PEREZ">PEPITO...</td><td> Transaccional</td><td>Corporativa</td><td title="RENTA 93496 SOLICITUD REMITIR INFORMACION SOBRE PAGO">RENTA...</td>
					                <td>Luis Alejandro Coral</td><td title="DIRECCION DE PREVISIONALES Y RENTAS VITALICIAS"> DIRECCION...</td><td>RADICADO</td><td>Media</td><td title=" CARLOS EDUARDO LAVERDE">CARLOS EDUARDO...</td><td>Si</td><td> 2017-09-29 16:53:00</td>
					            </tr>
					        </tbody>
					    </table>
				    </div>
			    </small>
			</div>
		</div> 
	</div>
</div>
<div class='col-md-2'>
  <div class="form-group">
    <?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-lg btn-success btn-block')); ?>
  </div>
</div>
<div class="row">
</div>
<?php $this->endWidget(); ?>
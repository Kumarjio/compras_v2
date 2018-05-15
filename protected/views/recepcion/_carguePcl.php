</br>
<?php $formPcl = $this->beginWidget('CActiveForm', array(
                'id'=>'cargue_pcl',
                'action'=>Yii::app()->createUrl('recepcion/masiva'),
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                        'validateOnChange'=>true,
                        'validateOnSubmit'=>true
))); ?>
<div class="panel panel-default margin-bottom-40">
	<div class="panel-heading">
    	<h3 class="panel-title"><i class="glyphicon glyphicon-upload"></i> Carga Pcl</h3>
  	</div>
  	<div class="panel-body">
		<center>
			<h4><i class="glyphicon glyphicon-import"></i> Carga Pcl</h4>
		</center>
		<br>
		<?php echo $formPcl->errorSummary($model) ?>
		<div class="form-group" align="center">
			<div class="col-md-4"></div>
			<div class="col-md-4">
			  	<div class="form-group" align="center">
			  		<?php
				        $this->widget('ext.EFineUploader.EFineUploader',
				            array(
				                'id'=>"adjuntoCarguePcl",
				                'config'=>array(
				                    'autoUpload'=>true,
				                    'request'=>array(
				                        'endpoint'=>$this->createUrl('uploadMasiva'),
				                        'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
				                    ),
				                    'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
				                    'callbacks'=>array(
				                        'onComplete'=>"js:function(id, name, response){ 
				                            $('#CargaMasivaPcl_adjunto').val(response.filename);
				                            $('#adjuntoCarguePcl').find('div.qq-uploader').find('ul.qq-upload-list').show();
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
			   		<?php echo $formPcl->hiddenField($model, 'adjunto')?>
			    </div>  
			</div>
			<div class="col-md-4"></div>
		</div>
		<br>
		<div class='col-md-12' align="center">
			<h4><a href="#" id="linkInfoCarguePcl" data-toggle="tooltip" title="Ver Ejemplo"><big><i class="glyphicon glyphicon-info-sign"></i></big> Ayuda</a></h4>
		</div>
		<div class='col-md-12 oculto' align="center" id="infoCarguePcl">
			<div class="alert alert-default" role="alert" align="center">
				<p align='justify'>
	        		<span class="label label-danger">NOTA</span> Recuerde que el archivo debe tener al menos un registro (una fila aparte de las cabeceras) y un total de diecinueve (23) campos (columnas) los cuales van desde la columna "A" hasta la "W", por favor retirar los estilos del documento para evitar errores durante el cargue. Ejemplo: <br><br>
	        	</p>
	        	<small>
		        	<div class="table-responsive">
			        	<table class="items table table-bordered">
					        <tbody>
					        	<tr class="odd active">
					                <th>-</th><th>A</th><th>B</th><th>C</th><th>D</th><th>E</th><th>F</th><th>G</th><th>H</th><th>I</th><th>J</th><th>K</th>
					                <th>L</th><th>M</th><th>N</th><th>O</th><th>P</th><th>Q</th><th>R</th><th>S</th><th>T</th><th>U</th><th>V</th><th>W</th>
					            </tr>
					            <tr class="odd">
					            	<th class="active">1</th>
						            <td>SINIESTRO</td>
						            <td>NOMBRE</td>
						            <td>DIRECCIÓN</td>
						            <td>TELEFONO</td>
						            <td>CIUDAD</td>
						            <td>DEPARTAMENTO</td>
						            <td>PORCENTAJE</td>
						            <td>FECHA_DE_ESTRUCTURACION</td>
						            <td>DIAGNOSTICO</td>
						            <td>MESES</td>
						            <td>MESES_EN_LETRAS</td>
						            <td>NOMBRE_DE_LA_EMPRESA</td>
						            <td>DIRECCIÓN</td>
						            <td>TELEFONO</td>
						            <td>CIUDAD</td>
						            <td>EPS</td>
						            <td>DIRECCIÓN</td>
						            <td>TELEFONO</td>
						       		<td>CIUDAD</td>
						            <td>AFP</td>
						            <td>DIRECCIÓN</td>
						            <td>TELEFONO</td>
						            <td>CIUDAD</td>					                              
					            </tr>
					            <tr class="odd">
					                <th class="active">2</th><td>2015003493</td><td title="LUIS NORBERTO VASCO VILLA">LUIS...</td><td title="Finca lusitania la puyana Carrera 19 No. 2-20">Finca...</td><td>3104146207</td><td title="Sabana de Torres">Sabana...</td><td>Santander</td><td>7.35</td><td title="31 de Agosto de 2016">31 de Agosto...</td><td title="Fractura unicortical de tibia y Lesión del tendón extensor y del nervio peroneal izquierdo, Reparado">Fractura...</td><td>3.18</td><td>Tres punto diesiocho</td>
					                <td>OYV OUTSOURCING LTDA</td><td title="Calle 36 15 32 OFC 603 Edi Colseguros">Calle 36...</td><td>6803140</td><td title="Bucaramanga">Bucara...</td><td title="NUEVA EPS">NUE...</td><td title="Calle 35 No.16 - 24">Calle 35...</td><td>6702575</td><td title="Bucaramanga">Bucara...</td><td>COLPENSIONES</td><td title="CARRERA 15 41-01 Esquina">CARRERA...</td><td></td><td title="Bucaramanga">Bucara...</td>
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
<?php $this->endWidget(); ?>
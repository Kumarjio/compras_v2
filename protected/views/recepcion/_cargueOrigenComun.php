</br>
<?php $formComun = $this->beginWidget('CActiveForm', array(
                'id'=>'cargue_comun',
                'action'=>Yii::app()->createUrl('recepcion/masiva'),
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                        'validateOnChange'=>true,
                        'validateOnSubmit'=>true
))); ?>
<div class="panel panel-default margin-bottom-40">
	<div class="panel-heading">
    	<h3 class="panel-title"><i class="glyphicon glyphicon-upload"></i> Carga Origen Común</h3>
  	</div>
  	<div class="panel-body">
		<center>
			<h4><i class="glyphicon glyphicon-import"></i> Carga Origen Común</h4>
		</center>
		<br>
		<?php echo $formComun->errorSummary($model) ?>
		<div class="form-group" align="center">
			<div class="col-md-4"></div>
			<div class="col-md-4">
			  	<div class="form-group" align="center">
			  		<?php
				        $this->widget('ext.EFineUploader.EFineUploader',
				            array(
				                'id'=>"adjuntoCargueOrigen",
				                'config'=>array(
				                    'autoUpload'=>true,
				                    'request'=>array(
				                        'endpoint'=>$this->createUrl('uploadMasiva'),
				                        'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
				                    ),
				                    'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
				                    'callbacks'=>array(
				                        'onComplete'=>"js:function(id, name, response){ 
				                            $('#CargaMasivaOrigen_adjunto').val(response.filename);
				                            $('#adjuntoCargueOrigen').find('div.qq-uploader').find('ul.qq-upload-list').show();
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
			   		<?php echo $formComun->hiddenField($model, 'adjunto')?>
			    </div>  
			</div>
			<div class="col-md-4"></div>
		</div>
		<br>
		<div class='col-md-12' align="center">
			<h4><a href="#" id="linkInfoCargueOrigen" data-toggle="tooltip" title="Ver Ejemplo"><big><i class="glyphicon glyphicon-info-sign"></i></big> Ayuda</a></h4>
		</div>
		<div class='col-md-12 oculto' align="center" id="infoCargueOrigen">
			<div class="alert alert-default" role="alert" align="center">
				<p align='justify'>
	        		<span class="label label-danger">NOTA</span> Recuerde que el archivo debe tener al menos un registro (una fila aparte de las cabeceras) y un total de diecinueve (19) campos (columnas) los cuales van desde la columna "A" hasta la "S", por favor retirar los estilos del documento para evitar errores durante el cargue. Ejemplo: <br><br>
	        	</p>
	        	<small>
		        	<div class="table-responsive">
			        	<table class="items table table-bordered">
					        <tbody>
					        	<tr class="odd active">
					                <th>-</th><th>A</th><th>B</th><th>C</th><th>D</th><th>E</th><th>F</th><th>G</th><th>H</th><th>I</th><th>J</th><th>K</th>
					                <th>L</th><th>M</th><th>N</th><th>O</th><th>P</th><th>Q</th><th>R</th><th>S</th>
					            </tr>
					            <tr class="odd">
					            	<th class="active">1</th>
						            <td>SINIESTRO</td>
						            <td>NOMBRE</td>
						            <td>DIRECCIÓN</td>
						            <td>TELEFONO</td>
						            <td>CIUDAD</td>
						            <td>DEPARTAMENTO</td>
						            <td>DIAGNOSTICO</td>
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
					                <th class="active">2</th><td>2017002588</td><td title="JOSE LUIS GONZALEZ SALAMANCA">JOSE...</td><td title="Calle 6B 79C - 90 Interior 1 Apto 101 Conjunto prados de techo 1 Barrio piodoce castilla ">Calle 6B...</td><td>3134718606</td><td title="Bogotá D.C.">Bogotá...</td><td></td><td title="Fractura de la epifisis inferior del radio izquierdo y Herida en cuero cabelludo">Fractura de la...</td>
					                <td>AJOVER SAS</td><td title="CALLE 65 BIS 91-82"> CALLE 65...</td><td>5949999</td><td title="Bogotá D.C.">Bogotá...</td><td title="NUEVA EPS">NUE...</td><td title="Carrera 85 K No. 46 A - 66">Carrera 85...</td><td>3077022</td><td title="Bogotá D.C.">Bogotá...</td><td>PORVENIR</td><td title="Carrera 13 No. 26A - 65">Carrera 13...</td><td>3393000</td><td title="Bogotá D.C.">Bogotá...</td>
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
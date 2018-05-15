<?php
header('Content-Description: File Transfer');
header("Content-type: application/vnd.ms-excel");
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header("Content-disposition: attachment; filename=Informe_contratos.xls");

?>
<html>
    <head>
    	<meta charset="utf-8">
    </head>
    <body>

    <?php $this->widget('bootstrap.widgets.BootGridView',array(
        'id'=>'documento-proveedor-grid',
        'dataProvider'=>$model->search_excel(),
        'type'=>'striped bordered condensed',
        'enableSorting'=>false,
        'summaryText'=>'',
        'columns'=>array(
            'consecutivo_contrato',
            array(
            'header'=>'Tipo Documento',
            'value' => '$data->tipo_documento_rel->tipo_documento'
            ),      
            'proveedor',
            array(
            'header'=>'Proveedor',
            'value'=>'DocumentoProveedor::traerNombreProveedor($data->proveedor)'
            ),
            'nombre_contrato',
            //  'objeto',
            array(
                'name'=> 'fecha_inicio',
                'type'=> 'text',
                'value'=> '(strlen($data->fecha_inicio)>0) ? date("Y-m-d",strtotime($data->fecha_inicio) ) : ""'
            ),
            array(
                'name'=> 'fecha_fin',
                'type'=> 'text',
                'value'=> '(strlen($data->fecha_fin)>0) ? date("Y-m-d",strtotime($data->fecha_fin) ) : ""'
            ),
            array(
                'header'=>'No. Documentos',
                'value'=>'DocumentoProveedor::numDocs($data->id_docpro)'
            ),
            array(
                'name'=> 'fecha_firma',
                'type'=> 'text',
                'value'=> '(strlen($data->fecha_firma)>0) ? date("Y-m-d",strtotime($data->fecha_firma) ) : ""'
            ),

            array(
                'name'=>'estado',
                'value'=>'$data->estado_rel->estado'
            ),
        ),
    )); ?>  
    </body>
</html>
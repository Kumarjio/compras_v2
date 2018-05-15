<?php 
    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename="'.utf8_decode("Informe_contratos_".date('Ymd').".csv").'"');
    header("Expires: 0");
    header("Pragma: cache");
    header("Cache-Control: private");

    if($pre)
        $cab = "Fecha Preaviso";
    else
        $cab = "Fecha Fin";

    echo utf8_decode("Tipo Documento;Nit Proveedor;Proveedor;Nombre;Objeto;Fecha Inicio;".$cab.";Responsable Proveedor; Responsable Compras;Estado \r\n");

    $fecha = date('Y-m-j');
    $nuevafecha = strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
    $nuevafecha = date ( 'Y-m-j' , $nuevafecha );

    foreach ($contratos as $con){
        
        $suma_fecha = DocumentoProveedor::calculaFechaFin($con['id_docpro'],$pre);
        if( !empty($suma_fecha) ){

            $fechafin = $suma_fecha;
            
            if($fechafin >= $fecha && $fechafin <= $nuevafecha){               
                echo utf8_decode(TipoDocumentos::model()->findByPk($con['tipo_documento'])->tipo_documento.";".$con['proveedor'].";".DocumentoProveedor::traerNombreProveedor($con['proveedor']).";".$con['nombre_contrato'].";".$con['objeto'].";".$con['fecha_inicio'].";".$suma_fecha.";".$con['responsable_proveedor'].";".DocumentoProveedor::traeResponsable($con['id_docpro']).";".DocumentoProveedor::traeEstado($con['id_docpro'])." \r\n");
            }
        }
    }

    exit;
?>
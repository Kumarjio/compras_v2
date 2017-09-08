<?php 
    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename="'.utf8_decode("personas_imagine".date('Ymd').".csv").'"');
    header("Expires: 0");
    header("Pragma: cache");
    header("Cache-Control: private");

    echo utf8_decode("documento,nro_historia,id_tipo_documento,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,fecha_nacimiento,id_departamento,id_ciudad,direccion,telefono,sexo,id_estado_civil,fecha_apertura,nro_historia,cod_cama,registro_activo,nivel_servicio,estado,zona,cod_lugar,correo,id_ocupacion,consecutivo_histo,tipo_paciente,religion,barrio,nombre_acompanante,direccion_acom \r\n");
    foreach ($data as $row){

        if($row['sexo'] == "m")
            $sexo = "1";
        else
            $sexo = "0";

        echo utf8_decode($row['documento'].";".$row['documento'].";".($row['id_tipo_documento'] - 1).";".$row['primer_apellido'].";".$row['segundo_apellido'].";".$row['primer_nombre'].";".$row['segundo_nombre'].";".date("d/m/y", strtotime($row['fecha_nacimiento'])).";".$row['id_departamento'].";".substr($row['id_ciudad'], 2).";".$row['direccion'].";".$row['telefono'].";".$sexo.";".($row['id_estado_civil'] - 1).";;;;;;1;;;".$row['correo'].";".$row['id_ocupacion'].";;;;;".$row['nombre_acompanante']."; \r\n");
    }
    exit;
    
?>
<?php 
    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename="'.utf8_decode("entidades_imagine".date('Ymd').".csv").'"');
    header("Expires: 0");
    header("Pragma: cache");
    header("Cache-Control: private");

    echo utf8_decode("nro_historia_pac,nit,cod_estrato,cod_carnet,id_categoria,estado_ent,estado_afi \r\n");
    foreach ($data as $row){

        if($row['id_categoria'] == "1" || $row['id_categoria'] == "7" || $row['id_categoria'] == "8")
            $categ = "0";
        
        if($row['id_categoria'] == "2")
            $categ = "1";

        if($row['id_categoria'] == "3")
            $categ = "2";

        if($row['id_categoria'] == "6")
            $categ = "4";

        if($row['id_categoria'] == "5")
            $categ = "6";

        echo utf8_decode($row['documento'].";".$row['nit'].";".$row['codigo_regimen'].";;".$categ.";1;S \r\n");
    }
    exit;
?>
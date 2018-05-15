<?php
$reportico = Yii::app()->getModule('reportico');
$engine = $reportico->getReporticoEngine();
$reportico->engine->initial_execute_mode = "PREPARE";
$reportico->engine->initial_report = $reporte;
$reportico->engine->access_mode = "ONEREPORT";
$reportico->engine->initial_project = "compras";
$reportico->engine->clear_reportico_session = true;
$reportico->generate();

?>
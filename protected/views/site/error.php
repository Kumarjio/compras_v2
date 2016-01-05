<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>


<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="error-v1">
            <span class="error-v1-title"><?php echo $code; ?></span>
            <span><?php echo CHtml::encode($message); ?></span>
            <p>Este es un error controlado.</p>
        </div>
    </div>
</div>

<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/jquery.maskMoney.js'); ?>
<div id="content">
	<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>
<link rel="stylesheet" type="text/css" href="/css/custom-theme/jquery-ui-1.10.0.custom.css" />  
<?php $this->beginContent('//layouts/main'); ?>

<div class="row">
  <div class="span12">
    <div class="row">
        <div class="span7">

        </div>
        <div class="span5">
          <div class="pull-right">
            <?php 
              foreach ($this->menu as $n => $op) {
                if($op['url'][0] == $this->action->Id){
                  $this->menu[$n]['active'] = true;
                  break;
                }
              } 

        
              
            ?>

            <?php $this->widget('bootstrap.widgets.BootMenu', array(
                'type'=>'pills',
                'items'=>$this->menu,
            )); ?>
          </div>
        </div>
    </div>  
 </div> 
</div>


<div class="row">
  <div class="span12">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $content; ?>
  </div> 
</div>



<?php $this->endContent(); ?>
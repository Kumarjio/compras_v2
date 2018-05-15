<?php $this->beginContent('//layouts/main'); ?>



	

<div class="row">
	
	<div class="span9">
			<div id="real_content">
				<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
			<?php echo $content; ?>
			</div>
		
	</div>


	<div class="span3">
		<div class="well">

			<?php 
				foreach ($this->menu as $n => $op) {
					if($op['url'][0] == $this->action->Id){
						$this->menu[$n]['active'] = true;
						break;
					}
				} 
			?>

			<?php $this->widget('bootstrap.widgets.BootMenu', array(
			    'type'=>'list',
			    'items'=>$this->menu,
			)); ?>
		</div>
	</div>

</div>

<script>
		  
 var $win = $(window)
   , $nav = $('.subnav')
   , navTop = $('.subnav').length && $('.subnav').offset().top - 40
   , isFixed = 0
   
   processScroll()
   
   $win.on('scroll', processScroll)
   
   function processScroll() {
   var i, scrollTop = $win.scrollTop()
   if (scrollTop >= navTop && !isFixed) {
     isFixed = 1
     $nav.addClass('fix')
   } else if (scrollTop <= navTop && isFixed) {
     isFixed = 0
     $nav.removeClass('fix')
   }
 }
		  


</script>

<?php $this->endContent(); ?>



	<?php 
	$content= mime_content_type($archivo);  
	if($content=='application/pdf' or $content=='image/jpeg'){  ?>
      <object width="100%" height="830" type="<?=$content ?>" data="<?php echo $this->createUrl("Facturas/verImagen?archivo=$archivo");?>" id="pdf_content">
        <p>No se puede visualizar Archivo.</p>
      </object>
	<?php  }  ?>
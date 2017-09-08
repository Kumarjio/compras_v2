<?php 
class SMailSender
{
	private $_mailer;
	private $direccion = "http://imagineb.ing.co/crm/index.php";
	
	public function init(){
		$this->_mailer = Yii::createComponent('application.extensions.mailer.EMailer');


		if(isset(Yii::app()->params->development) && Yii::app()->params->development == 1){
			$this->_mailer->IsSMTP();
			$this->_mailer->SMTPAuth   = true;
			$this->_mailer->Host       = "smtp.sendgrid.net";      
			$this->_mailer->Port       = 25;                   
			$this->_mailer->Username   = "santios";
			$this->_mailer->Password   = "imagineROOT1";            
			$this->_mailer->CharSet = 'UTF-8';
			$this->_mailer->FromName = 'Clínica San Diego';
			$this->_mailer->From = 'santios@imagineltda.com';

		}else{
			$this->_mailer->IsSMTP();
			$this->_mailer->SMTPAuth   = true;
            $this->_mailer->SMTPSecure = "ssl";
			$this->_mailer->Host       = "smtp.gmail.com";     
			$this->_mailer->Port       = 465;
			//$this->_mailer->Username   = "jairo.nino@imagineltda.com";
			//$this->_mailer->Password   = "ahl2631cvs46c";   
			$this->_mailer->Username   = "clinicasandiego.imagine@gmail.com";
			$this->_mailer->Password   = "Img_$4ND.2016*";           
			$this->_mailer->CharSet = 'UTF-8';
			$this->_mailer->FromName = 'Pruebas - Clínica San Diego';
//          $img = dirname(Yii::app()->request->scriptFile).'/images/logo-clinica-sandiego.png';
//          $this->_mailer->AddEmbeddedImage($img, 'imagen', $img, "base64", "image/png");
			if(isset(Yii::app()->params->test_cuenta_email) && Yii::app()->params->test_cuenta_email == 1){
				$this->_mailer->From = 'clinicasandiego.imagine@gmail.com';
			}else{
				$this->_mailer->From = 'clinicasandiego.imagine@gmail.com';
			}
			
		}
	}
	
	public function enviarCorreo($email, $asunto, $body = null, $adjuntos = false){
        $this->_mailer->clearAttachments();
        $this->_mailer->clearAllRecipients();
        $this->_mailer->clearAddresses();
		    
		
		$this->_mailer->Subject = $asunto;
		$this->_mailer->IsHTML(true);
		
		$this->setSender($email);

		if($adjuntos){
			foreach ($adjuntos as $a) {
				if($a['archivo']){
					$this->_mailer->AddAttachment($a['path']);	
				}	
			}	
		}
				
		$this->_mailer->Body = $body;
		return $this->_mailer->Send();	
	}


	public function setSender($email){
		if(isset(Yii::app()->params->development) && Yii::app()->params->development == 1){
			$this->_mailer->AddAddress(Yii::app()->params->devemail);
		} else if(isset(Yii::app()->params->test) && Yii::app()->params->test == 1){
			foreach (Yii::app()->params->testemail as $value) {
				$this->_mailer->AddAddress($value);
			}
		} else{
			$this->_mailer->AddAddress($email);
		}
			
	}

	
}

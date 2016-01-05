<?php

require_once("nusoap/lib/nusoap.php");

class SWebService{
	    public $_soap;
	    private $_userOffice;
	    private $_permisos = array();
	   
		private $_config = array(
			'aplicacion'=>'ALV01',
            'oficina'=>'p003',
		
		);

        public function SWebService()
        {

            $this->wsdl = Yii::app()->params->wsdl;
            $this->wsdl2 = Yii::app()->params->wsdl2;
            $this->_config['wsdl'] = $this->wsdl;
            $this->_config['wsdl2'] = $this->wsdl2;

            $this->_soap = new nusoap_client($this->_config['wsdl'],true);

        }
        
        public function autorizar($usuario,$clave){
        	
        	$pars = array('pUsuario'=>$usuario,
			  'pConstrasena'=>$clave,
		      'pAplicativo'=>$this->_config['aplicacion'],
			);
			
		
		    $b = $this->_soap->call('Autenticar',$pars);
		    //print_r($b);
		    if($b['AutenticarResult'] == "true")
		    {
				$this->listarOperaciones($usuario);
				$this->getUserData($usuario);
				return true;
			}else{
				return false;
			}
			
		}

	public function autorizarNuevo($usuario,$clave){
                $a = "";
				$b = "";
				$c = "";
                $pars = array('pUsuario'=>$usuario,
                          'pConstrasena'=>$clave,
                          'pAplicativo'=>$this->_config['aplicacion'],
			  			  'p_strMensaje'=>$a,
                          'p_strUrlRedireccion'=>$b,
                          'p_strTokenSeguridad'=>$c
                        );


                    $b = $this->_soap->call('AutenticarUsuario',$pars);
                    
                    if($b['AutenticarUsuarioResult'] == 0 || $b['AutenticarUsuarioResult'] == 1)
                    {
                                $this->listarOperaciones($usuario);
                                $this->getUserData($usuario);
                               
                    }

                    return $b;

                }

public function informacionUsuario($usuario)
  {
    $soap_nuevo = new nusoap_client($this->_config['wsdl2'],true);
    $par = array('pUsuario'=>$usuario);

    $a = $soap_nuevo->call('InformarcionUsuario',$par);


    if(isset($a['InformarcionUsuarioResult']['diffgram']['InformarcionUsuarioGetByUsuarioIDResult']['Usuarios'])){
      $cedula = $a['InformarcionUsuarioResult']['diffgram']['InformarcionUsuarioGetByUsuarioIDResult']['Usuarios']['Cedula'];
      if($cedula){
	return $cedula;
      }else{
	throw new CHttpException(500,"La cédula del usuario no registra en el sistema de seguridad");
      }
      
    }else{
      throw new CHttpException(500,"La cédula del usuario no registra en el sistema de seguridad");
    }
  }
        
        public function listarOperaciones($usuario)
        {
	        $par = array('pUsuario'=>$usuario,
				 	     'pAplicativo'=>$this->_config['aplicacion']
			);
			
			$a = $this->_soap->call('ListarAccionesNegocio',$par);
		    $acciones = array();
		    $j = 0;
		    
		    if($a == "")
		    	throw new CHttpException(500,"El usuario $usuario no tiene permisos en el sistema.");
		    
		    //$accID = $a['ListarAccionesNegocioResult']['diffgram']['NewDataSet']['Table'];
		    $accID = $a['ListarAccionesNegocioResult']['diffgram']['AYAListarAccionesNegocioResult']['Acciones'];
		    foreach($accID as $i=>$arreglo)
		    {
		    	//print_r($arreglo);
			$acciones[$j] = $arreglo['AccionID'];
		    	$j++;
		    }
		
		    $this->_permisos = $acciones;
	     
		    
        } 
        
        public function cambiarClave($pw)
        {
        	$par = array('pUsuario'=>Yii::app()->user->name,
				 	     'pContrasena'=>$this->cryptPassword($pw)
			);
			
			
			$a = $this->_soap->call('CambiarContrasena',$par);
        	if($a['CambiarContrasenaResult'] == "true")
		    	return true;
			else
				return false;
			
        }
        
        public function getUserData($usuario)
        {
        	$par = array('pUsuario'=>$usuario,
        				 'pCodigoParametro'=>$this->_config['oficina']);
        	
			$a = $this->_soap->call('InformarcionUsuarioGetByUsuarioIDAndParametroID',$par);
			//$this->_userOffice = $a['InformarcionUsuarioGetByUsuarioIDAndParametroIDResult']['diffgram']['NewDataSet']['Table']['Valor'];
			$this->_userOffice = $a['InformarcionUsuarioGetByUsuarioIDAndParametroIDResult']['diffgram']['AYAInformarcionUsuarioGetByUsuarioIDAndParametroIDResult']['Usuarios']['Valor'];
			
			
        }
        	
        private function cryptPassword($pw)
		{
			return base64_encode(pack("H*",sha1($pw)));
		}  
		
		public function getPermisos(){
		  return $this->_permisos;	
		}
		
		public function getOffice(){
		  return $this->_userOffice;	
		}
        
        public function call($method,$par)
        {
        	return $this->_soap->call($method,$par);
        }
	
}
?>

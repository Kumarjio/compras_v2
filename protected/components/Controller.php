<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    protected function beforeAction($a){

        $current_a = ucfirst($this->getUniqueId()).'/'.ucfirst($this->action->id);

        $sinLogin = array(
                        "Site/Error",
                        "Site/Login",
                        "Site/Logout",
                        "Citas/documento/CargaDocumentos",
                        "Citas/documento/DeleteUpload",
                        "Citas/documento/Upload",
                        "Paciente/pacientes/CargaCiudades",
                        "Citas/cita/ActualizaEstado"
                    );

        //if($current_a == "Site/Error" or $current_a == "Site/Login" or $current_a == "Site/Logout" or $current_a == "Citas/documento/CargaDocumentos") return true; // considero que estas acciones no requieren permisos
        if(in_array($current_a, $sinLogin)) 
            return true;
        
        if (Yii::app()->user->isGuest && ($current_a != "Site/Login" || $current_a =! "Citas/documento/CargaDocumentos" || $current_a =! "Paciente/pacientes/CargaCiudades")){
            Yii::app()->user->loginRequired();
        }
        
            header("X-UA-Compatible: IE=edge,chrome=1");
            $is_dev =  isset(Yii::app()->params->development) && Yii::app()->params->development == 1;
            $is_test = isset(Yii::app()->params->test) && Yii::app()->params->test == 1;	
            $a = array();
            $current = array();
            return true;
            $a = Yii::app()->getComponent('db')->createCommand("select id_perfil from permisos inner join perfil_permiso on id= id_permiso where LOWER(accion)='".strtolower($current_a)."';")->queryAll();
            if(count($a) > 0){
                
                foreach ($a as $dt){
                    array_push($current, $dt[id_perfil]);
                }
               
                    if(Yii::app()->user->isGuest){
                        return true;
                    }else{
                        $inter=array_intersect($current,Yii::app()->user->permisos);
                        if( count($inter) > 0 ){
                            Yii::app()->user->setReturnUrl($inter[0]);
                            return true;
                        }else{
                            throw new CHttpException(403,'No tiene permisos para ejecutar la acción deseada. Por favor contactar al administrador del sitio.');
                        }
                    }

            }else{
                    throw new CHttpException(403,'La accion que intenta ejecutar no esta configurada en el sistema de seguridad. Por favor contactar al administrador del sitio.');
            }	
    }
}

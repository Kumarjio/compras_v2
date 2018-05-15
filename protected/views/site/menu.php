<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
    <?php  
   /* $usuario = Yii::app()->user->usuario;
    $modelUsuario = Usuario::model()->findByAttributes(array("usuario"=>$usuario));
    $modelRol = UsuariosRoles::model()->findByAttributes(array("id_usuario"=>$modelUsuario->id));
    $permisos = array();

    if ($modelRol){
        $modelPermisos = PermisosRoles::model()->findAllByAttributes(array("id_rol"=>$modelRol->id_rol));
        if ($modelPermisos){
            foreach ($modelPermisos as $key => $value){
                if($value->idPermiso->estado){
                    $permisos[] = $value->id_permiso;
                }
            }
            if (!empty($permisos)){*/

                $criteria = new CDbCriteria;
                $criteria->select='id_menu';
                //$criteria->addInCondition('id_permiso',$permisos);
                $criteria->group = 'id_menu';
                $criteria->order = 'id_menu ASC';
                $modelPermiso = MenuPermiso::model()->findAll($criteria);
                
                //var_dump($modelPermiso);die;
                if($modelPermiso){
                    echo '<h3>Menú</h3>';
                    echo '<ul class="nav side-menu">';
                    echo '<li> <a href="'.Yii::app()->createUrl('orden/admin') . '" class="form_control"><i class="fa fa-bank"></i> Home </a></li>';
                    $auxMenu = array();
                    foreach ($modelPermiso as $key => $value){
                        $auxMenu[] = $value->id_menu;
                    }
                    foreach ($modelPermiso as $key => $value){
                        if( empty($value->idMenu->accion_menu) && empty($value->idMenu->padre_menu) ){
                            echo '<li><a><i class="'.$value->idMenu->menu_icono.'"></i> '.$value->idMenu->nombre_menu.' <span class="fa fa-chevron-down"></span></a>';
                            echo '<ul class="nav child_menu">';
                            $criteriaMenu = new CDbCriteria;
                            $criteriaMenu->addCondition('padre_menu = '.$value->id_menu);
                            $criteriaMenu->addInCondition('id_menu', $auxMenu);
                            $modelMenu = Menu::model()->findAll($criteriaMenu);

                            if($modelMenu){
                                foreach ($modelMenu as $key => $menu){
                                    echo '<li>';
                                    echo CHtml::link($menu->nombre_menu, $this->createUrl($menu->accion_menu), array('class'=>'form_control') );
                                    echo '</li>';
                                }
                            }
                            echo '</ul>';
                            echo '</li>';
                        }elseif( empty($value->idMenu->padre_menu) ){
                            echo '<li><a href="'.Yii::app()->getHomeUrl().$value->idMenu->accion_menu.'"><i class="'.$value->idMenu->menu_icono.'"></i> '.$value->idMenu->nombre_menu.'</a></li>';
                        }
                    }
                    echo '</ul>';
                }else{
                    echo '<h3>No tiene permisos en el menú.</h3>';
                    echo '<ul class="nav side-menu">';
                    echo '<li><a href="'.Yii::app()->createAbsoluteUrl('site/logout').'"><i class="glyphicon glyphicon-off"></i> Cerrar Sesión</a></li>';
                    echo '</ul>';
                }
            /*}else{
                echo '<h3>No tiene permisos en el menú.</h3>';
                echo '<ul class="nav side-menu">';
                echo '<li><a href="'.Yii::app()->createAbsoluteUrl('site/logout').'"><i class="glyphicon glyphicon-off"></i> Cerrar Sesión</a></li>';
                echo '</ul>';
            }
        }else{
            echo '<h3>No tiene permisos en el menú.</h3>';
            echo '<ul class="nav side-menu">';
            echo '<li><a href="'.Yii::app()->createAbsoluteUrl('site/logout').'"><i class="glyphicon glyphicon-off"></i> Cerrar Sesión</a></li>';
            echo '</ul>';
        }
    }*/
    ?>
    </div>
</div>
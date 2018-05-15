<?php
    //var_dump($modelRol);
?>
<div class="menu_section">
    <h3>Menú</h3>
    <ul class="nav side-menu">
        <li><a><i class="fa fa-edit"></i> Recepción <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li>
                    <?php echo CHtml::link('Recepcionar', $this->createUrl("/recepcion/form"), array('class'=>'form_control') );?>
                </li>
                <li>
                    <?php echo CHtml::link('Masiva', $this->createUrl("/recepcion/masiva"), array('class'=>'form_control') );?>
                </li>
            </ul>
        </li>
        <li><a><i class="fa fa-cube"></i> Beneficios <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="general_elements.html">Elementos Generales</a></li>
            </ul>
        </li>
        <li><a><i class="fa fa-desktop"></i> Sim Arl <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="general_elements.html">Elementos Generales</a></li>
            </ul>
        </li>
        <li><a><i class="fa fa-table"></i> Prevención <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="tables.html">Tablas</a></li>
            </ul>
        </li>
        <li><a><i class="fa fa-bar-chart-o"></i> Instructivos <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="chartjs.html">Uso correspondencia</a></li>
            </ul>
        </li>
        <li><a><i class="fa fa-clone"></i> Imagine <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li>
                    <?php echo CHtml::link('Punteo', $this->createUrl("/cartasFisicas/admin"), array('class'=>'form_control') );?>
                </li>
                <li>
                    <?php echo CHtml::link('Bandeja Imagine', $this->createUrl("/cartasFisicas/impresion"), array('class'=>'form_control') );?>
                </li>
            </ul>
        </li>
        <li><a><i class="fa fa-bug"></i> Trabajador <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="projects.html">Proyectos</a></li>
            </ul>
        </li>
        <li><a><i class="fa fa-windows"></i> Administración <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><?php echo CHtml::link('Flujos', $this->createUrl("/flujo/create"), array('class'=>'form_control') );?></li>
                <li><?php echo CHtml::link('Actividades', $this->createUrl("/actividades/admin"), array('class'=>'form_control') );?></li>
                <li><?php echo CHtml::link('Plantillas', $this->createUrl("/plantillasCartas/admin"), array('class'=>'form_control') );?></li>
                <li><?php echo CHtml::link('Roles', $this->createUrl("/roles/admin"), array('class'=>'form_control') );?></li>
                <li><?php echo CHtml::link('Tipologías', $this->createUrl("/controlFlujo/createTipologia"), array('class'=>'form_control') );?></li>
                <li><?php echo CHtml::link('Usuarios', $this->createUrl("/usuario/admin"), array('class'=>'form_control') );?></li>
            </ul>
        </li>
    </ul>   
</div>
<div class="menu_section">
    <h3>Gestión</h3>
    <ul class="nav side-menu">                
        <li><a href="<?=Yii::app()->getHomeUrl()?>/trazabilidad/pendientes"><i class="fa fa-sitemap"></i> Bandeja de pendientes</a></li>
    </ul>
</div>

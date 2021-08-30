<?php
    
    //LLAMO AL CONTROLADOR QUE ABRE LA VENTANA DE INICIO PARA EL LOGIN
    require_once "controllers/ctr_online_calidad.php";
    require_once "controllers/ctr_login_calidad.php";
    

    $plantilla = new ControladorPlantillaCalidad();
    $plantilla -> ctrTraerPlantillaCalidad();

    //$admin= 'admin_cpi';
    //$passwd= 'admin_labcpi';
    //$token = md5($admin.'+'.$passwd);
    //echo $token;

    /*    $admin= 'lab_cpi_admin';
    $passwd= 'Lab%2021$CPI';
    $token = md5($admin.'+'.$passwd);
    echo $token;*/
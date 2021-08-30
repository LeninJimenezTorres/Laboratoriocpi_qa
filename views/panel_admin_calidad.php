<?php
require_once '../Models/modelo_formulario_admin_calidad.php';

//TOMO EL TOKEN DE LA VARIABLE GET
$dirPanelAdmin='../views/panel_admin_calidad.php';
$dirPanelAdminModuloSalir='../views/panel_admin_calidad.php?modulos=salir_adminqa';
$dirIndexOnline='../index_online_calidad.php';
$idtad=ModeloFormulariosCalidad::mdlUserDataSpecific('usuarios','id','1');
//print_r($idtad);
//echo '<br><br>';
//echo 'Token admin: '; print_r($idtad['token']);
if ($_GET['idt'] &&  $_GET['name']){
    $idt=$_GET['idt'];
    $name=$_GET['name'];
    $consultaToken=ModeloFormulariosCalidad::mdlSpecificValueQuery('usuarios','token','token',$idt);
    //echo 'Consulta : '; print_r($consultaToken);
    if ($consultaToken){
        if($consultaToken['token']!=$idt)
        {
            echo '<script>window.location ="'.$dirIndexOnline.'"</script>';
            return;
        }
        if ($idtad['token']!=$idt){
            echo '<script>window.location ="'.$dirIndexOnline.'"</script>';
            return;
        }
    }
    else{
        echo '<script>window.location ="'.$dirIndexOnline.'"</script>';
        return;
    }          
}
else{
    echo '<script>window.location ='.$dirIndexOnline.'</script>';
    return;
}      
    require_once "../controllers/ctr_formularios_calidad.php";
    require_once "../Models/modelo_formulario_admin_calidad.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../Assets/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../Assets/styles-contenido.css">
    <link rel="stylesheet" type="text/css" href="../Assets/styles_warnings.css">
    
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://kit.fontawesome.com/a1eaea322c.js" crossorigin="anonymous"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>Control Panel</title>

</head>

<body>
    <!--Logo-->
    <div class="container-fluid head2">
        <h1 class="text-center py-3 text-s">SCOL</h1>
        <p class="text-center text-s space">Sistema de Consulda Online Lux<br></p>
    </div>
    <!--NavBar-->
    <div class="container-fluid ">
        <div class="container">
            <nav class="nav justify-content-center py-1 bg-light">
                <!-- Links -->
                <ul class="nav nav-pills justify-content-center">

                    <?php if (isset($_GET["modulos"])) : ?>
                        <?php if ($_GET["modulos"] == "inicio_admin_qa") : ?>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo $dirPanelAdmin.'?modulos=inicio_admin_qa&idt='.$idt.'&name='.$name;?>">Calidad</a>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $dirPanelAdmin.'?modulos=inicio_admin_qa&idt='.$idt.'&name='.$name;?>">Calidad</a>
                            </li>
                        <?php endif ?>
                        <?php if ($_GET["modulos"] == "inventario_admin_qa") : ?>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo $dirPanelAdmin.'?modulos=inventario_admin_qa&idt='.$idt.'&name='.$name;?>">Inventario</a>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $dirPanelAdmin.'?modulos=inventario_admin_qa&idt='.$idt.'&name='.$name;?>">Inventario</a>
                            </li>
                        <?php endif ?>
                        <?php if ($_GET["modulos"] == "capacitaciones_admin_qa") : ?>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo $dirPanelAdmin.'?modulos=capacitaciones_admin_qa&idt='.$idt.'&name='.$name;?>">Capacitaciones</a>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $dirPanelAdmin.'?modulos=capacitaciones_admin_qa&idt='.$idt.'&name='.$name;?>">Capacitaciones</a>
                            </li>
                        <?php endif ?>
                        <?php if ($_GET["modulos"] == "salir_admin_qa") : ?>
                            <li class="nav-item">
                                <a class="nav-link active" href= "<?php echo $dirPanelAdmin.'?modulos=salir_admin_qa&idt='.$idt.'&name='.$name;?>">Salir</a>
                                <input type="hidden" name="idt" id="code" value="<?php echo $idt; ?>">
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $dirPanelAdmin.'?modulos=salir_admin_qa&idt='.$idt.'&name='.$name;?>">Salir</a>
                                <input type="hidden" name="idt" id="code" value="<?php echo $idt; ?>">
                            </li>
                        <?php endif ?>

                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php echo $dirPanelAdmin.'?modulos=inicio_admin_qa&idt='.$idt.'&name='.$name;?>">Calidad</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $dirPanelAdmin.'?modulos=inventario_admin_qa&idt='.$idt.'&name='.$name;?>">Inventario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $dirPanelAdmin.'?modulos=capacitaciones_admin_qa&idt='.$idt.'&name='.$name;?>">Capacitaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $dirPanelAdmin.'?modulos=salir_admin_qa&idt='.$idt.'&name='.$name;?>">Salir</a>
                        </li>
                        <input type="hidden" name="idt" id="code" value="<?php echo $idt; ?>">
                    <?php endif ?>
                </ul>
            </nav>
        </div>
    </div>
    <div class="container-fluid contenido">
        <div class="container py-5">
            <?php

            if (isset($_GET["modulos"])) {
                if (($_GET["modulos"] == "salir_admin_qa") ||
                    ($_GET["modulos"] == "capacitaciones_admin_qa") ||
                    ($_GET["modulos"] == "inventario_admin_qa") ||
                    
                    ($_GET["modulos"] == "calidad_general") ||
                    ($_GET["modulos"] == "calidad_interno") ||
                    ($_GET["modulos"] == "calidad_publico") ||
                    
                    ($_GET["modulos"] == "inicio_admin_qa")
                ) {
                    include "../views/modulos/" . $_GET["modulos"] . ".php";
                }
                else{
                    header('Location:../views/error-404.html');
                    die();
                }
            } else {
                include "../views/modulos/inicio_admin_qa.php";
            }
            ?>
        </div>
    </div>
    <footer>
        <?php 
        include "../controllers/ctr_footer.php";
        DirsFooter::dirCSSFooterPA();
        DirsFooter::dirFooterPA(); 
        DirsFooter::dirCopyRight();
        ?>
    </footer>
</body>

</html>
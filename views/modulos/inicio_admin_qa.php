<?php
$dirPanelAdminCalidad="http://localhost/cpi_login_calidad/views/panel_admin_calidad.php";
$idtad=ModeloFormulariosCalidad::mdlUserDataSpecific('usuarios','id','1');
$dirIndexOnline='../index_online_calidad.php';
if ($_GET['idt'] && $_GET['name']){
    $idt=$_GET['idt'];
    $name=$_GET['name'];
    $consultaToken=ModeloFormulariosCalidad::mdlSpecificValueQuery('usuarios','token','token',$idt);
    //echo 'Consulta : '; print_r($consultaToken);
    //echo 'Variable idt: '.$_GET['idt'];
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
    include 'bootstrap.php';
?>

<form method="POST">
    <nav class="nav justify-content-center py-2 d-flex flex-column">
        <ul class="nav nav-pills justify-content-center nav-fill">
            <?php if (isset($_GET["modulos"])) : ?>
                <?php if ($_GET["modulos"] == "calidad_general") : ?>
                    <li class="nav-item">
                        <a class="nav-link text-center justify-center form-control-lg active" href="<?php echo $dirPanelAdminCalidad.'?modulos=calidad_general&name='.$name.'&idt='.$idt;?>"><i class="fas fa-users"></i><br>General</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link text-center justify-center form-control-lg" href="<?php echo $dirPanelAdminCalidad.'?modulos=calidad_general&name='.$name.'&idt='.$idt;?>"><i class="fas fa-users"></i><br>General</a>
                    </li>
                <?php endif ?>
                <?php if ($_GET["modulos"] == "calidad_interno") : ?>
                    <li class="nav-item">
                        <a class="nav-link text-center justify-center form-control-lg active" href="<?php echo $dirPanelAdminCalidad.'?modulos=calidad_interno&name='.$name.'&idt='.$idt;?>"><i class="fas fa-user-shield"></i><br>Interno</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link text-center justify-center form-control-lg" href="<?php echo $dirPanelAdminCalidad.'?modulos=calidad_interno&name='.$name.'&idt='.$idt;?>"><i class="fas fa-user-shield"></i><br>Interno</a>
                    </li>
                <?php endif ?>

            <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link text-center justify-center form-control-lg" href="<?php echo $dirPanelAdminCalidad.'?modulos=calidad_general&name='.$name.'&idt='.$idt;?>"><i class="fas fa-users"></i><br>General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center justify-center form-control-lg" href="<?php echo $dirPanelAdminCalidad.'?modulos=calidad_interno&name='.$name.'&idt='.$idt;?>"><i class="fas fa-user-shield"></i><br>Interno</a>
                </li>
            <?php endif ?>
        </ul>
    </nav>

</form>
<?php
    echo '<script>if(window.history.replaceState){window.history.replaceState( null, null, window.location.href);}</script>';
                    
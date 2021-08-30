<?php
if ($_GET['idt'] && $_GET['name']) {
    //$existe = ControladorFormulario::ctrDatoExistente('usuarios','idt',$idt);//me devuelve el id
    $dirIndexOnline = '../index_online.php';
    $dirPanelUser = '../views/panel_usuario.php';
    $dirPanelUserModuloSalir = '../views/panel_usuario.php?modulos=salir_admin';
    $idtad = ModeloFormulariosCalidad::mdlUserDataSpecific('usuarios', 'name', $_GET['name']);

    $idt = $_GET['idt'];
    $name = $_GET['name'];
    $consultaToken = ModeloFormulariosCalidad::mdlSpecificValueQuery('usuarios', 'token', 'token', $idt);
    //echo 'Consulta : '; print_r($consultaToken);
    if ($consultaToken) {
        if ($consultaToken['token'] != $idt) {
            //$validacion = 'WRONG';
            echo '<script>window.location ="' . $dirIndexOnline . '"</script>';
            return;
        }
        if ($idtad['token'] != $idt) {
            //$validacion = 'WRONG';
            echo '<script>window.location ="' . $dirIndexOnline . '"</script>';
            return;
        } else {
            $doc_generales = ControladorFormularioCalidad::ctrSeleccionarRegistros('capacitaciones');
        }
    } else {
        echo '<script>window.location ="' . $dirIndexOnline . '"</script>';
        return;
    }
} else {
    echo '<script>window.location =' . $dirIndexOnline . '</script>';
    return;
}

?>
<form action="#" class="bg-light" method="post" enctype="multipart/form-data">
    <div class="container-fluid justify-content-center align-items-center d-flex flex-column py-4">
        <div class="container-fluid container-lg justify-content-center align-items-center form-group form-control-lg d-flex flex-fill">
            <div class="form-group d-flex flex-fill mr-sm-2 d-fluid w-50">
                <div class="input-group-prepend  mr-sm-5 w-100">
                    <span class="input-group-text"><i class="fas fa-file"></i></span>
                    <input type="text" class="form-control" id="doc_name" name="doc_name" placeholder="Ingrese el nombre del documento">
                </div>
            </div>
            <div class="form-group d-flex flex-fill mr-sm-4 w-25">
                <input type="file" class="form-control-file border" name="file" id="file">
            </div>
            <div class="row justify-content-center align-items-center form-group d-flex flex-fill p-0">
                <button type="submit" class="btn btn-primary" name="upload" id="upload" value="upload">Agregar</button>
            </div>
        </div>
        <div class="container-fluid container-lg justify-content-center align-items-center form-group form-control-lg d-flex flex-column w-100">
            <input type="text" class="form-control" id="description" name="description" placeholder="Descripción">
        </div>
        <?php ControladorFormularioCalidad::ctrIngresoDocumentosGeneral($idt, $name, 'capacitaciones','../views/capacitaciones/','capacitaciones_admin_qa') ?>
    </div>
    <div class="container-fluid p-2 lola bg-light">
        <!--bg-light-->
        <h4 class="h3-title text-center"><br><br>Documentos de inventario</h4>
        <table class="table table-dark table-hover text-center">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Documentación</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($doc_generales as $key => $value) : ?>
                    <tr>
                        <td><?php echo $value["name"] ?> </td>
                        <td><?php echo $value["description"] ?> </td>
                        <td>
                            <div class="row justify-content-center align-items-center form-group">
                                <button type="submit" class="btn btn-primary" name="download" value="<?php echo $value["name"] ?>"><i class="fas fa-eye"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</form>
<?php ControladorFormularioCalidad::ctrDownloadDocs('capacitaciones','http://localhost/cpi_login_calidad/views/capacitaciones/');

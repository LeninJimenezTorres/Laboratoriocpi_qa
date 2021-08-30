<?php require_once 'Models/modelo_formulario_admin_calidad.php'; ?>
<script>
    function contacte(){
        alert("Contacte al administrador");
    }
</script>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Assets/styles.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet"> 
    <title>Consulta Resultados</title>
    <!-- <script type="text/javascript" src="http://localhost/cpi_login/Assets/script.js"></script> -->
</head>

<body>
    <div class="big-container">
        <div class="container-body">
            <div class="body-left">
                <header class="encabezado">
                    <div class="container-header-2">
                        <h1>SCOL</h1>
                    </div>
                    <div class="container-header-1">
                        <p>Sistema de Consulda Online Lux</p>
                    </div>
                </header>
                <div class="detalles-sistema">
                    <ul id="lista-servicios">
                        <li>Documentación de procesos</li>
                        <li>Manuales e instructivos</li>
                        <li>Normas de calidad</li>
                    </ul>
                </div>
                <video id="videoBGS" poster="./Galeria/woman.png" autoplay muted loop>
                    <source src="./Galeria/woman.mp4" type="video/mp4">
                </video>
            </div>
            <div class="body-right">
                <div class="sub-right">
                    <div class="container-header-3">
                        <p>BIENVENIDO A SCOL</p>
                    </div>
                    <div class="formulario-macro">
                        <form class="formulario-micro"  method="post"> 
                            <!-- action="./Controllers/validar.php" -->
                            <div class="usuario-out input-group-prepend">
                                <p>Usuario</p>
                                <label for="usuario">
                                    <input id="usuario" class="usuario form-control" type="text" name="nombre">
                                </label>
                            </div>
                            <div class="contraseña-out input-group-prepend">
                                <p>Contraseña</p>
                                <label for="contraseña">
                                    <input id="contraseña" class="contraseña form-control" type="password" name="passwd">
                                </label>
                            </div>
                            <div class="enviar input-group-prepend">
                                <button type="submit" id="boton-enviar" class="form-control" name="ingreso">Ingresar</button>
                            </div>
                            <div class="olvido">
                                <a href="#" onclick="contacte()">¿Olvidó su contraseña?</a>
                            </div>
                            <div class="registrarse">
                                <a href="#" onclick="contacte()">Registrarse</a>
                            </div>   
                            <?php
                                $ingreso =  new ControladorLoginCalidad();
                                $ingreso -> ctrLoginCalidad();
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
        <footer>
            <?php 
                require_once "controllers/ctr_footer.php";
                DirsFooter::dirCSSFooterPL();
                DirsFooter::dirFooterPL(); 
                DirsFooter::dirCopyRightL();
            ?>
        </footer>
    </div>
</body>

</html>
<?php

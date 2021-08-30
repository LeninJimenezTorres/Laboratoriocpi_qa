<?php

class ControladorFormularioCalidad
{
    //CONSULTO SI EXISTE UN DATO 
    static public function ctrDatoExistente($tabla, $column, $valor)
    {
        //echo '<br>Ingreso al controlador  la variable: '.$valor.'<br>';
        $respuesta = ModeloFormulariosCalidad::mdlUserDataSpecific($tabla, $column, $valor);
        //echo 'El resultado del modelo es: ';
        //print_r($respuesta);
        //echo '<br><br>';
        return $respuesta;
    }

    //ESTE CTRL REGISTRA USUARIOS VALIDANDO LOS FORMULARIOS
    static public function ctrRegistroUsuarioValidado($idt)
    {
        if (isset($_POST["submit"])) {
            if (
                preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["nombre"])
                && preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["especialidad"])
                && preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["casa"])
                && preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9]+$/', $_POST["pass"])
            ) {
                $tabla = "usuarios"; //el mismo nombre que la tabla en MyphpAdmin
                $datos = array(
                    "name" => $_POST["nombre"],
                    "specialty" => $_POST["especialidad"],
                    "home" => $_POST["casa"],
                    "password" => $_POST["pass"],
                    "email" => $_POST["email"],
                    "phone" => $_POST["telf"]
                );

                array_push($datos, $datos["token"] = (md5($_POST['nombre'] . '+' . $_POST['pass'])));
                if (
                    strlen($datos['name']) < 7 || strlen($datos['specialty']) < 4 ||
                    strlen($datos["home"]) < 7 || strlen($datos["password"]) < 7
                ) {
                    $errorDatos = array('name', 'specialty', 'home', 'password');
                    if (strlen($datos['name']) < 7) {
                        $errorDatos['name'] = 'Ingrese el nombre y apellido';
                    }
                    if (strlen($datos['specialty']) < 4) {
                        $errorDatos['specialty'] = 'Ingrese la especialidad';
                    }
                    if (strlen($datos['home']) < 7) {
                        $errorDatos['home'] = 'Ingrese la casa de salud a la que pertenece';
                    }
                    if (strlen($datos['password']) < 7) {
                        $errorDatos['password'] = 'Ingrese una contraseña con mas de 7 caracteres';
                    }
                    $cadenaError = "";
                    foreach ($errorDatos as $err) {
                        if (!empty($errorDatos[$err])) {
                            $cadenaError = $cadenaError . $errorDatos[$err] . "<br>";
                        }
                    }
                    if (!empty($cadenaError)) {
                        echo '<p class="alert-warning text-center">' . $cadenaError . '</p>';
                    }

                    //return $errorDatos;            
                    //print_r($errorDatos);
                }
                if (
                    strlen($datos['name']) >= 7 && strlen($datos['specialty']) >= 4 &&
                    strlen($datos["home"]) >= 7 && strlen($datos["password"]) >= 7
                ) {
                    $respuesta = ModeloFormulariosCalidad::mdlUserQueryExistent(
                        $tabla,
                        $datos,
                        $column = 'name',
                        $valor = $_POST['nombre']
                    );
                    if (empty($respuesta['name'])) {
                        include '../views/modulos/bootstrap.php';
                        ModeloFormulariosCalidad::mdlSignUpUser($tabla, $datos);
                        echo '<script>if(window.history.replaceState){
                                window.history.replaceState( null, null, window.location.href);
                            }</script>';
                        echo '<div class="alert-success text-center">Registro exitoso</div>';
                        echo '<script> setTimeout(function(){window.location = "../views/panel_admin.php?modulos=inicio_admin&idt=' . $idt . '";},3000)</script>';
                    }
                    if (!empty($respuesta['name'])) {
                        echo '<div class="alert-danger text-center">El usuario si existe, ingrese otro nombre diferente a: <br></div>';
                        echo '<div class="alert-danger text-center">' . $respuesta['name'] . '</div>';
                        echo '<script>if(window.history.replaceState){window.history.replaceState( null, null, window.location.href);}</script>';
                    }
                }
            } else {
                echo '<div class="alert-danger text-center">Error de ingreso, se ha detectado caracteres no permitidos <br></div>';
            }
        }
    }

    static public function ctrIngresoDocumentosGeneral($idt, $name, $tabla, $dirStorage, $moduloReabrir)
    {
        if (isset($_POST["upload"])) {
            include '../views/modulos/bootstrap.php';
            $datos = array(
                "name" => $_POST["doc_name"],
                "description" => $_POST["description"]);

            $file_tmp = $_FILES["file"]["tmp_name"];
            $filename = $_FILES["file"]["name"];
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            //echo 'File name = '.$filename.'<br>';
            //echo 'File temp = '.$file_tmp.'<br>';


            if (strlen($datos['name']) < 4 || empty($filename)
                || empty($datos['description']) || empty($file_tmp)) {
                $errorDatos = array('name', 'file', 'description');
                if (strlen($datos['name']) < 4) {
                    $errorDatos['name'] = 'Ingrese el nombre del documento';
                }
                if (empty($file_tmp) || empty($filename)){
                    $errorDatos['file'] = 'Ingrese el documento';
                }
                if (empty($datos['description'])) {
                    $errorDatos['file'] = 'Ingrese una breve descripción del documento documento';
                }
                $cadenaError = "";
                foreach ($errorDatos as $err) {
                    if (!empty($errorDatos[$err])) {
                        $cadenaError = $cadenaError . $errorDatos[$err] . "<br>";
                    }
                }
                if (!empty($cadenaError)) {
                    echo '<p class="alert-warning text-center">' . $cadenaError . '</p>';
                    echo '<script>if(window.history.replaceState){
                        window.history.replaceState( null, null, window.location.href);
                        setTimeout(function(){location.reload()},4000);}</script>';
                    return;
                }
                echo '<script>if(window.history.replaceState){
                    window.history.replaceState( null, null, window.location.href);
                    setTimeout(function(){location.reload()},4000);}</script>';
            
            }
            if ( strlen($datos['name']) >= 4 && isset($filename) && isset($file_tmp)
                && isset($datos['description']) && !empty($filename) && !empty($file_tmp)) {
                //echo 'Se acepta la informacion<br>';
                //VERIFICACION DE CARACTERES PERMITIDOS
                if (
                    preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\-\(\)\/\_ ]+$/', $_POST["doc_name"]) &&
                    preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\-\(\)\/\_ ]+$/', $_POST["description"])
                ) {
                    //VERIFICANDO SI EXISTEN EL DOCUMENTO EN LA BASE DE DATOS
                    $verificacionDocumentoExistente = ModeloFormulariosCalidad::mdlUserQueryExistent(
                        $tabla,
                        'name',
                        $_POST['doc_name']
                    );
                    if (empty($verificacionDocumentoExistente['name'])) {
                        //VERIFICO EL DIRECTORIO
                        $dirConsulta = glob($dirStorage);
                        $newDir = $dirStorage;

                        //CREACION DE DIRECTORIO
                        if (empty($dirConsulta[0])) {
                            echo '<div class="alert-success text-center">Creando directorio para la documentación de Inventarios</div>';
                            mkdir($newDir, 0777, true);
                        } else {
                            echo '<div class="alert-success text-center">Directorio existente</div>';
                        }

                        //REGISTRO EL DOCUMENTO EN LA TABLA
                        ModeloFormulariosCalidad::mdlRegistroDatosDocumentos($tabla, $datos);

                        //GUARDO EL DOCUMENTO EN LA BASE DE DATOS
                        move_uploaded_file($file_tmp, $newDir . '/' . $datos['name'] . '.' . $extension);

                        //POST ENTREGA
                        echo '<script>if(window.history.replaceState){
                                    window.history.replaceState( null, null, window.location.href);
                                }</script>';
                        echo '<div class="alert-success text-center">Registro exitoso</div>';
                        echo '<script> setTimeout(function(){window.location = "../views/panel_admin_calidad.php?modulos='.$moduloReabrir.'&idt=' . $idt . '&name=' . $name . '";},2000)</script>';
                    } else {
                        echo '<div class="alert-danger text-center">El nombre del documento ya existe, ingrese otro diferente a: <br></div>';
                        echo '<div class="alert-danger text-center">' . $_POST['doc_name'] . '</div>';
                        echo '<script>if(window.history.replaceState){
                            window.history.replaceState( null, null, window.location.href);
                            setTimeout(function(){location.reload()},3000);}</script>';
                    }
                } else {
                    echo '<script>if(window.history.replaceState){
                        window.history.replaceState( null, null, window.location.href);
                    }</script>';
                    echo '<div class="alert-danger text-center">Error de ingreso, se ha detectado caracteres no permitidos <br></div>';
                }
            }
            echo '<script>if(window.history.replaceState){window.history.replaceState( null, null, window.location.href);}</script>';
        }
    }

    

    //ESTA INGRESA LOS DATOS DE LOS RESULTADOS EN LA DB
    static public function ctrIngresoDocumentosCalidad($idt, $name, $tabla, $type)
    {
        if (isset($_POST["upload"])) {
            include '../views/modulos/bootstrap.php';
            $datos = array(
                "name" => $_POST["doc_name"],
                "description" => $_POST["description"]);

            $file_tmp = $_FILES["file"]["tmp_name"];
            $filename = $_FILES["file"]["name"];
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            //echo 'File name = '.$filename.'<br>';
            //echo 'File temp = '.$file_tmp.'<br>';


            if (strlen($datos['name']) < 4 || empty($filename)
                || empty($datos['description']) || empty($file_tmp)) {
                $errorDatos = array('name', 'file', 'description');
                if (strlen($datos['name']) < 4) {
                    $errorDatos['name'] = 'Ingrese el nombre del documento';
                }
                if (empty($file_tmp) || empty($filename)){
                    $errorDatos['file'] = 'Ingrese el documento';
                }
                if (empty($datos['description'])) {
                    $errorDatos['file'] = 'Ingrese una breve descripción del documento documento';
                }
                $cadenaError = "";
                foreach ($errorDatos as $err) {
                    if (!empty($errorDatos[$err])) {
                        $cadenaError = $cadenaError . $errorDatos[$err] . "<br>";
                    }
                }
                if (!empty($cadenaError)) {
                    echo '<p class="alert-warning text-center">' . $cadenaError . '</p>';
                    echo '<script>if(window.history.replaceState){
                        window.history.replaceState( null, null, window.location.href);
                        setTimeout(function(){location.reload()},4000);}</script>';
                    return;
                }
                echo '<script>if(window.history.replaceState){
                    window.history.replaceState( null, null, window.location.href);
                    setTimeout(function(){location.reload()},4000);}</script>';
            
            }
            if ( strlen($datos['name']) >= 4 && isset($filename) && isset($file_tmp)
                && isset($datos['description']) && !empty($filename) && !empty($file_tmp)) {
                //echo 'Se acepta la informacion<br>';
                //VERIFICACION DE CARACTERES PERMITIDOS
                if (
                    preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\-\(\)\/\_ ]+$/', $_POST["doc_name"]) &&
                    preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\-\(\)\/\_ ]+$/', $_POST["description"])
                ) {
                    //VERIFICANDO SI EXISTEN EL DOCUMENTO EN LA BASE DE DATOS
                    $verificacionDocumentoExistente = ModeloFormulariosCalidad::mdlUserQueryExistent(
                        $tabla,
                        'name',
                        $_POST['doc_name']
                    );
                    if (empty($verificacionDocumentoExistente['name'])) {
                        //VERIFICO EL DIRECTORIO
                        $dirConsulta = glob('../views/calidad/' . $type);
                        $newDir = '../views/calidad/' . $type;

                        //CREACION DE DIRECTORIO
                        if (empty($dirConsulta[0])) {
                            echo '<div class="alert-success text-center">Creando directorio para la documentación ' . $type . '</div>';
                            mkdir($newDir, 0777, true);
                        } else {
                            echo '<div class="alert-success text-center">Directorio existente</div>';
                        }

                        //REGISTRO EL DOCUMENTO EN LA TABLA
                        ModeloFormulariosCalidad::mdlRegistroDatosDocumentos($tabla, $datos);

                        //GUARDO EL DOCUMENTO EN LA BASE DE DATOS
                        move_uploaded_file($file_tmp, $newDir . '/' . $datos['name'] . '.' . $extension);

                        //POST ENTREGA
                        echo '<script>if(window.history.replaceState){
                                    window.history.replaceState( null, null, window.location.href);
                                }</script>';
                        echo '<div class="alert-success text-center">Registro exitoso</div>';
                        echo '<script> setTimeout(function(){window.location = "../views/panel_admin_calidad.php?modulos=calidad_' . $type . '&idt=' . $idt . '&name=' . $name . '";},2000)</script>';
                    } else {
                        echo '<div class="alert-danger text-center">El nombre del documento ya existe, ingrese otro diferente a: <br></div>';
                        echo '<div class="alert-danger text-center">' . $_POST['doc_name'] . '</div>';
                        echo '<script>if(window.history.replaceState){
                            window.history.replaceState( null, null, window.location.href);
                            setTimeout(function(){location.reload()},3000);}</script>';
                    }
                } else {
                    echo '<script>if(window.history.replaceState){
                        window.history.replaceState( null, null, window.location.href);
                    }</script>';
                    echo '<div class="alert-danger text-center">Error de ingreso, se ha detectado caracteres no permitidos <br></div>';
                }
            }
            echo '<script>if(window.history.replaceState){window.history.replaceState( null, null, window.location.href);}</script>';
        }
    }

    //ESTE CTRL PERMITE LA DESCARGA DEL DOCUMENTO
    static public function ctrDownloadCalidad($type)
    {
        if (isset($_POST["download"])) {
            $doc_name = ModeloFormulariosCalidad::mdlSpecificValueQuery('calidad_' . $type, 'name', 'name', $_POST['download']);
            //print_r($user['dr']); echo '<br><br>';
            $location = 'http://localhost/cpi_login_calidad/views/calidad/' . $type . '/';
            $dir = $location . $doc_name["name"] . '.pdf';
            //echo '<br><br>'.$dir;
            //fopen($dir, 'r');
            echo '<script> window.open("' . $dir . '", "Diseño Web") </script>';
        } else {
            return null;
        }
    }

    static public function ctrDownloadDocs($tabla,$dir)
    {
        if (isset($_POST["download"])) {
            $doc_name = ModeloFormulariosCalidad::mdlSpecificValueQuery($tabla, 'name', 'name', $_POST['download']);
            //print_r($user['dr']); echo '<br><br>';
            $location = $dir;
            $dir = $location . $doc_name["name"] . '.pdf';
            //echo '<br><br>'.$dir;
            //fopen($dir, 'r');
            echo '<script> window.open("' . $dir . '", "Diseño Web") </script>';
        } else {
            return null;
        }
    }


    static public function ctrSeleccionarRegistros($tabla)
    {
        $respuesta = ModeloFormulariosCalidad::mdlSeleccionarRegistros($tabla); //ENVIO EL NOMBRE OCULTO DE LA DB, AL MODELO QUE REALIZA LA CONSULTA
        return $respuesta;
    }

    //LOS DATOS DE LA DB, Y ALMACENA LOS RESULTADOS SIN QUE EL MODELO QUE CONSULTA DIRECTAMENTE LOS DATOS SE EXPONGA DE NINGUNA MANERA.
    static public function ctrConsultaDatosEspecificosUser($tabla, $column, $value)
    {
        $respuesta = ModeloFormulariosCalidad::mdlResultQuery($tabla, $column, $value);
        return $respuesta;
    }

    //ESTE CTRL CONSULTA CUALQUIER DATO POR MEDIO DEL MDL ModeloFormularioMain
    static public function ctrConsultaDatos($tabla, $column, $valor)
    {
        require_once '../Models/modelo_formulario.php';
        $respuesta = ModeloFormularioMain::mdlConsultaEspecfDB($tabla, $column, $valor);
        return $respuesta;
    }

    //ESTA CLASE CTRL LLAMA AL MODELO PARA ELIMINAR UN USUARIO
    static public function ctrEliminarDocumentoCalidad($type)
    {
        if (isset($_POST["eliminar"])) {
            $filename = ModeloFormulariosCalidad::mdlSpecificValueQuery('calidad_' . $type, 'name', 'name', $_POST['eliminar']);

            if (isset($filename)) {
                $location = '../views/calidad/' . $type . '/';
                $dir = $location . $filename['name'] . '.pdf';
                
                $eliminar = ModeloFormulariosCalidad::mdlEliminarRegistro('calidad_' . $type, 'name', $_POST["eliminar"]);

                if (!empty($dir)) {
                    if (unlink($dir)) {
                        error_reporting(0);
                        echo '<script>alert("Documento eliminado")</script>';
                        echo '<script> setTimeout(function(){location.reload();},1000)</script>';
                        //echo '<script>if(window.history.replaceState){window.history.replaceState( null, null, window.location.href);}</script>';
                    } else {
                        echo '<div class="alert-danger text-center">No se ha encontrado el documento en la base de datos <br></div>';
                        echo '<script> setTimeout(function(){location.reload();},1000)</script>';
                    }
                }
                else {
                    echo '<div class="alert-danger text-center">No se ha encontrado el documento en la base de datos <br></div>';
                    echo '<script> setTimeout(function(){location.reload();},1000)</script>';
                }
            } else {
                echo '<div class="alert-danger text-center">No se ha encontrado el documento  registrado en la base de datos <br></div>';
            }
        }
        echo '<script>if(window.history.replaceState){window.history.replaceState( null, null, window.location.href);}</script>';
    }

    //ESTA CLASE CTRL LLAMA AL MODELO PARA ELIMINAR UN USUARIO
    static public function ctrEliminarDocumentoGeneral($tabla,$dir)
    {
        if (isset($_POST["eliminar"])) {
            $filename = ModeloFormulariosCalidad::mdlSpecificValueQuery($tabla, 'name', 'name', $_POST['eliminar']);

            if (isset($filename)) {
                $location = $dir;
                $dir = $location . $filename['name'] . '.pdf';
                
                $eliminar = ModeloFormulariosCalidad::mdlEliminarRegistro($tabla, 'name', $_POST["eliminar"]);

                if (!empty($dir)) {
                    if (unlink($dir)) {
                        error_reporting(0);
                        echo '<script>alert("Documento eliminado")</script>';
                        echo '<script> setTimeout(function(){location.reload();},1000)</script>';
                        //echo '<script>if(window.history.replaceState){window.history.replaceState( null, null, window.location.href);}</script>';
                    } else {
                        echo '<div class="alert-danger text-center">No se ha encontrado el documento en la base de datos <br></div>';
                        echo '<script> setTimeout(function(){location.reload();},1000)</script>';
                    }
                }
                else {
                    echo '<div class="alert-danger text-center">No se ha encontrado el documento en la base de datos <br></div>';
                    echo '<script> setTimeout(function(){location.reload();},1000)</script>';
                }
            } else {
                echo '<div class="alert-danger text-center">No se ha encontrado el documento  registrado en la base de datos <br></div>';
            }
        }
        echo '<script>if(window.history.replaceState){window.history.replaceState( null, null, window.location.href);}</script>';
    }

}

<?php
class ModelUserTypesCalidad{
    static public function mdlAdmCallCalidad($token,$name){
        $dirMainQA ='http://localhost/cpi_login_calidad';
        echo '
            <script>
                if(window.history.replaceState)
                {
                    window.history.replaceState( null, null, window.location.href);
                }
                window.location = "'.$dirMainQA.'/views/panel_admin_calidad.php?modulos=inicio_admin_qa&idt='.$token.'&name='.$name.'"
            </script>
            ';
    }
    static public function mdlUserCallCalidad($token,$name){
        $dirMainQA ='http://localhost/cpi_login_calidad';
        echo '
            <script>
                if(window.history.replaceState)
                {
                    window.history.replaceState( null, null, window.location.href);
                }
                window.location = "'.$dirMainQA.'/views/panel_usuario_calidad.php?modulos=inicio_usuario_qa&name='.$name.'&idt='.$token.'"
            </script>
            ';
    }
}
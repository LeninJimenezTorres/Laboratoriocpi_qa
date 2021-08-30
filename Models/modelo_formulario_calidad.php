<?php

require_once "conexion_registros.php";

class ModeloFormularioMain{

    static public function mdlConsultaEspecfDB($tabla, $column, $valor)
    {
        $stmt = ConexionRegistrosDB::conectar()->prepare("SELECT * FROM $tabla WHERE $column = :$column");
        $stmt->bindParam(":".$column,$valor, PDO::PARAM_STR);
        $stmt->execute();
        if (!empty($stmt))
        {
            return $stmt-> fetch();   
            $stmt -> die;
            $stmt = null;    
        }

    }
}

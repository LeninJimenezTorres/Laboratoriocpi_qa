<?php

require_once "conexion_registros.php";

class ModeloFormulariosCalidad{
       
    //MODELO AGREGAR VALOR A DB SESION
    static public function mdlAddSession($tabla, $value)
    {
        $stmt = ConexionRegistrosDB::conectar() -> prepare("INSERT INTO $tabla(sesion) VALUES (:sesion)");
        $stmt->bindParam(":sesion", $value, PDO::PARAM_STR); 
        if($stmt->execute()){
            return "ok";
        }
        else{
            print_r(ConexionRegistrosDB::conectar()->errorInfo());
        }
        $stmt -> die;
        $stmt = null;
    }

    //ESTE MODELO TRAE UN VALOR EN ESPECIFICO DE UNA COLUMNA EN ESPECIFICO
    static public function mdlSpecificValueQuery($tabla, $columnQuery, $columnValue ,$value){
        $stmt = ConexionRegistrosDB::conectar() -> prepare("SELECT $columnQuery FROM $tabla WHERE $columnValue =:$columnValue");
        $stmt->bindParam(":".$columnValue,$value, PDO::PARAM_STR);
        if($stmt->execute()){
            return $stmt->fetch(); 
            $stmt -> die;
            $stmt = null;    
        }
        else{
            return 'error';
        }
        
    }

    static public function mdlUserQueryExistent($tabla, $column, $valor){
        //echo $valor;
        //echo '<pre>'; print_r($datos); echo '</pre>';   
        if (strlen($valor)>0){

            $stmt = ConexionRegistrosDB::conectar() -> prepare("SELECT $column FROM $tabla WHERE $column =:$column");
            $stmt->bindParam(":".$column,$valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(); 
            $stmt -> die;
            $stmt = null; 
            //echo '<script>if(window.history.replaceState){window.history.replaceState( null, null, window.location.href);}</script>'; 
        }
        
    }

    //ESTE MDL REGISTRA LOS DATOS DE LOS DOCUMENTOS 
    static public function mdlRegistroDatosDocumentos($tabla, $datos){
        $stmt = ConexionRegistrosDB::conectar() -> prepare("INSERT INTO $tabla(name, description) VALUES (:name, :description)");
        $stmt->bindParam(":name", $datos["name"], PDO::PARAM_STR);
        $stmt->bindParam(":description", $datos["description"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }
        else{
            print_r(ConexionRegistrosDB::conectar()->errorInfo());
        }
        $stmt -> die;
        $stmt = null;
    }

    static public function mdlSignUpUser($tabla, $datos){
        $stmt = ConexionRegistrosDB::conectar() -> prepare("INSERT INTO $tabla(name, specialty, home, password, email, phone, token) VALUES (:name,  :specialty, :home, :password, :email, :phone, :token)");
        $stmt->bindParam(":name", $datos["name"], PDO::PARAM_STR);
        $stmt->bindParam(":specialty", $datos["specialty"], PDO::PARAM_STR);
        $stmt->bindParam(":home", $datos["home"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
        $stmt->bindParam(":phone", $datos["phone"], PDO::PARAM_STR);
        $stmt->bindParam(":token", $datos["token"], PDO::PARAM_STR);
        
        if($stmt->execute()){
            return "ok";
        }
        else{
            print_r(ConexionRegistrosDB::conectar()->errorInfo());
        }
        $stmt -> die;
        $stmt = null;
    }

    //ESTA CLASE DEVUELVE TODOS LOS VALORES DE UNA COLUMNA
    static public function mdlColumnReturn($tabla, $column)
    {
        $stmt = ConexionRegistrosDB::conectar()->prepare("SELECT $column FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt -> die;
        $stmt = null;
    }
    
    //ESTA CLASE MODELO DEVUELVE DE TODOS LOS DATOS DEL USUARIO EN ESPECIFICO 
    static public function mdlUserDataSpecific($tabla, $column, $value){
        $stmt = ConexionRegistrosDB::conectar()->prepare("SELECT * FROM $tabla WHERE $column=:$column");
        $stmt->bindParam(":".$column,$value, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(); 
        $stmt -> die;
        $stmt = null; 
    }

    //ESTA CLASE MODELO DEVUELVE DE TODOS LOS RESULTADOS/INFORMES DEL USUARIO EN ESPECIFICO 
    static public function mdlResultQuery($tabla, $column ,$value){
        $stmt = ConexionRegistrosDB::conectar()->prepare("SELECT * FROM $tabla WHERE $column=:$column");
        $stmt->bindParam(":".$column,$value, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchall(); 
        $stmt -> die;
        $stmt = null; 
    }

        //ESTA CLASE MODELO DEVUELVE DE TODOS LOS RESULTADOS/INFORMES DEL USUARIO EN ESPECIFICO 
        static public function mdlResultQueryDouble($tabla, $column1 ,$value1, $column2, $value2){
            $stmt = ConexionRegistrosDB::conectar()->prepare("SELECT * FROM $tabla WHERE $column1=:$column1 AND $column2=:$column2");
            $stmt->bindParam(":".$column1,$value1, PDO::PARAM_STR);
            $stmt->bindParam(":".$column2,$value2, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchall(); 
            $stmt -> die;
            $stmt = null; 
        }
    
    //ESTA CLASE MODELO INVOCA AL MODELO DE CONEXION DE DB Y REALIZA UNA CONSULTA DE TODOS LOS DATOS
    static public function mdlSeleccionarRegistros($tabla){
        $stmt = ConexionRegistrosDB::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt -> die;
        $stmt = null;
    }

    //ESTE MODELO MODIFICA-ACTUALIZA LOS REGISTROS DE LOS RESULTADOS
    static public function mdlEditarResultado($tabla, $datos, $columnRef, $value){
        $stmt = ConexionRegistrosDB::conectar() -> prepare("UPDATE $tabla SET patient=:patient, reception=:reception, deliver=:deliver, result=:result WHERE $columnRef=:$columnRef");
        $stmt->bindParam(":patient", $datos["patient"], PDO::PARAM_STR);
        $stmt->bindParam(":reception", $datos["reception"], PDO::PARAM_STR);
        $stmt->bindParam(":deliver", $datos["deliver"], PDO::PARAM_STR);
        $stmt->bindParam(":result", $datos["result"], PDO::PARAM_STR);
        $stmt->bindParam(":".$columnRef, $value, PDO::PARAM_STR);
        
        if($stmt->execute()){
            return "ok";
        }
        else{
            return 'BADDDDD';
        }
        $stmt -> die;
        $stmt = null;
    }

    //ESTE MODELO MODIFICA-ACTUALIZA LOS REGISTROS DEL USUARIO
    static public function mdlEditar($tabla, $datos){
        $stmt = ConexionRegistrosDB::conectar() -> prepare("UPDATE $tabla SET name=:name, specialty=:specialty, home=:home, password=:password, email=:email, phone=:phone WHERE id=:id");
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt->bindParam(":name", $datos["name"], PDO::PARAM_STR);
        $stmt->bindParam(":specialty", $datos["specialty"], PDO::PARAM_STR);
        $stmt->bindParam(":home", $datos["home"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
        $stmt->bindParam(":phone", $datos["phone"], PDO::PARAM_STR);
        
        if($stmt->execute()){
            return "ok";
        }
        else{
            print_r(ConexionRegistrosDB::conectar()->errorInfo());
        }
        $stmt -> die;
        $stmt = null;
    }

    //ESTA CLASE ELIMINA CUALQUIER REGISTRO
    static public function mdlEliminarRegistro($tabla, $columnRef ,$valor){
        $stmt = ConexionRegistrosDB::conectar() -> prepare("DELETE FROM $tabla WHERE $columnRef=:$columnRef");
        $stmt->bindParam(":".$columnRef, $valor, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->fetch();
        //echo '<br><br>Modelo OK: '.$valor; 
        //echo '<br><br>RESULTADO CONSULTA: '; print_r($stmt->fetch());
        return "ok";
        //$stmt -> die;
        //$stmt = null;
    }
}
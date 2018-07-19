<?php

require_once "conexion.php";

class IngresoModels{
    public function ingresoModel($datosModel, $tabla){
        $stmt = Conexion::conectar()->prepare("SELECT usuario, password, intentos FROM $tabla WHERE usuario = :usuario");

        $stmt -> bindParam(":usuario", $datosModel["usuario"], PDO::PARAM_STR);

        $stmt -> execute();

        return $stmt -> fetch();//como es uno solo solo llamo a fetch, si fueran varios mando a fetchAll

        $stmt -> close();
    }

    public function intentosModel($datosModel, $tabla){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET intentos = :intentos WHERE usuario = :usuario");

        $stmt -> bindParam(":intentos", $datosModel["actualizarIntentos"], PDO::PARAM_STR);
        $stmt -> bindParam(":usuario", $datosModel["usuarioActual"], PDO::PARAM_STR);

        if($stmt -> execute()){
            return "OK";
        }else{
            return "Error";
        }
    }
}

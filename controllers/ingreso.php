<?php

class Ingreso{

    public function ingresoController(){//esta funcion debo ejecutarla en la vista

        if(isset($_POST["usuarioIngreso"])){

            if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["usuarioIngreso"]) && 
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["passwordIngreso"])) {

                // $encriptar = crypt($_POST["passwordIngreso"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                $datosController = array("usuario" => $_POST["usuarioIngreso"],
                                            "password" => $_POST["passwordIngreso"]);

                $respuesta = IngresoModels::ingresoModel($datosController, "usuarios");

                $intentos = $respuesta["intentos"];
                $usuarioActual = $_POST["usuarioIngreso"];
                $maximosIntentos = 2;

                if ($intentos < $maximosIntentos) {

                    if ($respuesta["usuario"] == $_POST["usuarioIngreso"] && $respuesta["password"] == $_POST["passwordIngreso"]) {

                        $intentos = 0;
                        $datosController = array("usuarioActual" => $usuarioActual, "actualizarIntentos" => $intentos);
                        $respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");

                        session_start();
                        $_SESSION["usuario"] = $respuesta["usuario"];
                        $_SESSION["validar"] = true;
                        //si todo coincide bien mando al inicio.php con el header
                        header("location:inicio");

                    } else {

                        ++$intentos;
                        $datosController = array("usuarioActual" => $usuarioActual, "actualizarIntentos" => $intentos);
                        $respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");
                        echo '<div class="alert alert-danger">Error al ingresar!</div>';
                    }
                } else {

                    $intentos = 0;
                    $datosController = array("usuarioActual" => $usuarioActual, "actualizarIntentos" => $intentos);
                    $respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");
                    // header("location:index.php?action=fallo3intentos");
                    echo '<div class="alert alert-danger">Ha fallado 3 Veces. Utilice Captcha</div>';
                }
            }
        }
    }

    public function imprimirJson(){

        $json = file_get_contents('http://34.229.201.249:1337/api/sucesos/list3?page=0&per_page=8');
        $obj = json_decode($json);

        foreach ($obj as$value){
            echo "Imagen  : " .$value->url_img . "<br>";
            echo "sector  : " .$value->sector . "<br>";
            echo "Reseña  : " .$value->mi_resena . "<br><br>";
        }

    }

}

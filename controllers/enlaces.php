<?php

class Enlaces{

    public function enlacesController(){

        if (isset($_GET["action"])){//en el action me va a traer la pagina que quiero abrir

            $enlaces = $_GET["action"];//todo lo que trae get["action"] lo guardo en enlaces

        }else{

            $enlaces = "index";

        }

        $respuesta = EnlacesModels::enlacesModel($enlaces);

        include $respuesta; //incluyo la respuesta que puede ser por ejemplo ingreso.php (el path completo)
    }
}
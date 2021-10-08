<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Require\Class\Validate;

session_start();
trait MethodTenant {

    // Metodo para validar las propiedades de la instancia 'Tenant': 
    public function validateData()
    {
        if(isset($_SESSION['validate'])){

            // Asignamos la instancia que contiene la sesion 'validate', a la variable: 
            $data = $_SESSION['validate'];

            // Instanciamos la clase 'Validate' para validar las propiedades de la instancia: 
            $validate = new Validate;

            // Validamos la propiedad 'telephone': 
            if(!empty($data->telephone)){

                if($validate->validateNumber($data->telephone)){

                    // Retornamos la respuesta:
                    return ['register' => true];

                }else{
                    // Retornamos el error:
                    die('{"register" : false, "error" : "Campo telephone: No debe contener caracter alfanumericos."}');
                }

            }
        }
    }
}
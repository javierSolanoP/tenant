<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Tenant as ControllersTenant;
use App\Models\Tenant;
use Exception;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    // Metodo para retornar todos los registros de la tabla de la DB: 
    public function index()
    {
        // Realizamos la consulta a la tabla de la DB: 
        $model = Tenant::all();

        // Retornamos la respuesta:
        return ['query' => true, 'tenants' => $model];    
    }

    // Metodo para registrar un nuevo 'Tenant' en la tabla de la DB: 
    public function store(Request $request)
    {
        // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar: 
        $name_tenant = $request->input(key: 'name_tenant');

        // Validamos que los argumentos no esten vacios:
        if(!empty($name_tenant) && !empty($request->input(key: 'telephone'))){

            // Realizamos la consulta a la tabla de la DB:
            $model = Tenant::where('name_tenant', $name_tenant);

            // Validamos que exista el registro en la tabla de la DB:
            $validateTenant = $model->first();

            // Si no existe, validamos los argumentos recibidos: 
            if(!$validateTenant){

                // Instanciamos la clase 'Tenant' para validar los argumentos: 
                $tenant = new ControllersTenant(telephone: $request->input(key: 'telephone'));

                // Asignamos a la sesion 'validate' la instancia 'tenant'. Con sus propiedades cargadas de informacion: 
                $_SESSION['validate'] = $tenant; 

                // Validamos los argumentos: 
                $validateTenantArgm = $tenant->validateData();
                
                // Si los argumentos han sido validados, realizamos el registro: 
                if($validateTenantArgm['register']){

                    try{

                        Tenant::create(['name_tenant' => $name_tenant, 
                                        'telephone' => $request->input(key: 'telephone')]);

                        // Retornamos la respuesta:
                        return ['register' => true];

                    }catch(Exception $e){
                        // Retornamos el error:
                        return ['register' => false, 'error' => $e->getMessage()];
                    }

                }else{
                    // Retornamos el error:
                    return $validateTenantArgm;
                }
            }else{
                // Retornamos el error:
                return ['register' => false, 'error' => 'Ya existe ese tenant en el sistema.'];
            }

        }else{
            // Retornamos el error:
            return ['register' => false, 'error' => "Campo 'name_tenant' o 'telephone': No deben estar vacios."];
        }
    }

    // Metodo para retornar un registro especifico de la tabla de la DB:
    public function show($id_tenant)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Tenant::where('id_tenant', $id_tenant);

        // Validamos que exista el registro en la tabla de la DB:
        $validateTenant = $model->first();

        // Si existe, retornamos el registro: 
        if($validateTenant){
            
            // Retornamos la respuesta:
            return ['query' => true, 'tenant' => $validateTenant];

        }else{
            // Retornamos el error:
            return ['query' => false, 'error' => 'No existe ese tenant en el sistema.'];
        }
    }

    // Metodo para actualizar un registro especifico de la tabla de la DB: 
    public function update(Request $request, $id_tenant)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Tenant::where('id_tenant', $id_tenant);

        // Validamos que no exista el registro en la tabla de la DB:
        $validateTenant = $model->first();

        // Si existe, validamos los argumentos recibidos: 
        if($validateTenant){

            // Si el argumento contiene caracteres de tipo mayusculas, los pasamos a minusculas. Para seguir una nomenclatura estandar: 
            $name_tenant = $request->input(key: 'name_tenant');

            // Validamos que los argumentos no esten vacios:
            if(!empty($name_tenant) && !empty($request->input(key: 'telephone'))){

                // Instanciamos la clase 'Tenant' para validar los argumentos: 
                $tenant = new ControllersTenant(telephone: $request->input(key: 'telephone'));

                // Asignamos a la sesion 'validate' la instancia 'tenant'. Con sus propiedades cargadas de informacion: 
                $_SESSION['validate'] = $tenant; 

                // Validamos los argumentos: 
                $validateTenantArgm = $tenant->validateData();
                    
                // Si los argumentos han sido validados, realizamos el registro: 
                if($validateTenantArgm['register']){

                    try{

                        $model->update(['name_tenant' => $name_tenant, 
                                        'telephone' => $request->input(key: 'telephone')]);

                        // Retornamos la respuesta:
                        return ['register' => true];

                    }catch(Exception $e){
                        // Retornamos el error:
                        return ['register' => false, 'error' => $e->getMessage()];
                    }

                }else{
                    // Retornamos el error:
                    return $validateTenantArgm;
                }

            }else{
                // Retornamos el error:
                return ['register' => false, 'error' => "Campo 'name_tenant' o 'telephone': No deben estar vacios."];
            }

        }else{
            // Retornamos el error:
            return ['register' => false, 'error' => 'No existe ese tenant en el sistema.'];
        }

    }

    // Metodo para eliminar un registro especifico de la tabla de la DB: 
    public function destroy($id_tenant)
    {
        // Realizamos la consulta a la tabla de la DB:
        $model = Tenant::where('id_tenant', $id_tenant);

        // Validamos que exista el registro en la tabla de la DB:
        $validateTenant = $model->first();

        // Si existe, retornamos el registro: 
        if($validateTenant){
            
            try{

                // Eliminamos el registro: 
                $model->delete();

                // Retornamos la respuesta:
                return ['delete' => true];

            }catch(Exception $e){
                // Retornamos el error:
                return ['delete' => false, 'error' => $e->getMessage()];
            }

        }else{
            // Retornamos el error:
            return ['delete' => false, 'error' => 'No existe ese tenant en el sistema.'];
        }
    }
}

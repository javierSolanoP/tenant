<?php

namespace App\Http\Controllers; 

class Tenant {

    public function __construct(
        private $name_tenant = '',
        private $telephone = ''
    ){}

    // Usamos el trait 'MethodTenant' para validar las proipiedades: 
    use MethodTenant;
}
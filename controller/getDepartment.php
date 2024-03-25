<?php

namespace controller;

use model\Departement;

class getDepartment
{

    protected array $departments = array();

    public function getAllDepartments()
    {
        return Departement::orderBy('nom_departement')->get()->toArray();
    }
}
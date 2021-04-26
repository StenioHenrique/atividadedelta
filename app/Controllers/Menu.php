<?php

namespace App\Controllers;

class Menu extends BaseController
{
    public function index()
    {
        $data ["titulo"] = "teste titulo"; 
        return view("menu_index", $data);
    }
}

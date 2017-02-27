<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class RoleController extends Controller
{
    public function store()
    {

    }

    public function create()
    {
        return view('admin/role');
    }

    public function index(){

        return view('admin/role/index');
    }

    public function update(){

    }

    public function edit(){

    }

}

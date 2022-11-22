<?php

namespace DreamFactory\Core\As400\Http\Controllers;

use DreamFactory\Core\Http\Controllers\Controller;

class ExampleController extends Controller
{
    public function index()
    {
        return ['Who am I?' => "I'm Batman"];
    }

}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cinema;

class CinemaController extends Controller
{
    public function index() {
        return Cinema::all();
    }
}
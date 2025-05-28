<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Screening;

class ScreeningController extends Controller
{
    public function index() {
        return Screening::all();
    }
}
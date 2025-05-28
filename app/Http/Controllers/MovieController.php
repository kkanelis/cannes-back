<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index() {
        return Movie::all();
    }
}
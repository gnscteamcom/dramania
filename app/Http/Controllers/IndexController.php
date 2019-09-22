<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        return response(['error' => true, 'message' => 'Congratulations! You have found an empty page! Go celebrate this great discovery by sending the admin a coffee (or a beer...) '])
        ->header('Content-Type', 'application/json');
    }
}

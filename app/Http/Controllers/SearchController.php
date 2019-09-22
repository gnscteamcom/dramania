<?php

namespace App\Http\Controllers;

use App\Drama;
use App\Genre;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{

    public function searchDrama(Request $request) {
        if ($request->has('q')) {
            $data = Drama::select("id", "title")->where("title", "LIKE", "%{$request->q}%")->get();
            return response()->json($data);
        }
    }
}

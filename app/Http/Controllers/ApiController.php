<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Medoo;
use DB;
use Goutte;
use Response;

class ApiController extends Controller
{

    public function news() {
        $drama = \App\DramaTag::join('tags', 'drama_tags.tag_id', 'tags.id')
                ->join('dramas', 'drama_tags.drama_id', 'dramas.id')
                ->where('tags.id', \App\Tag::TAG_NEWS)
                ->select('dramas.*')
                ->paginate(10);
        return response($drama)
        ->header('Content-Type', 'application/json');
    }

    public function genres() {
        return response(\App\Genre::all())
        ->header('Content-Type', 'application/json');
    }

    public function genre(Request $request) {
        $genre = $request->input('genre');
        $drama = \App\Drama::where('genres','LIKE',"%{$genre}%")->orderBy('title', 'ASC')->paginate(10);
        return response($drama)
        ->header('Content-Type', 'application/json');
    }

    public function search(Request $request) {
        $keyword = $request->input('keyword');
        $drama = \App\Drama::where('title','LIKE',"%{$keyword}%")            
            ->orderBy('title', 'ASC')->paginate(10);
        return response($drama)
        ->header('Content-Type', 'application/json');
    }

    public function populars() {
        $drama = \App\DramaTag::join('tags', 'drama_tags.tag_id', 'tags.id')
                ->join('dramas', 'drama_tags.drama_id', 'dramas.id')
                ->where('tags.id', \App\Tag::TAG_POPULAR)
                ->select('dramas.*')
                ->paginate(10);
        return response($drama)
        ->header('Content-Type', 'application/json');
    }

    public function latests() {        
        $drama = \App\DramaTag::join('tags', 'drama_tags.tag_id', 'tags.id')
                ->join('dramas', 'drama_tags.drama_id', 'dramas.id')
                ->where('tags.id', \App\Tag::TAG_LATEST)
                ->select('dramas.*')
                ->paginate(10);
        return response($drama)
        ->header('Content-Type', 'application/json');
    }

    public function getStreamLink(Request $request) {
        $crawler = Goutte::request('GET', $request->episode_url);
        $link['link'] = $crawler->filter('.player div > iframe')->first()->attr('src');
        return Response::json($link);
    }

    
}

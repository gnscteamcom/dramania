<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Medoo;
use DB;
use Goutte;
use Response;

class ApiEnController extends Controller
{

    public function news() {
        $drama = \App\DramaTag::join('tags', 'drama_tags.tag_id', 'tags.id')
                ->join('dramas', 'drama_tags.drama_id', 'dramas.id')
                ->where('tags.id', \App\Tag::TAG_NEWS)
                ->where('language_id', \App\Language::LANG_EN)
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
        $drama = \App\Drama::where('genres','LIKE', "%{$genre}%")
            ->where('language_id', \App\Language::LANG_EN)
            ->orderBy('title', 'ASC')->paginate(10);
        return response($drama)
        ->header('Content-Type', 'application/json');
    }

    public function search(Request $request) {
        $keyword = $request->input('keyword');
        $drama = \App\Drama::where('title', 'LIKE',"%{$keyword}%")
            ->where('language_id', \App\Language::LANG_EN)
            ->orderBy('title', 'ASC')->paginate(10);
        return response($drama)
        ->header('Content-Type', 'application/json');
    }

    public function populars() {
        $drama = \App\DramaTag::join('tags', 'drama_tags.tag_id', 'tags.id')
                ->join('dramas', 'drama_tags.drama_id', 'dramas.id')
                ->where('tags.id', \App\Tag::TAG_POPULAR)
                ->where('language_id', \App\Language::LANG_EN)
                ->select('dramas.*')
                ->paginate(10);
        return response($drama)
        ->header('Content-Type', 'application/json');
    }

    public function latests() {        
        $drama = \App\DramaTag::join('tags', 'drama_tags.tag_id', 'tags.id')
                ->join('dramas', 'drama_tags.drama_id', 'dramas.id')
                ->where('tags.id', \App\Tag::TAG_LATEST)
                ->where('language_id', \App\Language::LANG_EN)
                ->select('dramas.*')
                ->paginate(10);
        return response($drama)
        ->header('Content-Type', 'application/json');
    }

    public function movies() {
        $movies = \App\Movie::where('language_id', \App\Language::LANG_EN)->paginate(10);
        return response($movies)
        ->header('Content-Type', 'application/json');
    }

    public function getStreamLink(Request $request) {
        // dd('aaa');
        $crawler = Goutte::request('GET', $request->episode_url);
        // dd($crawler);
        $link['link'] = $crawler->filter('iframe')->first()->attr('src');
        return Response::json($link);
    }
    
}

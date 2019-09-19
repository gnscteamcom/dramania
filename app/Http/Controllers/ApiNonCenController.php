<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiNonCenController extends Controller
{
    public function genres() {
        $list = 
        [
            '4-Koma',
            'Action',
            'Adult',
            'Adventure',
            'Comedy',
            'Cooking',
            'Demons',
            'Doujinshi',
            'Drama',
            'Ecchi',
            'Fantasy',
            'Game',
            'Gender Bender',
            'Gore',
            'Harem',
            'Historical',
            'Horror',
            'Isekai',
            'Josei',
            'Magic',
            'Manga',
            'Manhua',
            'Manhwa',
            'Martial Arts',
            'Mature',
            'Mecha',
            'Medical',
            'Military',
            'Music',
            'Mystery',
            'One Shot',
            'Oneshot',
            'Police',
            'Psychological',
            'Romance',
            'Samurai',
            'School',
            'School Life',
            'Sci-fi',
            'Seinen',
            'Shoujo',
            'Shoujo Ai',
            'Shounen',
            'Shounen Ai',
            'Slice of Life',
            'Smut',
            'Sports',
            'Super Power',
            'Supernatural',
            'Thriller',
            'Tragedy',
            'Vampire',
            'Webtoon',
            'Webtoons',
            'Yuri'
        ];
        $genres = array();
        foreach($list as $genre) {
            $genres[] = array('genre_name' => $genre);
        }
        return response($genres)
        ->header('Content-Type', 'application/json');
    }

    public function manga() {
        
        $titles = ['one piece', 'conan', 'devils', 'black clover', 'naruto', 'shokugeki', 'gintama', 'no hero', 'shingeki', 'tokyo ghoul', 'haikyu', 'one punch', 'domestic na', 'yaiba'];
        $manga = \App\Manga::where('title','LIKE',"%{$titles[0]}%")
                ->orWhere('title','LIKE',"%{$titles[1]}%") 
                ->orWhere('title','LIKE',"%{$titles[2]}%") 
                ->orWhere('title','LIKE',"%{$titles[3]}%") 
                ->orWhere('title','LIKE',"%{$titles[4]}%") 
                ->orWhere('title','LIKE',"%{$titles[5]}%") 
                ->orWhere('title','LIKE',"%{$titles[6]}%") 
                ->orWhere('title','LIKE',"%{$titles[7]}%") 
                ->orWhere('title','LIKE',"%{$titles[8]}%") 
                ->orWhere('title','LIKE',"%{$titles[9]}%") 
                ->orWhere('title','LIKE',"%{$titles[9]}%") 
                ->orWhere('title','LIKE',"%{$titles[10]}%") 
                ->orWhere('title','LIKE',"%{$titles[11]}%") 
                ->orWhere('title','LIKE',"%{$titles[12]}%") 
                ->orWhere('title','LIKE',"%{$titles[13]}%") 
                ->orderBy('title', 'ASC')->paginate(10);

        return response($manga)
        ->header('Content-Type', 'application/json');
    }

    public function genre(Request $request) {
        $genre = $request->input('genre');
        $manga = \App\Manga::where('genres','LIKE',"%{$genre}%")->orderBy('title', 'ASC')->paginate(10);
        return response($manga)
        ->header('Content-Type', 'application/json');
    }

    public function search(Request $request) {
        $keyword = $request->input('keyword');
        $manga = \App\Manga::where('title','LIKE',"%{$keyword}%")->orderBy('title', 'ASC')->paginate(10);
        return response($manga)
        ->header('Content-Type', 'application/json');
    }

    public function popular() {
        $manga = \App\Manga::where('rating', '>=', 4.0)->orderBy('rating', 'DESC')->orderBy('title', 'ASC')->paginate(10);
        return response($manga)
        ->header('Content-Type', 'application/json');
    }

    public function new() {        
        $manga = \App\Manga::orderBy('updated_at', 'DESC')->orderBy('title', 'ASC')->paginate(10);
        return response($manga)
        ->header('Content-Type', 'application/json');
    }
}

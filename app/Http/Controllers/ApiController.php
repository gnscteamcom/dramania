<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Medoo;
use DB;
use Goutte;
use Response;

class ApiController extends Controller
{

    protected $adult = 'Adult';
    protected $ecchi = 'Ecchi';
    protected $mature = 'Mature';
    protected $manhwa = 'Manhwa';
    protected $manhua = 'Manhua';

    public function drama() {
        
        $titles = ['one piece', 'conan', 'devils', 'black clover', 'naruto', 'shokugeki', 'gintama', 'no hero', 'shingeki', 'tokyo ghoul', 'haikyu', 'one punch', 'domestic na', 'yaiba'];
        $drama = \App\Drama::where('title','LIKE',"%{$titles[0]}%")
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

        return response($drama)
        ->header('Content-Type', 'application/json');
    }

    public function genres() {
        $list = 
        [
            '4-Koma',
            'Action',
            'Adventure',
            'Comedy',
            'Cooking',
            'Demons',
            'Doujinshi',
            'Drama',
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
            'Drama',
            'Martial Arts',
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

    public function popular() {
        $drama = \App\Drama::where('rating', '>=', 4.0)
            ->orderBy('rating', 'DESC')->orderBy('title', 'ASC')->paginate(10);
        return response($drama)
        ->header('Content-Type', 'application/json');
    }

    public function new() {        
        $drama = \App\Drama::orderBy('updated_at', 'DESC')->orderBy('title', 'ASC')->paginate(10);
        return response($drama)
        ->header('Content-Type', 'application/json');
    }

    public function getStreamLink(Request $request) {
        $crawler = Goutte::request('GET', $request->episode_url);
        $link['link'] = $crawler->filter('.player div > iframe')->first()->attr('src');
        return Response::json($link);
    }

    public function images(Request $request) {
        $url = $request->url;
        $html = file_get_contents($url);
        preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i',$html, $matches);
        $arr = array();
        for ($i=0; $i<sizeof($matches[1]); $i++) {
            $image = $matches[1][$i];
            /**
             * Replace 
             */
            if (\strpos($image, 'https://i0.wp.com/lh3.googleusercontent.com/-WLbuBlTHHv8/XV-mIMGQxTI/AAAAAAAE0H4/h1rlFzsRQCEINl_m2m90B336dxbFUxSRgCLcBGAs/s1600/z100.png')!==false) {
                $image = '';
            }
            if (\strpos($image, 'https://i0.wp.com/lh3.googleusercontent.com/-srIyflpqsMc/XV-mDiD3rlI/AAAAAAAE0HA/0e2aQ_SjGZUxKA4fxBNwDSKmftBqkAn7wCLcBGAs/s1600/0.jpg') !==false) {
                $image = '';
            }
            if (\strpos($image, '//sstatic1.histats.com/0.gif?4293297&101') !==false) {
                $image = '';
            }
            if (\strpos($image, 'https://4.bp.blogspot.com/-n-RT-t4XnqM/XUVBnFm8jkI/AAAAAAAEZwg/SPrXrIVrwRUGSQ_yWwh-EgfHKdfIBzvdgCLcBGAs/s1600/2.gif') !==false) {
                $image = '';
            }
            
            if (\strpos($image, 'https://3.bp.blogspot.com/-vms00H77Dbo/XQMnWofF5vI/AAAAAAADPI4/KwMkbc0HN2IzieMnjU76wcysq_00oUv_wCLcBGAs/s1600/slot%2Biklan%2B728x90.png') !==false) {
                $image = '';
            }
            if (\strpos($image, 'https://i2.wp.com/mangashiro.org/wp-content/uploads/2019/02/mahadewa.gif') !==false) {
                $image = '';
            }
            if (\strpos($image, 'https://3.bp.blogspot.com/-ZZSacDHLWlM/VhvlKTMjbLI/AAAAAAAAF2M/UDzU4rrvcaI/s1600/btn_close.gif') !==false) {
                $image = '';
            }
            if (\strpos($image, 'https://2.bp.blogspot.com/-Cfa5vctMxfs/XUVBnW5fW4I/AAAAAAAEZwk/WdWAGdRXrRcFHQpbqsdy1KYYNTWXpRFdgCLcBGAs/s1600/1.gif') !==false) {
                $image = '';
            }
            if (\strpos($image, 'https://1.bp.blogspot.com/-Snz6SeNgG7o/XMRTRtU_9BI/AAAAAAACYV4/_0W6XrvKU0UFJW4Lfmx6WJAYU_3A50K-ACLcBGAs/s1600/banner-mainbet88.gif') !==false) {
                $image = '';
            }
            if (\strpos($image, 'https://i3.wp.com/mangashiro.org/wp-content/uploads/2019/08/mangashiro-org.png') !==false) {
                $image = '';
            }
            if (\strpos($image, 'https://1.bp.blogspot.com/-2P4dQHLESrI/XUUE-Q3RkDI/AAAAAAAEYkA/YpVZPwtub0oPK56Z2fwybkEHzN1s8bALQCLcBGAs/s1600/100x450-min.gif') !==false) {
                $image = '';
            }
            if (\strpos($image, 'https://i0.wp.com/lh3.googleusercontent.com/-TX1gOD-tbi4/XKg7ZZuvU9I/AAAAAAAB_bY/s9dsrGIOY7gKoZYpxhvzW44MC0vhVCqNwCLcBGAs/s1600/z100.png') !==false) {
                $image = '';
            }
            if (!empty($image)) {
                $arr[] = array("image" => $image);
            }
        }
        return response(json_encode($arr))
        ->header('Content-Type', 'application/json');
    }
}

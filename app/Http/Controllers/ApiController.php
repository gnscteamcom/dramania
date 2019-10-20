<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Medoo;
use DB;
use Goutte;
use Response;
// use Symfony\Component\DomCrawler\Crawler;

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

    public function movies() {
        $movies = \App\Movie::paginate(10);
        return response($movies)
        ->header('Content-Type', 'application/json');
    }

    /**
     * dramasiatv
     */
    // public function getStreamLink(Request $request) {
    //     $crawler = Goutte::request('GET', $request->episode_url);
    //     $link['link'] = $crawler->filter('.player div > iframe')->first()->attr('src');
    //     return Response::json($link);
    // }

     /**
     * dramasiatv
     */
    public function getStreamLink(Request $request) {
        $crawler = Goutte::request('GET', $request->episode_url);
        // dd($crawler);
        ///html/body/div[2]/div[3]/div/div[2]/div[1]/div[5]/p[3]/script
        
        //html body.modern.single div#wrap div#content div.content.wrapper.clearfix div.content-left div.single-content.video div.video-container p script
        // $crawler->filter('div.single-content.video div.video-container p > script')->each(function ($node) {
        //     $js = $node->each(function ($ii) {
        //         $js = $ii->text();
        //         print $js;
        //     });
        // });
       
        // $js = $crawler->filter('div.single-content.video div.video-container p:nth-child(3) > script')->text();
        // $js = str_replace('document.write( unescape(', '', $js);
        // $js = str_replace(') );', '', $js);

        $crawler->filter('div.single-content.video div.video-container p:nth-child(3) > script')->each(function ($node) {
            // $js = str_replace('document.write( unescape(', '', $node);
            // $js = str_replace(') );', '', $js);
            // print $node->text();
            $unescape = str_replace('document.write( unescape(', '', $node->text());
            $unescape = str_replace(') );', '', $unescape);

            $html = rawurldecode($unescape);
            
            // $link = new \App\Link();

            $dom = new \DOMDocument();
            $dom->loadHTML($html);

            $xpath = new \DOMXPath($dom);
            $tags = $xpath->query('//div[@class="apicodes-container"]/iframe');
            foreach ($tags as $tag) {
                // var_dump(trim($tag->getAttribute('src')));
                
                $url = trim($tag->getAttribute('src'));
                $url = str_replace('https://drmq.stream/v3/play.php?id=', 'https://drmq.stream/cdn/sinemaday2.php?id=', $url);
                $link = array('link' => $url);
                // $json = trim($tag->getAttribute('src'));
                echo json_encode($link);
            }
        });

        // print $js;

        // $crawler = rawurldecode($js);
        // $crawler .= htmlspecialchars_decode(urldecode($js));
        // $videoContainer = new Crawler(file_get_contents($crawler));
        // $doc = new DOMDocument();
        // $doc->loadHTML($videoContainer);

        // print $crawler;
        // $urls = $crawler->filter('div.apicodes-container > iframe')->attr('src');
        // print $urls;

        // dd($js);
        // dd($js);

        // $link['link'] = $crawler;
        // return Response::json($link);
    }

    
}

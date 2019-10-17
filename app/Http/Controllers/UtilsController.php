<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Medoo;
use Goutte;
use Response;

class UtilsController extends Controller
{
    protected $fileData;
    protected $fileJson;
    protected $decodeData;
    protected $insertData;
    protected $gen = array();
    protected $c_link = array();
    protected $c_chap = array();

    public function manga()
    {
        // $this->process('/home/winnerawan/data.xls');
        $this->process('/Users/winnerawan/Music/dmq.xls');

    }

    public function process($filename)
    {
        try {
            $this->readExcel($filename);
            $this->insertRecord();
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    /**
     */
    protected function readExcel($filename)
    {
        /**/
        $text = implode(' ', [
            escapeshellcmd(realpath(__DIR__ . '/cli/process.py')),
            escapeshellcmd($filename),
            escapeshellarg(1),
            '2>&1'
        ]);
        // dd($text);

        $this->fileData = trim(shell_exec($text));
        // dd($this->fileData);
        if (substr($this->fileData, 0, 1) !== '{') {
            throw new Exception($this->fileData);
        }
        $this->fileJson = json_decode($this->fileData, true);
        if (!is_array($this->fileJson)) {
            throw new Exception(json_last_error_msg());
        }
        if (empty($this->fileJson['data'])) {
            throw new Exception('The record data is empty.');
        }

        $this->decodeData = $this->fileJson['data'];
    }


    /**
     */
    protected function insertRecord()
    {
        foreach ($this->decodeData as $item) {
            $data = $this->wrapItemValues($this->readItemValues($item));
            if ($data != null) {
                $this->insertData[] = $data;
            }
        }
        // dd($this->insertData);
        // echo json_encode($this->insertData);
       Medoo::insert('mangas', $this->insertData);
        
    }

    /**
     */
    protected function readItemValues(array $item)
    {

        $data['id'] = \App\Uid::number();
        $data['title'] = trim(preg_replace('/\s+/', ' ', preg_replace('/[[:^print:]]/', ' ', trim($item[10]))));
        $data['author'] = trim(preg_replace('/\s+/', ' ', preg_replace('/[[:^print:]]/', ' ', trim($item[0]))));
        $data['banner'] = trim($item[1]);
        $data['description'] = trim(preg_replace('/\s+/', ' ', preg_replace('/[[:^print:]]/', ' ', trim($item[2]))));
        $data['poster'] = preg_replace('/[[:^print:]]/', ' ', trim($item[1]));
        $data['status'] = ''; //trim($item[8]);
        $data['genres'] = json_encode(explode(',', trim($item[5])));
        $data['stars'] = json_encode(explode(',', trim($item[8])));
        $data['rating'] = (float)trim($item[7]);
        $slug = preg_replace('/[[:^print:]]/', ' ', trim($item[10]));
        $slug = str_replace(' ', '-', $slug);
        $slug = strtolower(preg_replace("/[^a-zA-Z]/", "-", $slug));
        $slug = trim(preg_replace('/-+/', '-', $slug), '-');
        $data['slug'] = $slug;
        $data['updated_at'] = \Carbon\Carbon::now('Asia/Jakarta'); //gmdate("Y-m-d H:i:s", ((int)(trim($item[10])) - 25569) * 86400);
       
        $array1 = explode(',', trim($item[3])); //episode
        $array2 = explode(',', trim($item[4])); //episode links
        // $list1 = ['Chapter 6','Chapter 5.5','Chapter 5','Chapter 4','Chapter 3','Chapter 2','Chapter 1'];
        // $list2 = ['https://mangashiro.org/alcapus-chapter-6','https://mangashiro.org/alcapus-chapter-5-5','https://mangashiro.org/alcapus-chapter-5','https://mangashiro.org/alcapus-chapter-4','https://mangashiro.org/alcapus-chapter-3','https://mangashiro.org/alcapus-chapter-2-bahasa-indonesia','https://mangashiro.org/alcapus-chapter-1-bahasa-indonesia'];
        
        // foreach ($array1 as $l => $list) {
        //     $chapter[] = array('chapter' => $list, 'url' => $array2[$l]);
        //     // echo json_encode($chapter);
        // }

        if (count($array1)==count($array2)) {
            foreach($array1 as $key => $val) {
                $object[] = (Object) [ 'episode' => $array1[$key], 'url' => $array2[$key]];
                // echo json_encode($object);
           }
           $data['episodes'] = json_encode($object);
        }
        
        // echo json_encode($chapter);
        // dd($data);

        return $data;
    }

    function array_overlay($a1,$a2)
{
    foreach($a1 as $k => $v) {
        if ($a2[$k]=="::delete::"){
            unset($a1[$k]);
            continue;
        };
        if(!array_key_exists($k,$a2)) continue;
        if(is_array($v) && is_array($a2[$k])){
            $a1[$k] = array_overlay($v,$a2[$k]);
        }else{
            $a1[$k] = $a2[$k];
        }
       
    }
    return $a1;
}

    function array_combine2($arr1, $arr2) {
        $count1 = count($arr1);
        $count2 = count($arr2);
        $numofloops = $count2/$count1;
           
        $i = 0;
        while($i < $numofloops) {
            $arr3 = array_slice($arr2, $count1*$i, $count1);
            $arr4[] = array_combine($arr1, $arr3);
            $i++;
        }
       
        return $arr4;
    }

    protected function array_combine_($keys, $values){
        $result = array();
    
        foreach ($keys as $i => $k) {
         $result[$k][] = $values[$i];
         }
    
        array_walk($result, function(&$v){
         $v = (count($v) == 1) ? array_pop($v): $v;
         });
    
        return $result;
    }
    /**
     */
    protected function wrapItemValues(array $item)
    {
        /**/
        // $item[]
        $item['created_at'] = date('Y-m-d H:i:s');
        // $this->readGenres($item);
        return $item;
    }


    public function updateLinks(Request $request) {
        $drama = \App\Drama::findOrFail('2019091717252600135597213347');
        $episodes = $drama->episodes;
        // return Response::json($episodes);

        foreach($episodes as $episode) {
            // $links[] = array('url' => $episode['url'], 'episode' => $episode['episode']);
            $links[] = $episode['url'];
        }
        foreach($links as $link) {
            $crawler = Goutte::request('GET', $link);
            $xxx[] = $crawler->filter('.player div > iframe')->first()->attr('src');
        }
        return Response::json($xxx);
    }
}

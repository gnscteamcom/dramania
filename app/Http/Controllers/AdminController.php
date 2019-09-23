<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Medoo;
use File;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;


class AdminController extends Controller
{
    

    public function dashboard() {
        $ids = \App\Drama::where('language_id', \App\Language::LANG_ID)->get();
        $ens = \App\Drama::where('language_id', \App\Language::LANG_EN)->get();
        $genres = \App\Genre::all();
        
        $records = \App\XlsFile::all();
        $languages = \App\Language::all();
        // $adult = \App\Drama::where('genres', 'LIKE', '%Adult%')
        //     ->orWhere('genres', 'LIKE', '%Mature%')
        //     ->get();
        // $broken = \App\Drama::where('chapters', 'LIKE', '%%')
        //     ->get();    

        return view('system.index')->with([
            'ids' => $ids,
            'ens' => $ens,
            'genres' => $genres,
            'records' => $records,
            'languages' => $languages
        ]);
    }

    public function restore()
    {
        $records = \App\XlsFile::all();
        $languages = \App\Language::all();
        return view('system.restore')->with([
            'records' => $records,
            'languages' => $languages
        ]);
    }

    public function genres()
    {
        $records = \App\Genre::orderBy('name', 'ASC')->get();
        return view('system.genres')->with([
            'records' => $records,
        ]);
    }

    public function editGenre($id) {
        return view('system.edit_genre')->with([
            'record' => \App\Genre::findOrFail($id)
        ]);
    }

    public function editGenrePost(Request $request, $id) {
        $genre = \App\Genre::findOrFail($id);
        $genre->name = $request->name;
        $genre->save();

        return redirect()->route('system.genres');
    }

    public function createGenre(Request $request) {
        return view('system.create_genre');
    }

    public function createGenrePost(Request $request) {
        $genre = new \App\Genre();
        $genre->name = $request->name;
        $genre->save();

        return redirect()->route('system.genres');
    }

    public function deleteGenre($id) {
        $genre = \App\Genre::findOrFail($id);
        $genre->delete();

        return redirect()->route('system.genres');
    }

    public function tags() {
        return view('system.tags')->with([
            'records' => \App\DramaTag::all()
        ]);
    }

    public function createTag() {
        return view('system.create_tag')->with([
            'languages' => \App\Language::all(),
            'tags' => \App\Tag::all()
        ]);
    }

    public function createTagPost(Request $request) {
        $tags = $request->tags;
        foreach($tags as $tag) {
            $dramaTag = new \App\DramaTag();
            $dramaTag->drama_id = $request->dramaId;
            $dramaTag->tag_id = $tag;
            $dramaTag->save();
        }

        return redirect()->route('system.tags');
    }

    public function deleteTag($id) {
        $dramaTag = \App\DramaTag::findOrFail($id);
        $dramaTag->delete();

        return redirect()->route('system.tags');
    }

    public function upload(Request $request) {
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));
        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            return $this->saveFile($request, $save->getFile());
        }

        $handler = $save->handler();
        
        return redirect()->route('system.restore');
    }

    protected function saveFile(Request $request, UploadedFile $file)
    {
        $date = $request->date;
        $lang = \App\Language::findOrFail($request->language);
        $source = $request->source;
        $file_name = strtoupper($source.'_' .str_replace(' ', '_', $lang->language_name) . '_' . str_replace('-', '', $date));
        // $xls_file = $request->file('file');
        $file_size = $file->getSize();
        $file_name .= '.' . $file->getClientOriginalExtension();

        // $file->move('/home/winnerawan/Dramahive/uploads/', $file_name);
        $file->move('/Users/winnerawan/Music/', $file_name);

        $xls = new \App\XlsFile();
        $xls->filename = $file_name;
        $xls->created_at = $date;
        $xls->xls_status_id = \App\XlsStatus::STATUS_DRAFT;
        $xls->language_id = $lang->id;
        $xls->size = $file_size;
        $xls->save();

        return redirect()->route('system.restore');

    }

    public function insertDrama(Request $request) {
        $xls = \App\XlsFile::findOrFail($request->xls_id);
        $filename = '/Users/winnerawan/Music/'.$xls->filename;
        $this->process($request, $filename);
        $xls->xls_status_id = \App\XlsStatus::STATUS_ACTIVE;
        $xls->save();
        return redirect()->route('system.restore');
    }

    public function removeDraft(Request $request) {
        $xls = \App\XlsFile::findOrFail($request->xls_id);
        if (File::exists($xls->filename)) {
            File::delete($xls->filename);
        }
        $xls->xls_status_id = \App\XlsStatus::STATUS_DELETED;

        foreach(\App\Drama::where('xls_id', $xls->id)->get() as $Drama) {
            $Drama->delete();
        }
        $xls->save();
        return redirect()->route('system.restore');
    }

    public function dramas() {
        return view('system.dramas')->with([
            'records' => \App\Drama::with(['language'])->orderBy('title', 'ASC')->paginate(100)
        ]);
    }

    public function editDrama($id) {
        return view('system.edit_drama')->with([
            'record' => \App\Drama::findOrFail($id),
            'languages' => \App\Language::all()
        ]);
    }

    public function editDramaPost(Request $request, $id) {
        $comic = \App\Drama::findOrFail($id);
        $comic->title = $request->title;
        $comic->language_id = $request->language_id;
        $comic->author = $request->author;
        $comic->description = $request->description;
        $comic->poster = $request->poster;
        $comic->status = $request->status;
        $comic->rating = $request->rating;
        $comic->save();

        return redirect()->route('system.dramas');

    }

    /**
     */
    public function process(Request $request, $filename)
    {
        try {
            $this->readExcel($filename);
            $this->insertRecord($request);
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
    protected function insertRecord(Request $request)
    {
        foreach ($this->decodeData as $item) {
            $data = $this->wrapItemValues($request, $this->readItemValues($item));
            if ($data != null) {
                $this->insertData[] = $data;
            }
        }
       Medoo::insert('Dramas', $this->insertData);    
    }

    /**
     */
    protected function readItemValues(array $item)
    {

        $data['id'] = \App\Uid::number();
        $title = trim(preg_replace('/\s+/', ' ', preg_replace('/[[:^print:]]/', ' ', trim($item[9]))));
        $data['title'] = str_replace('Bahasa Indonesia', '', $title);
        $data['author'] = trim(preg_replace('/\s+/', ' ', preg_replace('/[[:^print:]]/', ' ', trim($item[0]))));
        $data['banner'] = trim($item[1]);
        $data['description'] = trim(preg_replace('/\s+/', ' ', preg_replace('/[[:^print:]]/', ' ', trim($item[4]))));
        $data['poster'] = preg_replace('/[[:^print:]]/', ' ', trim($item[6]));
        $data['status'] = trim($item[8]);
        $data['genres'] = json_encode(explode(',', trim($item[5])));
        $data['rating'] = (float)trim($item[7]);
        $slug = preg_replace('/[[:^print:]]/', ' ', trim($item[9]));
        $slug = str_replace(' ', '-', $slug);
        $slug = strtolower(preg_replace("/[^a-zA-Z]/", "-", $slug));
        $slug = trim(preg_replace('/-+/', '-', $slug), '-');
        $data['slug'] = $slug;
        $data['updated_at'] = gmdate("Y-m-d H:i:s", ((int)(trim($item[10])) - 25569) * 86400);
       
        $array1 = explode(',', trim($item[3]));
        $array2 = explode(',', trim($item[2]));

        if (count($array1)==count($array2)) {
            foreach($array1 as $key => $val) {
                $object[] = (Object) [ 'episode' => $array1[$key], 'url' => $array2[$key]];
           }
           $data['episodes'] = json_encode($object);
        }
        
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
    protected function wrapItemValues(Request $request, array $item)
    {
        /**/
        // $item[]
        $item['created_at'] = date('Y-m-d H:i:s');
        $item['xls_id'] = $request->xls_id;
        $item['language_id'] = $request->language_id;
        // $this->readGenres($item);
        return $item;
    }

    public function changePassword() {
        return view('system.change_password')->with([
            'user' => \App\User::findOrFail(1)
        ]);
    }

    public function changePasswordPost(Request $request) {
        
        $admin = \App\User::findOrFail(1);
        $admin->password = bcrypt($request->password);
        $admin->save();

        return redirect()->route('system.dashboard');
    }

    // public function keys() {
    //     return view('system.keys')->with([
    //         'keys' => \App\Ap
    //     ])
    // }
}

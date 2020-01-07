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
    
    protected $oldXlsId;

    public function dashboard() {
        $movies = \App\Movie::all();
        $genres = \App\Genre::all();
        
        $records = \App\XlsFile::all();
        $languages = \App\Language::all();
        // $adult = \App\Drama::where('genres', 'LIKE', '%Adult%')
        //     ->orWhere('genres', 'LIKE', '%Mature%')
        //     ->get();
        // $broken = \App\Drama::where('chapters', 'LIKE', '%%')
        //     ->get();    

        return view('system.index')->with([
            'movies' => $movies,
            'genres' => $genres,
            'records' => $records,
            'languages' => $languages
        ]);
    }

    public function restore()
    {
        $records = \App\XlsFile::orderBy('created_at', 'DESC')->get();
        $languages = \App\Language::all();
        $types = \App\XlsFileType::all();
        return view('system.restore')->with([
            'records' => $records,
            'languages' => $languages,
            'types' => $types
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
        $source = $request->source;
        $file_name = strtoupper($source.'_' . str_replace('-', '', $date));
        // $xls_file = $request->file('file');
        $file_size = $file->getSize();
        $file_name .= '.' . $file->getClientOriginalExtension();

        // dd(config('app.xls_location'));
        $file->move(config('app.xls_location'), $file_name);
        // $file->move('/Users/winnerawan/Music/', $file_name);

        $xls = new \App\XlsFile();
        $xls->filename = $file_name;
        $xls->created_at = $date;
        $xls->xls_status_id = \App\XlsStatus::STATUS_DRAFT;
        $xls->xls_file_type_id = \App\XlsFileType::TYPE_MOVIES;
        $xls->language_id = \App\Language::LANG_EN;
        $xls->size = $file_size;
        $xls->save();

        return redirect()->route('system.restore');

    }

    

    /**
     */
    public function insertMovie(Request $request) {
        $xls = \App\XlsFile::findOrFail($request->xls_id);
        $filename = config('app.xls_location').$xls->filename;
        $this->processMovies($request, $filename);
        $xls->xls_status_id = \App\XlsStatus::STATUS_ACTIVE;
        $xls->save();

        $otherMovieXls = \App\XlsFile::where('xls_file_type_id', \App\XlsFileType::TYPE_MOVIES)
            ->where('id', '!=', $xls->id)->get();
        foreach($otherMovieXls as $other) {
            $other->xls_status_id = \App\XlsStatus::STATUS_UPDATED;
            $other->save();

            $oldMovies = \App\Movie::where('xls_id', $other->id)->get();
            foreach ($oldMovies as $oldM) {
                $oldM->delete();
            }
        }    
        
        return redirect()->route('system.restore');
    }

    public function removeDraft(Request $request) {
        $xls = \App\XlsFile::findOrFail($request->xls_id);
        if (File::exists($xls->filename)) {
            File::delete($xls->filename);
        }
        $xls->xls_status_id = \App\XlsStatus::STATUS_DELETED;

        foreach(\App\Drama::where('xls_id', $xls->id)->get() as $drama) {
            // $drama->
            // $drama->delete();
        }
        $xls->save();
        return redirect()->route('system.restore');
    }

    public function dramas(Request $request) {

        $records = \App\Drama::with(['language'])->orderBy('title', 'ASC')->paginate(50);
        if ($request->title!=null) {
            $records = \App\Drama::with(['language'])
                ->where("title", "LIKE", "%{$request->title}%")->orderBy('title', 'ASC')->paginate(50);
        } 
        return view('system.dramas')->with([
            'records' => $records
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
    public function processMovies(Request $request, $filename)
    {
        try {
            $this->readExcel($filename);
            $this->insertRecordMovies($request);
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
        dd($this->insertData);
       Medoo::insert('dramas', $this->insertData);    
    }

    /**
     */
    protected function insertRecordMovies(Request $request)
    {
        foreach ($this->decodeData as $item) {
            $data = $this->wrapItemValues($request, $this->readItemMovies($item));
            if ($data != null) {
                $this->insertData[] = $data;
            }
        }
       dd($this->insertData);
       Medoo::insert('movies', $this->insertData);    
    }

    /**
     */
    protected function readItemValues(array $item)
    {

        $data['id'] = \App\Uid::number();
        $data['title'] = trim(preg_replace('/\s+/', ' ', preg_replace('/[[:^print:]]/', ' ', trim($item[8]))));
        $data['quality'] = trim($item[4]);
        $data['country'] = trim($item[0]);
        $data['synopsis'] = trim(preg_replace('/\s+/', ' ', preg_replace('/[[:^print:]]/', ' ', trim($item[7]))));
        $data['poster'] = trim($item[3]); //preg_replace('/[[:^print:]]/', ' ', trim($item[1]));
        $data['genres'] = json_encode(explode(',', trim($item[1])));
        $data['rating'] = trim($item[5]);
        $slug = preg_replace('/[[:^print:]]/', ' ', trim($item[8]));
        $slug = str_replace(' ', '-', $slug);
        $slug = strtolower(preg_replace("/[^a-zA-Z]/", "-", $slug));
        $slug = trim(preg_replace('/-+/', '-', $slug), '-');
        $data['slug'] = $slug;
        $data['updated_at'] = \Carbon\Carbon::now('Asia/Jakarta')->toDateTimeString(); //gmdate("Y-m-d H:i:s", ((int)(trim($item[10])) - 25569) * 86400);

        return $data;
    }

    /**
     */
    protected function readItemMovies(array $item)
    {

        $data['id'] = \App\Uid::number();
        $data['title'] = trim(preg_replace('/\s+/', ' ', preg_replace('/[[:^print:]]/', ' ', trim($item[8]))));
        $data['quality'] = trim($item[4]);
        $data['country'] = trim($item[0]);
        $data['release'] = trim($item[6]);
        $data['synopsis'] = trim(preg_replace('/\s+/', ' ', preg_replace('/[[:^print:]]/', ' ', trim($item[7]))));
        $data['poster'] = trim($item[3]); //preg_replace('/[[:^print:]]/', ' ', trim($item[1]));
        $data['genres'] = json_encode(explode(',', trim($item[1])));
        $data['rating'] = trim($item[5]);
        $slug = preg_replace('/[[:^print:]]/', ' ', trim($item[8]));
        $slug = str_replace(' ', '-', $slug);
        $slug = strtolower(preg_replace("/[^a-zA-Z]/", "-", $slug));
        $slug = trim(preg_replace('/-+/', '-', $slug), '-');
        $data['slug'] = $slug;
        $data['link'] = trim($item[2]);
        $data['updated_at'] = \Carbon\Carbon::now('Asia/Jakarta')->toDateTimeString();
        return $data;
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

    public function changeEmail() {
        return view('system.change_email')->with([
            'user' => \App\User::findOrFail(1)
        ]);
    }

    public function changeEmailPost(Request $request) {
        
        $admin = \App\User::findOrFail(1);
        $admin->email = $request->email;
        $admin->save();

        return redirect()->route('system.dashboard');
    }

    public function ads() {
        return view('system.ads')->with([
            'records' => \App\Ad::all()
        ]);
    }

    public function createAds() {
        return view('system.create_ads')->with([
           
        ]);
    }

    public function createAdsPost(Request $request) {
        $ads = new \App\Ad();
        $ads->title = $request->title;
        $ads->description = $request->description;
        $ads->image = $request->image;
        $ads->url = $request->url;
        $ads->save();
        return redirect()->route('system.ads');
    }

    public function updateAds($id) {
        return view('system.update_ads')->with([
           'record' => \App\Ad::findOrFail($id)
        ]);
    }

    public function updateAdsPost(Request $request, $id) {
        $ads = \App\Ad::findOrFail($id);
        $ads->title = $request->title;
        $ads->description = $request->description;
        $ads->image = $request->image;
        $ads->url = $request->url;
        $ads->save();
        return redirect()->route('system.ads');
    }

    public function deleteAds($id) {
        $ads = \App\Ad::findOrFail($id);
        $ads->delete();
        return redirect()->route('system.ads');
    }

    public function movies() {
        return view('system.movies')->with([
            'records' => \App\Movie::paginate(50)
        ]);
    }

    public function createMovie() {
        return view('system.create_movie');
    }

    public function createMoviePost(Request $request) {
        $movie = new \App\Movie();
        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->url = $request->url;
        $movie->rating = $request->rating;
        $movie->genres = $request->genre;
        $movie->poster = $request->poster;
        $slug = preg_replace('/[[:^print:]]/', ' ', trim($request->title));
        $slug = str_replace(' ', '-', $slug);
        $slug = strtolower(preg_replace("/[^a-zA-Z]/", "-", $slug));
        $slug = trim(preg_replace('/-+/', '-', $slug), '-');
        $movie->slug = $slug;
        $movie->save();
        return redirect()->route('system.movies');
    }

    public function editMovie($id) {
        return view('system.update_movie')->with([
            'record' => \App\Movie::findOrFail($id)
        ]);
    }

    public function editMoviePost(Request $request, $id) {
        $movie = \App\Movie::findOrFail($id);
        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->url = $request->url;
        $movie->rating = $request->rating;
        $movie->genres = $request->genre;
        $movie->poster = $request->poster;
        $slug = preg_replace('/[[:^print:]]/', ' ', trim($request->title));
        $slug = str_replace(' ', '-', $slug);
        $slug = strtolower(preg_replace("/[^a-zA-Z]/", "-", $slug));
        $slug = trim(preg_replace('/-+/', '-', $slug), '-');
        $movie->slug = $slug;
        $movie->save();
        return redirect()->route('system.movies');
    }

    public function comingSoon() {
        return view('system.coming_soon');
    }

   
}

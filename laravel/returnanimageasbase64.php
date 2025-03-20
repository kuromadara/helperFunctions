<img src="{{ route('image',str_replace("/","-----",$userInfo->photo)) }}" alt="" title="" class="avatar-img rounded">

Route::get('/private/{file}', function($filename){
    $path = storage_path().'/'.'app/'.str_replace("-----","/",$filename);
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::stream(function() use($file) {
      echo $file;
    }, 200, ["Content-Type"=> $type]);
    return $response;
})->name('image');


//buggy need fixing

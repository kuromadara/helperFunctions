<?php
namespace App\Services;
use Illuminate\Support\Facades\Storage;
class UploadFiles
{
    public static function saveFile($file, $path, $query,$queryType,$fieldName,$data=null) {
        $fileName = time().'_'.$file->getClientOriginalName();
        $filePath = $file->storeAs($path, $fileName, '');
        if($queryType == 'update'){
            $query->$fieldName = $filePath;
            $save = $query->save();
        }
        else{
            $save = $query->uploads()->create($data);
        }
        if ($save) return true;
    }

    public static function updateFile($file, $path, $query, $queryFile){
        $url = $file->store($path);

        if(self::deleteFile($queryFile))
            $queryFile->url = $url;

        if ($query->uploads()->save($queryFile))
            return true;
    }

    public static function deleteFile($queryFile) {
        Storage::delete($queryFile->url);
        $queryFile->delete();
        return true;
    }

    public static function get_file($path)
    {
        /**this will force download your file**/
        return response()->download($path);
    }

}

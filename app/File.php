<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'filename',
        'url'
    ];


    static public function save_picture($file)
    {
        if( env('APP_ENV') == 'local' )
            return File::local_upload($file);
        
        return File::s3_upload($file);
    }
    
    static public function local_upload($file)
    {
        $fileName = time().'_'.$file->getClientOriginalName();

        \Storage::disk('local')->put($fileName, \File::get($file));
        \Storage::disk('local')->put('archivos/'.$fileName, \File::get($file));

        $file_stocked = File::create([
            'filename' => $fileName,
            'url' => '/app/archivos/',
        ]);

        return $file_stocked->id;
    }

    static public function s3_upload($file)
    {
        $path = $file->store('/', 's3');

        $image = File::create([
            'filename' => basename($path),
            'url' => \Storage::disk('s3')->url($path),
        ]);

        return $image->id;
    }

    static public function get_path($id)
    {
        $image = File::find($id);

        if( env('APP_ENV') == 'local' )
            return storage_path('/app/archivos'). "/" . $image->filename;
        
        return $image->url;   
    }
}

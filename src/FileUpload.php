<?php

namespace adolfbagenda\InvestmentClub;
use File;
use Illuminate\Support\Str;
Use Image;
use Intervention\Image\Exception\NotReadableException;
class FileUpload
{


    public static function upload($image_upload,$file_path,$thumbs_path,$title)
    {
      if (!File::isDirectory(storage_path($file_path))) {
          File::makeDirectory(storage_path($file_path), 0777, true, true);
      }
      if (!File::isDirectory(storage_path($thumbs_path))) {
          File::makeDirectory(storage_path($thumbs_path), 0777, true, true);
      }
      $name = Str::lower($title);
      $resultString = str_replace(' ', '', $name);
      $ImageUpload = Image::make($image_upload);
      $photoname = $resultString.'_'.time().'.'.$image_upload->getClientOriginalExtension();
      $ImageUpload->save(storage_path($file_path).'/'.$photoname);

      // for save thumnail image
    // $ImageUpload->resize(null, 520, function ($constraint) {
  //  $constraint->aspectRatio();
//});
     $ImageUpload->fit(600, 600, function ($constraint) {
    $constraint->upsize();
});
     $ImageUpload = $ImageUpload->save(storage_path($thumbs_path).'/'.$photoname);
        return $photoname;
    }
}

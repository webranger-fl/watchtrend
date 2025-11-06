<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use App\Helpers\GoogleDrive;
use Jenssegers\Date\Date;
use Carbon\Carbon;

class BackupsController extends Controller
{
  public function index()
  {
    //dd('googledisk');
    $gd = new \App\Helpers\GoogleDrive();
    $gdFiles = $gd->searchForFiles();
    //dd($gdFiles);
    $gdFiles = $gdFiles[0];
    usort($gdFiles, function ($a, $b) {
      return strtotime($a->modifiedTime) < strtotime($b->modifiedTime);
    });
    $lastGdBackup = $gdFiles[0];
    //$lastGD = new Date($lastGdBackup->modifiedTime);
    //$lastGD = new Date(new Carbon($lastGdBackup->modifiedTime));
    //dd($lastGdBackup->modifiedTime);
    //dd($lastGD);
    $localFiles = Storage::files(config('app.name'));
    $lastLocalBackup = null;
    $lastLocalBackup['name'] = count($localFiles) > 0 ? $localFiles[count($localFiles) - 1] : null;
    //dd($lastLocalBackup);
    if($lastLocalBackup['name']) $lastLocalBackup['modified'] = Storage::lastModified($lastLocalBackup['name']);
    if($lastLocalBackup['name']) $lastLocalBackup['size'] = Storage::size($lastLocalBackup['name']);
    //dd(Storage::lastModified($lastLocalBackup));
    return view('admin.backups.index', compact('gdFiles', 'localFiles', 'lastLocalBackup'));
  }

  public function store()
  {
    Artisan::call('backup:run');
    Log::channel('artisan')->debug(Artisan::output());
    return redirect()->route('admin.backups')->with('msg', 'Новый локальный бэкап сделан');
  }

  public function gdStore()
  {
    $backupFiles = Storage::files(config('app.name'));
    $mostRecentBackup = $backupFiles[count($backupFiles) - 1];

    //$driveFileName = "backup-" . str_replace(config('app.name') . "/", '', $mostRecentBackup);
    $driveFileName = "backup-" . str_replace("/", '-', $mostRecentBackup);
    //dd($driveFileName);
    $googleDrive = new GoogleDrive();

    $files = ($googleDrive->searchForFiles());
    $files = $files[0];
    // если больше пяти бэкапов, самый старый удаляем.
    if (count($files) >= 5) {
      usort($files, function ($a, $b) {
        return strtotime($a->modifiedTime) > strtotime($b->modifiedTime);
      });
      $oldestBackup = $files[0];
      $googleDrive->deleteFile($oldestBackup->id);
    }

    $fileId = $googleDrive->uploadToFolder(config('app.google_upload_folder_id'), [
      'drive_name' => $driveFileName,
      'mime' => 'application/zip',
      'content' => file_get_contents(
        base_path() . "/storage/app/private/$mostRecentBackup"
      )
    ]);
    if ($fileId) {
      //уведомление о бэкапе, например
      Log::channel('cron')->debug('New backup successfully uploaded on Google Drive');
    }
    return redirect()->route('admin.backups')->with('msg', 'Последний локальный бэкап залит на Google Drive');
  }
}

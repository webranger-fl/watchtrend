<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use App\Helpers\GoogleDrive;


class StoreBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:store-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store backup to Google Drive';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $backupFiles = Storage::files(config('app.name'));
        $mostRecentBackup = $backupFiles[count($backupFiles) - 1];
        //$mostRecentBackup = $backupFiles[0];
        // если бэкапов больше трех, удалим лишний
        if(count($backupFiles) > 3) {
            $oldestBackup = $backupFiles[0];
            Storage::delete($oldestBackup);
        }
        //$driveFileName = "backup-" . str_replace(config('app.name') . "/", '', $mostRecentBackup);
        $driveFileName = "backup-" . str_replace("/", '-', $mostRecentBackup);
        //dd($driveFileName);

        $googleDrive = new GoogleDrive();
        // по хорошему нужен будет тип загрузки resumable, просто еще не разобрался с ним
        // а также смотреть сколько бэкапов уже в папке, старые удалять
        $files = ($googleDrive->searchForFiles());
        $files = $files[0];
        // если больше пяти бэкапов, самый старый удаляем
        if(count($files) >= 5) {
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
        if($fileId) {
            //уведомление о бэкапе, например
            Log::channel('cron')->debug('New backup successfully uploaded on Google Drive');
        }
        
    }
}

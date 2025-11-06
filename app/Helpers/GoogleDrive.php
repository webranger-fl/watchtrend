<?php

namespace App\Helpers;
use Google\Client;
use Google\Service\Drive;

use Illuminate\Support\Facades\Http;

class GoogleDrive {

    public $driveService;

    public function __construct() {
        $client = new Client();
        //$client->useApplicationDefaultCredentials();
        $client->setAuthConfig(config('app.google_application_credentials'));
        $client->addScope(Drive::DRIVE);
        $this->driveService = new Drive($client);
    }

    public function uploadToFolder($folderId, $fileInfo, $resumable = false) {
    try {
        $fileMetadata = new Drive\DriveFile(array(
            'name' => $fileInfo['drive_name'],
            'parents' => array($folderId)
        ));
        //$content = file_get_contents(base_path() . "/phpunit.xml");
        $file = $this->driveService->files->create($fileMetadata, array(
            'data' => $fileInfo['content'],
            'mimeType' => $fileInfo['mime'],
            'uploadType' => !$resumable ? 'multipart' : 'resumable',
            'fields' => 'id'));
        //printf("File ID: %s\n", $file->id);
        return $file->id;
    } catch (Exception $e) {
        echo "Error Message: " . $e;
    }
}

    public function deleteFile($fileId) {
        try {
            //$file = $this->driveService->files->delete(array('fileId' => $fileId));
            $file = $this->driveService->files->delete($fileId);
            //return $file->id;
        } catch (Exception $e) {
            echo "Error Message: " . $e;
        }
    }

    public function searchFiles() {
    try {
        $files = [];
        $pageToken = null;
        do {
            $response = $this->driveService->files->listFiles([
                'q' => "mimeType='application/vnd.google-apps.folder'",
                'spaces' => 'drive',
                'pageToken' => $pageToken,
                'fields' => 'nextPageToken, files(id, name)',
            ]);
            foreach ($response->files as $file) {
                printf("Found file: %s (%s)\n", $file->name, $file->id);
            }
            array_push($files, $response->files);

            $pageToken = $response->pageToken;
        } while ($pageToken != null);
        return $files;
    } catch(Exception $e) {
       echo "Error Message: ".$e;
    }
}

public function searchForFiles() {
    try {
        $files = [];
        $pageToken = null;
        do {
            $folderId = config('app.google_upload_folder_id');
            $response = $this->driveService->files->listFiles([
                'q' => "mimeType='application/zip' and '$folderId' in parents",
                'spaces' => 'drive',
                'pageToken' => $pageToken,
                'fields' => 'nextPageToken, files(id, name, modifiedTime, size)',
            ]);
            foreach ($response->files as $file) {
                //printf("Found file: %s (%s)\n", $file->name, $file->id);
            }
            array_push($files, $response->files);

            $pageToken = $response->pageToken;
        } while ($pageToken != null);
        return $files;
    } catch(Exception $e) {
       echo "Error Message: ".$e;
    }
}

  
    public static function createFolder() {
        try {
            $client = new Client();
            $client->useApplicationDefaultCredentials();
            $client->addScope(Drive::DRIVE);
            $driveService = new Drive($client);
            $fileMetadata = new Drive\DriveFile(array(
                'name' => 'Invoices',
                'mimeType' => 'application/vnd.google-apps.folder'));
            $file = $driveService->files->create($fileMetadata, array(
                'fields' => 'id'));
            //printf("Folder ID: %s\n", $file->id);
            return $file->id;
    
        }catch(Exception $e) {
           echo "Error Message: ".$e;
        }
    }

    /*try {
            $client = new Google\Client();
            $client->useApplicationDefaultCredentials();
            $client->addScope(Google\Service\Drive::DRIVE);
            $driveService = new Google\Service\Drive($client);
            $fileMetadata = new Google\Service\Drive\DriveFile(array('name' => 'phpunit.xml'));
            $content = file_get_contents(base_path() . "/phpunit.xml");
            $file = $driveService->files->create($fileMetadata, array(
                'data' => $content,
                'mimeType' => 'application/xml',
                'uploadType' => 'multipart',
                'fields' => 'id'));
            dd($file->id);
        } catch(Exception $e) {
            echo "Error Message: ".$e;
        } */
        /*$client = new Google\Client();
        // авторизация через сервисный аккаунт
        $client->useApplicationDefaultCredentials();
        $client->addScope(Google\Service\Drive::DRIVE);*/
        // returns a Guzzle HTTP Client
        /*$httpClient = $client->authorize();
        //dd($httpClient);
        //dd(file_get_contents(base_path() . "/phpunit.xml"));
        //$response = $httpClient->post('https://www.googleapis.com/upload/drive/v3/files', [
        $response = $httpClient->post('https://www.googleapis.com/upload/drive/v3/files?uploadType=resumable', [
            //'uploadType' => 'resumable'
            'file' => file_get_contents(base_path() . "/phpunit.xml")
        ]);
        dd($response->getBody());*/
        //dd($client);
        //$client->setApplicationName("My Application");
        //$client->setDeveloperKey("MY_SIMPLE_API_KEY");
        // это у нас OAuth, пока закомментируем
        /*$client->setAuthConfig(base_path() . '/speedy-district-415812-9627e8e345c6.json');
        $client->addScope(Google\Service\Drive::DRIVE);
        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        $client->setRedirectUri($redirect_uri);
        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        }*/
  


}
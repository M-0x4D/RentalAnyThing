<?php

namespace MvcCore\Rental\Services;

use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Support\Filesystem\DirectoryComposer;
use MvcCore\Rental\Validations\Alerts;
use MvcCore\Rental\Support\Debug\Debugger;


class UploadingService
{
    public function uploadFile($file, $folder)
    {
        
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = ['jpg', 'jpeg', 'png'];

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000_000) {
                    $fileNameNew = uniqid() . "." . $fileActualExt;
                    // check $folder is existed

                    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/mediafiles';

                    $dirname = $uploadPath . '/' . $folder . '/';
                    if (!file_exists($dirname)) {
                        mkdir($uploadPath . '/' . $folder . '/', 0777);
                    }

                    $fileDestination = $dirname . $fileNameNew;

                    move_uploaded_file($fileTmpName, $fileDestination);

                    return $fileNameNew;
                    // end here
                } else {
                    Response::json([
                        'message' => 'file size is too big',
                    ], 02);
                    Alerts::show('warning', 'file size is too big', 'Error:');
                }
            } else {
                Response::json([
                    'message' => 'Error while uploading file',
                ], 02);
                Alerts::show('warning', 'Error while uploading file', 'Error:');
            }
        } else {
            Response::json([
                'message' => 'file extension is not allowed',
            ], 02);
            Alerts::show('warning', 'file extension is not allowed', 'Error:');
        }
    }
    public function get_path($uploadPath)
    {

        try {

            $uploadTmp = '/mediafiles/'. $uploadPath . '/';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $uploadTmp;
    }


    public function fakerImage($folder, $image,$url)
    {
        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/mediafiles';

        $dirname = $uploadPath . '/' . $folder . '/';
        if (!file_exists($dirname)) {
            mkdir($uploadPath . '/' . $folder . '/', 0777);
        }

        $imagePath = $dirname . $image;

        $fp = fopen($imagePath, 'w+');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_exec($ch);

        curl_close($ch);
        fclose($fp);
    }

    public function load_resources()
    {
        $loadingPathFrom = $_SERVER['DOCUMENT_ROOT'] . '/plugins/TecSeeProductsRentalBooking/Src/Resources';
        $loadingPathTo = $_SERVER['DOCUMENT_ROOT'] . '/mediafiles/Resources';
        exec("cp -r $loadingPathFrom $loadingPathTo");
    }

    public function unload_resources()
    {
        $unLoadingPath = $_SERVER['DOCUMENT_ROOT'] . '/mediafiles/Resources';
        exec("rm -r $unLoadingPath");
    }


    public function deleteFile($file,$folder)
    {

        $rootPath = $_SERVER['DOCUMENT_ROOT'] . '/mediafiles';
        $directory = $rootPath . '/' . $folder;
        $fileName = $directory . '/' . $file;
        if(file_exists($fileName)) {
            unlink($fileName);
            return 'file deleted successfully';
        }
        else {
            return 'file not exists';
        }
    }
}

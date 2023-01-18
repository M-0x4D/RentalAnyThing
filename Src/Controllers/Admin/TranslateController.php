<?php

namespace MvcCore\Rental\Controllers\Admin;


use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Support\Http\Request;
use JTL\Shop;
use MvcCore\Rental\Support\Facades\Filesystem\DirectoryComposer;
use MvcCore\Rental\Support\Facades\Localization\Translate;
use MvcCore\Rental\Requests\TranslateRequest;

    class TranslateController
    {

    /**
     * list lang
     *
     * @param Request $request
     * @param integer $pluginId
     * @return Response
     */
        public function index(Request $request)
        {
            $validation = $request->all();
            $lang = $validation['language'];
            $directoryComposer = new DirectoryComposer();
            if ($handle = opendir("{$directoryComposer->plugin_root()}/Src/Langs/{$lang}")) {
                while (false !== ($entry = readdir($handle))) {
    
                    if ($entry != "." && $entry != "..") {
                        $json[] = $entry;
                        foreach ($json as $key) {
                            $fileNameBaseExtension = basename($key, '.json');
                            $fileName = file_get_contents("{$directoryComposer->plugin_root()}/Src/Langs/{$lang}/{$fileNameBaseExtension}.json");
                            $fileName = json_decode($fileName, true);
                        }
                        $jsons["$fileNameBaseExtension"] = $fileName;
                    }
                }
    
                closedir($handle);
            }
            return Response::json(['message' => 'translate are loaded successfully', 'translate' => $jsons], 200);
        }


    /**
     * store a room
     *
     * @param Request $request
     * @return Response
     */
        public function set_translation()
    {
        $request = new TranslateRequest;
        $validationDate = $request->validate();
        $lang = $validationDate['language'];
        $fileName = $validationDate['categories'];
        $key = $validationDate['key'];
        $value = $validationDate['value'];
        $translate = (new Translate)->setValue($lang, $fileName, $key, $value);

        return Response::json(['message' => 'translate is set successfully', 'translate' => $translate], 200);
    }
    }
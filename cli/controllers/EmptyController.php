<?php

namespace ox4D\cli\Controllers;

// require_once __DIR__.'/requireFile.php';
class EmptyController
{

    protected static $fileName;

    public static function runCommand($fileName)
    {

        $dir = __DIR__ . '/../../Src/Controllers/Admin/';
        self::$fileName = $dir.$fileName;
        $myfile = fopen(self::$fileName.".php", "w") or die("Unable to create file!");
        $txt = "<?php

namespace MvcCore\Rental\Controllers\Admin;


use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Support\Http\Request;
use JTL\Shop;
   
    class $fileName
    {

    }";
        fwrite($myfile, $txt);
        fclose($myfile);
        echo "[+] $fileName Empty Controller File created successfully!\n";

    }
}
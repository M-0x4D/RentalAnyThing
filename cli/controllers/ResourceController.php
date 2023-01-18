<?php

namespace ox4D\cli\Controllers;

class ResourceController
{
    /***
     * 
     * file name property
     */
    protected static $fileName;

    public static function runCommand($fileName)
    {
        $dir = __DIR__ . '/../../Src/Controllers/Admin/';
        self::$fileName = $dir.$fileName;
        $interfaceFile = "$dir/ICrud.php";
        if (!file_exists($interfaceFile)) {
            $myfile = fopen($interfaceFile, "w") or die("Unable to create interface!");
        $request='$'.'request';
        $txt = "<?php

namespace MvcCore\Rental\Controllers\Admin;

use MvcCore\Rental\Support\Http\Request;



    interface ICrud
    {

        /***
         * 
         * index function
         */
        public function index();
        /***
         * 
         * create function
         */
        public function create(Request $request);

        /***
         * 
         * update function
         */
        public function update(Request $request);

        /***
         * 
         * destroy function
         */
        public function destroy(Request $request);

    }";
        fwrite($myfile, $txt);
        fclose($myfile);
        echo "Icrud interface created successfully\n";
        }
        $myfile = fopen(self::$fileName.".php", "w") or die("Unable to create resource!");
        $request = '$' . 'request';
        $smarty = '$' . 'smarty';
        $data = '$' . 'data';
        $all = 'all';
        $assign = 'assign';
        $txt = "<?php
namespace MvcCore\Rental\Controllers\Admin;


use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Controllers\Admin\ICrud;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Support\Http\Request;
use JTL\Shop;
   
    class $fileName implements ICrud
    {
        public function index()
        {
            $smarty = Shop::Smarty();
            return $smarty->$assign('',);
        }
    
    
        public function create(Request $request)
        {
            $data = $request->$all();

        return response()->json(' created succefully' , 201);
        }
    
    
        public function update(Request $request)
        {
            $data = $request->$all();

        return response()->json(' updated succefully' , 206);
        }
    
    
        public function destroy(Request $request)
        {
            $data = $request->$all();

        return response()->json(' deleted succefully' , 204);
        }
        
        }";
        fwrite($myfile, $txt);
        fclose($myfile);
        echo "[+] $fileName Resource Controller File created successfully!\n";

    }
}

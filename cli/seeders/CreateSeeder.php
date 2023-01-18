<?php

namespace ox4D\cli\Seeders;

class CreateSeeder
{
    protected static $fileName;

    public static function runCommand($fileName)
    {
        $dir = __DIR__ . '/../../Src/Database/Seeders/';
        self::$fileName = $dir.$fileName;
        $myfile = fopen(self::$fileName.".php", "w") or die("Unable to create file!");
        $variable = '$'.'variable';
        $variables = '$'.'variables';
        $txt = "<?php

namespace MvcCore\Rental\Database\Seeders;

use MvcCore\Rental\Support\Debug\Debugger;

        
    class $fileName
    {
    
        public function create()
        {
            $variables = [];
            array_map(fn ($variable) => 'Write your code here!', $variables);
            
        }
    }";
        fwrite($myfile, $txt);
        fclose($myfile);
        echo "[+] $fileName Seeder created successfully!\n";

    }
}
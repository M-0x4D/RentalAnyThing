<?php

namespace ox4D\cli\Models;

class CreateModel
{
    protected static $fileName;

    public static function runCommand($fileName)
    {
        $dir = __DIR__ . '/../../Src/Models/';
        self::$fileName = $dir.$fileName;
        $myfile = fopen(self::$fileName.".php", "w") or die("Unable to create file!");
        $table = '$' . 'table';
        $timestamps = '$'.'timestamps';
        $fillable = '$'.'fillable';
        $txt = "<?php

namespace MvcCore\Rental\Models;

use Illuminate\Database\Eloquent\Model;

    class $fileName extends Model 
    {

        protected $table = '';
        public $timestamps = true;
        protected $fillable = [];


    }";
        fwrite($myfile, $txt);
        fclose($myfile);
        echo "[+] $fileName Model created successfully!\n";

    }
}
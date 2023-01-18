<?php

namespace ox4D\cli\Migrations;

class CreateMigration
{

    protected static $fileName;
    public static function create($fileName)
    {
        $dir = __DIR__ . '/../../Src/Database/Migrations/';
        self::$fileName = $dir.$fileName;
        $myfile = fopen(self::$fileName.".php", "w") or die("Unable to create file!");
        $table = '$' . 'table';
        $dollarSignThis = '$'.'this';
        $call = 'call';
        $string = 'string';
        $id = 'id';
        $timestamps = 'timestamps';
        $txt = "<?php

namespace MvcCore\Rental\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

    class $fileName {

        public function up()
        {
            Capsule::schema()->create('', function ($table) {
                $table->$id();
                $table->$string('');
                $table->$timestamps();
            });
        }

        public function down()
        {
            Capsule::schema()->dropIfExists('');
        }
    }";
        fwrite($myfile, $txt);
        fclose($myfile);




        /***
         * 
         * push new migration into DataBaseMigration file
         * 
         */

         $databaseMigrationFile =  __DIR__ . '/../../Src/Database/Migrations/DataBaseMigrations.php';
        $databaseMigrationFileHandle = fopen($databaseMigrationFile, "w+") or die("Unable to create file!");
        $newMigrations=[];
        $content = "<?php

namespace MvcCore\Rental\Database\Migrations;

use MvcCore\Rental\Database\Initialization\Migration;
        
    class DataBaseMigrations extends Migration
    {
        public function up()
        {
                $dollarSignThis->$call([
                PaymentApiCredentialsTable::class,
                TokenParametersTable::class,
                OrderLinksTable::class,
                ColorsTable::class,
                LocationsTable::class,
                CategoriesTable::class,
                RentalsTable::class,
                ObjectsTable::class,
                LabelsTable::class,
                ImagesTable::class , 
                BanarImageTable::class,
                UnBookedObjectsTable::class,
                DescriptionTable::class,
                CurrenciesTable::class
    
            ], 'up'); 
        }
    
    
        public function upExtention()
        {
            $dollarSignThis->$call([
                $fileName::class,
            ], 'up');
        }
    
        public function down()
        {
            $dollarSignThis->$call([
                PaymentApiCredentialsTable::class,
                TokenParametersTable::class,
                OrderLinksTable::class,
                ColorsTable::class,
                RentalsTable::class,
                LabelsTable::class,
                FeatureObjectTable::class,
                ImagesTable::class,
                ObjectsTable::class,
                LocationsTable::class,
                CategoriesTable::class,
                FeaturesTable::class,
                BanarImageTable::class,
                UnBookedObjectsTable::class, 
                DescriptionTable::class,
                CurrenciesTable::class
    
            ], 'down');
        }
    
    
        public function downExtention()
        {
            
            $dollarSignThis->$call([
                $fileName::class,
            ], 'down');
            
        }
    }";

    fwrite($databaseMigrationFileHandle, $content);
        fclose($databaseMigrationFileHandle);

        echo "[+] Create Table $fileName migration File created successfully!\n";

    }


    public function update($fileName)
    {

    }


    public function delete($fileName)
    {

    }
}
<?php

namespace ox4D\cli\Migrations;

use MvcCore\Rental\Database\Migrations\DataBaseMigrations;
class migrate
{

    public static function create()
    {

        // echo __DIR__.'\sshConnect.bat'.PHP_EOL;
        // exec('call ssh ssh-w01d5aea@v1158262.kasserver.com');
        // system("cmd /k ".__DIR__."\sshConnect.bat");
        // popen("call ssh ssh-w01d5aea@v1158262.kasserver.com", "r");
        $migration = new DataBaseMigrations();
        $migration->upExtention();
        echo ' [+] Migration Created Successfully!';
    }


    function update($fileName)
    {

    }

    function delete()
    {
        $migration = new DataBaseMigrations();
        $migration->downExtention();

    }
}
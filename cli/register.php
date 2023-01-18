<?php

use MvcCore\Rental\Support\Debug;
use ox4D\cli\controllers\EmptyController;
use ox4D\cli\controllers\ResourceController;
use ox4D\cli\migrations\CreateMigration;
use ox4D\cli\models\CreateModel;
use ox4D\cli\migrations\migrate;
use ox4D\cli\requests\CreateRequest;

require_once __DIR__ . '/requireFile.php';
// require_once __DIR__.'/MakeController/EmptyController.php';

function  excute($command, $fileName)
{
    // ReflectionMethod::isStatic();

    $sysCommands = require_once __DIR__ . '/commands.php';
    foreach ($sysCommands as $keyX => $valueX) {
        if ($keyX === $command) {
            $controller = $valueX[0];
            $method = $valueX[1];
            $reflection = new ReflectionMethod($controller , $method);
            $res = $reflection->isStatic();
            if ($res) {
                $controller::$method($fileName);
            }else {
                $obj = new $controller();
                $obj->$method($fileName);
            }
        }
    }
}


function executeMigrate($command)
{
    $sysCommands = require_once __DIR__ . '/commands.php';
    foreach ($sysCommands as $keyX => $valueX) {

        if ($keyX === $command) {
            $controller = $valueX[0];
            $method = $valueX[1];
            $reflection = new ReflectionMethod($controller , $method);
            $res = $reflection->isStatic();
            if ($res) {
                $controller::$method();
            }else {
                $obj = new $controller();
                $obj->$method();
            }
        }
    }

}

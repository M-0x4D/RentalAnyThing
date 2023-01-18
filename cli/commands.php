<?php
use ox4D\cli\Controllers\EmptyController;
use ox4D\cli\Controllers\ResourceController;
use ox4D\cli\Migrations\CreateMigration;
use ox4D\cli\Models\CreateModel;
use ox4D\cli\Migrations\migrate;
use ox4D\cli\Requests\CreateRequest;
use ox4D\cli\Seeders\CreateSeeder;
use ox4D\cli\help\Help;

return [

    '--help' => [Help::class,'runCommand'],
    '-h'=>[Help::class,'runCommand'],
    '-make:migration' => [CreateMigration::class, 'create'],
    '-make:migrate' =>[migrate::class,'create'],
    '-make:resource' =>[ResourceController::class,'runCommand'],
    '-make:empty' => [EmptyController::class, 'runCommand'],
    '-make:seeder' => [CreateSeeder::class, 'runCommand'],
    '-make:model' => [CreateModel::class, 'runCommand'],
    '-make:request' => [CreateRequest::class, 'runCommand'],
    '-add:command' => []
];
<?php
namespace ox4D\cli\help;
class Help
{
    function runCommand()
    {
        $commands = require_once __DIR__.'/helpContent.php';
        foreach ($commands as $key => $value) {
            echo $key.'  =>  '.$value."\n";
        }
    }
}
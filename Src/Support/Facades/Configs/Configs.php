<?php

namespace MvcCore\Rental\Support\Facades\Configs;

use MvcCore\Rental\Support\Facades\Filesystem\DirectoryComposer;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Support\Debug\Debugger;


class Configs
{
    private array $configs = [];

    public function __construct()
    {

        $directoryComposer = new DirectoryComposer();
        $lines  = file("{$directoryComposer->plugin_root()}/.env");
        $keys   = [];
        $values = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === PHP_EOL || stripos($line, '#') === 0) {
                continue;
            }
            if (stripos($line, PHP_EOL)) {
                [$line,] = explode(PHP_EOL, $line);
            }
            [$keys[], $values[]] = explode('=', $line);
        }
        $this->configs = array_combine($keys, $values);
    }


    public function get_configs(): array
    {
        return $this->configs;
    }

    function setEnv($key, $mode)
    {
        $directoryComposer = new DirectoryComposer();
        if (array_key_exists($key, $this->configs)) {
            $this->configs[$key] = $mode;
            $configCopy = $this->configs;
            
            array_walk($configCopy, function (&$value, $key) {
                $value = "{$key}={$value}";
            });
            file_put_contents("{$directoryComposer->plugin_root()}/.env", implode("\n", $configCopy));
        }

    }

    function getEnvValue($key)
    {
        if (array_key_exists($key, $this->configs)) {
            return $this->configs[$key];
        }
        return NULL;
    }

}

<?php

namespace MvcCore\Rental\Support\Facades\Configs;

use MvcCore\Rental\Support\Facades\Filesystem\DirectoryComposer;

class ConfigurationsLoader
{
    private array $configs = [];

    public function __construct(string $path)
    {
        $lines  = file("$path/.env");
        $keys   = [];
        $values = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (!$line) {
                continue;
            }
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

    public function get(string $key): ?string
    {
        return key_exists($key, $this->configs) ? (string) $this->configs[$key] : null;
    }
}

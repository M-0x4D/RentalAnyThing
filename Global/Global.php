<?php

use GlobalFunctions\GlobalHelper;
use MvcCore\Rental\Models\Rental;
use MvcCore\Rental\Models\User;
use MvcCore\Rental\Support\Facades\Filesystem\DirectoryComposer;
use MvcCore\Rental\Helpers\Redirect;
use MvcCore\Rental\Support\Debug\Debugger;
use JTL\Session\AbstractSession;
use JTL\Session\Frontend;
use MvcCore\Rental\Helpers\Response;
use JTL\Shop;
use MvcCore\Rental\Models\Admin;



// use GlobalFunctions\ViewsHelper;
require_once __DIR__ . '/GlobalHelper.php';

/**
 * for executeHook function
 */
// require PFAD_ROOT . PFAD_INCLUDES . 'bestellabschluss_inc.php';




/**
 * Global variables and constants
 * 
 */
define('TESTGLOBAL', 'testGlobalValue');


$smartyParameters = [];




/**
 * read data from .env file
 * 
 * @param string $key
 */
function readEnv($key): string
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
    $configs = array_combine($keys, $values);
    if (array_key_exists($key, $configs)) {
        return $configs[$key];
    }
    return NULL;
}

/**
 * set key&value into .env file
 * 
 * @param string $key
 * @param string $value
 */
function setEnv($key, $value): void
{
    $directoryComposer = new DirectoryComposer();
    $configs[$key] = $value;
}

/**
 * check if key exists in .env file or not
 * 
 * @param string $key
 * @return boolean $value
 */
function checkEnvKey($key)
{
}


function executePluginHook(string $HOOK, array $params)
{

    $Hooks = require_once __DIR__ . '/../PluginHook/HOOKS.php';
    foreach ($Hooks as $hook => $action) {
        if ($hook === $HOOK) {
            $method = $action[1];
            $action[0]::$method($params);
        }
    }
}


function redirect()
{
    return GlobalHelper::redirect();
}


function view(string $route)
{
    if (str_contains($route, '/')) {
        # code...
        Redirect::homeWith($route);
    } else {
        Redirect::homeWith("/$route");
    }
}

function session()
{
    return GlobalHelper::session();
}
function response()
{
    return GlobalHelper::response();
}

function dda($params)
{
    Debugger::die_and_dump(Response::json($params));
}


function adminName()
{
    $admin = Admin::where('kAdminlogin', 1)->first();
    return $admin->cName;
}
function adminEmail()
{
    $admin = Admin::where('kAdminlogin', 1)->first();
    return $admin->cMail;
}
function userName()
{
    $customer          = Frontend::getCustomer();
    $customerId = $customer->kKunde;
    $user = User::where('kKunde', $customerId)->first();
    return $user->cVorname;
}


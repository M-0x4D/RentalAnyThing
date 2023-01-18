<?php

namespace MvcCore\Rental\Controllers;

use MvcCore\Rental\Support\Facades\Configs\Configs;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Requests\LicenseRequest;
use MvcCore\Rental\Support\Facades\Filesystem\DirectoryComposer;
use SimpleXMLElement;
use JTL\Shop;
use MvcCore\Rental\Support\Http\HttpRequest;
use MvcCore\Rental\Support\Http\Request;

class LicenseController
{
    public function verify(Request $request)
    {
        $validatedData = (new LicenseRequest())->validate($request->all());
        $hostLicenses = (new Configs())->get_configs()['HOST_LICENSES'];
        $httpClient = new HttpRequest($hostLicenses);

        $response = (string) $httpClient->post('/modules/servers/licensing/check_license', 'Guest', $validatedData, [
            'content-type' => 'application/xml'
        ]);
        
        $response = new SimpleXMLElement($response);
        $response = current((array) $response);
      
        if ($response === 'Valid') {
            $directoryComposer = new DirectoryComposer();
            $licensesFile = "{$directoryComposer->plugin_root()}/.licenses";
            $encryptedLicense = sha1($validatedData['licensekey']);
            $text = "Licenses Status: $response\nKey: $encryptedLicense";
            file_put_contents($licensesFile, $text);
            return Response::json([
                'message' => 'licenses is valid your plugin is activated'
            ], 201);
        }
        if ($response === 'Invalid') {
            return Response::json([
                'message' => 'licenses is Invalid please contact support team'
            ], 422);
        }
        
    }

    public function index(Request $request)
    {
        $smarty        = Shop::Smarty();
        $directoryComposer = new DirectoryComposer();
        
        $licensesFile = "{$directoryComposer->plugin_root()}/.licenses";
        file_exists($licensesFile) ? $smarty->assign('licensesFile', true) : $smarty->assign('licensesFile', false);
    }
}

<?php
namespace MvcCore\Rental\Controllers\Frontend;

use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Support\Filesystem\DirectoryComposer;
use JTL\Shop;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Support\Facades\Localization\Translate;

class Translation
{
    function handle()
    {
        $arrContent = Translate::getTranslations('frontend');
        // Debugger::die_and_dump($arrContent);
        $samrty = Shop::Smarty();
        $samrty->assign ('translations' , $arrContent);
       
    }
}
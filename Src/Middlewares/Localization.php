<?php

namespace Plugin\TecSeeProductsRentalBooking\Src\Middlewares;

use Plugin\TecSeeProductsRentalBooking\Src\Support\Translate;
use JTL\Shop;

class Localization
{
    public static function handle()
    {
        $smarty        = Shop::Smarty();

        $translations = Translate::getTranslations('frontend');

        $smarty->assign('translations', $translations);
    }
}

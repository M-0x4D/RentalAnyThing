<?php

declare(strict_types=1);

namespace Plugin\TecSeeProductsRentalBooking;

use InvalidArgumentException;
use JTL\Shop;
use MvcCore\Rental\Support\Debug\Debugger;
use PhpParser\Node\Expr\Cast\Object_;

/**
 * Class AdminRender
 * @package Plugin\TecSeeProductsRentalBooking
 */
class AdminRender
{
 
 

      /**
     * @var path
     */
    private $plugin;

    /**
     * @var path
     */
    private $path;

    /**
     * templates of the admin menu
     *
     * @var array
     */
    private array $templates;

    /**
     * AdminRender constructor.
     * @param Object $plugin
     */
    public function __construct(Object $plugin)
    {
        $this->plugin = $plugin;
        $this->path   = $this->plugin->getPaths()->getAdminPath() . 'templates/';
        $this->templates = [
            'Object_Categories' => 'categories/index.tpl',
            'Object_Colors' => 'color/index.tpl',
            'Object_Countries' => 'country/index.tpl',
            'Object_Provinces' => 'province/index.tpl',
            'Object_Cities' => 'city/index.tpl',
            'Currency' => 'currency/index.tpl',
            'Objects' => 'objects/index.tpl',
            'Main_Banner' => 'mainBanner/index.tpl',
            'Translations' => 'translations/layout.tpl',
            'Api_Credentials' => 'apiCredentials/index.tpl',
        ];
    }

    /**
     * @param string    $template
     * @param int       $menuID
     * @param Object $smarty
     * @return string
     * @throws \SmartyException
     */
    public function renderPage(string $template , Object $smarty): string
    {
        // $smarty = Shop::Smarty();
        $smarty->assign('pluginPath', $this->plugin->getPaths()->getAdminURL());

        $smarty->assign('pluginURL', $this->plugin->getPaths()->getShopURL());

        $smarty->assign('pluginId', $this->plugin->getId());

        $template = $this->path . $this->templates[$template];
 
        return $smarty->fetch($template);
    }
}

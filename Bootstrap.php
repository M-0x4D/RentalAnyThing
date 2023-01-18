<?php

declare(strict_types=1);
namespace Plugin\TecSeeProductsRentalBooking;
// define('TESTCONST','TEST CONST');

// use Illuminate\Support\Facades\Request;
use JTL\Events\Dispatcher;
use JTL\Link\LinkInterface;
use JTL\Plugin\Bootstrapper;
use JTL\Smarty\JTLSmarty;
use MvcCore\Rental\Controllers\Frontend\Test;
use MvcCore\Rental\Services\InstallService;
use Plugin\TecSeeProductsRentalBooking\AdminRender;
use MvcCore\Rental\Services\RoutesService;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Support\Http\Session;
use MvcCore\Rental\Support\Plugin;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Support\Facades\Configs\ConfigurationsLoader;
use Shop;
require_once __DIR__ .'/vendor/autoload.php';
require_once __DIR__ . '/Global/Global.php';

/**
 * Class Bootstrap
 * @package Plugin\TecSeeProductsRentalBooking
 */
class Bootstrap extends Bootstrapper
{
    private $routesService;

    /**
     * @inheritdoc
     */
    public function boot(Dispatcher $dispatcher)
    {
        
        parent::boot($dispatcher);
        $plugin = new Plugin;
        $plugin->set_plugin($this->getPlugin());
        $this->routesService = new RoutesService();
        if (Shop::isFrontend()) {

            // before request is proceed
            $dispatcher->listen('shop.hook.' . \HOOK_IO_HANDLE_REQUEST, function () use ($plugin) {
                $request = new Request;
                $io = $request->all()['io'] ?? null;
                $configurationLoader = new ConfigurationsLoader($plugin->get_plugin()->getPaths()->getBasePath());

                if ($io === $configurationLoader->get('ENTRY_POINT')) {
                    $this->routesService->frontend_endpoints();
                }
            }, 1);

            // before loading the template
            $dispatcher->listen('shop.hook.' . \HOOK_SMARTY_FETCH_TEMPLATE, fn () => $this->routesService->frontend_executions(), 1);
        } else {
            
            $dispatcher->listen('shop.hook.' . \HOOK_IO_HANDLE_REQUEST_ADMIN, function () use ($plugin) {
                $request = new Request;
                $io = $request->all()['io'] ?? null;
                $configurationLoader = new ConfigurationsLoader($plugin->get_plugin()->getPaths()->getBasePath());
                if ($io === $configurationLoader->get('ENTRY_POINT')) 
                {
                    $this->routesService->backend_endpoints();
                }
            }, 1);
        }
    }

    /**
     * @inheritdoc
     */
    public function installed()
    {
        parent::installed();

        $withInstall = new InstallService();
        $withInstall->install();
    }

    /**
     * 
     * it's migrate database tables when plugin 
     */

    public function enabled()
    {
    }

    public function uninstalled(bool $deleteData = false)
    {
        if ($deleteData === true) {
            $deleteTables = new InstallService();
            $deleteTables->unInstall();
        }
    }
    /**
     * 
     * writing adminpanel routes for retriving data from database
     * @return string
     */
    public function renderAdminMenuTab(string $template, int $menuID, JTLSmarty $smarty): string
    {

        $this->routesService->backend_executions();

        $render = new AdminRender($this->getPlugin());
        return $render->renderPage($template,  $smarty);
    }

    /**
     * writing frontend routes for retrieving data from database
     */
    public function prepareFrontend(LinkInterface $link, JTLSmarty $smarty): bool
    {
        $this->routesService->frontend_process();
        parent::prepareFrontend($link, $smarty);

       
        return true;
    }

    /**
     * writing frontend routes for retrieving data from database
     */
    // public function prepareFrontend(LinkInterface $link, JTLSmarty $smarty): bool
    // {
    //     $this->routesService->frontend_process();
    //     parent::prepareFrontend($link, $smarty);
    //     return true;
    // }
}

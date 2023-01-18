<?php

namespace MvcCore\Rental\Services;

use MvcCore\Rental\Controllers\Admin\TranslateController;
use MvcCore\Rental\Support\Route;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Database\Initialization\Database;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Controllers\Frontend\Translation;
use MvcCore\Rental\Support\Http\Session;

class RoutesService
{

    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
        $this->database->connect();
    }


    public function frontend_executions()
    {
        Route::execute('LicenseController@index');
        // Route::execute('Frontend\LocationsController@locations');
        Route::execute('Frontend\CountryController@index');
        Route::execute('Frontend\GovernrateController@index');
        Route::execute('Frontend\CityController@index');
        Route::execute('Frontend\RentalsController@index');
        // Route::execute('Frontend\ReservationsController@rentals'); // my rental button
        Route::execute('Frontend\Translation@handle');
        Route::execute('Frontend\ObjectDetailsController@objectDetailsSmarty');
        Route::execute('Frontend\MainBanar@index');
        Route::execute('Frontend\CategoryController@index');
        // Route::execute('Frontend\ReservationsController@confirm_payment');
        Route::execute('Frontend\ReservationsController@pendingRentals');
        $session = new Session();
        if (empty($session->get_items('objects'))) {
            $session->add_items(['objects' => []]);
        }
        // Debugger::die_and_dump($session->get_session());
    }


    public function backend_executions()
    {
        Route::execute('Admin\LicenseController@index');
        Route::execute('Admin\CurrencyController@index');
        Route::execute('Admin\ColorsController@index');
        Route::execute('Admin\MainBanar@index');
        Route::execute('Admin\ApiCredentialsController@index');
        Route::execute('Admin\CategoryController@index');
        Route::execute('Admin\ObjectController@index');
        Route::execute('Admin\CountryController@index');
        Route::execute('Admin\GovernrateController@index');
        Route::execute('Admin\CityController@index');
    }

    public function backend_endpoints()
    {
        /* routes */
        Route::group(['VerifyCsrfToken'], function () {

            Route::post('create-api-credentials', 'Admin\ApiCredentialsController@create');
            Route::post('destroy-api-credentials', 'Admin\ApiCredentialsController@destroy');
            Route::post('update-api-credentials', 'Admin\ApiCredentialsController@update');

            Route::post('create-currency', 'Admin\CurrencyController@create');
            Route::post('update-currency', 'Admin\CurrencyController@update');
            Route::post('destroy-currency', 'Admin\CurrencyController@destroy');

            // country
            Route::post('create-country', 'Admin\CountryController@create');
            Route::post('update-country', 'Admin\CountryController@update');
            Route::post('destroy-country', 'Admin\CountryController@destroy');


            // governrate
            Route::post('create-governrate', 'Admin\GovernrateController@create');
            Route::post('update-governrate', 'Admin\GovernrateController@update');
            Route::post('destroy-governrate', 'Admin\GovernrateController@destroy');
            Route::post('governrates', 'Admin\GovernrateController@governratesForAdmin');



            // city
            Route::post('create-city', 'Admin\CityController@create');
            Route::post('update-city', 'Admin\CityController@update');
            Route::post('destroy-city', 'Admin\CityController@destroy');
            Route::post('cities', 'Admin\CityController@citiesForAdmin');



            Route::post('create-color', 'Admin\ColorsController@create');
            Route::post('destroy-color', 'Admin\ColorsController@destroy');
            Route::post('update-color', 'Admin\ColorsController@update');

            Route::post('translate', 'Admin\TranslateController@index');
            Route::post('set-translation', 'Admin\TranslateController@set_translation');


            Route::post('create-banar', 'Admin\MainBanar@create');
            Route::post('update-banar', 'Admin\MainBanar@update');
            Route::post('destroy-banner', 'Admin\MainBanar@destroy');

            // categories
            Route::post('create-category', 'Admin\CategoryController@create');
            Route::post('destroy-category', 'Admin\CategoryController@destroy');
            Route::post('update-category', 'Admin\CategoryController@update');
            Route::post('paginate-category', 'Admin\CategoryController@pagination');

            Route::post('create-Label', 'Admin\LabelController@create');
            Route::post('destroy-Label', 'Admin\LabelController@destroy');
            Route::post('update-Label', 'Admin\LabelController@update');

            Route::post('create-object', 'Admin\ObjectController@create');
            Route::post('destroy-object', 'Admin\ObjectController@destroy');
            Route::post('update-object', 'Admin\ObjectController@update');

            Route::post('/licensekey', 'Admin\LicenseController@verify');

            Route::post('/paypal-mode', 'Admin\SetPaypalMode@handle');
            // Route::post('/return-creds', 'Admin\SetPaypalMode@returnCreds');
        });

        Route::resolveApi(Request::uri(), Request::type());
    }

    public function frontend_endpoints()
    {

        Route::group([''], function () {
            Route::post('path', 'Frontend\Test@fake');
            Route::post('remove-product', 'Frontend\ObjectDetailsController@removeFromSession');
            Route::post('add-to-cart', 'Frontend\ObjectDetailsController@addToCart');
            Route::post('return-governrates', 'Frontend\CountryController@returnGovernrates');
            Route::post('return-cities', 'Frontend\GovernrateController@returnCities');
            Route::post('arrange-objects', 'Frontend\ObjectController@arrangeByPrice');
            Route::post('cron-job', 'Repository\CronJob@run');
            Route::post('licensekey', 'LicenseController@verify');
            Route::post('book-object', 'Frontend\ReservationsController@store'); //proceed
            Route::post('search-available-objects', 'Frontend\ObjectController@searchAvailableObjects');
            Route::post('filter-by-price', 'Frontend\ObjectController@filterByPrice');
            Route::post('filter-rentals-by-date', 'Frontend\RentalsController@filterRentalsByDate');
            Route::post('cancle-payment', 'Frontend\ReservationsController@canel_payment');
            Route::post('cancle-rental', 'Frontend\ReservationsController@cancle_rental');
            Route::post('cash-on-deliver', 'Frontend\ReservationsController@cash_on_delever');
        });
        Route::resolveApi(Request::uri(), Request::type());
    }

    function frontend_process()
    {
        // Route::get('car-details', 'Frontend\ObjectDetailsController@objectDetailsSmarty');
        Route::get('success', 'Frontend\ReservationsController@confirm_payment');
        // Route::get('cancel', 'Frontend\ReservationsController@canel_payment');
        // Route::get('product-details', 'Frontend\ObjectDetailsController@objectDetails');


        //     // Route::get('rental', 'Frontend\ReservationsController@rentals');
        try {
            Route::resolve(Request::uri(), Request::type());
        } catch (RouteNotFoundException $exception) {
            return Response::json(['message' => $exception->getMessage()], 404);
        } catch (DatabaseQueryException $exception) {
            return Response::json(['message' => $exception->getMessage()], 422);
        }
    }
}

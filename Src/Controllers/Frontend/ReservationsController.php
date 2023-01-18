<?php

namespace MvcCore\Rental\Controllers\Frontend;

use MailHelper;
use MvcCore\Rental\Helpers\Response;
use MvcCore\Rental\Models\Rental;
use MvcCore\Rental\Models\Car;
use MvcCore\Rental\Models\Image;
use MvcCore\Rental\Models\confirmPaymentLink;
use MvcCore\Rental\Models\TokenParameter;
use MvcCore\Rental\Models\OrderLink;
use MvcCore\Rental\Requests\ReservationStoreRequest;
use MvcCore\Rental\Requests\PaymentStoreRequest;
use Carbon\Carbon;
use MvcCore\Rental\Support\Facades\Localization\Lang;
use MvcCore\Rental\Controllers\Repository\FetchReservations;
use MvcCore\Rental\Controllers\Repository\InitiatePayment;
use MvcCore\Rental\Models\ApiCredentials;
use MvcCore\Rental\Controllers\TranslationsController;
use MvcCore\Rental\Helpers\Header;
use MvcCore\Rental\Helpers\Redirect;
use MvcCore\Rental\Support\Http\Request;
use JTL\Session\AbstractSession;
use JTL\Session\Frontend;
use MvcCore\Rental\Controllers\Repository\StoreOrder;
use MvcCore\Rental\Middlewares\VerifyUserLogin;
use MvcCore\Rental\Support\DisplayData;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Support\Http\HttpRequest;
use MvcCore\Rental\Support\Http\Server;
use JTL\Shop;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Support\Facades\Configs\Configs;
use MvcCore\Rental\Helpers\GetPaypalMode;
use MvcCore\Rental\Support\Http\Session;
use MvcCore\Rental\Support\Http\proxy;
use MvcCore\Rental\Helpers\ArrayToJson;
use MvcCore\Rental\Models\CacheModel;
use MvcCore\Rental\Models\Currency;
use MvcCore\Rental\Models\ObjectModel;
use MvcCore\Rental\Models\UnBookedObject;
use MvcCore\Rental\Support\Mail\MailService;

class ReservationsController
{
        public function store($totalPrice, $objectId, $customerId, $pickUpDate, $pickoffDate, $currencyId, $quantity)
        {

                $headerData = getallheaders();
                $token = $headerData['Jtl-Token'];
                /** payment process */
                $object = ObjectModel::where('id', $objectId)->first();
                $paymentVariables = [
                        'service_cost' => $totalPrice,
                        'service_currency' => $currencyId,
                ];
                // $validator = new PaymentStoreRequest;
                // $validatedData = $validator->validate($paymentVariables);
                $results = InitiatePayment::initiate();

                $tokenName = $results['tokenName'];
                $tokenType = $results['tokenType'];
                $baseUrl = GetPaypalMode::getPaypalUrl();
                $headers = [
                        "Content-Type: application/json",
                        "Authorization: $tokenType $tokenName"
                ];
                $url = Lang::get() === 'de' ? 'prozess' : 'process';
                $successUrl = Server::make_link("/$url?return=success");
                $cancelUrl = Server::make_link("/$url?return=cancel");
                $object = ObjectModel::where('id', $objectId)->first();
                $name = json_decode($object->name);
                $name = $name->en;
                $values = [
                        "intent" => "CAPTURE",
                        "purchase_units" => [
                                [
                                        "items" => [
                                                [
                                                        "name" => $object->name,
                                                        "description" => 'test',
                                                        "quantity" => '1',
                                                        "unit_amount" => [
                                                                "currency_code" => 'USD',
                                                                "value" => intval($totalPrice),
                                                        ]
                                                ]
                                        ],
                                        "amount" => [
                                                "currency_code" => 'USD',
                                                "value" => intval($totalPrice),
                                                "breakdown" => [
                                                        "item_total" => [
                                                                "currency_code" => 'USD',
                                                                "value" => intval($totalPrice),
                                                        ]
                                                ]
                                        ]
                                ]
                        ],
                        "application_context" => [
                                "cancel_url" => "$cancelUrl",
                                "return_url" => "$successUrl"
                        ]
                ];
                $jsonBody = json_encode($values);
                // //! proxy
                // $remoteEndPoint = "$baseUrl/v2/checkout/orders";
                // $proxy = new proxy('http' , $remoteEndPoint ,'127.0.0.1' , 8080 , $headers);                     
                // $proxy->useProxy( $values ,'post' ,$tokenType);
                // Proxy::useProxy( $values ,'post' ,$tokenType);

                $curl = new HttpRequest($baseUrl);
                $response = $curl->post('/v2/checkout/orders', $tokenType, $jsonBody, $headers);
                if (!isset($response['debug_id'])) {
                        /** remember to save links in database */
                        $id = $response['id'];
                        $status = $response['status'];
                        $links = $response['links'];
                        $checkoutLink = $links['1']['href'];
                        if (!empty($id)) {
                                foreach ($links as $link) {
                                        $orderLink = new OrderLink;
                                        $orderLink->create([
                                                'order_id' => $response['id'],
                                                'order_status' => $status,
                                                'order_link' => $link['href'],
                                                'link_name' => $link['rel'],
                                                'order_method' => $link['method'],
                                                'customer_id' => $customerId,
                                                'object_id' => $objectId
                                        ]);
                                }
                        } else {
                                # code...
                        }
                        /** add field in reservation table called status */
                        $variables = [
                                'customer_id' => $customerId,
                                'object_id' => $objectId,
                                'pickup_date' => $pickUpDate,
                                'dropoff_date' => $pickoffDate,
                                'total_amount' => $totalPrice,
                                'currency_id' => $currencyId,
                                'jtl_token' => $token,
                                'order_id' =>  $id,
                        ];
                        $validator = new ReservationStoreRequest;
                        $validatedData = $validator->validate($variables);
                        $createdData = [
                                'customer_id' => $customerId,
                                'object_id' => $objectId,
                                'pickup_date' => $pickUpDate,
                                'dropoff_date' => $pickoffDate,
                                'total_amount' => $totalPrice,
                                'currency_id' => $currencyId,
                                'rental_status' => 'Pending',
                                'order_id' => $id,
                                'quantity' => $quantity
                        ];
                        // $objectTest = ObjectModel::where('id', $validatedData['object_id'])->first();
                        // if ($objectTest->quantity === 0) {
                        //         ObjectModel::where('id', $validatedData['object_id'])->update([
                        //                 'booked' => true,
                        //                 'quantity' => $objectTest->quantity - $quantity
                        //         ]);
                        // } else {
                        //         ObjectModel::where('id', $validatedData['object_id'])->update([
                        //                 'quantity' => $objectTest->quantity - $quantity
                        //         ]);
                        // }

                        // $rentals = Rental::get();
                        // if ($rentals->isNotEmpty()) {
                        //         $rentals->map(function ($rental) use ($createdData , $quantity , $objectId , $checkoutLink) {
                        //                 if ($rental->object_id === $createdData['object_id']) {
                        //                         Rental::where('object_id' , $objectId)->update([
                        //                                 'quantity' => $quantity
                        //                         ]);
                        //                         return $checkoutLink;
                        //                 }
                        //         });
                        // }


                        CacheModel::create($createdData);
                        return $checkoutLink;
                } else {
                        return $checkoutLink = null;
                }
                // redirect()->route('Cart');

        }


        public function rentals(Request $request)
        {

                // $customer          = Frontend::getCustomer();
                $customerId = $request->user()->kKunde;
                if ($customerId) {
                        $reserved = new Rental;
                        $rentals = $reserved->select(
                                'customer_id',
                                'car_id',
                                'pickup_location_id',
                                'pickup_date',
                                'dropoff_location_id',
                                'dropoff_date',
                                'total_amount',
                                'currency',
                                'order_id',
                                'rental_status'
                        )->where('customer_id', $customerId)->get();
                        $car = new Car;

                        $rentals->map(function (&$rental) use ($car) {

                                $pickup_date = Carbon::parse($rental->pickup_date);
                                $dropoff_date = Carbon::parse($rental->dropoff_date);

                                $rental->duration = $pickup_date->diffInDays($dropoff_date, false);

                                $cars    = $car->select(
                                        'cars.*',
                                        'model_name',
                                        'colors.color_name',
                                        'locations.location_name',
                                )
                                        ->join('colors', 'cars.color_id', 'colors.id')
                                        ->join('car_models', 'cars.car_model_id', 'car_models.id')
                                        ->join('locations', 'cars.location_id', 'locations.id')
                                        ->where('cars.id', $rental->car_id)
                                        ->get();

                                $filePath = new UploadingService;
                                $uploads = $filePath->get_path('cars');
                                $lang = Lang::get();
                                $cars->map(function (&$car) use ($lang, $rental, $uploads) {

                                        $status = json_decode($car->car_status);
                                        $car->car_status = $status->$lang;

                                        $modelName = json_decode($car->model_name);
                                        $car->model_name = $modelName->$lang;

                                        $colorName = json_decode($car->color_name);
                                        $car->color_name = $colorName->$lang;

                                        $location = json_decode($car->location_name);
                                        $car->location_name = $location->$lang;

                                        $carImages    = Image::select('imagePath', 'car_id')
                                                ->where('car_id', $car->id)->get();
                                        $imagePath = $carImages['0']->imagePath;
                                        $rental->image_path = $uploads . $imagePath;

                                        $rental->construction_year = $car->construction_year;
                                        $rental->seats = $car->seats;
                                        $rental->transmission_type = $car->transmission_type;
                                        $rental->size = $car->size;
                                        $rental->bags = $car->bags;
                                        $rental->air_conditioner = $car->air_conditioner;
                                        $rental->price_per_day = $car->price_per_day;
                                        $rental->currency = $car->currency;
                                        $rental->air_conditioner = $car->air_conditioner;
                                        return $car;
                                });

                                return $rental;
                        });

                        $smarty = Shop::Smarty();

                        $smarty->assign('rentals', $rentals);
                } else {
                        $rentals  = [];
                }
        }

        public function fetch_more_rentals(Request $request)
        {
                $data = $request->all();

                // recieve customerId and get his rentals from rentals table

                // $customer          = Frontend::getCustomer();
                $customerId = $request->user()->kKunde;

                $reserved = new Rental;
                $rentals = $reserved->select(
                        'customer_id',
                        'car_id',
                        'pickup_location_id',
                        'pickup_date',
                        'dropoff_location_id',
                        'dropoff_date',
                        'total_amount',
                        'currency',
                        'order_id',
                        'rental_status'
                )->where('customer_id', $customerId)->get();

                $car = new Car;
                foreach ($rentals as  &$rental) {

                        $cars    = $car->selectWith(
                                'cars.*',
                                'model_name',
                                'colors.color_name',
                                'locations.location_name',
                        )->join('colors', 'cars.color_id', 'colors.id')->join('cars', 'car_model_id', 'car_models', 'id')
                                ->join('cars', 'location_id', 'locations', 'id')
                                ->where('cars.id', $rental->car_id)
                                ->get();

                        $filePath = new UploadingService;
                        $uploads = $filePath->get_path('cars');
                        foreach ($cars as &$value) {
                                $lang = Lang::get();
                                $status = json_decode($value->car_status);
                                $value->car_status = $status->$lang;

                                $modelName = json_decode($value->model_name);
                                $value->model_name = $modelName->$lang;

                                $colorName = json_decode($value->color_name);
                                $value->color_name = $colorName->$lang;

                                $location = json_decode($value->location_name);
                                $value->location_name = $location->$lang;
                                // array_push($carsCopy, $value);

                                $carImage     = new Image;
                                $carImages    = $carImage->select('imagePath', 'car_id')
                                        ->where('car_id', $value->id)->get();
                                $imagePath = $carImages['0']->imagePath;
                                $rental->image_path = $uploads . $imagePath;

                                $rental->construction_year = $value->construction_year;
                                $rental->seats = $value->seats;
                                $rental->transmission_type = $value->transmission_type;
                                $rental->size = $value->size;
                                $rental->bags = $value->bags;
                                $rental->air_conditioner = $value->air_conditioner;
                                $rental->price_per_day = $value->price_per_day;
                                $rental->currency = $value->currency;
                                $rental->air_conditioner = $value->air_conditioner;
                        }

                        return $rentals;
                }
        }

        public function pendingRentals()
        {
                $customer          = Frontend::getCustomer();
                $customerId = $customer->kKunde;
                if ($customerId) {

                        $confimLinks = OrderLink::where('link_name', 'approve')->get();
                        foreach ($confimLinks as $confimLink) {
                                AbstractSession::set('completePayment', $confimLink);
                        }
                }
        }



        public function confirm_payment(Request $request)
        {
                $data = $request->all();
                $orderId = $data['token'];
                // send request 
                $initiatePayment = new InitiatePayment;
                $results = $initiatePayment->initiate();

                $tokenName = $results['tokenName'];
                $tokenType = $results['tokenType'];

                $baseUrl = GetPaypalMode::getPaypalUrl();

                $headers = [
                        "Content-Type: application/json",
                        "Authorization: $tokenType $tokenName"
                ];


                //!
                $curl = new HttpRequest($baseUrl);
                $response = $curl->get("/v2/checkout/orders/$orderId", $tokenType, [], $headers);
                //!






                /** remember to save links in database */

                if ($response['status'] === 'APPROVED') {

                        $rental = CacheModel::where('customer_id', $request->user()->kKunde)->where('order_id', $orderId)->first();

                        Rental::create([
                                'customer_id' => $rental->customer_id,
                                'object_id' => $rental->object_id,
                                'pickup_date' => $rental->pickup_date,
                                'dropoff_date' => $rental->dropoff_date,
                                'total_amount' => $rental->total_amount,
                                'currency_id' => $rental->currency_id,
                                'rental_status' => 'APPROVED',
                                'order_id' => $rental->order_id,
                                'quantity' => $rental->quantity
                                
                        ]);

                        $objectTest = ObjectModel::where('id', $rental->object_id)->first();
                        if ($objectTest->quantity === 0) {
                                ObjectModel::where('id', $rental->object_id)->update([
                                        'booked' => true,
                                        'quantity' => $objectTest->quantity - $rental->quantity
                                ]);
                        } else {
                                ObjectModel::where('id', $rental->object_id)->update([
                                        'quantity' => $objectTest->quantity - $rental->quantity
                                ]);
                        }

                        CacheModel::where('customer_id', $request->user()->kKunde)->delete();


                        //change status of reservation 
                        // $rentals = Rental::where('order_id', $orderId)->get();

                        // if ($rentals->isNotEmpty()) {
                        //         foreach ($rentals as $key => $rental) {
                        //                 Rental::where('object_id', $rental->object_id)->update(
                        //                         [
                        //                                 'rental_status' => 'APPROVED',

                        //                         ],

                        //                 );
                        //         }

                        $storeOrder = new StoreOrder();
                        $storeOrder->storeV2([
                                'id' => $orderId,
                                'address' => $response['purchase_units']['0']['shipping']['address']['address_line_1'],
                                'creationTime' => $response['create_time'],
                                'totalAmount' => $response['purchase_units']['0']['amount']['value'],
                                'paymentMethod' => 'paypal'

                        ]);

                        // send E-mail
                        // client
                        $clientName = userName();
                        $ownerName = adminName();
                        $clientBody = file_get_contents(__DIR__ . "/../../Support/Mail/ClientReserve.php");
                        $clientBody = sprintf($clientBody, $clientName, $ownerName);

                        // admin
                        $ownerBody = file_get_contents(__DIR__ . "/../../Support/Mail/OwnerReserve.php");
                        $ownerBody = sprintf($ownerBody, $ownerName, $clientName);
                        \ob_start();
                        // send mail to client
                        (new MailService(
                                $request->user()->cMail,
                                'Reservation',
                                $clientBody
                        ))->sendMail();

                        // send mail to shop owner
                        (new MailService(adminEmail(), 'Reservation', $ownerBody))->sendMail();

                        // delete from session
                        foreach ($_SESSION['objects'] as $key => $value) {

                                if ($value->id == $data['id']) {
                                        unset($_SESSION['objects'][$key]);
                                }
                        }

                        Redirect::homeWith('/my-rentals');
                } else {
                        Redirect::homeWith('/my-rentals');
                }
        }


        public function cancel_payment(Request $request)
        {
                $data = $request->all();
                $orderId = $data['0']['token'];

                dda($data);
                $link = "https://api.paypal.com/checkoutnow?token=$orderId";

                AbstractSession::set('paymentStatus', 0);
                // AbstractSession::set('completePayment', $link);
                AbstractSession::set('auto_details', '');

                Redirect::homeWith('/my-rentals');
        }



        protected $totalPrice;
        function cancle_rental()
        {
                Rental::where()->delete();
        }
        function cash_on_delever(Request $request)
        {
                $data = $request->all();




                $rental = CacheModel::where('customer_id', $request->user()->kKunde)->first();
                if ($rental->object_id === $data['id']) {
                        Rental::where('object_id' , $rental->object_id)->update([
                                'quantity' => $rental->quantity,
                                'total_amount' => $rental->total_amount,

                        ]);
                }
                else {
                        Rental::create([
                                'customer_id' => $rental->customer_id,
                                'object_id' => $rental->object_id,
                                'pickup_date' => $rental->pickup_date,
                                'dropoff_date' => $rental->dropoff_date,
                                'total_amount' => $rental->total_amount,
                                'currency_id' => $rental->currency_id,
                                'rental_status' => 'APPROVED',
                                'order_id' => $rental->order_id,
                                'quantity' => $rental->quantity
                                
                        ]);
                }

                

                $objectTest = ObjectModel::where('id', $rental->object_id)->first();
                if ($objectTest->quantity === 0) {
                        ObjectModel::where('id', $rental->object_id)->update([
                                'booked' => true,
                                'quantity' => $objectTest->quantity - $rental->quantity
                        ]);
                } else {
                        ObjectModel::where('id', $rental->object_id)->update([
                                'quantity' => $objectTest->quantity - $rental->quantity
                        ]);
                }

                CacheModel::where('customer_id', $request->user()->kKunde)->delete();




                foreach ($_SESSION['objects'] as $key => $value) {
                        if ($value->id == $data['id']) {
                                $this->totalPrice = $value->totalPrice;
                        }
                }
                $storeOrder = new StoreOrder();
                $storeOrder->storeV2([
                        'id' => uniqid(),
                        'address' => $request->user()->cAdressZusatz,
                        'creationTime' => Carbon::now(),
                        'totalAmount' => $this->totalPrice,
                        'paymentMethod' => 'Cash on deliver'
                ]);

                // client
                $clientName = userName();
                $ownerName = adminName();
                $clientBody = file_get_contents(__DIR__ . "/../../Support/Mail/ClientReserve.php");
                $clientBody = sprintf($clientBody, $clientName, $ownerName);

                // admin
                $ownerBody = file_get_contents(__DIR__ . "/../../Support/Mail/OwnerReserve.php");
                $ownerBody = sprintf($ownerBody, $ownerName, $clientName);
                ob_start();

                // send mail to client
                (new MailService(
                        $request->user()->cMail,
                        'Reservation',
                        $clientBody
                ))->sendMail();

                // send mail to shop owner
                (new MailService(adminEmail(), 'Reservation', $ownerBody))->sendMail();
                ob_end_clean();


                // delete from session
                foreach ($_SESSION['objects'] as $key => $value) {

                        if ($value->id == $data['id']) {
                                unset($_SESSION['objects'][$key]);
                        }
                }



                // $rentals = Rental::where('object_id', $data['id'])->get();
                // if ($rentals->isNotEmpty()) {
                //         foreach ($rentals as $key => $rental) {
                //                 Rental::where('object_id', $rental->object_id)->update(
                //                         [
                //                                 'rental_status' => 'APPROVED',

                //                         ],
                //                 );
                //         }

                       

                        return response()->json('test', 302);
                }
}

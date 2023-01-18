<?php

namespace MvcCore\Rental\Controllers\Frontend;

use Illuminate\Support\Facades\Response as FacadesResponse;
use LDAP\Result;
use MvcCore\Rental\Models\Product;
use MvcCore\Rental\Support\Http\Request;
use MvcCore\Rental\Controllers\Repository\getObjectById;
use MvcCore\Rental\Models\ObjectModel;
use MvcCore\Rental\Models\Rental;
use MvcCore\Rental\Requests\getObjectDetailsRequest;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Helpers\Response;
use JTL\Shop;
use MvcCore\Rental\Services\UploadingService;
use MvcCore\Rental\Helpers\Redirect;
use MvcCore\Rental\Support\Http\Session;
use MvcCore\Rental\Models\shoppingCart;
use MvcCore\Rental\Session\AbstractSession;
use Carbon\Carbon;
use stdClass;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



class ObjectDetailsController
{
    protected $imagePath;
    protected $paypalLink;


    public function objectDetailsSmarty()
    {
        $arr = explode("?redirect=pick-object&objectId=", $_SERVER['REQUEST_URI']) ? explode("?redirect=pick-object&objectId=", $_SERVER['REQUEST_URI']) : null;
        if (isset($arr[1]) && $arr[1] !== '' && is_numeric($arr[1]) &&  $arr[0] ===  '/product-details' || $arr[0] === '/produkt-details') {
            $validator = new getObjectDetailsRequest;
            $validatedData = $validator->validate($arr);
            $objectId = +$validatedData['objectId'];
            $objectIds = ObjectModel::get()->pluck('id')->toArray();
            if (in_array($objectId, $objectIds)) {
                $getObject = new getObjectById;
                $object = $getObject->get($objectId);
                $smarty = Shop::Smarty();
                $smarty->assign('objekt_details', $object);
            } else {
                Redirect::homeWith('/rental');
            }
        } elseif ($arr[0] ===  '/product-details' || $arr[0] === '/produkt-details') {

            Redirect::homeWith('/rental');
        }
    }


    public function addToCart(Request $request)
    {
        $data = $request->all();
        $quantity = $data['quantity'];
        $pickUpDate = $data['pick_up_date'];
        $pickoffDate = $data['pick_of_date'];
        $start  = new Carbon($pickUpDate);
        $end = new Carbon($pickoffDate);
        $diff = $end->diff($start);
        if (!!$diff->days) {
            $dateInHours = $diff->days * 24 + $diff->h;
        } else {
            $dateInHours = $diff->h;
        }
        // quantity , object_id ,  pick_up_date ,, pick_of_date

        $customerId = $request->user()->kKunde;

        /**
         * before adding item into shopping cart
         * HOOK_CARTHELPER_ADD_PRODUCT_ID_TO_CART
         * HOOK_TOOLS_GLOBAL_CHECKEWARECARTBENTRY_BEGIN
         */
        // executeHook(HOOK_CARTHELPER_ADD_PRODUCT_ID_TO_CART, [
        //     'kArticle' => $request->objectId,
        //     'fnumber' => 1
        // ]);
        if ($customerId) {
            $object = ObjectModel::where('id', $data['object_id'])->with('currency')->first();
            $std = new stdClass;
            $std->quantity = $quantity;
            $std->id = $object->id;
            $std->duration = $object->duration;
            $std->pickupDate = $pickUpDate;
            $std->dropoffDate = $pickoffDate;
            $price = $object->price;
            $std->price = $price;
            $std->currencyName = $object->currency->name;
            $std->currencyCode = $object->currency->currency_code;
            switch ($object->duration) {
                case 1:
                    $std->totalPrice = (($price / 24) * $dateInHours) * $quantity;
                    break;
                case 7:
                    $std->totalPrice = (($price / 24 * 7) * $dateInHours) * $quantity;
                    break;
                case 30:
                    $std->totalPrice = (($price / 24 * 30) * $dateInHours) * $quantity;
                    break;
                case 60:
                    $std->totalPrice = intval($price * $dateInHours) * $quantity;
                    break;
                default:
                    # code...
                    break;
            }
            $std->productLink = $_SERVER['HTTP_HOST'] . "?redirect=pick-object&objectId=" . $object->id;
            if (isset($object->name)) {
                $std->name = json_decode($object->name);
            }
            if (isset($object->category->name)) {
                $std->categoryName = json_decode($object->category->name);
            }
            if (isset($object->city->name)) {
                $std->cityName = json_decode($object->city->name);
            }
            if (isset($object->color->color_name)) {
                $std->colorName = json_decode($object->color->color_name);
            }
            if (isset($object->country->name)) {
                $std->countryName = json_decode($object->country->name);
            }
            if (isset($object->descriptions)) {
                foreach ($object->descriptions as $key => $description) {
                    if (isset($description->long_description)) {
                        $std->long_description = json_decode($description->long_description);
                    }
                    if (isset($description->short_description)) {
                        $std->short_description = json_decode($description->short_description);
                    }
                }
            }
            if (isset($object->governrate->name)) {
                $std->governrateName = json_decode($object->governrate->name);
            }
            if (!count($object->images) == 0) {
                $filePath = new UploadingService;
                $uploads = $filePath->get_path('objects');
                foreach ($object->images as $key => $image) {
                    $imagePath = $uploads . $image->imagePath;
                }
                $std->imagePath = $imagePath;
                unset($object->images);
            } else {
                $std->imagePath = null;
            }
            $this->paypalLink = (new ReservationsController)->store($std->totalPrice, $object->id, $customerId, $pickUpDate, $pickoffDate, $object->currency_id , $quantity);
            $std->paypalLink = $this->paypalLink;

            // session()->set('objects' , $objects);
            $session = new Session;
            $session->start();
            if (!empty($_SESSION['objects'])) {

                foreach ($_SESSION['objects'] as $key => $value) {
                    if ($value->id === $std->id) {
                        $_SESSION['objects'][$key] = $std;
                        goto test;
                    }
                }
                array_push($_SESSION['objects'], $std);
            } else {
                $session->add_key_value('objects'  ,[$std]);
            }

            test:
            return response()->json('cart added successfully', 200);
        }

        // session()->set([]);
        return response()->json('no user', 404);
        /**
         * after adding item into shopping cart
         */
        // executeHook(HOOK_CART_CLASS_FUEGEEIN, []);
    }




    function removeFromSession(Request $request)
    {
        $data = $request->all();
        foreach ($_SESSION['objects'] as $key => $value) {

            if ($value->id == $data['id']) {
                unset($_SESSION['objects'][$key]);
            }
        }
        return response()->json('object deleted successfully', 204);
    }

}

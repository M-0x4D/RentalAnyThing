<?php

namespace MvcCore\Rental\Database\Seeders;

use MvcCore\Rental\Models\Car;
use Illuminate\Support\Traits;

// use Plugin\TecSeeProductsRentalBooking\vendor\Illuminate\Database\Eloquent;

class CarsSeeder
{

    public function createCars()
    {
        $car     = new Car;
        $cars = [
            [
                'color_id' => 1,
                'car_model_id' => 1,
                'construction_year' => '2021',
                'seats' => 4,
                'transmission_type' => 'Automatic',
                'size' => 'Medium',
                'bags' => 'true',
                'air_conditioner' => 'true',
                'price_per_day' => '40',
                'currency' => 'EUR',
                'car_status' => '{"en":"Active","de":"Aktiv"}',
                'location_id' => 3,
                'engine_type' => 'Benzin',
                'max_speed' => '174',
                'speed_type' => 'kmh',
                'engine_power' => '4',
                'power_type' => 'PowerHorse',
                'fuel_consumption' => '7.0',
                'price_includes' => '{"en":"Lorem ipsum dolor sit amet, consectetuer adipiscing elit.,Aliquam tincidunt mauris eu risus.,Vestibulum auctor dapibus neque.,Nunc dignissim risus id metus.","de":"Lorem ipsum dolor sit amet, consectetuer adipiscing elit.,Aliquam tincidunt mauris eu risus.,Vestibulum auctor dapibus neque.,Nunc dignissim risus id metus."}',
                'price_excludes' =>'{"en":"Cras ornare tristique elit., Vivamus vestibulum ntulla nec ante., Praesent placerat risus quis eros., Fusce pellentesque suscipit nibh., Integer vitae libero ac risus egestas placerat., Vestibulum commodo felis quis tortor.","de":"Cras ornare tristique elit., Vivamus vestibulum ntulla nec ante., Praesent placerat risus quis eros., Fusce pellentesque suscipit nibh., Integer vitae libero ac risus egestas placerat., Vestibulum commodo felis quis tortor."}', 
            ],
            [
                'color_id' => 3,
                'car_model_id' => 4,
                'construction_year' => '2022',
                'seats' => 5,
                'transmission_type' => 'Automatic',
                'size' => 'Large',
                'bags' => 'false',
                'air_conditioner' => 'true',
                'price_per_day' => '170',
                'currency' => 'EUR',
                'car_status' => '{"en":"Deactive","de":"Deaktiviert"}',
                'location_id' => 2,
                'engine_type' => 'Diesel',
                'max_speed' => '174',
                'speed_type' => 'kmh',
                'engine_power' => '4',
                'power_type' => 'PowerHorse',
                'fuel_consumption' => '7.0',
                'price_includes' => '{"en":"Lorem Ipsum is the single greatest threat.,We are not - we are not keeping up with other websites.,Lorem Ipsum best not make any more threats to your website.,It will be met with fire and fury like the world has never seen.","de":"Lorem Ipsum is the single greatest threat.,We are not - we are not keeping up with other websites.,Lorem Ipsum best not make any more threats to your website.,It will be met with fire and fury like the world has never seen."}',
                'price_excludes' => '{"en":"Zombie ipsum reversus ab viral inferno, nam rick grimes malum cerebro.,De carne lumbering animata corpora quaeritis.,Ground round jerky brisket pastrami shank.,Cupcake ipsum dolor.,Sit amet marshmallow topping cheesecake muffin.","de":"Zombie ipsum reversus ab viral inferno, nam rick grimes malum cerebro.,De carne lumbering animata corpora quaeritis.,Ground round jerky brisket pastrami shank.,Cupcake ipsum dolor.,Sit amet marshmallow topping cheesecake muffin."}', 
            ],
            [
                'color_id' => 5,
                'car_model_id' => 6,
                'construction_year' => '2020',
                'seats' => 3,
                'transmission_type' => 'Automatic',
                'size' => 'Small',
                'bags' => 'false',
                'air_conditioner' => 'false',
                'price_per_day' => '25',
                'currency' => 'EUR',
                'car_status' => '{"en":"Deactive","de":"Deaktiviert"}',
                'location_id' => 4,
                'engine_type' => 'Battery',
                'max_speed' => '196',
                'speed_type' => 'kmh',
                'engine_power' => '3',
                'power_type' => 'PowerHorse',
                'fuel_consumption' => '7.0',
                'price_includes' => '{"en":"Collision Damage Waiver (CDW) (Excess To GBP 1100.00),Theft Waiver (THW) (Excess To GBP 1100.00),Premium Station Surcharge,Vehicle Licensing Fee & Road Tax,VAT Included","de":"Collision Damage Waiver (CDW) (Excess To GBP 1100.00),Theft Waiver (THW) (Excess To GBP 1100.00),Premium Station Surcharge,Vehicle Licensing Fee & Road Tax,VAT Included"}',
                'price_excludes' => '{"en":"SUPER PERSONAL ACCIDENT INSURANCE GBP 8.00 Per Rental,Windscreen, Glass And Tires GBP 12.00 Per Rental,Fuel. Return The Vehicle With The Same Level Of Fuel Or Use Our Refueling Service (Price Communicated At Pick-Up) Except In Jersey And Guernsey Where Up To Half A Tank Of Fuel Will Need To Be Pre-Paid When Picking Up The Vehicle.,Deposit Will Apply (The Amount Will Be Pre-Authorized On Your Credit Card At The Time Of Rental Pickup, But Not Debited From Your Account). If You Need Further Information About Deposit Release Time And Amount, Please Refer To The `Deposit Policy` Section In Our Full Terms And Conditions.","de":"SUPER PERSONAL ACCIDENT INSURANCE GBP 8.00 Per Rental,Windscreen, Glass And Tires GBP 12.00 Per Rental,Fuel. Return The Vehicle With The Same Level Of Fuel Or Use Our Refueling Service (Price Communicated At Pick-Up) Except In Jersey And Guernsey Where Up To Half A Tank Of Fuel Will Need To Be Pre-Paid When Picking Up The Vehicle.,Deposit Will Apply (The Amount Will Be Pre-Authorized On Your Credit Card At The Time Of Rental Pickup, But Not Debited From Your Account). If You Need Further Information About Deposit Release Time And Amount, Please Refer To The `Deposit Policy` Section In Our Full Terms And Conditions."}',
            ],
            [
                'color_id' => 6,
                'car_model_id' => 8,
                'construction_year' => '2018',
                'seats' => 4,
                'transmission_type' => 'Manual',
                'size' => 'Large',
                'bags' => 'true',
                'air_conditioner' => 'false',
                'price_per_day' => '20',
                'currency' => 'EUR',
                'car_status' => '{"en":"Active","de":"Aktiv"}',
                'location_id' => 7,
                'engine_type' => 'Diesel',
                'max_speed' => '155',
                'speed_type' => 'kmh',
                'engine_power' => '184',
                'power_type' => 'PowerHorse',
                'fuel_consumption' => '28.2',
                'price_includes' => '{"en":"Collision Damage Waiver (CDW) (Excess To GBP 1100.00),Theft Waiver (THW) (Excess To GBP 1100.00),Premium Station Surcharge,Vehicle Licensing Fee & Road Tax,VAT Included","de":"Collision Damage Waiver (CDW) (Excess To GBP 1100.00),Theft Waiver (THW) (Excess To GBP 1100.00),Premium Station Surcharge,Vehicle Licensing Fee & Road Tax,VAT Included"}',
                'price_excludes' => '{"en":"SUPER PERSONAL ACCIDENT INSURANCE GBP 8.00 Per Rental,Windscreen, Glass And Tires GBP 12.00 Per Rental,Fuel. Return The Vehicle With The Same Level Of Fuel Or Use Our Refueling Service (Price Communicated At Pick-Up) Except In Jersey And Guernsey Where Up To Half A Tank Of Fuel Will Need To Be Pre-Paid When Picking Up The Vehicle.,Deposit Will Apply (The Amount Will Be Pre-Authorized On Your Credit Card At The Time Of Rental Pickup, But Not Debited From Your Account). If You Need Further Information About Deposit Release Time And Amount, Please Refer To The `Deposit Policy` Section In Our Full Terms And Conditions.","de":"SUPER PERSONAL ACCIDENT INSURANCE GBP 8.00 Per Rental,Windscreen, Glass And Tires GBP 12.00 Per Rental,Fuel. Return The Vehicle With The Same Level Of Fuel Or Use Our Refueling Service (Price Communicated At Pick-Up) Except In Jersey And Guernsey Where Up To Half A Tank Of Fuel Will Need To Be Pre-Paid When Picking Up The Vehicle.,Deposit Will Apply (The Amount Will Be Pre-Authorized On Your Credit Card At The Time Of Rental Pickup, But Not Debited From Your Account). If You Need Further Information About Deposit Release Time And Amount, Please Refer To The `Deposit Policy` Section In Our Full Terms And Conditions."}',
            ],
            [
                'color_id' => 9,
                'car_model_id' => 10,
                'construction_year' => '2017',
                'seats' => 3,
                'transmission_type' => 'Manual',
                'size' => 'SUVs',
                'bags' => 'false',
                'air_conditioner' => 'true',
                'price_per_day' => '28',
                'currency' => 'EUR',
                'car_status' => '{"en":"Active","de":"Aktiv"}',
                'location_id' => 6,
                'engine_type' => 'Benzin',
                'max_speed' => '210',
                'speed_type' => 'kmh',
                'engine_power' => '85',
                'power_type' => 'Kilowatt',
                'fuel_consumption' => '20.2',
                'price_includes' => '{"en":"Collision Damage Waiver (CDW) (Excess To GBP 1100.00),Theft Waiver (THW) (Excess To GBP 1100.00),Premium Station Surcharge,Vehicle Licensing Fee & Road Tax,VAT Included","de":"Collision Damage Waiver (CDW) (Excess To GBP 1100.00),Theft Waiver (THW) (Excess To GBP 1100.00),Premium Station Surcharge,Vehicle Licensing Fee & Road Tax,VAT Included"}',
                'price_excludes' => '{"en":"SUPER PERSONAL ACCIDENT INSURANCE GBP 8.00 Per Rental,Windscreen, Glass And Tires GBP 12.00 Per Rental,Fuel. Return The Vehicle With The Same Level Of Fuel Or Use Our Refueling Service (Price Communicated At Pick-Up) Except In Jersey And Guernsey Where Up To Half A Tank Of Fuel Will Need To Be Pre-Paid When Picking Up The Vehicle.,Deposit Will Apply (The Amount Will Be Pre-Authorized On Your Credit Card At The Time Of Rental Pickup, But Not Debited From Your Account). If You Need Further Information About Deposit Release Time And Amount, Please Refer To The `Deposit Policy` Section In Our Full Terms And Conditions.","de":"SUPER PERSONAL ACCIDENT INSURANCE GBP 8.00 Per Rental,Windscreen, Glass And Tires GBP 12.00 Per Rental,Fuel. Return The Vehicle With The Same Level Of Fuel Or Use Our Refueling Service (Price Communicated At Pick-Up) Except In Jersey And Guernsey Where Up To Half A Tank Of Fuel Will Need To Be Pre-Paid When Picking Up The Vehicle.,Deposit Will Apply (The Amount Will Be Pre-Authorized On Your Credit Card At The Time Of Rental Pickup, But Not Debited From Your Account). If You Need Further Information About Deposit Release Time And Amount, Please Refer To The `Deposit Policy` Section In Our Full Terms And Conditions."}',
            ],
            [
                'color_id' => 10,
                'car_model_id' => 9,
                'construction_year' => '2022',
                'seats' => 5,
                'transmission_type' => 'Automatic',
                'size' => 'Large',
                'bags' => 'true',
                'air_conditioner' => 'true',
                'price_per_day' => '250',
                'currency' => 'EUR',
                'car_status' => '{"en":"Active","de":"Aktiv"}',
                'location_id' => 1,
                'engine_type' => 'Battery',
                'max_speed' => '230',
                'speed_type' => 'kmh',
                'engine_power' => '200',
                'power_type' => 'Kilowatt',
                'fuel_consumption' => '25.2',
                'price_includes' => '{"en":"Collision Damage Waiver (CDW) (Excess To GBP 1100.00),Theft Waiver (THW) (Excess To GBP 1100.00),Premium Station Surcharge,Vehicle Licensing Fee & Road Tax,VAT Included","de":"Collision Damage Waiver (CDW) (Excess To GBP 1100.00),Theft Waiver (THW) (Excess To GBP 1100.00),Premium Station Surcharge,Vehicle Licensing Fee & Road Tax,VAT Included"}',
                'price_excludes' => '{"en":"SUPER PERSONAL ACCIDENT INSURANCE GBP 8.00 Per Rental,Windscreen, Glass And Tires GBP 12.00 Per Rental,Fuel. Return The Vehicle With The Same Level Of Fuel Or Use Our Refueling Service (Price Communicated At Pick-Up) Except In Jersey And Guernsey Where Up To Half A Tank Of Fuel Will Need To Be Pre-Paid When Picking Up The Vehicle.,Deposit Will Apply (The Amount Will Be Pre-Authorized On Your Credit Card At The Time Of Rental Pickup, But Not Debited From Your Account). If You Need Further Information About Deposit Release Time And Amount, Please Refer To The `Deposit Policy` Section In Our Full Terms And Conditions.","de":"SUPER PERSONAL ACCIDENT INSURANCE GBP 8.00 Per Rental,Windscreen, Glass And Tires GBP 12.00 Per Rental,Fuel. Return The Vehicle With The Same Level Of Fuel Or Use Our Refueling Service (Price Communicated At Pick-Up) Except In Jersey And Guernsey Where Up To Half A Tank Of Fuel Will Need To Be Pre-Paid When Picking Up The Vehicle.,Deposit Will Apply (The Amount Will Be Pre-Authorized On Your Credit Card At The Time Of Rental Pickup, But Not Debited From Your Account). If You Need Further Information About Deposit Release Time And Amount, Please Refer To The `Deposit Policy` Section In Our Full Terms And Conditions."}',
            ],
            [
                'color_id' => 2,
                'car_model_id' => 11,
                'construction_year' => '2021',
                'seats' => 5,
                'transmission_type' => 'Automatic',
                'size' => 'SUVs',
                'bags' => 'true',
                'air_conditioner' => 'true',
                'price_per_day' => '60',
                'currency' => 'EUR',
                'car_status' => '{"en":"Active","de":"Aktiv"}',
                'location_id' => 3,
                'engine_type' => 'Diesel',
                'max_speed' => '220',
                'speed_type' => 'kmh',
                'engine_power' => '100',
                'power_type' => 'PowerHorse',
                'fuel_consumption' => '23.2',
                'price_includes' => '{"en":"Collision Damage Waiver (CDW) (Excess To GBP 1100.00),Theft Waiver (THW) (Excess To GBP 1100.00),Premium Station Surcharge,Vehicle Licensing Fee & Road Tax,VAT Included","de":"Collision Damage Waiver (CDW) (Excess To GBP 1100.00),Theft Waiver (THW) (Excess To GBP 1100.00),Premium Station Surcharge,Vehicle Licensing Fee & Road Tax,VAT Included"}',
                'price_excludes' => '{"en":"SUPER PERSONAL ACCIDENT INSURANCE GBP 8.00 Per Rental,Windscreen, Glass And Tires GBP 12.00 Per Rental,Fuel. Return The Vehicle With The Same Level Of Fuel Or Use Our Refueling Service (Price Communicated At Pick-Up) Except In Jersey And Guernsey Where Up To Half A Tank Of Fuel Will Need To Be Pre-Paid When Picking Up The Vehicle.,Deposit Will Apply (The Amount Will Be Pre-Authorized On Your Credit Card At The Time Of Rental Pickup, But Not Debited From Your Account). If You Need Further Information About Deposit Release Time And Amount, Please Refer To The `Deposit Policy` Section In Our Full Terms And Conditions.","de":"SUPER PERSONAL ACCIDENT INSURANCE GBP 8.00 Per Rental,Windscreen, Glass And Tires GBP 12.00 Per Rental,Fuel. Return The Vehicle With The Same Level Of Fuel Or Use Our Refueling Service (Price Communicated At Pick-Up) Except In Jersey And Guernsey Where Up To Half A Tank Of Fuel Will Need To Be Pre-Paid When Picking Up The Vehicle.,Deposit Will Apply (The Amount Will Be Pre-Authorized On Your Credit Card At The Time Of Rental Pickup, But Not Debited From Your Account). If You Need Further Information About Deposit Release Time And Amount, Please Refer To The `Deposit Policy` Section In Our Full Terms And Conditions."}',
            ],
            [
                'color_id' => 8,
                'car_model_id' => 7,
                'construction_year' => '2022',
                'seats' => 4,
                'transmission_type' => 'Automatic',
                'size' => 'Large',
                'bags' => 'true',
                'air_conditioner' => 'true',
                'price_per_day' => '90',
                'currency' => 'EUR',
                'car_status' => '{"en":"Active","de":"Aktiv"}',
                'location_id' => 4,
                'engine_type' => 'Battery',
                'max_speed' => '120',
                'speed_type' => 'kmh',
                'engine_power' => '230',
                'power_type' => 'Kilowatt',
                'fuel_consumption' => '23.2',
                'price_includes' => '{"en":"Collision Damage Waiver (CDW) (Excess To GBP 1100.00),Theft Waiver (THW) (Excess To GBP 1100.00),Premium Station Surcharge,Vehicle Licensing Fee & Road Tax,VAT Included","de":"Collision Damage Waiver (CDW) (Excess To GBP 1100.00),Theft Waiver (THW) (Excess To GBP 1100.00),Premium Station Surcharge,Vehicle Licensing Fee & Road Tax,VAT Included"}',
                'price_excludes' => '{"en":"SUPER PERSONAL ACCIDENT INSURANCE GBP 8.00 Per Rental,Windscreen, Glass And Tires GBP 12.00 Per Rental,Fuel. Return The Vehicle With The Same Level Of Fuel Or Use Our Refueling Service (Price Communicated At Pick-Up) Except In Jersey And Guernsey Where Up To Half A Tank Of Fuel Will Need To Be Pre-Paid When Picking Up The Vehicle.,Deposit Will Apply (The Amount Will Be Pre-Authorized On Your Credit Card At The Time Of Rental Pickup, But Not Debited From Your Account). If You Need Further Information About Deposit Release Time And Amount, Please Refer To The `Deposit Policy` Section In Our Full Terms And Conditions.","de":"SUPER PERSONAL ACCIDENT INSURANCE GBP 8.00 Per Rental,Windscreen, Glass And Tires GBP 12.00 Per Rental,Fuel. Return The Vehicle With The Same Level Of Fuel Or Use Our Refueling Service (Price Communicated At Pick-Up) Except In Jersey And Guernsey Where Up To Half A Tank Of Fuel Will Need To Be Pre-Paid When Picking Up The Vehicle.,Deposit Will Apply (The Amount Will Be Pre-Authorized On Your Credit Card At The Time Of Rental Pickup, But Not Debited From Your Account). If You Need Further Information About Deposit Release Time And Amount, Please Refer To The `Deposit Policy` Section In Our Full Terms And Conditions."}',
            ],
        ];

        //array_map(fn ($variable) => $car->create($variable), $variables);

        array_map(function ($variable) use ($car) {
            $car->create($variable);
            // $lastId = $car->select('id')->orderBy('id', 'DESC')->get();
            // $id = $lastId[0]->id;

            $myarray = [
                'a' => 1,
                'b' => 2,
                'c' => 3,
                'd' => 4,
                'e' => 5,
                'f' => 6,
            ];
            $data = array_rand($myarray, 4);

            $a = $myarray[$data[0]];
            $b = $myarray[$data[1]];
            $c = $myarray[$data[2]];
            $d = $myarray[$data[3]];

            $values = [
                [
                    'car_id' => 1,
                    'per_person' => true,
                    'price' => 10
                ],
                [
                    'car_id' => 1,
                    'per_person' => false,
                    'price' => 15
                ],
                [
                    'car_id' => 1,
                    'per_person' => false,
                    'price' => 10
                ],
                [
                    'car_id' => 1,
                    'per_person' => false,
                    'price' => 10
                ],
            ];

            foreach ($values as $value) {
                $car->features()->attach(1, $value);
            }
        }, $cars);
    }
}

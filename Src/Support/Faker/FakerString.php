<?php

namespace MvcCore\Rental\Support\Faker;

class FakerString
{
    public function first_name($gender = 'male')
    {
    }

    public function words($count = 6)
    {
    }

    public function random_string($length): string
    {
        $alphabetCaps = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $alphabetSmall = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '1234567890';
        $key = 'JTL_ARTISAN';
        $string = '';
        for ($i = 0; $i <= $length; $i++) {
            $alphabetCapsIndex = rand(0, strlen($alphabetCaps) - 1);
            $alphabetSmallIndex = rand(0, strlen($alphabetSmall) - 1);
            $numbersIndex = rand(0, strlen($numbers) - 1);
            $keyIndex = rand(0, strlen($key) - 1);
            $string .=
                $alphabetCaps[$alphabetCapsIndex] .
                $alphabetSmall[$alphabetSmallIndex] .
                $numbers[$numbersIndex] .
                $key[$keyIndex];
        }
        return $string;
    }
}
<?php

namespace MvcCore\Rental\Controllers\Repository;

use Illuminate\Support\Facades\Redis;
use MvcCore\Rental\Models\ObjectModel;
use MvcCore\Rental\Models\Rental;
use Carbon\Carbon;
use MvcCore\Rental\Support\Mail\MailService;


class CronJob
{
    public function run()
    {
        $currentTime = Carbon::now()->format('Y-m-d H:i:s');
        $rentals = Rental::get();
        $rentals->map(function ($rental) use ($currentTime) {
            if ($rental->droppoff_date === $currentTime) {
                ObjectModel::where('id', $rental->object_id)->update([
                    'booked' => false
                ]);
                Rental::where('id', $rental->id)->delete();
            }
        });
    }


    function end_date()
    {
        $customer          = Frontend::getCustomer();
        $customerMail = $customer->cMail;
        $rentals = Rental::get();
        $currentTime = new \DateTime('now');
        foreach ($rentals as $key => $rental) {
            $diff = date_diff($rental->dropoff_date, $currentTime);
            if ($diff->h <= 24) {
                // send E-mail
                $clientBody = file_get_contents(__DIR__ . "/../../Support/Mail/ClientEndDate.php");
                $ownerBody = file_get_contents(__DIR__ . "/../../Support/Mail/OwnerEndDate.php");
                // send mail to client
                (new MailService(
                    $customerMail,
                    'Reservation',
                    $clientBody
                ))->sendMail();

                // send mail to shop owner
                (new MailService(adminEmail(), 'Reservation', $ownerBody))->sendMail();
            }
        }
    }
}

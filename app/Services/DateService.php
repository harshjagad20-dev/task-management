<?php

namespace App\Services;

use Carbon\Carbon;

class DateService {
    public static function addWorkingDays($start, $days) {
        $date = Carbon::parse($start);

        while ($days > 0) {
            $date->addDay();

            if (!$date->isWeekend()) {
                $days--;
            }
        }

        return $date->toDateString();
    }
}

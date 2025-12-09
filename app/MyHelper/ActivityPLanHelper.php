<?php

namespace App\MyHelper;

use Carbon\Carbon;

class ActivityPlanHelper
{
    public static function estimatedDuration($startDate, $endDate)
    {
        if (!$startDate || !$endDate) {
            return null;
        }

        return Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;
    }
}

<?php

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Cassandra\Timestamp;

/**
 *
 * Import Posts command function
 * @return void
 */

if (!function_exists('importPosts')) {

    function importPosts(): void
    {

        $admin = User::whereRoleIs('admin')->first();
        if (!$admin) {
            abort(403, 'Unauthorized action.');
        }

    }

}

/**
 * Format Date to month Name and Date
 * @param $date
 * @return mixed|string
 */

if (!function_exists('getMonthAndDate')) {

    function getMonthAndDate($date)
    {
        try {
            return $date->format('F d');
        } catch (Throwable $exception) {
            return $exception->getMessage();
        }

    }
}

if (!function_exists('getTime')) {
    function getTime($date): string
    {
        return Carbon::createFromTimestamp($date)->format('H:i');

    }
}

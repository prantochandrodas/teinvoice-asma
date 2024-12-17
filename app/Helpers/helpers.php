<?php

function last_query_start() {
    \DB::enableQueryLog();
}

function last_query_end() {
    $query = \DB::getQueryLog();
    dd(end($query));
}

function file_url($file, $path) {
    return asset('uploads/' . $path . '/' . $file);
}

function setTimeZone() {
    date_default_timezone_set('Asia/Dhaka');
}

function auth_admin_user_permission($permission) {
    $auth = \Auth::guard('admin')->user();
    return $auth->can($permission) || ($auth->email == defaultAdmin());
}

function defaultAdmin() {
    return 'admin@gmail.com';
}

function auth_admin_user() {
    return auth()->guard('admin')->user();
}

function auth_customer_user() {
    return auth()->guard('customer')->user();
}

function get_browser_name($user_agent) {
    $t = strtolower($user_agent);
    $t = " " . $t;

    if (strpos($t, 'opera') || strpos($t, 'opr/')) {
        return 'Opera';
    } elseif (strpos($t, 'edge')) {
        return 'Edge';
    } elseif (strpos($t, 'chrome')) {
        return 'Chrome';
    } elseif (strpos($t, 'safari')) {
        return 'Safari';
    } elseif (strpos($t, 'firefox')) {
        return 'Firefox';
    } elseif (strpos($t, 'msie') || strpos($t, 'trident/7')) {
        return 'Internet Explorer';
    }

    return 'Unkown';
}

function current_guard() {
    $allGuards       = config('auth.guards');
    $auth            = null;
    $guardName       = null;
    $userId          = null;

    foreach ($allGuards as $guard => $guard_value) {

        if (request()->is('api/*')) {
            if(auth("shop_api")->user()){
                $auth      = auth("shop_api")->user();
                $guardName = $guard;
                $userId    = $auth->id;
            }
            elseif(auth("customer_api")->user()){
                $auth      = auth("customer_api")->user();
                $guardName = $guard;
                $userId    = $auth->id;
            }
        }
        elseif (auth()->guard($guard)->check()) {
            $auth      = auth($guard)->user();
            $guardName = $guard;
            $userId    = $auth->id;
        }
    }

    return [
        "activityCauseBy" => $auth,
        "guardName"       => $guardName,
        "userId"          => $userId,
    ];
}


function convertNumberToWords($number) {
    $words = array(
        0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
        6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
        11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty',
        30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
        80 => 'Eighty', 90 => 'Ninety'
    );

    $digits = array(
        '', 'Thousand', 'Lakh', 'Crore'
    );

    if ($number == 0) {
        return 'Zero';
    }

    $result = '';
    $place = 0;

    // Split the number into groups of 3 digits from right to left
    while ($number > 0) {
        $remainder = $number % 1000; // Get the last 3 digits
        $number = floor($number / 1000); // Remove last 3 digits

        if ($remainder > 0) {
            $result = convertThreeDigits($remainder, $words) . ' ' . $digits[$place] . ' ' . $result;
        }

        $place++;
    }

    return trim($result);
}

function convertThreeDigits($number, $words) {
    $result = '';

    if ($number >= 100) {
        $hundreds = floor($number / 100);
        $result .= $words[$hundreds] . ' Hundred ';
        $number %= 100;
    }

    if ($number >= 20) {
        $tens = floor($number / 10) * 10;
        $result .= $words[$tens] . ' ';
        $number %= 10;
    }

    if ($number > 0) {
        $result .= $words[$number] . ' ';
    }

    return trim($result);
}


?>

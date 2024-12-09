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

?>

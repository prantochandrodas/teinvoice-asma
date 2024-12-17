<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\Models\Application;

class LocalizationController extends Controller
{
    /**
     * @param $locale
     * @return RedirectResponse
     */
    public function index($locale){

        if(!($locale == "ar" || $locale == "bn" || $locale == "en")){
            $locale = "en";
        }

        $secondary_locale='ar';
        if ($locale == "ar"){
            $secondary_locale='en';
        }

        Application::query()->update(['locale' => $locale]);

        app()->setLocale($locale);
        session()->put('locale', $locale);
        session()->put('secondary_locale', $secondary_locale);
        return redirect()->back();
    }
}

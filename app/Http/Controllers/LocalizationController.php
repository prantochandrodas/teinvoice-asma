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

        Application::query()->update(['locale' => $locale]);

        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }
}

<?php

namespace App\Providers;

use App\Models\Application;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        Activity::saving(function (Activity $activity) {

            $current_guard = current_guard();

            $activity->guard   = $current_guard['guardName'];
            $activity->user_id = $current_guard['userId'];
            $activity->ip      = request()->ip();
            $activity->browser = get_browser_name(request()->userAgent());

            if (!empty($current_guard['activityCauseBy'])) {
                $activity->causer()->associate($current_guard['activityCauseBy']);
            }

        });

        Schema::defaultStringLength(191);

        View::share('application', Application::first());

    }

}

<?php

namespace App\Providers;

use App\Enums\Modules;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';
    /**
     * @var array
     */
    private $moduleList = [];

    /**
     * @param $app
     */
    public function __construct($app)
    {
        parent::__construct($app);
        $this->moduleList[] = Modules::AUTH->value;
        $this->moduleList[] = Modules::COURSE->value;
        $this->moduleList[] = Modules::USER->value;
        $this->moduleList[] = Modules::STATS->value;
        $this->moduleList[] = Modules::NOTES->value;
        $this->moduleList[] = Modules::REVIEWS->value;
        $this->moduleList[] = Modules::COURSE_START->value;
        $this->moduleList[] = Modules::SECTIONS->value;
        $this->moduleList[] = Modules::LESSONS->value;
        $this->moduleList[] = Modules::QUESTIONS->value;
        $this->moduleList[] = Modules::ANSWERS->value;
        $this->moduleList[] = Modules::TESTS->value;
    }

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            foreach ($this->moduleList as $module) {
                Route::middleware('api')
                    ->prefix('api' . "/" . strtolower($module))
                    ->group(
                        app_path() . DIRECTORY_SEPARATOR . "Modules" . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . "routes.php");
            }

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}

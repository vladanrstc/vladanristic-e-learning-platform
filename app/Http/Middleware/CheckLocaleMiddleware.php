<?php

namespace App\Http\Middleware;

use App\Enums\Languages;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class CheckLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if(!is_null(!is_array($lang = $request->header("Lang")))) {
            App::setLocale($lang);
        }

        App::setLocale(Languages::EN->value);

        return $next($request);
    }
}

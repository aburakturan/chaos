<?php

namespace App\Http\Middleware;

use App;
use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Route;
use Exception;

class RedirectLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $firstSegment = $request->segment(1);
        $availableLocales = config('app.locales');

        // If first segment is equal to default locale then continue normal request
        if ($firstSegment == config('app.locale')) {
            return $next($request);
        }

        // Browser language
        if (is_null($firstSegment) && isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $browserLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

            if (isset($availableLocales[$browserLanguage])) {
                App::setLocale($browserLanguage);
            }
        }

        // Change locale
        if (isset($availableLocales[$firstSegment])) {
            App::setLocale($firstSegment);
        }

        // Redirect locale url
        try {
            Route::getRoutes()->match($request->instance());
        } catch (Exception $e) {
            $createRequest = Request::create(App::getLocale().'/'.$request->path());

            // Check if target is not found?
            try {
                $tryThisURL = config('app.url').'/'.$createRequest->path();
                $client = new Client([
                    'verify' => false
                ]);
                $client->request('GET', $tryThisURL);
            } catch (BadResponseException $e) {
                if ($e->getResponse()->getStatusCode() == 404) {
                    return $next($request);
                }
            }

            return redirect($createRequest->path());
        }

        return $next($request);
    }
}

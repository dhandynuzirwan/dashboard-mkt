<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\UserPageVisit;

class TrackPageVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Hanya lacak request GET, user terautentikasi, dan bukan request AJAX
        if ($request->isMethod('GET') && Auth::check() && !$request->ajax()) {
            $routeName = Route::currentRouteName();

            if ($routeName) {
                // Ambil daftar route yang bisa dilacak dari konfigurasi
                $trackableRoutes = config('quickaccess');
                
                // Jika route ini ada di daftar quickaccess
                if ($trackableRoutes && array_key_exists($routeName, $trackableRoutes)) {
                    $userId = Auth::id();
                    
                    // Gunakan updateOrCreate untuk menambah visits
                    $visit = UserPageVisit::firstOrCreate(
                        ['user_id' => $userId, 'route_name' => $routeName]
                    );
                    
                    $visit->increment('visits');
                }
            }
        }

        return $response;
    }
}

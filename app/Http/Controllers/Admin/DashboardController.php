<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guardian;
use App\Models\Camper;
use App\Models\Friend;
use App\Models\CampEnrollment;
use Illuminate\Support\Facades\Http;


class DashboardController extends Controller
{
    public function index()
    {
        $guardianZips = Guardian::whereNotNull('zip_code')
            ->distinct()
            ->pluck('zip_code')
            ->toArray();

        $zipCoordinates = collect($guardianZips)->map(function ($zip) {
            $response = Http::get('http://api.positionstack.com/v1/forward', [
                'access_key' => 'bd732ee3739d230a4275c16aba67e802',
                'query' => $zip,
                'country' => 'US',
                'limit' => 1,
            ]);

            if ($response->ok() && isset($response['data'][0])) {
                return [
                    'zip' => $zip,
                    'lat' => (float) $response['data'][0]['latitude'],
                    'lng' => (float) $response['data'][0]['longitude'],
                ];
            }

            return null;
        })->filter()->values();       
        
        $guardianCount = Guardian::count();
        $camperCount = Camper::count();
        $friendCount = Friend::count();
        $campEnrollmentCount = CampEnrollment::count();

        return view('dashboard', compact(
            'guardianCount',
            'camperCount',
            'friendCount',
            'campEnrollmentCount',
            'zipCoordinates'
        ));
    }
}

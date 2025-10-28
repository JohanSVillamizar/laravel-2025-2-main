<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Venue;
use App\Models\Event;
use App\Models\Computer;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Métricas básicas
        $usersCount    = User::count();
        $venuesCount   = Venue::count();

        // Eventos (total y próximos por event_date)
        $eventsTotal    = Event::count();
        $eventsUpcoming = Event::whereDate('event_date', '>=', now())->count();
        $eventsCount    = $eventsTotal; // o usa $eventsUpcoming si prefieres

        // Computers según tu esquema (no existe 'status')
        $computersTotal = Computer::count();
        // Desglose opcional:
        $laptopsCount   = Computer::where('computer_is_laptop', true)->count();
        $desktopsCount  = Computer::where('computer_is_laptop', false)->count();

        // Últimos venues
        $latestVenues = Venue::orderByDesc('id')
            ->take(5)
            ->get(['id', 'venue_name', 'venue_status']);

        return Inertia::render('Dashboard', [
            'metrics' => [
                'users'     => $usersCount,
                'venues'    => $venuesCount,
                'events'    => $eventsCount,
                'computers' => $computersTotal, // ← usa este en tu tarjeta “Computadores”
                // Si quieres mostrar también el desglose, envíalos:
                'laptops'   => $laptopsCount,
                'desktops'  => $desktopsCount,
                'events_upcoming' => $eventsUpcoming,
            ],
            'latest' => [
                'venues' => $latestVenues,
            ],
        ]);
    }
}
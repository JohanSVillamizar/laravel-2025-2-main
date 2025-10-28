<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Listado de eventos (con venue).
     */
    public function index(Request $request)
    {
        $query = Event::query()->with('venue');

        // Aplica filtros si los usas (opcional)
        if ($request->filled('venue_id')) {
            $query->where('fk_venue_event', $request->input('venue_id'));
        }

        // Ordena por la columna correcta 'event_date'
        $events = $query->orderBy('event_date', 'desc')->get();

        return Inertia::render('Events/Index', [
            'events' => $events,
            'filters' => [
                'venue_id' => $request->input('venue_id'),
            ],
            'venues' => Venue::orderBy('venue_name')->get(['id', 'venue_name']),
        ]);
    }


    /**
     * Formulario de creación.
     */
    public function create(Request $request)
    {
        // Opcionalmente preseleccionar venue_id con ?venue_id=#
        $prefillVenueId = $request->integer('venue_id');

        return Inertia::render('Events/Create', [
            'venues' => Venue::orderBy('venue_name')->get(['id', 'venue_name']),
            'prefill' => [
                'venue_id' => $prefillVenueId,
            ],
        ]);
    }

    /**
     * Persistir un nuevo evento.
     */
    public function store(StoreEventRequest $request)
    {
        Event::create($request->validated());

        return redirect()
            ->route('events.index')
            ->with('success', 'Evento creado correctamente');
    }

    /**
     * Mostrar detalle.
     */
    public function show(Event $event)
    {
        $event->load(['venue:id,venue_name,venue_address,venue_max_capacity']);

        return Inertia::render('Events/Show', [
            'event' => $event,
        ]);
    }

    /**
     * Formulario de edición.
     */
    public function edit(Event $event)
    {
        return Inertia::render('Events/Edit', [
            'event'  => $event->load(['venue:id,venue_name']),
            'venues' => Venue::orderBy('venue_name')->get(['id', 'venue_name']),
        ]);
    }

    /**
     * Actualizar evento.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());

        return redirect()
            ->route('events.index')
            ->with('success', 'Evento actualizado correctamente');
    }


    /**
     * Eliminar evento.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return back()->with('success', 'Evento eliminado');
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVenueRequest;
use App\Http\Requests\UpdateVenueRequest;
use App\Models\Venue;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $venues = Venue::orderBy('id', 'desc')->get();

        return Inertia::render('Venues/Index', [
            'venues' => $venues,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Venues/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVenueRequest $request)
    {
        $data = $request->validated();

        // Si tu modelo tiene una columna de imagen, puedes manejarla aquí:
        if ($request->hasFile('venue_image')) {
            $data['venue_image'] = $request->file('venue_image')->store('venues', 'public');
        }

        Venue::create($data);

        return redirect()->route('venues.index')->with('success', 'Lugar creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Venue $venue)
    {
        // Si quieres cargar eventos asociados
        $venue->load('events');

        return Inertia::render('Venues/Show', [
            'venue' => $venue,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $venue = Venue::findOrFail($id);

        return Inertia::render('Venues/Edit', [
            'venue' => $venue
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVenueRequest $request, Venue $venue)
    {
        $data = $request->validated();

        // Si tienes imágenes:
        if ($request->hasFile('venue_image')) {
            // Eliminar imagen anterior si existe
            if ($venue->venue_image && Storage::disk('public')->exists($venue->venue_image)) {
                Storage::disk('public')->delete($venue->venue_image);
            }

            $data['venue_image'] = $request->file('venue_image')->store('venues', 'public');
        }

        $venue->update($data);

        return redirect()->route('venues.index')->with('success', 'Lugar actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venue $venue)
    {
        if ($venue->venue_image && Storage::disk('public')->exists($venue->venue_image)) {
            Storage::disk('public')->delete($venue->venue_image);
        }

        $venue->delete();

        return redirect()->route('venues.index')->with('success', 'Lugar eliminado correctamente.');
    }
}

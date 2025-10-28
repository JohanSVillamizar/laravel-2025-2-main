<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // App/Http/Controllers/Web/VenueController.php
    public function index()
    {
        return Inertia::render('Venues/Index', [
            'venues' => Venue::orderBy('id', 'asc')->get()
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'venue_name' => ['required', 'string', 'max:255'],
            'venue_max_capacity' => ['required', 'integer', 'min:1'],
            'venue_address' => ['nullable', 'string', 'max:500'],
            'venue_status' => ['required', 'boolean'],
        ]);

        Venue::create($validated);

        return redirect()->route('venues.index')->with('success', 'Lugar creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Venue $venue)
    {
        return Inertia::render('Venues/Show', ['venue' => $venue]);
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
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'venue_name' => ['required', 'string', 'max:255'],
            'venue_max_capacity' => ['required', 'integer', 'min:1'],
            'venue_address' => ['nullable', 'string', 'max:500'],
            'venue_status' => ['required', 'boolean'],
        ]);

        $venue = Venue::findOrFail($id);
        $venue->update($validated);

        return redirect()->route('venues.index')->with('success', 'Lugar actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venue $venue)
    {
        $venue->delete();
        return back()->with('success', 'Lugar eliminado');
    }
}

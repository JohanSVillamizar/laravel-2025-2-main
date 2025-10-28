<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Computer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ComputerController extends Controller
{
    public function index()
    {
        $computers = Computer::orderBy('id_computer', 'desc')->get();
        return Inertia::render('Computers/Index', ['computers' => $computers]);
    }

    public function create()
    {
        return Inertia::render('Computers/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'computer_brand'     => ['required','string','max:100'],
            'computer_model'     => ['required','string','max:100'],
            'computer_price'     => ['nullable','numeric','min:0'],
            'computer_ram_size'  => ['nullable','integer','min:1'],
            'computer_is_laptop' => ['required','boolean'],
            'category_id'        => ['nullable','integer'],
            'computers_barcode'  => ['nullable','string','max:100','unique:computers,computers_barcode'],
        ]);

        Computer::create($validated);

        return redirect()->route('computers.index')->with('success', 'Equipo creado');
    }

    public function show(Computer $computer)
    {
        return Inertia::render('Computers/Show', ['computer' => $computer]);
    }

    public function edit(Computer $computer)
    {
        return Inertia::render('Computers/Edit', ['computer' => $computer]);
    }

    public function update(Request $request, Computer $computer)
    {
        $validated = $request->validate([
            'computer_brand'     => ['required','string','max:100'],
            'computer_model'     => ['required','string','max:100'],
            'computer_price'     => ['nullable','numeric','min:0'],
            'computer_ram_size'  => ['nullable','integer','min:1'],
            'computer_is_laptop' => ['required','boolean'],
            'category_id'        => ['nullable','integer'],
            'computers_barcode'  => ['nullable','string','max:100','unique:computers,computers_barcode,'.$computer->id_computer.',id_computer'],
        ]);

        $computer->update($validated);

        return redirect()->route('computers.index')->with('success', 'Equipo actualizado');
    }

    public function destroy(Computer $computer)
    {
        $computer->delete();
        return back()->with('success', 'Equipo eliminado');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Mesa; 
use Illuminate\Http\Request;
use App\Http\Requests\MesaStoreRequest;
use App\Http\Requests\MesaUpdateRequest;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $mesas = Mesa::orderBy('numero')->get();
        return view('mesas.index', compact('mesas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mesas.create');
    }

    public function store(MesaStoreRequest $request)
    {
        $request->validate([
            'numero' => 'required|unique:mesas',
            'capacidad' => 'required|integer|min:1',
        ]);

        Mesa::create($request->all());

        return redirect()->route('mesas.index')
            ->with('success', 'Mesa creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mesa = Mesa::find($id);
        return view('mesas.edit', compact('mesa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MesaUpdateRequest $request, Mesa $mesa)
    {
       
        //dd('ENTRÓ AL UPDATE', $request->all(), $mesa);
       
        $mesa->update($request->validated());
        return redirect()
            ->route('mesas.index')
            ->with('success', 'Mesa actualizada correctamente');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mesa $mesa)
    {
        abort_if($mesa->estado !== 'libre', 403, 'Mesa ocupada');

        $mesa->delete();

        return back()->with('success', 'Mesa eliminada');
    }

}

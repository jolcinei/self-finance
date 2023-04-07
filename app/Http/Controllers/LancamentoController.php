<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Lancamento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LancamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('lancamentos.index', [
            'lancamentos' => Lancamento::with(['user', 'categoria'])->orderBy('data_referencia', 'desc')->latest()->get(),
            'categorias' => Categoria::with('user')->where('parent_id', '!=', null)->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'valor' => 'required|decimal:2',
            'comentario' => 'string|max:255',
            'categoria_id' => 'required|int',
            'data_referencia' => 'required|date_format:Y-m-d',
        ]);
        $request->user()->lancamentos()->create($validated);

        return redirect(route('lancamentos.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Lancamento $lancamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lancamento $lancamento): View
    {
        $this->authorize('update', $lancamento);

        return view('lancamentos.edit', [
            'lancamento' => $lancamento,
            'categorias' => Categoria::where('parent_id', '!=' , null)
                ->orderBy('nome')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lancamento $lancamento): RedirectResponse
    {
        $this->authorize('update', $lancamento);

        $validated = $request->validate([
            'valor' => 'required|decimal:2',
            'comentario' => 'string|max:255',
            'categoria_id' => 'required|int',
            'data_referencia' => 'required|date_format:Y-m-d',
        ]);

        $lancamento->update($validated);

        return redirect(route('lancamentos.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lancamento $lancamento): RedirectResponse
    {
        $this->authorize('delete', $lancamento);

        $lancamento->delete();

        return redirect(route('lancamentos.index'));
    }
}

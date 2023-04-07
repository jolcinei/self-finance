<?php

namespace App\Http\Controllers;

use App\Enums\CategoriaOperacaoEnum;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;

class CategoriaController extends Controller
{

    public function index(): View
    {
        return view('categorias.index', [
            'categorias' => Categoria::with('user')->latest()->get(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
            'operacao' => [new Enum(CategoriaOperacaoEnum::class)],
        ]);

        $request->user()->categorias()->create($validated);

        return redirect(route('categorias.index'));
    }

    public function show(Categoria $categoria)
    {
        //
    }

    public function edit(Categoria $categoria): View
    {
        $this->authorize('update', $categoria);

        return view('categorias.edit', [
            'categoria' => $categoria,
            'categorias' => Categoria::where('operacao', $categoria->operacao)
                            ->orderBy('nome')->get(),
        ]);
    }

    public function update(Request $request, Categoria $categoria): RedirectResponse
    {
        $this->authorize('update', $categoria);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
            'operacao' => [new Enum(CategoriaOperacaoEnum::class)],
            'parent_id' => 'int',
        ]);

        $categoria->update($validated);

        return redirect(route('categorias.index'));
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        $this->authorize('delete', $categoria);

        $categoria->delete();

        return redirect(route('categorias.index'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $query = Produto::with('categoria');

        // Ordenação solicitada (padrão: mais antigos primeiro, mais novos por último)
        match ($request->get('ordem')) {
            'mais_novos' => $query->latest(),
            'nome_asc' => $query->orderBy('nome', 'asc'),
            'maior_preco' => $query->orderBy('preco', 'desc'),
            'menor_preco' => $query->orderBy('preco', 'asc'),
            'maior_estoque' => $query->orderBy('quantidade', 'desc'),
            default => $query->oldest(), // Ordena por data de criação crescente: os mais novos ficam por último
        };

        $produtos = $query->get();
        return view('index', compact('produtos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Produto::create($validated);

        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $nome = $produto->nome;
        $produto->delete();

        return redirect()->route('produtos.index')->with('success', "Produto '{$nome}' excluído com sucesso!");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with('categoria')->latest()->get();
        return view('index', compact('produtos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Produto::create($request->all());

        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesafioController extends Controller
{
    public function saudacaoIdade($nome,$idade){
        return view('desafio', ['nome' => $nome, 'idade' => $idade]);
    }
}

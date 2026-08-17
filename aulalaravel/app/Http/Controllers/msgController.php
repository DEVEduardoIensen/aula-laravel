<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class msgController extends Controller
{
    public function enviarmensagem(){
        $mensagem = "mensagem enviada para a view";
        return view('mensagem', ['texto' => $mensagem]);
    }

    public function saudacao(String $nome){
        return view('oi', ['nome' => $nome]);
    }
}
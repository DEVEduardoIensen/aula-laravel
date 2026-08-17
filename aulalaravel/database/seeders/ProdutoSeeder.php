<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Produto;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('produtos')->insert([
            'nome' => 'Notebook Dell',
            'preco' => 5000.00,
            'quantidade' => 10,
            'categoria_id' => 2,
        ]);

        Produto::create([
            'nome' => 'Monitor 24pol',
            'preco' => 800.00,
            'quantidade' => 4,
            'categoria_id' => 2,
        ]);

        Produto::create([
            'nome' => 'aliança',
            'preco' => 150.00,
            'quantidade' => 5,
            'categoria_id' => 3,
        ]);
    }
}

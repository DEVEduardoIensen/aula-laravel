<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

Route::get('/', function () {
    return redirect('produtos');
});

Route::prefix('produtos')->name('produtos.')->group(function () {
    Route::get('/', [ProdutoController::class, 'index'])->name('index');
    Route::get('create', [ProdutoController::class, 'create'])->name('create');
    Route::post('/', [ProdutoController::class, 'store'])->name('store');
    Route::delete('{produto}', [ProdutoController::class, 'destroy'])->name('destroy');
});

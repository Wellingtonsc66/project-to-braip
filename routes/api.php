<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProdutoController;


Route::post('adicionar-produtos', [ProdutoController::class, 'create']);
Route::post('baixar-produtos', [ProdutoController::class, 'update']);

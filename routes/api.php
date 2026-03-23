<?php

use App\Http\Controllers\Eleve\QuizController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth')->group(function () {
    Route::get('/quiz/questions', [QuizController::class, 'getQuestions']);
});
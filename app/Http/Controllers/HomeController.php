<?php

namespace App\Http\Controllers;

use App\Models\PageView;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Incrément atomique du compteur de vues
        $totalVues = PageView::hit('home');

        return view('welcome', compact('totalVues'));
    }
}
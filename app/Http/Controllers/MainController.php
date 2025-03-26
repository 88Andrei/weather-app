<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
  public function index(): \Illuminate\View\View
  {
    return view('home');
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index() {
        if (session('isLog') == true){
            // $fill = fonctionsController::fill_eim_table();
            return view('home');
        } else {
            return redirect(route('try.login'));
        }
    }}

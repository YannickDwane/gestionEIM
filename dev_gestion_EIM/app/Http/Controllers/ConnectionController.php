<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    function connect(){
        
        if (isset($_SERVER['HTTP_REMOTE_USER']) && isset($_SERVER['HTTP_GROUPS'])) {
            $groups = explode(';',$_SERVER['HTTP_GROUPS']);
            session(['isLog' => True]);
            session(['username' => $_SERVER['HTTP_REMOTE_USER']]);
            session(['group' => $groups]);
            if (empty(session('redirect')))
                session(['redirect' => "home"]);
            return redirect(route(session('redirect')));
        }else{
            session(['isLog' => True]);
            session(['username' => "yannick.rakotonirina"]);
            session(['group' => ["Support Technique"," Direction Informatique"]]);
            return redirect(route('home')); //'portail'
        }
    }
}

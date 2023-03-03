<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LdapRecord\Container;
use LdapRecord\Connection;
use LdapRecord\Utilities;
use LdapRecord\LdapInterface;

use App\Models\ldapModel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as BasicAuthenticatable;
//Gère la connexion LDAP de l'utilisateur

class ldapController extends Controller
{
    //
    private $ad_login;

    public function __construct()
    {
        $this->ad_login = new ldapModel();
    }

    //Vérifie les données du formulaires

    public function connection(){
        request()->validate([
            'login' => ['required','regex:/^[0-9A-Za-z.\-_]+$/u'],
            'password' => ['required', 'string'],
        ]);
        $login = request("login");
        $password = request("password");
        try {
            $data = $this->ad_login->getConnectionAd($login, $password);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
            //Vérifie si la connexion est réussie
        //session(['username' => $login]);
        //$data['success'] = 'true';
        if ($data['success'] == 'false' ) {
            session(['isLog' => False]);
            session(['username' => ""]);
            //Retourne erreur
            return redirect(route('view.login'))->withInput()->withErrors([
                'password' => "Identifiants inccorects",
            ]);
        }
            //Change de page
        else {
            //print($data);
            session(['isLog' => True]);
            session(['username' => $login]);
            session(['group' => $data['group']]);
            return view('home');
        }
    }
}

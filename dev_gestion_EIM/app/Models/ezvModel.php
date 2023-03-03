<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ezvModel extends Model
{
    use HasFactory;

    public function eims(){
        $db = DB::select("SELECT eim_numinv as numInv, eim_statut as statut, eim_marque as marque, eim_modele as modele, eim_entite as entite, eim_localisation as localisation from eims where eim_statut = 'En service' AND eim_entite NOT LIKE '_CD974/CABINET/GROUPE/%';");
        
        $jsdb = json_encode($db, JSON_PRETTY_PRINT);
        $lesLignes=json_decode($jsdb,true);

        foreach ($lesLignes as $key => $value) {
            $adip = "pr".$value['numInv'];
            $lesLignes[$key]['ip'] = $adip;
        }
        
        return $lesLignes ;
    }
}

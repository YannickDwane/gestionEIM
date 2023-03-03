<?php

namespace App\Models;

// namespace App\Ldap;

use Illuminate\Http\Request;
use LdapRecord\Container;
use Illuminate\Database\Eloquent\Model;
// use LdapRecord\Models\ActiveDirectory\User;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ldapModel extends Model
{
    private static $server = '10.2.1.204';
    private static $port = '389';
    private static $baseDn = 'dc=intranet,dc=cg974,dc=fr';
  // private static $server = env('LDAP_HOST', 'default');
  // private static $port = env('LDAP_PORT');
  // private static $baseDn = env('LDAP_BASE_DN');
    private static $domain = 'intranet.cg974.fr';
    private static $group = ["Support Technique", "Direction Informatique", "Referents_Informatiques"];
    private static $ldap;

    public function __construct() {
        ### On se connecte au server AD
        if (ldap_connect(ldapModel::$server, ldapModel::$port)) {
            ldapModel::$ldap = ldap_connect(ldapModel::$server, ldapModel::$port);
            ldap_set_option(ldapModel::$ldap,   LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option(ldapModel::$ldap, LDAP_OPT_REFERRALS, 0);
        } else {
            throw new Exception('Connexion au serveur ad impossible');
        }
    }

    public function __destruct() {
        ldapModel::$ldap = null;
    }

    public function getConnectionAd ($username,$password) {
            $user = $username."@intranet.cg974.fr";
            ###Format prénom.nom@intranet.cg974.fr
            ###Connexion à l'AD
            $conn = @ldap_bind(ldapModel::$ldap, $user, $password);
            ###Mauvais identifiants
            if (!$conn) {
                return array("success" => 'false', "message" => "Login ou mot de passe incorect");
            }

            ###On récupère le distinguishedName

            try {
                $dn = $this->getDn($username); 
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }

            ###On récupère le nom de l'utilisateur
            // $_SESSION['user'] = $this->getCn($dn);

            ###Test si l'utilisateur est dans un groupe autorisé
            $infosUser = explode(',', $dn);
            $Groupes = array();
            // dd($infosUser);
            foreach ($infosUser as $info) {
                if ($info) { 
                    if ($info[0] !== 'O'){
                        continue;
                    }
                    $Groupes[] = $info;
                    ###On parcours les groupes de l'utilisateur pour voir si au moins un groupe correspond au groupe souhaité
                    $i=0;
                    $gp=[];
                    foreach ($Groupes as $groupe) {
                        $gp[$i] = explode('=', $groupe)[1];
                        return array("success" => 'true', "message" => "Connecté", "CN" => $this->getCn($dn), "group" => $gp);
                        $i++;
                    }
                }
            }
            return array("success" => 'false', "message" => "Vous n'êtes pas autorisé à vous connecté à l'application");    
    }

    private function getDn($username) {
        ###On recherhce le dn avec l'identifiant récupéré
        $dn = @ldap_search(ldapModel::$ldap, ldapModel::$baseDn, "(samaccountname=" . $username . ")", array('dn'));
        ###Aucun résultat trouvé
        if (!$dn) {
            return '';
        }
    
        $entries = ldap_get_entries(ldapModel::$ldap, $dn);
        if ($entries['count'] > 0) {
            return $entries[0]['dn'];
        }

        return '';
    }

    private function getCn($entries) {
        ini_set("pcre.jit", "0");
        ###Récupérer le nom de l'utilisateur
        preg_match('/[^,]*/', $entries, $matchs, PREG_OFFSET_CAPTURE, 3);
        return $matchs[0][0];
    }
}
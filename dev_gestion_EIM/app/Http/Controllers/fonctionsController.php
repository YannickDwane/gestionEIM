<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Ndum\Laravel\Snmp;
use FreeDSx\Snmp\SnmpClient;
use FreeDSx\Snmp\Exception\SnmpRequestException;
use FreeDSx\Snmp\Oid;

/*
FreeDSx reference : https://github.com/FreeDSx/SNMP/blob/master/docs/Client/Request-Types.md
*/

class fonctionsController extends Controller
{
    public static function speedtest(){
        $domain_name = "pr171212";
        $stime = microtime(true);
        $ip =gethostbyname($domain_name);
        $etime = microtime(true);
        $ttime = $etime - $stime;
        echo "Total time for gethostbyname : ".$ttime."s \n";
        echo $ip."\n";
    }

    public static function eims(){
        $db = DB::select("SELECT eim_numinv as numInv, eim_statut as statut, eim_marque as marque, eim_modele as modele, eim_entite as entite, eim_localisation as localisation from eims where eim_statut = 'En service' AND eim_entite NOT LIKE '_CD974/CABINET/GROUPE/%';");
        
        $jsdb = json_encode($db, JSON_PRETTY_PRINT);
        $lesLignes=json_decode($jsdb,true);

        foreach ($lesLignes as $key => $value) {
            // $adip = gethostbyname('PR' . $value['numInv']);
            // if(str_starts_with($adip,'PR')){
            //     $adip = gethostbyname('pr' . $value['numInv']);
            // }
            $adip = "pr".$value['numInv'];
            $lesLignes[$key]['ip'] = $adip;
        }
        
        return $lesLignes ;
    }

    public static function tocsv(){
        // CSV file name => eims.csv
        $csv = 'eims - '.date("Y_m_d - H_i_s").'.csv';
        // File pointer in writable mode
        $file_pointer = fopen($csv, 'w');

        
        // Traverse through the associative
        // array using for each loop
        $header = false;
        foreach(static::eims() as $i){
            
            if (empty($header))
            {
                $header = array_keys($i);
                fputcsv($file_pointer, $header,';', "\"", "\n");
                $header = array_flip($header);
            }
            $line_array = array();
	
            foreach($i as $value) {
                array_push($line_array, $value);
            }

            fputcsv($file_pointer, $line_array,';', "\"", "\n");
        }
        // Close the file pointer.
        fclose($file_pointer);  
        
        if (file_exists($csv)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($csv) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($csv));
            readfile($csv);  
            unlink($csv); 
        }
        exit;
    }
    

    private function sock_ping($host) {
        // $curl = curl_init($host);
        // curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        // curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // $data = curl_exec($curl);
        // $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // curl_close($curl);
        // if ($httpCode >= 200 && $httpCode < 300) {
        //     echo 'success';
        // } else {
        //     echo "error";
        // }
        // if(str_starts_with($host,'pr')){
        //     return "Connexion perdue ";
            
        // }else{
        exec("ping -c 1 " . $host, $output, $result);


        if ($result == 0){
            return "L'eim " . $host . " est connecté";
        }
        else{
            return "Connexion perdue";
        }

            
            // if(){
            //     return "Connexion perdue: " . $host;
            //     // return "La machine " . $host . " est connectée ";
            //     // return $fp; 
            // }else{
            //     //  
            //     // return $fp;    
            //     return "La machine " . $host . " est connectée ";
            // }
        // }
        
            // CHECK IF SOCKET CAN REACH
        // return $fp;    
        
    }

    /*
    * Fonction utilisé pour avoir chaque IP et les transformer en format JSON
    */
    public static function ip_to_json() {
        $i = 0;
        $array = [];
        foreach (static::eims() as $monEim) { //Recupére et créer ke format JSON
            $array += [$i => $monEim['ip']];
            $Myjson = json_encode($array);
            $i++;
        }
        return $Myjson;
    }

    /*
    * Fonction utilisé pour avoir chaque modele et les transforme en format JSON
    */
    public static function model_to_json() {
        $i=0;
        $array = [];
        
        foreach (static::eims() as $monEim){
            $array += [$i => $monEim['modele']];
            $Myjson = json_encode($array);
            $i++;
        }
        return $Myjson;
    }


    /*
    * Fontion pour génrér le Tableau
    */
    public static function fill_eim_table() {
        //On va remplir le tableau avec les informations des Eim
        $i = 0;
        $array = [];
        $color=["E-studio 3015 AC A3/A4 color","E-studio 347CS A4 color","E-Studio 3005 AC A3/A4 color"];

        $url = file_get_contents('https://ninemiles.intranet.cg974.fr/ezv/getEmployee.php?loginAD=' . session('username'));
        $jsonArray = json_decode($url, true);
        $Localisation_user = "ENTITE";

        $Explode_Groups = session('group');
        switch($Explode_Groups){
            
            case (in_array(" Direction Informatique", $Explode_Groups)):
                foreach (static::eims() as $monEim) {
                    $href = /* "<a href=http://" . $monEim['ip'] . " target='_blank'>" . */$monEim['ip']/* . "</a>" */;
                    // On change le bouton de couleur
                    // $host=$monEim['ip'];
                    // if (str_starts_with($monEim['ip'],'pr')) {
                    //     $image = "rondRouge";
                    // } 
                    // else{
                    //     $image = "rondVert";
                    // }   
                    $image = "rondPing";
                    
                    
                    if (in_array($monEim['modele'], $color)){
                        
                            echo "
                                    <tr>
                                    <td class='numInv'>" . $monEim['numInv'] . "</td>
                                    <td class='marque'>" . $monEim['marque'] . "</td>
                                    <td class='modele'>" . $monEim['modele'] . "</td>
                                    <td class='entite'>" . $monEim['entite'] . "</td>
                                    <td class='localisation'>" . $monEim['localisation'] . "</td>
                                    <td class='cmpteur'> <button id='encre" . $i . "' style='border:none;background:none;'> <img src='Images/Colorwheel.svg'   alt='Ok' width='30px' ></button> <br><br> <div id='encre_div" . $i . "'></div> <div class='progress' id='progress".$i."'><div class='bar' id='bar".$i."'></div></div></td>";
                            //echo "<td class='cmpteur'><button id='copie" . $i . "' style='border:none;background:none;'> <img src='Images/loupe.png' width='30px' ' alt='Ok'></button> <br><br> <div id='copie_div" . $i . "'></div> </td>";
                            echo "<td class='ping'><button style='border:none;background:none;' id='Ping" . $i . "' ><img  id='img".$i."' src='Images/" . $image . ".png'  alt='Ok' width='30px' ></button> <br><br> <div id='Ping_div" . $i . "'></div></td>
                                    <td class='reset'><button id='show" . $i . "' style='border:none;background:none;'> <img src='Images/svg/printer.svg'  alt='Ok' width='30px' ></button>  </td>
                                    </tr>
                                    <div id='myModal' class='modal'>
                                        <div class='modal-content'>
                                            <span class='close'>&times;</span>
                                                <div id='teste'>";
                    }else{
                            echo "
                                    <tr>
                                    <td class='numInv'>" . $monEim['numInv'] . "</td>
                                    <td class='marque'>" . $monEim['marque'] . "</td>
                                    <td class='modele'>" . $monEim['modele'] . "</td>
                                    <td class='entite'>" . $monEim['entite'] . "</td>
                                    <td class='localisation'>" . $monEim['localisation'] . "</td>
                                    <td class='cmpteur'><button id='encre" . $i . "' style='border:none;background:none;'> <img src='Images/loupe.png'  alt='Ok' width='30px'></button> <br><br> <div id='encre_div" . $i . "'></div> <div class='progress' 'id='progress".$i."'><div class='bar' id='bar".$i."'></div></div></td>";
                            //echo "<td class='cmpteur'><button id='copie" . $i . "' style='border:none;background:none;'> <img src='Images/loupe.png' width='30px' ' alt='Ok'></button> <br><br> <div id='copie_div" . $i . "'></div> </td>";
                            echo "<td class='ping'><button style='border:none;background:none;' id='Ping" . $i . "' ><img id='img".$i."' src='Images/" . $image . ".png' alt='Ok' width='30px'></button> <br><br> <div id='Ping_div" . $i . "'></div></td>
                                    <td class='reset'>Pas de quota (<a href='#quote'>*</a>)</td>
                                    </tr>
                                    <div id='myModal' class='modal'>
                                    <div class='modal-content'>
                                        <span class='close'></span>
                                        <div id='teste'>";
                    }

                $array += ["'ip.$i.'" => $monEim['ip']];
                $Myjson = json_encode($array);
                $i++;
                }
                break;
                default :
                    foreach (static::eims() as $monEim) {
                        $href = /* "<a href=http://" . $monEim['ip'] . " target='_blank'>" . */$monEim['ip']/* . "</a>" */;
                        // On change le bouton de couleur
                        // if (str_starts_with($monEim['ip'],'pr')) {
                        //     $image = "rondRouge";
                        // } 
                        // else{
                        //     $image = "rondVert";
                        // }
                        $image = "rondPing";

                        $explode_user = explode("/", $jsonArray[$Localisation_user]);
                        $explode_EIM = explode("/", $monEim['entite']);

                        $splice_user = array_slice($explode_user, 0, 3);
                        $splice_EIM = array_slice($explode_EIM, 0, 3);
                        if ($splice_user === $splice_EIM) {
                            if (in_array($monEim['modele'], $color)){
                                echo "
                                        <tr>
                                        <td class='numInv'>" . $monEim['numInv'] . "</td>
                                        <td class='marque'>" . $monEim['marque'] . "</td>
                                        <td class='modele'>" . $monEim['modele'] . "</td>
                                        <td class='entite'>" . $monEim['entite'] . "</td>
                                        <td class='localisation'>" . $monEim['localisation'] . "</td>
                                        <td class='cmpteur'><button id='encre" . $i . "' style='border:none;background:none;'> <img src='Images/Colorwheel.svg'   alt='Ok' width='30px' ></button> <br><br> <div id='encre_div" . $i . "'></div> <div class='progress' id='progress".$i."'><div class='bar' id='bar".$i."'></div></div></td>";
                                //echo "<td class='cmpteur'><button id='copie" . $i . "' style='border:none;background:none;'> <img src='Images/loupe.png' width='30px' ' alt='Ok'></button> <br><br> <div id='copie_div" . $i . "'></div> </td>";
                                echo "<td class='ping'><button style='border:none;background:none;' id='Ping" . $i . "' ><img id='img".$i."' src='Images/" . $image . ".png'  alt='Ok' width='30px' ></button> <br><br> <div id='Ping_div" . $i . "'></div></td>
                                        <td class='reset'><button id='show" . $i . "' style='border:none;background:none;'> <img src='Images/svg/printer.svg'  alt='Ok' width='30px' ></button> </td>
                                        </tr>
                                        <div id='myModal' class='modal'>
                                            <div class='modal-content'>
                                                <span class='close'>&times;</span>
                                                    <div id='teste'>";
                            }else{
                                    echo "
                                            <tr>
                                            <td class='numInv'>" . $monEim['numInv'] . "</td>
                                            <td class='marque'>" . $monEim['marque'] . "</td>
                                            <td class='modele'>" . $monEim['modele'] . "</td>
                                            <td class='entite'>" . $monEim['entite'] . "</td>
                                            <td class='localisation'>" . $monEim['localisation'] . "</td>
                                            <td class='cmpteur'><button id='encre" . $i . "' style='border:none;background:none;'> <img src='Images/loupe.png'   alt='Ok' width='30px'></button> <br><br> <div id='encre_div" . $i . "'></div> <div class='progress' id='progress".$i."'><div class='bar' id='bar".$i."'></div></div></td>";
                                    //echo "<td class='cmpteur'><button id='copie" . $i . "' style='border:none;background:none;'> <img src='Images/loupe.png' width='30px' ' alt='Ok'></button> <br><br> <div id='copie_div" . $i . "'></div> </td>";
                                    echo "<td class='ping'><button style='border:none;background:none;' id='Ping" . $i . "' ><img id='img".$i."' src='Images/" . $image . ".png'  alt='Ok' width='30px'></button> <br><br> <div id='Ping_div" . $i . "'></div></td>
                                            <td class='reset'>Pas de quota (*)</td>
                                            </tr>
                                            <div id='myModal' class='modal'>
                                                <div class='modal-content'>
                                                    <span class='close'>&times;</span>
                                                        <div id='teste'>";
                            }

                    }

                    $array += ["'ip.$i.'" => $monEim['ip']];
                    $Myjson = json_encode($array);
                    $i++;
                    }
                    break;
                    exit();
            }

}


    /*
    * Compte les utilisateur présent sur l'imprimante
    */

    public function count_id($host) {
        $community = 'public';

        # snmp2_real_walk(): pour parcourir un certain nombre d'objets SNMP 
        # à partir de object_id
        $oid_id_dep = "1.3.6.1.4.1.1129.2.3.50.1.3.21.5.1.4";
        $id_dep = snmp2_real_walk($host, $community, $oid_id_dep);  
        return count($id_dep);

        // $snmp = new SnmpClient([
        //     'host' => $host,
        //     'version' => 2,
        //     'community' => $community,
        // ]);
        // $oid_id_dep = $snmp->getOid('1.3.6.1.4.1.1129.2.3.50.1.3.21.5.1.4');
        // $id_dep = $snmp->walk()->startAt($oid_id_dep); 
        // # Commencer le walk à partir de $oid_id_dep
        // return $id_dep->count();

    }

    /*
    * Fonction pour montrer les informations des EIM
    */
    private function infotip($host) {
        //OID pour l'infobulle (ID,NAME,MATRICULE,QUOTA) & definie les paramétre des fonction SNMP

        $oid_id_dep = '1.3.6.1.4.1.1129.2.3.50.1.3.21.5.1.4';
        $oid_name_dep = '1.3.6.1.4.1.1129.2.3.50.1.3.21.5.1.2';
        $oid_matricule_dep = '1.3.6.1.4.1.1129.2.3.50.1.3.21.5.1.3';
        $oid_quota_dep = '1.3.6.1.4.1.1129.2.3.50.1.3.21.3.1.22.1';
        $oid_quota_def = '1.3.6.1.4.1.1129.2.3.50.1.3.21.3.1.20.1';
        $community = "private";
        
        $snmp = new SnmpClient([
            'host' => $host,
            'version' => 2,
            'community' => $community,
        ]);
        try {
            $oids = $snmp->get($oid_id_dep, $oid_name_dep, $oid_matricule_dep, $oid_quota_dep, $oid_quota_def );
        } catch (SnmpRequestException $e) {
            echo $e->getMessage();
            exit;
        }

        $id_dep = snmp2_real_walk($host, $community, $oid_id_dep);
        $name_dep = snmp2_real_walk($host, $community, $oid_name_dep);
        $matricule_dep = snmp2_real_walk($host, $community, $oid_matricule_dep);
        $quota_dep = snmp2_real_walk($host, $community, $oid_quota_dep);
        $quota_def = snmp2_real_walk($host, $community, $oid_quota_def);
        // $id_dep = $snmp->walk()->startAt($oid_id_dep);
        // $name_dep = $snmp->walk()->startAt($oid_name_dep);
        // $matricule_dep = $snmp->walk()->startAt($oid_matricule_dep);
        // $quota_dep = $snmp->walk()->startAt($oid_quota_dep);
        // $quota_def = $snmp->walk()->startAt($oid_quota_def);
    
        $Explode_Groups = session('group');
    
        //counteur pour les utilisateur

        // $compteur =  $id_dep->count();
        // $compteur =  count($id_dep);
        // var_dump($quota_dep);


        $listeid=[];

        // foreach ((array)$id_dep as $value) { //Récupere chaque matricule et les affiches
        //     $suppr0 = intval(substr($value, 9));
        //     array_push($listelastoid, end($suppr0));
        // }
        foreach ((array)$id_dep as $values) { // CButton qui permet de réinitialiser et lance l'éxécution de la fonction resetQuotas
            $result = substr($values, 9);
            array_push($listeid,$result);
        }

        
        $i = 1;
        //Div qui vont afficher les informations dans l'infobulle
        echo "          <div class='row1' href='#test'>
                            <div class='column1'>
                                <h4>Matricule</h4>";
        foreach ((array)$matricule_dep as $value) { //Récupere chaque matricule et les affiches
            $suppr0 = substr($value, 9);
            $suppr1 = substr($suppr0, 0, -1);
            echo "<p>" . $suppr1 . "</p>";
        }
        
        echo "              </div>
                            <div class='column2'>
                                <h4>Nom</h4>";
        foreach ((array)$name_dep as $value) { ////Récupere chaque nom d'utilisateur et les affiches
            $suppr0 = substr($value, 12); //supprime les caractére inutile:
            $suppr1 = substr($suppr0, 0, -4);
            $clean = preg_replace('/\s+/', '', $suppr1);
            $result = pack("H*", $clean);
            echo '<p>' . $result . '</p>';
        }

        echo "              </div>
                            <div class='column3 text'>
                                <h4> Quota par défaut </h4>";
        foreach ((array)$quota_def as $key => $values) { // Récupere chaque quota initiale et les affiches
            $suppr0 = substr($values, 9);
            $needle = explode(".",$key);
            if (in_array(end($needle),$listeid)) {
        
                echo "<div id='ini-".end($needle)."'class='Quote'><p>" . $suppr0 . "</p></div>";
                
            }
        }
        
        echo "              </div>
                            <div class='column3 text'>
                                <h4> Impressions restantes </h4>";
        foreach ((array)$quota_dep as $key => $values) { //Récupere chaque quota restantes et les affiches
            $suppr0 = substr($values, 9);
            $needle = explode(".",$key);
            if (in_array(end($needle),$listeid)) {
        
                echo "<div id='res-".end($needle)."'class='Quote'><p>" . $suppr0 . "</p></div>";
                
            }
        }

        echo"               </div>";
        switch ($Explode_Groups) { // Donne accès a la rénitialisation si on fait partie de la bonne O.U
            case (in_array("Support Technique", $Explode_Groups)):
                echo "<div class='column4'>
                                            <h4> Reinitialiser </h4>";
                foreach ((array)$id_dep as $values) { // CButton qui permet de réinitialiser et lance l'éxécution de la fonction resetQuotas
                    $result = substr($values, 9);
                    echo "<p><input type='number' id='number".$result."'>
                    <button class='style1' id='reset" . $result . "'> Reinitialiser </button></p>";
                    $i++;
                }
                echo "</div>";
                

                break;
            case (in_array(" Direction Informatique", $Explode_Groups)):
                echo "<div class='column4'>
                                            <h4> Reinitialiser </h4>";
                foreach ((array)$id_dep as $values) { // CButton qui permet de réinitialiser et lance l'éxécution de la fonction resetQuotas
                    $result = substr($values, 9);
                    echo "<p><input type='number'  id='number".$result."'>
                    <button class='style1' id='reset" . $result . "'> Reinitialiser </button></p>";
                    $i++;
                }
                echo "</div>";
                break;
                
                
            case (in_array("Referents_Informatiques", $Explode_Groups)):
                    echo "<div class='column4'>
                                                <h4> Reinitialiser </h4>";
                    foreach ((array)$id_dep as $values) { // CButton qui permet de réinitialiser et lance l'éxécution de la fonction resetQuotas
                        $result = substr($values, 9);
                        echo "<p>Demander à un administrateur de la DEMS</p>";
                        $i++;
                    }
                    echo "</div>";
                    break;
            default:
                break;
                exit();



        }


        
        echo"</div>";
    }

    // Function pour checker les OID
    public function check_oid($host) {
        //OID et paramètre pour la fonction SNMP

        // $community = "public";
        // $snmp = new SnmpClient([
        //     'host' => $host,
        //     'version' => 2,
        //     'community' => $community,
        // ]);
        // $oid_id_dep= $snmp->getValue('1.3.6.1.4.1.1129.2.3.50.1.3.21.5.1.4').PHP_EOL;
        // $oid_quota_dep = $snmp->getValue('1.3.6.1.4.1.1129.2.3.50.1.3.21.3.1.22.1').PHP_EOL;

        // $id_dep = $snmp->walk()->startAt($oid_id_dep); 

        // // $compteur = count($id_dep);
        // $compteur = $id_dep->count();

        $oid_id_dep = "1.3.6.1.4.1.1129.2.3.50.1.3.21.5.1.4";
        $oid_quota_dep = "1.3.6.1.4.1.1129.2.3.50.1.3.21.3.1.22.1";
        $community = "public";


        $id_dep = snmp2_real_walk($host, $community, $oid_id_dep);
        $compteur = count($id_dep);

        for ($i = 1; $i <= $compteur; $i++) { // CHECK FOR EACH OID DEP
            $get_oid = snmpget($host, $community, $oid_quota_dep . $i);

            if ($get_oid == -1) {
                echo '<script> var teste1 = ' . $true . '</script>';
            } else {
                echo '<script> var teste2 = ' . $false . '</script>';
            }
        }
    }

    public function get_all_oid_quota() {
        $oid_id_dep = "1.3.6.1.4.1.1129.2.3.50.1.3.21.5.1.4";
        $oid_quota_dep = "1.3.6.1.4.1.1129.2.3.50.1.3.21.3.1.22.1";
        $community = "public";

        foreach (static::eims() as $monEim) {
            $id_dep = snmp2_real_walk($monEim['ip'], $community, $oid_id_dep);
            $compteur = count($id_dep);
        }
    }

    /*
    * Fonction qui récupére et affiche les informations des encres selon le modèle de l'imprimante
    */

    private function toner($host, $mod) {
        $OIDTb = '1.3.6.1.2.1.43.11.1.1.9.1.1';
        $OIDTm = '1.3.6.1.2.1.43.11.1.1.9.1.2';
        $OIDTc = '1.3.6.1.2.1.43.11.1.1.9.1.3';
        $OIDTy = '1.3.6.1.2.1.43.11.1.1.9.1.4';
        $community = "public";
        
        $snmp = new SnmpClient([
            'host' => $host,
            'version' => 2,
            'community' => $community,
        ]);
        try {
            $oids = $snmp->get($OIDTb, $OIDTm, $OIDTc, $OIDTy);
        } catch (SnmpRequestException $e) {
            echo $e->getMessage();
            exit;
        }
        
        // var_dump($mod);
        switch ($mod) {
            case 'E-Studio 3005 AC A3\/A4 color':
                // $community = "private";
                $snmp = new SnmpClient([
                    'host' => $host,
                    'version' => 2,
                    'community' => $community,
                ]);
                try {
                    $oids = $snmp->get($OIDTb, $OIDTm, $OIDTc, $OIDTy);
                } catch (SnmpRequestException $e) {
                    echo $e->getMessage();
                    exit;
                }
                # snmpwalkoid() lit tous les OID et leurs valeurs respectives
                // $TB = snmpwalkoid($host, $community, $OIDTb);
                // $TM = snmpwalkoid($host, $community, $OIDTm);
                // $TC = snmpwalkoid($host, $community, $OIDTc);
                // $TY = snmpwalkoid($host, $community, $OIDTy);

                # Obtenir un OID spécifique et ces valeurs sur la liste $oids
                # déclarée en haut
                $TB = $oids->get($OIDTb)->getValue().PHP_EOL;
                $TM = $oids->get($OIDTm)->getValue().PHP_EOL;
                $TC = $oids->get($OIDTc)->getValue().PHP_EOL;
                $TY = $oids->get($OIDTy)->getValue().PHP_EOL;
                
                if ($TB == "") {
                    $TB = "0";
                }
                if ($TM == "") {
                    $TM = "0";
                }
                if ($TC == "") {
                    $TC = "0";
                }
                
                if ($TY == "") {
                    $TY = "0";
                }

                echo "<p>  Noir : </p>
                        <div id='B1' class='B'><div id='numberB1'>" . $TB . "%</div></div></br>
                    <p>  Magenta :  </p>
                        <div id='M1' Class='M'><div id='numberM1'>" . $TM . "%</div></div></br>
                    <p>  Cyan : </p>
                        <div id='C1' class='C'><div id='numberC1'>" . $TC . "%</div></div></br>
                    <p>  Jaune :  </p>
                        <div id='J1' Class='J'><div id='numberJ1'>" . $TY . "%</div></div>";

                echo "<script text='javascript'>
                    $(  function() {
                        x = '#B1';
                        m = '#M1';
                        c = '#C1';
                        j = '#J1';

                        $(x).progressbar({
                        value: " . $TB ."
                        });
                        $(m).progressbar({
                        value: " . $TM ."
                        });
                        $(c).progressbar({
                        value: " . $TC ."
                        });
                        $(j).progressbar({
                        value: " . $TY ."
                        });

                        i++;
                        y = x + i;
                        m1 = m + i;
                        c1 = c + i;
                        j1 = j + i;

                        $(x).attr('id', y);
                        $(m).attr('id', m1);
                        $(c).attr('id', c1);
                        $(j).attr('id', j1);

                        $(y).progressbar({
                        value: " . $TB ."
                        });
                        $(m1).progressbar({
                        value: " . $TM ."
                        });
                        $(c1).progressbar({
                        value: " . $TC ."
                        });
                        $(j1).progressbar({
                        value: " . $TY ."
                        });
                    });
                    </script>";
                break;
            case "E-studio 347CS A4 color":

                $TB = $oids->get($OIDTb)->getValue().PHP_EOL;
                $TM = $oids->get($OIDTm)->getValue().PHP_EOL;
                $TC = $oids->get($OIDTc)->getValue().PHP_EOL;
                $TY = $oids->get($OIDTy)->getValue().PHP_EOL;
                

                if ($TB == "") {
                    $TB = "0";
                }
                if ($TM == "") {
                    $TM = "0";
                }
                if ($TC == "") {
                    $TC = "0";
                }
                
                if ($TY == "") {
                    $TY = "0";
                }
                
                echo "<p>  Noir : </p>
                        <div id='B2' class='B'><div id='numberB2'>" . $TB . "%</div></div></br>
                    <p>  Magenta :  </p>
                        <div id='M2' Class='M'><div id='numberM2'>" . $TM . "%</div></div></br>
                    <p>  Cyan : </p>
                        <div id='C2' class='C'><div id='numberC2'>" .$TC . "%</div></div></br>
                    <p>  Jaune :  </p>
                        <div id='J2' Class='J'><div id='numberJ2'>" . $TY . "%</div></div>";

                echo "<script text='javascript'>
                $(  function() {
                    x = '#B2';
                    m = '#M2';
                    c = '#C2';
                    j = '#J2';

                    $(x).progressbar({
                    value: " . $TB ."
                    });
                    $(m).progressbar({
                    value: " . $TM ."
                    });
                    $(c).progressbar({
                    value: " . $TC ."
                    });
                    $(j).progressbar({
                    value: " . $TY ."
                    });

                    i++;
                    y = x + i;
                    m1 = m + i;
                    c1 = c + i;
                    j1 = j + i;

                    $(x).attr('id', y);
                    $(m).attr('id', m1);
                    $(c).attr('id', c1);
                    $(j).attr('id', j1);

                    $(y).progressbar({
                    value: " . $TB ."
                    });
                    $(m1).progressbar({
                    value: " . $TM ."
                    });
                    $(c1).progressbar({
                    value: " . $TC ."
                    });
                    $(j1).progressbar({
                    value: " . $TY ."
                    });
                });
                    </script>";
                break;

            case "E-studio 356SE":
                
                $community = "private";
                $snmp = new SnmpClient([
                    'host' => $host,
                    'version' => 2,
                    'community' => $community,
                ]);
                $OIDTb = '1.3.6.1.2.1.43.11.1.1.9.1.1';
                try {
                    $oid = $snmp->get($OIDTb);
                } catch (SnmpRequestException $e) {
                    echo $e->getMessage();
                    exit;
                }
                
                $TB = $oid->get($OIDTb)->getValue().PHP_EOL;
                if ($TB == "") {
                    $TB = "0";
                }

                echo "<p>  Noir : </p><div id='B3' class='B'><div id='numberB3'>" . $TB . "%</div></div></br>";
                echo "<script text='javascript'>
                        $(  function() {
                        x = '#B3';
                        $(x).progressbar({
                            value: " . $TB ."
                        });
                        i++;
                        y = x + i;
                        $(x).attr('id', y);
                        $(y).progressbar({
                            value: " . $TB ."
                        });
                        });
                    </script>";
                break;

            case "E-Studio 3008A A4\/A3 n&b":

                // $TB = snmpwalkoid($host, $community, $OIDTb);

                $TB = $oids->get($OIDTb)->getValue().PHP_EOL;

                
                if ($TB == "") {
                    $TB = "0";
                }
                echo "<p>  Noir : </p><div id='B4' class='B'><div id='numberB4'>" . $TB . "%</div></div></br>";
                echo "<script text='javascript'>
                        $(  function() {
                        x = '#B4';
                        $(x).progressbar({
                            value: " . $TB ."
                        });
                        i++;
                        y = x + i;
                        $(x).attr('id', y);
                        $(y).progressbar({
                            value: " . $TB ."
                        });
                        });
                    </script>";
                break;

            case "E-studio 477S A4 n&b":

                // $TB = snmpwalkoid($host, $community, $OIDTb);

                $TB = $oids->get($OIDTb)->getValue().PHP_EOL;

                
                if ($TB == "") {
                    $TB = "0";
                }
                echo "<p>  Noir : </p><div id='B5' class='B'><div id='numberB5'>" . $TB . "%</div></div></br>";
                echo "<script text='javascript'>
                        $(  function() {
                        x = '#B5';
                        $(x).progressbar({
                            value: " . $TB ."
                        });
                        i++;
                        y = x + i;
                        $(x).attr('id', y);
                        $(y).progressbar({
                            value: " . $TB ."
                        });
                        });
                    </script>";
                break;

            case "e-studio 385S":
                
                // $TB = snmpwalkoid($host, $community, $OIDTb);

                $TB = $oids->get($OIDTb)->getValue().PHP_EOL;

                echo " manque l'oid";
                break;

            case "E-studio 357SE":

                // $TB = snmpwalkoid($host, $community, $OIDTb);

                $TB = $oids->get($OIDTb)->getValue().PHP_EOL;

                if ($TB == "") {
                    $TB = "0";
                }
                echo "<p>  Noir : </p><div id='B7' Class='B'><div id='numberB7'>" . $TB . "%</div></div></br>";
                echo "<script text='javascript'>
                        $(  function() {
                        x = '#B7';
                        $(x).progressbar({
                            value: " . $TB ."
                        });
                        i++;
                        y = x + i;
                        $(x).attr('id', y);
                        $(y).progressbar({
                            value: " . $TB ."
                        });
                        });
                    </script>";
                break;

            case "E-studio 3018A A4\/A3 n&b":

                // $TB = snmpwalkoid($host, $community, $OIDTb);

                $TB = $oids->get($OIDTb)->getValue().PHP_EOL;

                
                if ($TB == "") {
                    $TB = "0";
                }
                echo "<p>  Noir : </p><div id='B8' Class='B'><div id='numberB8'>" . $TB . "%</div></div></br>";
                echo "<script text='javascript'>
                        $(  function() {
                        x = '#B8';
                        $(x).progressbar({
                            value: " . $TB ."
                        });
                        i++;
                        y = x + i;
                        $(x).attr('id', y);
                        $(y).progressbar({
                            value: " . $TB ."
                        });
                        });
                    </script>";
                break;

            case "E-studio 3015 AC A3\/A4 color":
                // $snmp = new SnmpClient([
                //     'host' => $host,
                //     'version' => 2,
                //     'community' => $community,
                // ]);
                // try {
                //     $oids = $snmp->get($OIDTb, $OIDTm, $OIDTc, $OIDTy);
                // } catch (SnmpRequestException $e) {
                //     echo $e->getMessage();
                //     exit;
                // }
                $TB = $oids->get($OIDTb)->getValue().PHP_EOL;
                $TM = $oids->get($OIDTm)->getValue().PHP_EOL;
                $TC = $oids->get($OIDTc)->getValue().PHP_EOL;
                $TY = $oids->get($OIDTy)->getValue().PHP_EOL;

                if ($TB == "") {
                    $TB = "0";
                }
                if ($TM == "") {
                    $TM = "0";
                }
                if ($TC == "") {
                    $TC = "0";
                }
                
                if ($TY == "") {
                    $TY = "0";
                }

                echo "<p>  Noir : </p>
                        <div id='B9' class='B'><div id='numberB9'>" . $TB. "%</div></div></br>
                    <p>  Magenta :  </p>
                        <div id='M9' Class='M'><div id='numberM9'>" . $TM . "%</div></div></br>
                    <p>  Cyan : </p>
                        <div id='C9' class='C'><div id='numberC9'>" . $TC . "%</div></div></br>
                    <p>  Jaune :  </p>
                        <div id='J9' Class='J'><div id='numberJ9'>" . $TY . "%</div></div>";

                echo "<script text='javascript'>
                        $(  function() {
                            x = '#B9';
                            m = '#M9';
                            c = '#C9';
                            j = '#J9';

                            $(x).progressbar({
                            value: " . $TB ."
                            });
                            $(m).progressbar({
                            value: " . $TM ."
                            });
                            $(c).progressbar({
                            value: " . $TC ."
                            });
                            $(j).progressbar({
                            value: " . $TY ."
                            });

                            i++;
                            y = x + i;
                            m1 = m + i;
                            c1 = c + i;
                            j1 = j + i;

                            $(x).attr('id', y);
                            $(m).attr('id', m1);
                            $(c).attr('id', c1);
                            $(j).attr('id', j1);

                            $(y).progressbar({
                            value: " . $TB ."
                            });
                            $(m1).progressbar({
                            value: " . $TM ."
                            });
                            $(c1).progressbar({
                            value: " . $TC ."
                            });
                            $(j1).progressbar({
                            value: " . $TY ."
                            });
                        });
                    </script>";
                break;

            default :
                echo "pas encore recensé";
                exit();
        }
        // dd();

    }

    /*
    * Function pour rénitialiser le quota
    */
    private function resetQuotas($host, $object_id, $value) {
        $community = "private";
        $snmp_object_id_quotas = "1.3.6.1.4.1.1129.2.3.50.1.3.21.3.1.22.1."; //Manque le dernier numéro de l'OID qui sera compléter par l'ajax car dépendant de l'utilisateur qui est ciblé
        $type = "u";
        //le quota est définie par le paramètre value si aucun nombre est donnée il est défini par défaut à 20 par la fonction SNMPSET.
        var_dump($value);
        if ($value === NULL){
        $value=20;
        }
        
        snmpset($host, $community, $snmp_object_id_quotas . $object_id, $type, $value);
    }

    /*
    *Créer une requete pour chaque fonction qui seront appelée par l'ajax
    */
    public function ext_ping(Request $r){
        echo static::sock_ping($r['ip']);
    }
    public function ext_reset(Request $r){
        echo static::resetQuotas($r['ip'], $r['oid'], $r['value']);
    }public function ext_infotip(Request $r){
        echo static::infotip($r['ip']);
    }public function ext_toner(Request $r){
        echo static::toner($r['ip'],$r['mod']);
    }
}

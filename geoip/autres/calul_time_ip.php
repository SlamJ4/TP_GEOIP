<?php
require_once("tab_ip.php");
include("../connectBDD.php");
define('pdo', connect_to_bdd());

function get_infos_ip($tab, $pdo_bdd) {
    $req_sql = "SELECT * FROM geoip WHERE ip_from <= :ip AND ip_to >= :ip";
    $start_time = microtime(true);
    foreach($tab as $ip) {
        $tab_remote = explode(".", $ip);
        $calcul_ip = $tab_remote[0] * 256 * 256 * 256 + $tab_remote[1] * 256 * 256 + $tab_remote[2] * 256 + $tab_remote[3];
    
        $search_sql = $pdo_bdd -> prepare($req_sql);
        if(
            $search_sql -> bindValue(':ip', $calcul_ip, PDO::PARAM_INT) &&
            $search_sql -> execute()
        ) {
            $infos_ip = $search_sql -> fetch(PDO::FETCH_ASSOC);
            print_r($infos_ip);
        }
    }
    $end_time = microtime(true);
    $total_time = ($end_time - $start_time) / count($tab) * 1000;
    return $total_time;
}


echo(get_infos_ip($tab_ip, pdo));
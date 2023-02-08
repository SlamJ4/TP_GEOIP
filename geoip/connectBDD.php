<?php

function connect_to_bdd() {
    $json_file = file_get_contents('app.settings.json');
	$json_content = json_decode($json_file);
		
	$pdo_connect_string = "mysql:host=".$json_content->Host.";dbname=".$json_content->Name.";charset=utf8";
	try 
	{
		$pdo = new PDO($pdo_connect_string, $json_content->Login, $json_content->Password);
	}
	catch(Exception $e)
	{
		exit($e);
	}
    return $pdo;
}

function get_infos_ip($param_pdo, $ip) {
    $req_sql = "SELECT * FROM geoip WHERE ip_from <= :ip AND ip_to >= :ip";

    $tab_remote = explode(".", $ip);
    $calcul_ip = $tab_remote[0] * 256 * 256 * 256 + $tab_remote[1] * 256 * 256 + $tab_remote[2] * 256 + $tab_remote[3];

    $search_ip = pdo -> prepare($req_sql);
    $search_ip -> bindValue(':ip', $calcul_ip, PDO::PARAM_INT);
    $search_ip -> execute();

    $infos = $search_ip -> fetch(PDO::FETCH_ASSOC);

    return $infos;
}
<?php
		include("../connectBDD.php");
		define('pdo', connect_to_bdd());
		
		function searchIp ($pdo,$ip) {
			/*
				L'IP doit d'abord être calculée
			*/
			$search = pdo -> prepare("SELECT country_code,country_name,region_name,city_name,lagitude,longitude FROM geoip WHERE ip_from <= :ip AND ip_to >= :ip");
			$search -> bindValue(':ip', $calcul_ip, PDO::PARAM_INT);
			$search -> execute();

			$infos = $search -> fetch(PDO::FETCH_ASSOC);

			$res = [];
			foreach($infos as $elmt) {
				array_push($res, $elmt);
			}

			return $res;
		}

		//-----TEST-----//
		$tab = searchIp(pdo,16777300);
		print_r($tab);
?>

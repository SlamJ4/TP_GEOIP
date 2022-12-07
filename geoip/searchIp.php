<?php
		define("BDD_HOST", "localhost");
		define("BDD_NAME", "tp_geoip");
		define("BDD_LOGIN", "jordan");
		define("BDD_PASSWORD", "Ytreza4321");

        $pdo_connect_string = sprintf("mysql:host=%s;dbname=%s;charset=utf8", BDD_HOST, BDD_NAME);
		try 
		{
			$pdo = new PDO($pdo_connect_string, BDD_LOGIN, BDD_PASSWORD);
		}
		catch(PDOException $e)
		{
			echo $e;
		}
		
		function searchIp ($pdo,$ip) {
			/*
				L'IP doit d'abord être calculée
			*/
			$search = $pdo -> prepare("SELECT country_code,country_name,region_name,city_name,lagitude,longitude FROM geoip WHERE ip_from <= ? AND ip_to >= ?");
			$search -> execute(array($ip,$ip));

			$infos = $search -> fetch(PDO::FETCH_ASSOC);

			$res = [];
			foreach($infos as $elmt) {
				array_push($res, $elmt);
			}

			return $res;
		}

		//-----TEST-----//
		$tab = searchIp($pdo,16777300);
		print_r($tab);
?>

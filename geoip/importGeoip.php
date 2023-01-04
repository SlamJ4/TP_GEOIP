<?php
// Variables pour la connexion à la base
$bdd_host = "localhost";
$bdd_name = "tp_geoip";
$bdd_table = "geoip";
$bdd_login = "jordan";
$bdd_password = "Ytreza4321";

// Variables pour infos nécessaires à la lecture du fichier csv
$csv_file = "geoip.csv";
$terminated_by = ",";
$enclosed_by = '"';
$lines_terminated = "\r\n";

// Connexion à la BDD
try {
	$bdd = new PDO("mysql:host=$bdd_host;dbname=$bdd_name;charset=utf8", $bdd_login, $bdd_password,
	array(PDO::MYSQL_ATTR_LOCAL_INFILE => true)	
);

} catch(PDOException $e) {
	error_log("Impossible de se connecter à la base !");
}

// Import des données du fichier dans la base
try {
$bdd -> exec("LOAD DATA LOCAL INFILE"
	. $bdd -> quote($csv_file)
	."INTO TABLE $bdd_table FIELDS TERMINATED BY"
	. $bdd -> quote($terminated_by)
	."ENCLOSED BY "
	. $bdd -> quote($enclosed_by)
	."LINES TERMINATED BY "
	. $bdd -> quote($lines_terminated)
	."IGNORE 1 LINES");
} catch (Exception $e) {
error_log("Erreur lors de l'import !");
}
?>

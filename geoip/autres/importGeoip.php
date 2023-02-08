<?php
$json_file = file_get_contents('../app.settings.json');
$json_content = json_decode($json_file);

$pdo_connect_string = "mysql:host=".$json_content->Host.";dbname=".$json_content->Name.";charset=utf8";

$csv_file = "geoip.csv";
$terminated_by = ",";
$enclosed_by = '"';
$lines_terminated = "\r\n";

try {
	$bdd = new PDO($pdo_connect_string, $json_content->Login, $json_content->Password,
	array(PDO::MYSQL_ATTR_LOCAL_INFILE => true)
);

} catch(PDOException $e) {
	error_log("Impossible de se connecter à la base !");
}

try {
$bdd -> exec("LOAD DATA LOCAL INFILE"
	. $bdd -> quote($csv_file)
	."INTO TABLE ".$json_content->Table." FIELDS TERMINATED BY"
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

<?php
define("BDD_HOST", "127.0.0.1");
define("BDD_NAME", "tp_geoip");
define("BDD_LOGIN", "jordan");
define("BDD_PASSWORD", "Ytreza4321");
define("REQ_SQL", "SELECT * FROM geoip WHERE ip_from <= ? AND ip_to >= ?");

$pdo_connect_string = sprintf("mysql:host=%s;dbname=%s;charset=utf8", BDD_HOST, BDD_NAME);

//$var_remote = $_SERVER['REMOTE_ADDR'];  IP serveur VM
$var_remote = "37.58.179.26";  // IP serveur CFAI
$tab_remote = explode(".", $var_remote);

$calcul_ip = $tab_remote[0] * 256 * 256 * 256 + $tab_remote[1] * 256 * 256 + $tab_remote[2] * 256 + $tab_remote[3];

try {
$pdo = new PDO($PDOConnectString, BDD_LOGIN, BDD_PASSWORD);
} catch (PDOException $e) {
echo $e;
}

$start_time = microtime(true);
$search_ip = $pdo -> prepare(REQ_SQL);
$search_ip -> execute(array($calcul_ip, $calcul_ip));
$end_time = microtime(true);

$infos = $search_ip -> fetch(PDO::FETCH_ASSOC);

if($infos['country_code'] == "FR") {
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>GEOIP</title>
    <meta charset='utf-8'>
    <style>
        table {
            border: solid;
	        border-collapse: collapse;
        }
        tr {
            border: solid;
        }
        th {
            border: solid;
        }
        td {
            border: solid;
        }
        .contains {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="contains">
        <h1>Bienvenue en France !</h1>

        <p>Temps de réponse : <?php echo ((($end_time - $start_time) * 100)." ms");?></p>
        <p><?php echo "Votre IP Public : ".$var_remote; ?></p>
        <p> Voici votre localisation</p>
        <table align="center">
            <tr>
                <th>
                    Country Code
                </th>
                <th>
                    Country Name
                </th>
                <th>
                    Region Name
                </th>
                <th>
                    City Name
                </th>
                <th>
                    Latitude
                </th>
                <th>
                    Longitude
                </th>
            </tr>

            <tr>
                <td>
                    <?php echo $infos['country_code']; ?>
                </td>
                <td>
                    <?php echo $infos['country_name']; ?>
                </td>
                <td>
                    <?php echo $infos['region_name']; ?>
                </td>
                <td>
                    <?php echo $infos['city_name']; ?>
                </td>
                <td>
                    <?php echo $infos['lagitude']; ?>
                </td>
                <td>
                    <?php echo $infos['longitude']; ?>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
<?php
} else {
	http_response_code(403);
}
?>

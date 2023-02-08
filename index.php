<?php
include("geoip/connectBDD.php");
define('pdo', connect_to_bdd());
define("REQ_SQL", "SELECT * FROM geoip WHERE ip_from <= :ip AND ip_to >= :ip");


//$var_remote = $_SERVER['REMOTE_ADDR'];  IP serveur VM
$var_remote = "37.58.179.26";  // IP serveur CFAI
$tab_remote = explode(".", $var_remote);

$calcul_ip = $tab_remote[0] * 256 * 256 * 256 + $tab_remote[1] * 256 * 256 + $tab_remote[2] * 256 + $tab_remote[3];


$start_time = microtime(true);
$search_ip = pdo -> prepare(REQ_SQL);
$search_ip -> bindValue(':ip', $calcul_ip, PDO::PARAM_INT);
$search_ip -> execute();
$end_time = microtime(true);

$infos = $search_ip -> fetch(PDO::FETCH_ASSOC);

if($infos['country_code'] == "FR") {
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>GEOIP</title>
    <meta charset='utf-8'>
    <link rel="shortcut icon" type="image/png" href="image/favicon.png"/>
    <link rel="stylesheet" type="text/css" href="css/index.css"/>
</head>
<body>
    <div class="border">
        <div class="contains">
            <h1>Bienvenue en France !</h1>

            <p>Temps de réponse : <?php echo ((($end_time - $start_time) * 1000)." ms");?></p>
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
    </div>
</body>
</html>
<?php
} else {
	http_response_code(403);
}
?>

<?php

define("NB_TEST", 98);

$tab_ip = [
    "37.58.179.26",
    "192.168.122.143"
];

// Generation d'adresses IP aleatoires
for($i = 0; $i < NB_TEST; $i++) {
    $sIP = sprintf("%d.%d.%d.%d", rand(1,255), rand(1,255), rand(1,255), rand(1,255) );
    $tab_ip[] = $sIP;
}


// Ecriture des adresses dans le fichier source tab_ip.php
$sTabLine = "\t'%s',\n";

$fp = fopen("tab_ip.php", "w");
fputs($fp, '<?php'.PHP_EOL);
fputs($fp, '$tab_ip = ['.PHP_EOL);

for($i=0; $i<count($tab_ip); $i++) {
    fputs($fp, sprintf($sTabLine, $tab_ip[$i]));
}

fputs($fp, "];\n");
fclose($fp);
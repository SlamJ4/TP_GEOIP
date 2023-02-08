<?php

function createAndRenderHTML($infos_ip, $ip_public, $total_time) {
    if($infos_ip['country_code'] == 'FR') {

        echo("
        <!DOCTYPE html>
        <html lang='fr'>

        <head>
            <title>GEOIP</title>
            <meta charset='utf-8>
            <link rel='shortcut icon' type='image/png' href='image/favicon.pgn'>
            <link rel='stylesheet' type='text/css' href='css/index.css'>
        </head>

        <body>
            <div class='border'>
                <div class='contains'>
                    <h1>Bienvenue en France !</h1>

                    <p>Temps de réponse : ".$total_time." ms</p>
                    <p>Votre IP public : ".$ip_public."</p>
                    <p>Voici votre localisation</p>
                    <table align=center>
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
                                ".$infos_ip['country_code']."
                            </td>
                            <td>
                                ".$infos_ip['country_name']."
                            </td>
                            <td>
                                ".$infos_ip['region_name']."
                            </td>
                            <td>
                                ".$infos_ip['city_name']."
                            </td>
                            <td>
                                ".$infos_ip['lagitude']."
                            </td>
                            <td>
                                ".$infos_ip['longitude']."
                            </td>
                        </tr>
                </div>
            </div>
        </body>
        </html>
        ");
    } else {
        http_response_code(403);
    }
}
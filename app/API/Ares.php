<?php

namespace App\API;

use App\Core\Request;

class Ares
{
    public function fetch(Request $req): string|bool
    {
        $ico = $req->getParam('ico');
        $url = "http://wwwinfo.mfcr.cz/cgi-bin/ares/ares_es.cgi?ico=" . $ico;
        $init = curl_init($url);
        curl_setopt($init, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($init);
        curl_close($init);
        header('Content-type: application/xml');
        return ($response);
    }
}

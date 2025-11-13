<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use SoapClient;

class SoapController extends BaseController
{
    public static function SoapCorporativo($funcao, $parametros, $destino){

      if (ENV('APP_ENV') == 'development')
      {
        $endpoint = "http://192.168.3.100:8080/soap/";
      }else{
        // Recupera o IP ativo
        $ip = trim(file_get_contents("/var/www/link.ip"));
        $endpoint = str_replace('IP', $ip, env('ENDPOINT'));
      }
      
        $api = $endpoint . 'wsdl?targetURI=urn:' . $destino;

        $client = new SoapClient(
                    $api,
                    [
                      'exceptions' => 0,
                      'cache_wsdl' => WSDL_CACHE_NONE
                    ]
                  );

        $arguments = [ $funcao => $parametros ];
  
        $options = ['location'  => $endpoint];

        $result = $client->__soapCall($funcao, $arguments, $options);

        if (is_soap_fault($result)) {
          dd($result, true);
        }

        return $result;
  }
}

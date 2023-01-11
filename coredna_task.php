<?php

class API {
    function postData($url, $data)
    {
        $http_origin = "https://corednacom.corewebdna.com/assessment-endpoint.php";
        $params = array(
                'http' => array(
                    'method' => 'POST',
                    'header'=> 
                        "Authorization: Bearer d417fcbc-94b7-4357-aff3-536c33364428\r\n"    
                        ."content-Type: application/json; charset=utf-8;\r\n"
                        ."Access-Control-Allow-Origin: $http_origin\r\n"
                        ."Access-Control-Allow-Methods: GET, POST\r\n"
                        ."Connection: close\r\n",
                    'ignore_errors' => true,
                    'content' => $data
                ),
                "ssl" => array(
                    "ciphers" => "TLSv1",
                )
        );
        $context = stream_context_create($params);
        try {
            $fp = @file_get_contents($url, false, $context);
            if (!$fp) {
                throw new Exception("failed to open stream ", 1);
            }else{
                echo "File is loaded and content is there";
            }
        }catch (Exception $e) {
            echo $e->getMessage();
        }
        try{
            $response = @stream_get_contents($fp);
        }catch(Exception $e){
            throw new Exception("Problem reading data from $url, $e->getMessage()");
        }
        
        return $response;
    }

}

$API = new API;
$payload = array(
    'name' => 'Ravi Jyothula',
    'email' => 'ravijyothula@gmail.com',
    'url' => 'https://github.com/ravijyothula/coredna_task'
);

echo $API->postData('https://corednacom.corewebdna.com/assessment-endpoint.php', json_encode($payload));
?>
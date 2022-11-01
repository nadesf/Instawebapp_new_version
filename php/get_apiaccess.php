<?php 

session_start();

#$domain = "http://localhost:8000/api/v1/";
$domain = "http://164.92.134.116/api/v1/";

$endpoints = array(
    "generateAPIKey" => $domain . "users/generateAPIKey/",
    "getDeveloperAPIKey" => $domain . "users/getDeveloperAPIKey/"
);

if (isset($_POST["code_confirmation_developer_key"])) {
    
    $code = htmlspecialchars($_POST["code_confirmation_developer_key"]);
    $url = $endpoints["generateAPIKey"];
    $method = "POST";
    $data = array(
        "code" => $code
    );
    $req = send_data_to_api($url, $data, $method, 1);
    if ($req["http_code"] === 200) {
        $_SESSION["apiaccess_asking"] = 1;
    }else {
        $_SESSION["apiaccess_asking"] = 0;
    }
    $_SESSION["ask_apiaccess"] = null;
    $_SESSION["check_apiaccess"] = null;
    header("Location: ../settings_m_generate_apiaccess.php");
} else {
    
    $url = $endpoints["generateAPIKey"];
    $req = get_data_from_api($url, 1);

    if ($req["http_code"] === 200) {
        $_SESSION["check_apiaccess"] = 1;
        $_SESSION["ask_apiaccess"] = 1;
        header("Location: ../settings_m_generate_apiaccess.php");
    }else {
        var_dump("Problem detected !");
    }
}

#$url = $endpoints["getPaymentCode"];
#$req = get_data_from_api($url, 1);
#if ($req["http_code"] === 200) {
#    $_SESSION["myTemporaryCode"] = $req["response"]->code;
#}

function get_data_from_api($url, $use_token) {

    # La requête
    $request = curl_init();
    curl_setopt($request, CURLOPT_URL, $url);
    if ($use_token === 1) {
        curl_setopt($request, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $_SESSION["Authorization"]));
    }else {
        curl_setopt($request, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    }
    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($request);
    $response = json_decode($response);
    $httpcode = curl_getinfo($request, CURLINFO_HTTP_CODE);
    curl_close($request);

    # Traitement de la réponse.
    # On retourne le résultat.
    $result = array(
        "http_code" => $httpcode,
        "response" => $response
    );
    return $result;
    #var_dump($response->success)
}

function send_data_to_api($url, $data, $request_type, $use_token) {

    # Encodage des données
    $data_json = json_encode($data);

    # Création et envoie de la requête
    $request = curl_init();
    curl_setopt($request, CURLOPT_URL, $url);
    if ($use_token === 1) {
        curl_setopt($request, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $_SESSION["Authorization"]));
    }else {
        curl_setopt($request, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    }
    if ($request_type === "POST") {
        curl_setopt($request, CURLOPT_POST, 1);
    }else {
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, $request_type);
    }
    curl_setopt($request, CURLOPT_POSTFIELDS,$data_json);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($request);
    $response = json_decode($response);
    $httpcode = curl_getinfo($request, CURLINFO_HTTP_CODE);
    curl_close($request); 

    # On retourne le résultat.
    $result = array(
        "http_code" => $httpcode,
        "response" => $response
    );
    return $result;
}

?>
<?php 
session_start();

if (isset($_SESSION["IsAuthenticate"]) && $_SESSION["IsAuthenticate"] === 1) {

    #$domain = "http://localhost:8000/api/v1/";
    $domain = "http://164.92.134.116/api/v1/";

    $endpoints = array(
        "generateAPIKey" => $domain . "users/generateAPIKey/",
        "getDeveloperAPIKey" => $domain . "users/getDeveloperAPIKey/"
    );
    
    $url = $endpoints["getDeveloperAPIKey"];
    $req = get_data_from_api($url, 1);
    if ($req["http_code"] === 200) {
        if ($req["response"]->apiUser != null and $req["response"]->apiUser != "") {
            $_SESSION["APIUser"] = $req["response"]->apiUser;
            $_SESSION["APIKey"] = $req["response"]->apiKey;
        }
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Instapay</title>

    <!-- Les Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    
    <!-- Liens vers le fichier de bootstrap CSS et JS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="main.css"/>
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>

    <style>
        h1 {
            color: #613de6;
        }
    </style>
</head>
<body>

        <!-- Header de la page -->>
        <div class="header bg-light">
        <div class="container">
            <div class="row">
                <div class="header-content d-flex justify-content-between">
                    <div class="header-left">
                        <h1><img src="4-removebg-preview.png" alt=""/>Instapay</h1>
                    </div>
                    <div class="right d-flex">

                        <div class="dropdown align-self-center">
                            <span class="mx-2 mt-1 mt-3 fs-4 dropdown-toggle" id="notification" data-bs-toggle="dropdown" aria-expanded="False">
                                <i class="bi bi-bell"></i>
                            </span>
                            
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Aucun message</a></li>
                            </ul>
                        </div>

                        <div class="dropdown align-self-center">
                            <span class="rounded-circle dropdown-toggle account" id="notification" data-bs-toggle="dropdown" aria-expanded="False">
                                <i class="bi bi-person-fill text-white"></i>
                            </span>
                            <ul class="dropdown-menu" style="width: 270px;">
                                <li><a class="dropdown-item name fw-bold" href="home_client.php"><?php echo $_SESSION["full_name"]; ?></a></li>
                                <li><a class="dropdown-item text-muted" href="#"><?php echo $_SESSION["email"]; ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item fs-6" href="home_client.php"><i class="bi bi-person mx-2 fs-6"></i>Portefeuille</a></li>
                                <li><a class="dropdown-item fs-6" href="#"><i class="bi bi-wallet2 mx-2 fs-6"></i>Mes comptes</a></li>
                                <li><a class="dropdown-item fs-6" href="settings.php"><i class="bi bi-gear mx-2 fs-6"></i>Paramêtre</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item fs-6 text-danger" href="php/signuser.php?logout=1"><i class="bi bi-box-arrow-left mx-2 fs-6 text-danger"></i>Deconnexion</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Header de la page -->
    
    <div class="container"> <!-- Div principale -->
        <div class="row">
            <div class="col-md-6 mt-md-3 mb-md-2 welcome_message">
                <h4>Recevoir des paiements</h4>
            </div> <!-- Le message de bonne arrivé -->

            <div class="col-12 col-md-6 mt-md-3">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home.php" class="link_breadcrumb">Home</a></li>
                    <li class="breadcrumb-item"><a href="#" class="link_breadcrumb">Paramètre</a></li>
                    <li class="breadcrumb-item active"><a href="#" class="link_breadcrumb">Recevoir des paiements</a></li>
                </ul>
            </div>

            <div class="col-12 shadow p-3 mb-5 bg-body rounded">
                <div class="card" style="border: 1px solid white;">
                    <div class="card-header bg-white">
                        <nav class="nav">
                            <ul class="list-unstyled d-flex">
                                <a href="settings-m.php" class="nav-link fs-5 active">Profil</a>
                                <a href="settings_m_security.php" class="nav-link fs-5">Securité</a>
                                <a href="settings_m_generate_apiaccess.php" class="nav-link fs-5">Recevoir des paiements</a>
                            </ul>
                        </nav>
                    </div>

                    <div class="card-body">

                    <div class="text-center">
                        <p class="fs-3 fw-bold" style="color: #613de6;">API User</p>
                        
                        <p class="fs-3" style="color: #1f2c73;">
                            <?php
                            if (isset($_SESSION["APIUser"])) {
                            echo $_SESSION["APIUser"];
                            }else {
                            echo "****************";
                            }
                            ?>
                        </p>
                        <p class="fs-3 fw-bold" style="color: #613de6;">API Key</p>
                        <p class="fs-3" style="color: #1f2c73;">
                            <?php
                            if (isset($_SESSION["APIKey"])) {
                            echo $_SESSION["APIKey"];
                            }else {
                            echo "****************";
                            }                              
                            ?>
                        </p>
                    </div>
                
                        <p><br></p>
                        <form action="php/get_apiaccess.php" method="POST">
                            <div class="text-center">
                                <?php 
                                #if (isset($_SESSION["ask_apiaccess"])) {
                                    if (1) {
                                ?>
                                <div class="mb-3">
                                    <input type="text" class="form-control form-control-lg" name="code_confirmation_developer_key" placeholder="Saisissez le code recu par mail">
                                </div>
                                <?php 
                                }
                                ?>
                                <button type="button" class="btn btn-lg btn-outline-primary submit_outline" style="color: 613de6;" id="btnShowHide">Afficher</button>
                                <button type="submit" class="btn btn-primary btn-lg submit">Générer</button>
                            </div>
                        </form>
                        
                            <?php
                            if (isset($_SESSION["check_apiaccess"])) {
                            ?>
                            <p class="text-center fs-6 text-success fw-bold">Un code de confirmation vous à été envoyé par mail</p>
                            <?php
                            $_SESSION["check_apiaccess"] = null;
                            } else if (isset($_SESSION["apiaccess_asking"]) and $_SESSION["apiaccess_asking"] === 0) {
                            ?>
                            <p class="text-center fs-6 text-danger fw-bold">Code de confirmation incorrect. Faite une nouvelle demande</p>
                            <?php
                            }
                            $_SESSION["apiaccess_asking"] = null;
                            ?>
                        
                        <!--
                        <p class="display-2 text-center" style="color: #613de6; letter-spacing: 10px;">
                        
                        <br>
                        </p>
                        <p><br></p>
                        <form action="php/generate_code.php">
                            <div class="text-center">
                                <button class="btn btn-primary btn-lg submit">Générer</button>
                            </div>
                        </form>
                        -->
                    </div>
                  </div>
            </div>

            
        </div>
    </div> <!-- div princiaple -->

    <!-- Ajout de notre propre script JS -->
</body>
</html>

<?php
} else {
    header("Location: login.php");
}

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

$_SESSION["check"] = NULL;
$_SESSION["msg"] = NULL; 
?>
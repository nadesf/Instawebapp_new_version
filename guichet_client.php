<?php 

session_start();
if (!isset($_SESSION["IsAuthenticate"]) or $_SESSION["IsAuthenticate"] !== 1) {
    header("Location: login.php");
}else {
?>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- Les Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    
    <!-- Liens vers le fichier de bootstrap CSS et JS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="sign.css"/>
    <link rel="stylesheet" href="guichet.css">
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <title>Instapay - Payer plus facilement </title>

</head>
<body>
        <div class="col-12 col-sm-6 col-md-6 col-lg-3 shadow p-3 mb-5 bg-body rounded login">
            <form action="php/requestopay.php" method="POST">
    
                <div class="d-flex">
                    <div class="logoinsta">
                    </div>
                    <button type="button" class="btn" style="color: white; background-color: #613de6; margin-left: 260px; height:40px; position:relative; top:15px;" data-bs-toggle="modal" data-bs-target="#smallModal">Scanner</button>
                    <div class="modal fade" id="smallModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Veuillez effectuer le scan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12">
                                   <video id="preview" width="100%"></video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="title">
                    <h4 class="text-center fw-bold">Payez avec </h4>
                    <br>
                </div>
    
                <div class="d-flex justify-content-center">
                    <div class="col-md-6 logomtn">
                    </div>
                    <div class="col-md-6 logoorange">
                    </div>
                    <div class="col-md-6 logoinsta">
                    </div>
                    <div class="col-md-6 logomoov">
                    </div>
                </div>
    
                <div class="mb-3">
                    <p></p>
                    <label for="payer_address" class="form-label">Adresse de paiement</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="payee" placeholder="example@instapay.com">
                </div>
                <div class="mb-3">
                    <p></p>
                    <label for="payer_address" class="form-label">Montant</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="amount" placeholder="Ex : 100">
                </div>

                <?php 
                
                if (isset($_SESSION["transaction_protection"]) and (int) $_SESSION["transaction_protection"] === 1) {
                ?>
                <div class="mb-3">
                    <p></p>
                    <label for="payer_address" class="form-label">Pour pour les transactions</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="transaction_protection_code" placeholder="Ex : 100">
                </div>
                <?php
                }
                ?>
                <!-- Bouton radio : Choisir le provider -->
                <div class="d-flex justify-content-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="instapay_provider" id="flexRadioDefault1" checked>
                        <label class="form-check-label me-3" for="instaoay">
                          Instapay
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="mtn_provider">
                        <label class="form-check-label me-3" for="mtn">
                          MTN
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="orange_provider" id="flexRadioDefault1">
                        <label class="form-check-label me-3" for="flexRadioDefault1">
                            Orange
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="moov_provider" id="flexRadioDefault2">
                        <label class="form-check-label me-3" for="flexRadioDefault2">
                            MOOV
                        </label>
                    </div>

                </div>
            
                <p></p>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary submit" type="submit">Suivant</button>
                </div>
            </form>
            <p></p>
            <?php 
            if(isset($_SESSION["transaction_state"]) && (int) $_SESSION["transaction_state"] === 1) {
            ?>
            <p class="text-success text-center fw-bold"> Transaction effectué avec succès </p>
            <?php
            }else if (isset($_SESSION["transaction_state"]) && (int) $_SESSION["transaction_state"] === 0) {
            ?>
            <p class="text-danger text-center fw-bold"> Echec de la transaction </p>
            <?php
            }
            $_SESSION["transaction_state"] = NULL;
            ?>
        </div>
        <script src="assets/js/instascan.min.js"></script>
        <script type="text/javascript">
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
        Instascan.Camera.getCameras().then(function(cameras){
           if(cameras.length > 0 ){
            scanner.start(cameras[0]);
           } else{
               alert('Camera inactive');
            }

           }).catch(function(e) {
               console.error(e);
           });

           scanner.addListener('scan',function(c){
               document.getElementById('payer_address').value=c;
        });
    </script>
</body>

</html>

<?php
}
?>
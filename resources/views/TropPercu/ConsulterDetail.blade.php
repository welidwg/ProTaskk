<?php

use App\Http\Controllers\ParametreController;

$current = "consulterDetail";
if (Session::get("type") == "CONTROLER" && Session::get('tp') == "OUI") {
?>

    <html lang="en">

    <head>
        @include("GestionDeParametre.nav");
        <meta charset="UTF-8">
        <link rel="stylesheet" href="CSS/login.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ProTask | Controle des dossiers</title>
        <link rel="stylesheet" href="CSS/GererDossier.css">
    </head>

    <style>
        legend {
            width: auto;
            margin-left: 20px;
            font-size: 22px;
            color: #2f4f4f;
            font-weight: bolder;

            font-weight: normal;
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;



        }





        fieldset {
            border: 10px solid rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            margin-bottom: 30px;



        }


        h1 {
            color: #2f4f4f;

            font-weight: normal;
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            font-size: 36px;
            line-height: 42px;
            text-transform: uppercase;
            text-shadow: 0 3px white, 0 3px #777;
            text-align: center;

        }





        .table {
            border: 1px solid black;
            width: auto;
            position: relative;
        }

        .table td {
            height: 10px;
            border: #2f4f4f 1px solid;
            border-radius: 20px;
        }

        .table input {
            width: 100px;
            border: 3px solid #2f4f4f;
            height: 5px;
            border-radius: 20px;
            font-size: 10px;
            color: black;
            margin: auto;
            position: relative;
            top: 0;

            text-align: justify;

        }

        .styled-table {
            border-collapse: collapse;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            margin: auto;




        }

        .styled-table thead tr {
            background-color: #2f4f4f;
            color: #ffffff;
            text-align: center;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            text-align: center;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #2f4f4f;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #2f4f4f;
        }

        .styled-table tbody tr.active-row {
            font-weight: bold;
            color: #009879;
        }

    


    </style>

    <body>

        <script>
        </script>


        <?php
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');





        if (isset($_GET["matricule"])) {


            $matricule = $_GET["matricule"];



            $search1 = "SELECT * FROM dossier where Matricule like $matricule ";
            $search2 = "SELECT * FROM Paiement where Matricule like $matricule";
            $search3 = "SELECT * FROM Recu where Matricule like $matricule ";





            $Dossier = mysqli_fetch_array(mysqli_query($connect, $search1));
            $Paiement = mysqli_fetch_array(mysqli_query($connect, $search2));
            $Recu = mysqli_fetch_array(mysqli_query($connect, $search3));
            if ($Dossier['Controle'] == "") {







        ?>



                <div class="donne">
                    <fieldset>
                        <legend>Données personnelles</legend>
                        <ul class="list" style='list-style: none;'>

                            <li> <label for="matricule">Matricule</label>

                                <input class="input100" readonly value="<?php echo $Dossier["Matricule"] ?>" type="number" id="matricule" name="matricule" required="required" oninput="maxLengthCheck(this)" />
                            </li>
                            <li> <label for="cin">Carte d'Identité Nationale</label>
                                <input class="input100" readonly value="<?php if ($Dossier["Cin"] == "") {
                                                                            echo "Vide";
                                                                        } else {
                                                                            echo $Dossier["Cin"];
                                                                        } ?>" type=" number" id="cin" name="cin" required="required" oninput="maxLengthCheck(this)" />
                            </li>
                            <br>
                            <li>
                                <label for="nom">Nom et prenom</label>
                                <input class="input100" readonly value="<?php echo $Dossier["NomPrenom"] ?>" type="text" name="nomprenom" minlength="6" required />
                            </li>

                            <li>
                                <label for="">Type de la dette</label>
                                <input class="input100" readonly value="<?php echo $Dossier["TypeDette"] ?>" type="text" name="" id="">
                            </li>




                        </ul>


                    </fieldset>
                    <fieldset>
                        <legend>
                            Paiement
                        </legend>
                        <ul class="list">
                            <li>
                                <label for="">Méthode de paiement</label>
                                <input class="input100" id="methode" readonly value="<?php if ($Paiement["MethodePaiement"] != "") {
                                                                                            echo $Paiement["MethodePaiement"];
                                                                                        } else {
                                                                                            echo "Vide";
                                                                                        } ?> " type="text" name="">
                            </li>

                            <li>
                                <label for="">Banque</label>
                                <input class="input100" readonly value="<?php echo $Paiement["Banque"] ?>" type="text" name="" id="">
                            </li>
                            <br>

                            <li>
                                <label for="">Date Correspondance 1</label>
                                <input class="input100" readonly value="<?php if ($Dossier["DateCorrespondance"] != NULL) {
                                                                            echo $Dossier["DateCorrespondance"];
                                                                        } else {
                                                                            echo "Vide";
                                                                        } ?>" type="text" name="" id="">
                            </li>
                            <li>
                                <label for="">Date Correspondance 2</label>
                                <input class="input100" readonly value="<?php if ($Dossier["DateCorrespondance2"] != NULL) {
                                                                            echo $Dossier["DateCorrespondance2"];
                                                                        } else {
                                                                            echo "Vide";
                                                                        } ?>" type="text" name="" id="">
                            </li>
                            <br>

                            <li>
                                <label for="">Pension Servie Du</label>
                                <input onload="if(this.value==0 || this.value=='' || this.value=='Vide'){this.display='none'}" class="input100" readonly value="<?php echo $Paiement["Du"] ?>" type="text" name="" id="">
                            </li>
                            <li>
                                <label for="">Jusqu'au</label>
                                <input class="input100" readonly value="<?php echo $Paiement["Jusquau"] ?>" type="text" name="" id="">
                            </li>
                            <br>
                            <li id="4">
                                <label for="">Date debut</label>
                                <input class="input100" readonly value="<?php if ($Paiement["DateDebut"] != NULL) {
                                                                            echo $Paiement["DateDebut"];
                                                                        } else {
                                                                            echo "Vide";
                                                                        }  ?> " name="DateDebut" type="text">
                            </li>


                        </ul>



                    </fieldset>
                    <fieldset>
                        <legend>
                            Les montants
                        </legend>

                        <ul class="list">

                            <li>
                                <label for="">Pension servie</label>
                                <input class="input100" readonly value="<?php echo $Dossier["MontantDemande"]." DT" ?>" name="montantDemande" type="text">
                            </li>

                            <li>
                                <label for="">Montant bloqué</label>
                                <input class="input100" readonly value="<?php echo $Dossier["MontantBloque"]." DT"  ?>" name="montantBloque" type="text">
                            </li>
                            <br>
                            <li>
                                <label for="">Montant Restitué</label>
                                <input class="input100" readonly value="<?php echo $Dossier["MontantRestitue"]." DT"  ?>" type="text">
                            </li>
                            <li id="3">
                                <label for="">Reste</label>
                                <input class="input100" readonly value="<?php echo $Dossier["Reste"]." DT"  ?>" name="" type="text">
                            </li>
                            <br>

                            <li id="1">
                                <label for="">Total Payé</label>
                                <input class="input100" readonly value="<?php echo $Dossier["TotalPaye"]." DT"  ?>" name="" type="text">
                            </li>
                            <br>


                            <li id="2">
                                <label for="">Reste pour cloture</label>
                                <input class="input100" readonly value="<?php if($Dossier["Reste"]!="" && $Dossier["Reste"]!=0){echo  $Dossier["Reste"] - $Dossier["TotalPaye"]." DT" ;}else{echo $Dossier["MontantDemande"]." DT"; }  ?>" name="montantBloque" type="text">
                            </li>


                            <li id="MM">

                                <label for="">Montant par tranche/mois/trimestre</label>
                                <input class="input100" readonly value="<?php echo $Paiement["MontantAPaye"]." DT"  ?> " name='montantMensuel' type="text">
                            </li>
                            <br>


                            <li id="MA">
                                <label for="">Monatnt payé en avance</label>
                                <input class="input100" readonly value="<?php echo $Paiement["MontantAvance"]." DT" ?> " name="montantAvance" type="text">
                            </li>
                        </ul>







                    </fieldset>
                    <fieldset>
                        <legend>Etat de dossier</legend>
                        <ul class="list">
                            <li>
                                <label for="">L'Etat du dossier:</label>
                                <input class="input100" readonly value="<?php echo $Dossier["Etat"] ?>" type="text" name="" id="">
                            </li>
                        </ul>

                    </fieldset>

                    <?php
                    $array = runQuery("SELECT * from recu Where Matricule like $matricule  ORDER BY id ASC");
                    if(!empty($array)){


                    


                    if ($Paiement["MethodePaiement"] != "بطاقة إلزام" && $Paiement["MethodePaiement"] != "") {
                    ?>
                        <fieldset class="Hist" id="8">

                            <legend>Historique de paiement</legend>
                            <ul class="list">
                                <li>

                                    <table class="styled-table">
                                        <thead>
                                            <tr>
                                                <th>N° Reçu</th>
                                                <th>Date</th>
                                                <th>Montant Payé</th>

                                            </tr>
                                        </thead>
                                        <tbody>


                                            <?php





                                                foreach ($array as $key => $value) {
                                            ?>
                                                    <tr class="active-row">
                                                        <td><input readonly value="<?php echo $array[$key]["NumRecu"] ?>" type="text" name="recu" id=""></td>
                                                        <td><input readonly value="<?php echo $array[$key]["Date"] ?>" type="text" name="dateRecu" id=""></td>
                                                        <td><input readonly value="<?php echo $array[$key]["MontantPaye"] . " DT" ?>" type="text" name="montantRecu" id=""></td>
                                                    </tr>

                                            <?php }
                                            
                                            ?>

                                            <!-- and so on... -->



                                </li>
                            </ul>
                        </fieldset>
                    <?php }
                 } ?>









                </div>





            <?php

            } else {
                ?>
                <style>html{zoom:1} </style> 
                 <?php
                 $params=new ParametreController();
                echo "<h3 style='text-align:center'>Ce dossier est déja controlé par " . $params->GetName( $Dossier["ControlePar"]) . " !</h3> ";
            ?>
                <script>
                    document.getElementById("accepter").style.display = "none";
                    document.getElementById("refuser").style.display = "none";
                </script>
        <?php
            }
        }
        ?>

        <script src="choices.js"></script>
        <script>
            const choices = new Choices('[data-trigger]', {
                searchEnabled: false,
                itemSelectText: '',
            });

            function maxLengthCheck(object) {
                if (object.value.length > object.maxLength) {
                    object.value = object.value.slice(0, 8)


                }
            }

            function show() {
                document.getElementById("tableRec").style.display = "block";
                document.getElementById("hist").onclick = function() {
                    document.getElementById("tableRec").style.display = "none";

                };



            }
        </script>
        <script>
            document.getElementById("accepter").href = "ProcessControl?action=accepter&matricule=<?php echo $Dossier["Matricule"] ?>"

            document.getElementById("refuser").href = "ProcessControl?action=refuser&matricule=<?php echo $Dossier["Matricule"] ?>"
        </script>

        <script>
            if ($Paiement['MethodePaiement'] == "بطاقة إلزام") { 
                document.getElementById("MM").style.display = "none";
                document.getElementById("MA").style.display = "none";
                document.getElementById("1").style.display = "none";
                document.getElementById("2").style.display = "none";
                document.getElementById("3").style.display = "none";
                document.getElementById("4").style.display = "none";
                document.getElementById("8").style.display = "none";
            }
            else {
                document.getElementById("MM").style.display = "inline";
                document.getElementById("MA").style.display = "inline";
                document.getElementById("1").style.display = "inline";
                document.getElementById("2").style.display = "inline";
                document.getElementById("3").style.display = "inline";
                document.getElementById("4").style.display = "inline";
                document.getElementById("8").style.display = "block";

            } 
        </script>
        </div>
    </body>
<?php
} else { ?>
    @include("Error");
<?php }
?>

    </html>
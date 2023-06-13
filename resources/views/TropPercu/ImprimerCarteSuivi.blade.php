<?php
$current = "ImprimerEtat";
session_start();
    if (Session::get("type") == "LIQUIDER" && Session::get("tp") == "OUI") {
?>

        <script>
            window.print()
        </script>
        <html lang="en">

        <head>

            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Impression Carte Suivi</title>
            <link rel="icon" href="CSS/Image/logo3.png" />

        </head>
        <style>
            @media print {
                @page {
                    margin: 0.5cm;
                }

                body {
                    margin: 0.5cm;
                }
            }

            body {
                height: auto;
                width: 850px;

                ;
                /* to centre page on screen*/
                margin-left: auto;
                margin-right: auto;

            }

            h1 {
                text-align: center;
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
                font-size: 30px;
            }

            p {
                width: 150px;
                font-size: 20px;
            }

            img {
                width: 95%;
                height: 100px;
                margin-top: 20px;
            }








            .styled-table {
                border-collapse: collapse;
                font-size: 0.9em;
                font-family: sans-serif;
                width: 100%;
                border-top: 2px solid black;
                margin-bottom: 300px;
                margin: 0px auto;








            }

            .styled-table thead tr {
                background-color: #2f4f4f;
                color: #ffffff;
                text-align: center;
            }

            .styled-table th,
            .styled-table td {
                padding: 12px 12px;
                text-align: center;
                color: #000;
            }

            .styled-table tbody tr {
                border-bottom: 1px solid #2f4f4f;

            }

            .styled-table tbody tr:nth-of-type(even) {
                background-color: #f3f3f3;
            }

            .styled-table tbody tr:last-of-type {
                border-bottom: 2px solid black;
            }

            .styled-table tbody tr.active-row {
                font-weight: bold;
                color: #009879;
            }

            .styled-table input {
                color: black;
                border: #000 2px solid;
                width: 100px;
                height: 30px;
                padding: 5px 5px 5px 5px;
                font-size: 15px;
                border-radius: 20px;
            }

            .list li {
                display: inline;
                margin: auto;
                max-width: 160px;
            }

            .input100 {
                max-width: 25%;
                display: inline-block;
                box-shadow: 2px 2px 5px #2f4f4f;
                margin-bottom: 20px;

            }

            h4 {
                display: inline-block;
                font-size: 18px;
                font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                width: 250px;
            }

            h6 {
                text-align: center;
            }
        </style>

        <body>
            <h6><img src="CSS/Image/cnr.PNG" alt=""></h6>
            <br>

            <h1>
                Carte de suivi de la dette
            </h1>


            <?php
            if (isset($_GET["Matricule"])) {
                $Matricule = $_GET["Matricule"];
                $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
                mysqli_select_db($connect, 'cnrps');

                $sql1 = "SELECT * FROM Dossier Where Matricule like $Matricule";
                $sql2 = "SELECT * FROM Paiement Where Matricule like $Matricule";
                $result = mysqli_query($connect, $sql1);
                $count = mysqli_num_rows($result);
                if ($count == 1) {

                    $Dossier = mysqli_fetch_array($result);
                    $Paiement = mysqli_fetch_array(mysqli_query($connect, $sql2));


            ?>

                    <h4>Type de la dette </h4>


                    <?php echo $Dossier["TypeDette"] ?>
                    <br>

                    <h4>Identifiant Unique </h4>


                    <?php echo $Dossier["Matricule"] ?>
                    <br>


                    <h4>Nom et prenom </h4>


                    <?php echo $Dossier["NomPrenom"] ?> <br>




                    <h4>Pension servie à tôrt </h4>


                    <?php echo $Dossier["MontantDemande"] . " DT" ?>
                    &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                    <h4>Montant bloqué </h4>


                    <?php echo $Dossier["MontantBloque"] . " DT" ?>




                    <br>

                    <h4>Du</h4>
                    <?php echo $Paiement["Du"]  ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <h4>Jusqu'au </h4>
                    <?php echo $Paiement["Jusquau"]  ?>

                    <br>

                    <h4>Montant restitué </h4>


                    <?php echo $Dossier["MontantRestitue"] . " DT"  ?>
                    <br>
                    <?php if ($Dossier["DateCorrespondance"] != "1970-01-01") { ?>
                        <h4>Date de correspondance </h4>


                        <?php echo $Dossier["DateCorrespondance"]  ?>
                        <br>
                    <?php } ?>

                    <h4>Banque </h4>


                    <?php echo $Paiement["Banque"] ?>
                    <br>













                    <?php
                    if (($Dossier["Etat"] != "Non Paye") && ($Dossier["Etat"] != "correspondance")) {

                    ?>
                        <div class="Content Bottom">


                            <br>
                            <h4>Historique de paiement : &nbsp</h4>

                            <br>

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
                                    function runQuery($query)
                                    {
                                        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
                                        mysqli_select_db($connect, 'cnrps');

                                        $result = mysqli_query($connect, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $resultset[] = $row;
                                        }
                                        if (!empty($resultset))
                                            return $resultset;
                                    }

                                    $array = runQuery("SELECT * from recu Where Matricule like $Matricule  ORDER BY id ASC LIMIT 5");



                                    if (!empty($array)) {
                                        foreach ($array as $key => $value) {
                                    ?>
                                            <tr class="active-row">
                                                <td><input readonly value="<?php echo $array[$key]["NumRecu"] ?>" type="text" name="recu" id=""></td>
                                                <td><input readonly value="<?php echo $array[$key]["Date"] ?>" type="text" name="dateRecu" id=""></td>
                                                <td><input readonly value="<?php echo $array[$key]["MontantPaye"] . " DT" ?>" type="text" name="montantRecu" id=""></td>
                                            </tr>


                                    <?php }
                                    }

                                    ?>
                                    <tr>
                                        <td></td>
                                        <th>Total</th>
                                        <td><input readonly value="<?php echo $Dossier["TotalPaye"] . " DT" ?>" type="text" name="montantRecu" id=""></td>
                                    </tr>




                                    <!-- and so on... -->



                                </tbody>

                            </table>







                            <!-- and so on... -->



                            </tbody>

                            </table>

                        </div>




                        </div>

                    <?php
                    } ?>
                    <h3 style="text-align:right">Signature</h3>


                <?php

                }
            } else {
                ?>

                <h5>Error</h5>
            <?php } ?>

        </body>

<?php } else { ?> 
    @include("Error");
     <?php }
 ?>

        </html>
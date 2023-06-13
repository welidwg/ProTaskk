<?php
$current = "ImprimerEtat";
if (Session::get("type")== "LIQUIDER" && Session::get("tp") == "OUI") {
?>


    <html lang="en">
    <script>
        window.print();
       
    </script>

    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Impression Etat</title>
        <link rel="stylesheet" href="CSS/print.css" media="print">
        <link rel="icon" href="CSS/Image/logo3.png" sizes="16x16" />

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
            Etat Du Dossier
        </h1>


        <?php
        if (isset($_GET["Matricule"])) {
            $Matricule = $_GET["Matricule"];
            $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
            mysqli_select_db($connect, 'cnrps');

            $sql = "SELECT * FROM Dossier Where Matricule like $Matricule";
            $sql2 = "SELECT * FROM Paiement Where Matricule like $Matricule";

            $result = mysqli_query($connect, $sql);
            $count = mysqli_num_rows($result);
            if ($count == 1) {

                $Dossier = mysqli_fetch_array($result);
                $Paiement = mysqli_fetch_array(mysqli_query($connect, $sql2));


        ?>
                <br><br><br>
                <h4>Identifiant Unique : &nbsp </h4>


                <?php echo $Dossier["Matricule"] ?>
                <br>

                <h4>Nom et prenom : &nbsp </h4>


                <?php echo $Dossier["NomPrenom"] ?>
                <br>
                <h4>Type de la dette : &nbsp </h4>


                <?php echo $Dossier["TypeDette"] ?>
                <br>
                <h4>Etat : &nbsp </h4>


                <?php echo $Dossier["Etat"] ?>
                <br>
                <h4>Pension servie : &nbsp </h4>


                <?php echo $Dossier["MontantDemande"] . " DT" ?>
                <br>


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
<?php  } ?>

    </html>
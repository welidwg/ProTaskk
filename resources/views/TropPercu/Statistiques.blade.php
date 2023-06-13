<?php
$current = "StatTP";
$connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
    mysqli_select_db($connect, 'cnrps');
      function GetName($id)
    {
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $username = mysqli_fetch_array(mysqli_query($connect, "SELECT Nom from utilisateurs where id like '$id'"));
        return $username[0];
    }
if (Session::get('type')=='CHEF CENTRE') {
?>

@include("GestionDeParametre.nav")

    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ProTask | Statistiques</title>
        <link href="CSS/style2.css" rel="stylesheet" media="all">




    </head>

    <body>
        <?php
        $number = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier"));
        $row = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) from Dossier "));
        $ctrl = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where Controle!=''"));
        $done = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where Controle like 'Accepter' and Etat like 'Paye' " ));
        $nonpaye = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where Etat='Non Paye'"));
        $date = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where MONTH(DateAjout) =  1 and Controle !=''"));
        $date2 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where MONTH(DateAjout) = 2 and Controle !=''"));
        $date3 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where MONTH(DateAjout) = 3 and Controle !=''"));
        $date4 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where MONTH(DateAjout) = 4 and Controle !=''"));
        $date5 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where MONTH(DateAjout) = 5 and Controle !=''"));
        $date6 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where MONTH(DateAjout) = 6 and Controle !=''"));
        $date7 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where MONTH(DateAjout) = 7 and Controle !=''"));
        $date8 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where MONTH(DateAjout) = 8 and Controle !=''"));
        $date9 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where MONTH(DateAjout) = 9 and Controle !=''"));
        $date10 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where MONTH(DateAjout) = 10 and Controle !='' "));
        $date11 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where MONTH(DateAjout) = 11 and Controle !=''"));
        $date12 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where MONTH(DateAjout) = 12 and Controle !=''"));



        ?>
        <div class="main-content">
            <div class="section__content ">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-3 stretch-card grid-margin">
                            <div class="card bg-gradient-info card-img-holder text-white" onclick="document.getElementById('ajoute').style.display='block'">

                                <img src="CSS/Image/circle.png" class="card-img-absolute" alt="circle-image" />

                                <h2 style="color:white;font-size:18px;padding:40px;text-align:center;font-weight: 700;"><i class="fa fa-folder"></i> Dossiers Ajoutés <br><?php echo $number; ?></h2>

                            </div>
                        </div>
                        <div class="col-md-3 stretch-card grid-margin">

                            <div class="card bg-gradient-warning card-img-holder text-white">

                                <img src="CSS/Image/circle.png" class="card-img-absolute" alt="circle-image" />

                                <h2 style="color:white;font-size:18px;padding:40px;text-align:center;font-weight: 700;"><i class="fa fa-hourglass-end"></i> Dossiers Contrôlés<br><?php echo $ctrl ?> </h2>


                            </div>
                        </div>


                        <div class="col-md-3 stretch-card grid-margin">
                            <div class="card bg-gradient-danger card-img-holder text-white">

                                <img src="CSS/Image/circle.png" class="card-img-absolute" alt="circle-image" />

                                <h2 style="color:white;font-size:18px;padding:40px;text-align:center;font-weight: 700;"><i class="fa fa-ban"></i> Dossiers non Payés <br><?php echo $nonpaye ?></h2>


                            </div>
                        </div>
                        <div class="col-md-3 stretch-card grid-margin">
                            <div class="card bg-gradient-success card-img-holder text-white">

                                <h2 style="color:white;font-size:18px;padding:40px;text-align:center;font-weight: 700;"><i class="fa fa-check"></i> Dossiers Cloturés <br><?php echo $done ?></h2>

                                <img src="CSS/Image/circle.png" class="card-img-absolute" alt="circle-image" />



                            </div>
                        </div>


                    </div>
                    <script src="js/canvasjs.min.js"> </script>
                    <div class="row" id="" style="width: 55%;float:left">
                        <div class="col-md-12 grid-margin">
                            <div class="card">

                                <div class="card-body">

                                    <div id="chartContainer" style=" width: 100%;height:350px"></div>

                                    <script type="text/javascript">
                                        window.onload = function() {

                                            var chart = new CanvasJS.Chart("chartContainer", {
                                                theme: "light2", // "light2", "dark1", "dark2"
                                                animationEnabled: true, // change to true
		
                                                title: {
                                                    text: "Nombre des dossiers traités par mois"
                                                },
                                                data: [{
                                                    // Change type to "bar", "area", "spline", "pie",etc.
                                                    type: "spline",
                                                    dataPoints: [{
                                                            label: "Janvier",
                                                            y: <?php echo $date ?>
                                                        },
                                                        {
                                                            label: "Fevrier",
                                                            y: <?php echo $date2 ?>
                                                        },
                                                        {
                                                            label: "Mars",
                                                            y: <?php echo $date3 ?>
                                                        },
                                                        {
                                                            label: "Avril",
                                                            y: <?php echo $date4 ?>
                                                        },
                                                        {
                                                            label: "Mai",
                                                            y: <?php echo $date5 ?>
                                                        },
                                                        {
                                                            label: "Juin",
                                                            y: <?php echo $date6 ?>
                                                        },
                                                        {
                                                            label: "Juillet",
                                                            y: <?php echo $date7 ?>
                                                        },
                                                        {
                                                            label: "Août",
                                                            y: <?php echo  $date8 ?>
                                                        },
                                                        {
                                                            label: "Septembre",
                                                            y: <?php echo $date9 ?>
                                                        },
                                                        {
                                                            label: "Octobre",
                                                            y: <?php echo $date10 ?>
                                                        },
                                                        {
                                                            label: "Novembre",
                                                            y: <?php echo $date11 ?>
                                                        },
                                                        {
                                                            label: "Decembre",
                                                            y: <?php echo $date12 ?>
                                                        },

                                                    ]
                                                }]
                                            });
                                            chart.render();

                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .icons i {
                            color: #b5b3b3;
                            border: 1px solid #b5b3b3;
                            padding: 6px;
                            margin-left: 4px;
                            border-radius: 5px;
                            cursor: pointer
                        }

                        .activity-done {
                            font-weight: 600;
                            color: #336;
                        }

                        .list-group li {
                            margin-bottom: 12px
                            
                        }


                        .list li {
                            list-style: none;
                            padding: 10px;
                            border: 1px solid #e3dada;
                            margin-top: 12px;
                            border-radius: 5px;
                            background: #fff;
                            border-radius: 30px;
                        }

                        .checkicon {
                            color: green;
                            font-size: 19px
                        }

                        .date-time {
                            font-size: 12px
                        }

                        .profile-image img {
                            margin-left: 3px
                        }
                    </style>
                    <div class="row" id="" style="width: 45%;">
                        <div class="col-md-12 grid-margin">
                            <div class="card" style="overflow:hidden ;height:400px">

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center activity">
                                        <div><span class="activity-done"> <i class="fa fa-money-bill-alt"></i> Montants </span></div>

                                    </div>
                                    <div class="mt-3">
                                        <ul class="list list-inline">

                                            <li class="d-flex justify-content-between">
                                                <div class="d-flex flex-row align-items-center">
                                                    <div class="ml-2">
                                                        <h6 class="mb-0" style="font-size:14px;color:limegreen"><i class="fa fa-check"></i> Total des montant encaissés</h6>

                                                    </div>

                                                </div>
                                                <div class="d-flex flex-row align-items-center">
                                                    <div class="d-flex flex-column mr-2">
                                                        <?php $array = runQuery("SELECT * from dossier where TotalPaye!='' or TotalPaye!=0  ");
                                                        $total = 0;

                                                        if (!empty($array)) {
                                                            foreach ($array as $k => $v) {

                                                                $total = $total + $array[$k]["TotalPaye"];
                                                        ?>





                                                        <?php
                                                            }
                                                        } ?>
                                                        <?php echo $total . " DT" ?>


                                                    </div>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <div class="d-flex flex-row align-items-center">
                                                    <div class="ml-2">
                                                        <h6 class="mb-0" style="font-size:14px;color:red"> <i class="fa fa-ban"></i> Total des montant non encaissés</h6>

                                                    </div>

                                                </div>
                                                <div class="d-flex flex-row align-items-center">
                                                    <div class="d-flex flex-column mr-2">
                                                        <?php $array1 = runQuery("SELECT * from dossier where TotalPaye is null or TotalPaye =0");
                                                        $total1 = 0;

                                                        if (!empty($array1)) {
                                                            foreach ($array1 as $kk => $vv) {

                                                                $total1 = $total1 + $array1[$kk]["MontantDemande"];
                                                        ?>





                                                        <?php
                                                            }
                                                        } ?>
                                                        <?php echo $total1 . " DT" ?>

                                                    </div>
                                            </li>



                                        </ul>
                                    </div>
                                    <br>
                                    <div class="d-flex justify-content-between align-items-center activity">
                                        <div><span class="activity-done"> <i class="fa fa-folder"></i> Dossiers </span></div>
                                    </div>
                                    <div class="mt-3">
                                        <ul class="list list-inline">
                                            <?php $array = runQuery("SELECT * from utilisateurs where logged='true' and type!='CHEF CENTRE'  and type!='CONSULTER'");
                                            ?>
                                            <li class="d-flex justify-content-between">
                                                <div class="d-flex flex-row align-items-center">
                                                    <div class="ml-2">
                                                        <h6 class="mb-0" style="font-size:14px;color:orange"> <i class="fa fa-search"></i> Total des dossiers non encore controlés</h6>

                                                    </div>

                                                </div>
                                                <div class="d-flex flex-row align-items-center">
                                                    <div class="d-flex flex-column mr-2">
                                                        <?php $num = mysqli_num_rows(mysqli_query($connect, "SELECT * from dossier where Controle is null"));
                                                        echo $num;



                                                        ?>





                                                    </div>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <div class="d-flex flex-row align-items-center">
                                                    <div class="ml-2">
                                                        <h6 class="mb-0" style="font-size:14px;"><i class="fa fa-times"></i> Total des dossiers contrôlés avec erreurs</h6>

                                                    </div>

                                                </div>
                                                <div class="d-flex flex-row align-items-center">
                                                    <div class="d-flex flex-column mr-2">
                                                        <?php $num = mysqli_num_rows(mysqli_query($connect, "SELECT * from dossier where Controle ='Refuser'"));
                                                        echo $num;



                                                        ?> </div>
                                            </li>
                                            <br>



                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                     

                        .fix {
                            position: sticky;
                            top: 0;
                            background-color: white;
                            z-index: 1;
                        }

                        h2 {
                            font-size: 25px;
                        }
                    </style>

                    <style>
                        .card {
                            height: auto;
                            max-height: 500px;
                            overflow: hidden;
                        }
                    </style>
                    <br>

                    <div class="row" id="ajoute" style="width: auto;height: 450px;overflow: hidden;">
                        <div class="col-md-12 grid-margin">
                            <div class="card" style="height: 700px;">

                                <div class="card-body">
                                    <div class="fix">
                                        <h4 class="card-title" style="color:green">
                                            <h2 class="title-1 m-b-25 "><i style="font-size : 30px; color : #4272d7" class="fa fa-folder"></i>
                                                Listes Des Dossiers Ajoutés</h2>

                                        </h4>
                                        <style>
                                            .input100:focus {
                                                outline: auto;
                                            }
                                        </style>
                                        <div class="input-group md-form form-sm form-2 pl-0" style="padding:15px">
                                            <input onkeyup="Search('input_ajout','data1')" class="input100 " style="border-radius: 0;height:40px;background-color: white;border: 1px solid grey;" type="text" placeholder="Recherche..." id="input_ajout" aria-label="Search">
                                        </div>
                                    </div>
                                    <style>
                                        .tableFixHead {
                                            overflow-y: auto;
                                            height: 200px;

                                        }

                                        .tableFixHead thead th {
                                            position: sticky;
                                            top: 0; 
                                            z-index: 9; 
                                            background-color: white;
                                        }
                                    </style>



                                    <div class="table-responsive" id="ajoute">
  <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

        <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />



                                        <div class="tableFixHead" style="height: 300px;">
                                        <script>
                                        $(document).ready( function () {
    $('#myTable').DataTable({bFilter: false, bInfo: false,bPaginate: false});
} );</script>
                                            <table id="myTable" class="table table-borderless table-striped table-earning">
                                                <thead>
                                                    <tr>
                                                        <th>Matricule</th>
                                                        <th>Nom et prenom</th>
                                                        <th>Etat</th>
                                                        <th>Pension Servie (DT)</th>
                                                        <th>Ajouté Par</th>
                                                        <th>Date Ajout</th>

                                                    </tr>

                                                </thead>


                                                <tbody>

                                                    <?php

                                                    $array = runQuery("SELECT * from dossier  ORDER BY id ASC ");
                                                    $count1 = mysqli_num_rows(mysqli_query($connect, "SELECT * from dossier  ORDER BY id ASC "));

                                                    if (!empty($array)) {
                                                        foreach ($array as $key => $value) {

                                                    ?>
                                                            <tr class="data1">
                                                                <td><?php echo $array[$key]["Matricule"] ?></td>
                                                                <td><?php echo $array[$key]["NomPrenom"] ?></td>
                                                                <td> <?php if ($array[$key]["Etat"] == "Paye") {
                                                                            echo "<p style='color:green'>" . $array[$key]["Etat"] . "</p>";
                                                                        } elseif ($array[$key]["Etat"] == "Non Paye") {
                                                                            echo "<p style='color:darkred'>" . $array[$key]["Etat"] . "</p>";
                                                                        } elseif ($array[$key]["Etat"] == "en cours de paiement") {
                                                                            echo "<p style='color:orange'>" . $array[$key]["Etat"] . "</p>";
                                                                        } elseif ($array[$key]["Etat"] == "correspondance") {
                                                                            echo "<p style='color:red'>" . $array[$key]["Etat"] . "</p>";
                                                                        }  ?></td>
                                                                        <td><?php echo $array[$key]["MontantDemande"] ?></td>
                                                                <td><?php echo GetName($array[$key]["AjoutePar"]) ?></td>
                                                                <td><?php echo $array[$key]["DateAjout"] ?></td>




                                                            </tr>


                                                    <?php }
                                                    } ?>






                                                </tbody>

                                            </table>


                                        </div>



                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row" id="controle" style="width: auto;height: 450px;overflow: hidden;">
                        <div class="col-md-12 grid-margin">
                            <div class="card" style="height: 700px;">

                                <div class="card-body">
                                    <div class="fix">
                                        <h4 class="card-title" style="color:green">
                                            <h2 class="title-1 m-b-25"><i class="fas fa-search" style="font-size : 30px; color : rgba(255, 255, 0, 0.897);"></i> Listes Des Dossiers Controlés</h2>


                                        </h4>
                                        <div class="input-group md-form form-sm form-2 pl-0" style="padding:15px">
                                            <input onkeyup="Search('input2','data2')" class="input100 " style="border-radius: 0;height:40px;background-color: white;border: 1px solid grey;" type="text" placeholder="Recherche..." id="input2" aria-label="Search">
                                        </div>
                                    </div>

                                    <div class="table-responsive ">

         <script>
                                        $(document).ready( function () {
    $('#myTable2').DataTable({bFilter: false, bInfo: false,bPaginate: false});
} );</script>
                                        <div class="tableFixHead" style="height: 300px;">
                                            <table id="myTable2" class="table table-borderless table-striped table-earning">
                                                <thead>
                                                    <tr>
                                                        <th>Matricule </th>
                                                        <th>Nom et prenom</th>
                                                        <th>Etat</th>
                                                        <th>Pension Servie (DT)</th>
                                                        <th>Contrôlé Par</th>
                                                        <th>Date Contrôle</th>

                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <?php


                                                    $array = runQuery("SELECT * from dossier WHERE Controle!=''  ORDER BY id ASC");
                                                    $count2 = mysqli_num_rows(mysqli_query($connect, "SELECT * from dossier WHERE Controle!=''  ORDER BY id ASC"));

                                                    if (!empty($array)) {
                                                        foreach ($array as $key => $value) {

                                                    ?>
                                                            <tr class="data2">
                                                                <td><?php echo $array[$key]["Matricule"] ?></td>
                                                                <td><?php echo $array[$key]["NomPrenom"] ?></td>
                                                                <td> <?php if ($array[$key]["Etat"] == "Paye") {
                                                                            echo "<p style='color:green'>" . $array[$key]["Etat"] . "</p>";
                                                                        } elseif ($array[$key]["Etat"] == "Non Paye") {
                                                                            echo "<p style='color:darkred'>" . $array[$key]["Etat"] . "</p>";
                                                                        } elseif ($array[$key]["Etat"] == "en cours de paiement") {
                                                                            echo "<p style='color:orange'>" . $array[$key]["Etat"] . "</p>";
                                                                        } elseif ($array[$key]["Etat"] == "correspondance") {
                                                                            echo "<p style='color:red'>" . $array[$key]["Etat"] . "</p>";
                                                                        }  ?></td>
                                                                        <td><?php echo $array[$key]["MontantDemande"] ?></td>
                                                                <td><?php 
                                                                        echo GetName($array[$key]["ControlePar"]);
                                                                     ?></td>
                                                                <td><?php echo $array[$key]["DateControle"] ?></td>


                                                            </tr>

                                                    <?php }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row" id="nonPaye" style="width: auto;height: 450px;overflow: hidden;">

                        <div class="col-md-12 grid-margin">
                            <div class="card" style="height: 700px;">

                                <div class="card-body">
                                    <div class="fix">
                                        <h4 class="card-title" style="color:green">
                                            <h2 class="title-1 m-b-25"><i class="fas fa-times" style="font-size : 30px; color : red"> </i> Listes Des Dossiers Non Payé</h2>


                                        </h4>
                                        <div class="input-group md-form form-sm form-2 pl-0" style="padding:15px">
                                            <input onkeyup="Search('input3','data3')" class="input100 " style="border-radius: 0;height:40px;background-color: white;border: 1px solid grey;" type="text" placeholder="Recherche..." id="input3" aria-label="Search">
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        
                                        <div class="tableFixHead" style="height: 300px;">
                                        <script>
                                        $(document).ready( function () {
    $('#myTable3').DataTable({bFilter: false, bInfo: false,bPaginate: false});
} );</script>
                                            <table id="myTable3" class="table table-borderless table-striped table-earning">
                                                <thead>

                                                    <tr>
                                                        <th>

                                                            Matricule
                                                        </th>
                                                        <th>Nom et prenom</th>
                                                        <th>Ajouté Par</th>
                                                        <th>Controlé Par</th>
                                                        <th>Pension servie (DT)</th>



                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php

                                                    $array = runQuery("SELECT * FROM Dossier where  Etat like 'Non Paye' ");

                                                    if (!empty($array)) {
                                                        foreach ($array as $key => $value) {

                                                    ?>
                                                            <tr class="data3">
                                                                <td><?php echo $array[$key]["Matricule"] ?></td>
                                                                <td><?php echo $array[$key]["NomPrenom"] ?></td>
                                                                <td><?php echo GetName($array[$key]["AjoutePar"]) ?></td>
                                                                <td><?php if ($array[$key]["ControlePar"] == "") {
                                                                        echo "-----";
                                                                    } else {
                                                                        echo GetName($array[$key]["ControlePar"]);
                                                                    } ?></td>

                                                                <td><?php echo $array[$key]["MontantDemande"] ?></td>


                                                            </tr>

                                                    <?php }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <style>
                        .row,
                        .card,.table{
                            border-radius: 30px;
                        }
                    </style>
                    <div class="row" id="cloture" style="width: auto;height: 450px;overflow: hidden;">

                        <div class="col-md-12 grid-margin">
                            <div class="card" style="height: 700px;">

                                <div class="card-body">
                                    <div class="fix">
                                        <h4 class="card-title" style="color:green">
                                            <h2 class="title-1 m-b-25"><i class="far fa-check-circle" style="font-size : 30px; color : green"></i>Listes Des Dossiers Cloturés</h2>


                                        </h4>
                                        <div class="input-group md-form form-sm form-2 pl-0" style="padding:15px">
                                            <input onkeyup="Search('input4','data4')" class="input100 " style="border-radius: 0;height:40px;background-color: white;border: 1px solid grey;" type="text" placeholder="Recherche..." id="input4" aria-label="Search">
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <div class="tableFixHead" style="height: 300px;">
                                                   <script>
                                        $(document).ready( function () {
    $('#myTable4').DataTable({bFilter: false, bInfo: false,bPaginate: false});
} );</script>
                                            <table id="myTable4" class="table table-borderless table-striped table-earning">
                                                <thead>

                                                    <th>
                                                        Matricule
                                                    </th>
                                                    <th>Nom et prenom</th>
                                                    <th>Pension servie (DT)</th>
                                                    <th>Ajouté Par</th>
                                                    <th>Date Ajout</th>
                                                    <th>Controlé Par</th>
                                                    <th>Date Controle</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $array = runQuery("SELECT * FROM Dossier where  Etat like 'Paye' and Controle like 'Accepter' ");
                                                    $count4 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where  Etat like 'Paye' and Controle!='' "));

                                                    if (!empty($array)) {
                                                        foreach ($array as $key => $value) {

                                                    ?>
                                                            <tr class="data4">
                                                                <td><?php echo $array[$key]["Matricule"] ?></td>
                                                                <td><?php echo $array[$key]["NomPrenom"] ?></td>
                                                                <td><?php echo $array[$key]["MontantDemande"] ?></td>

                                                                <td><?php echo GetName($array[$key]["AjoutePar"]) ?></td>
                                                                <td><?php echo $array[$key]["DateAjout"] ?></td>
                                                                <td><?php echo GetName($array[$key]["ControlePar"]) ;?></td>

                                                                <td><?php echo $array[$key]["DateControle"] ?></td>



                                                            </tr>

                                                    <?php }
                                                    } ?>

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script>
            function Search(input, data) {
                var input = document.getElementById(input);
                var filter = input.value.toLowerCase();
                var element = document.getElementsByClassName(data);


                for (i = 0; i < element.length; i++) {

                    if (element[i].innerText.toLowerCase().includes(filter)) {
                        element[i].style.display = "table-row";

                    } else {
                        element[i].style.display = "none";

                    }
                }
            }
        </script>
    </body>
<?php
} else { ?>
    @include("Error");
<?php }
?>


    </html>
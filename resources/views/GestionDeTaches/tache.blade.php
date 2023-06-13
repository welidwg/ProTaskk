<?php
use Illuminate\Support\Facades\Input;

$current = "tache";
      $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
?>
<html lang="en">

<head>
    @include("GestionDeParametre.nav")
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery.js" type="text/javascript"></script>
    <link rel="stylesheet" href="js/fullcalendar/fullcalendar.min.css" />
    <script src="js/fullcalendar/lib/moment.min.js"></script>
    <script src="js/fullcalendar/fullcalendar.min.js"></script>
    <script src="js/fullcalendar/locale-all.js"></script>
    <title>ProTask | Gestion des tâches </title>
    <link rel="stylesheet" href="CSS/style2.css">
    <script src="js/canvasjs.min.js"> </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    


</head>
<style>
    html {}

    .card {
        height: auto;
        max-height: 500px;
        overflow: hidden;
    }
</style>
<style>
    .input100 {
        display: inline-block;
        box-shadow: 2px 2px 5px #2f4f4f;
        margin-bottom: 20px;
        outline: none;
        max-width: 90%;
        margin-left: 5px
    }


    label {
        font-size: 16px;

        font-weight: bolder;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        margin-left: 20px;
    }

    .add_task {
        border-radius: 50%;
        background-color: limegreen;
        padding: 10px;
        float: right;
    }

    .add_task:hover {
        color: limegreen;
        background-color: #2f4f4f;
    }

    .fa-plus {
        color: white;
    }


    .modal-content1 {
        height: auto;
        z-index: 9999;

    }

    .form .btn {
        display: block;
        width: 50%;
        padding: 12px;
        margin: auto;

        -webkit-appearance: none;
        outline: 0;
        border: #05324f 1px solid;
        color: #05324f;
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        background-color: transparent;
        transition: 0.3s;
        font-size: 15px;
        border-radius: 40px;
    }



    .btn:hover {
        background-color: #05324f;
        color: white;

    }

    .btn1 {
        width: 50%;
        border-radius: 20px;

    }

    .btn1:hover {
        background-color: limegreen;
        color: white;

    }


    .form-control:focus {
        box-shadow: none;

    }



    td {
        padding: 0px;
    }

    .date {
        max-width: 90%;
        font-size: 13px;
    }

    .row,
    .card {
        border-radius: 30px;
    }
</style>

<body>

    <?php
    $type=Session::get('type') ;
    if ($type == "CHEF CENTRE") {
        $all = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM tache"));
        $utilisateur = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM utilisateurs"));
        $encours = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where etat like 'En cours'"));
        $done = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where etat like 'complete'"));
        $enattente = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where etat like 'en attente'"));
        $rejete = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where etat like 'rejete'"));
        $date = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where MONTH(datefintravail) =  1 and etat like 'complete'"));
        $date2 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(datefintravail) =  2 and etat like 'complete'"));
        $date3 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(datefintravail) =  3 and etat like 'complete'"));
        $date4 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(datefintravail) =  4 and etat like 'complete'"));
        $date5 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(datefintravail) =  5 and etat like 'complete' "));
        $date6 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(datefintravail) =  6 and etat like 'complete' "));
        $date7 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(datefintravail) =  7 and etat like'complete'"));
        $date8 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where MONTH(datefintravail) =  8 and etat like 'complete'"));
        $date9 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(datefintravail) =  9 and etat like 'complete'"));
        $date10 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(datefintravail) =  10 and etat like 'complete' "));
        $date11 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(datefintravail) =  11 and etat like 'complete'"));
        $date12 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(datefintravail) =  12 and etat like 'complete'"));


        $dateAff = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where MONTH(dateAffectation) =  1 "));
        $dateAff2 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(dateAffectation) =  2 "));
        $dateAff3 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(dateAffectation) =  3"));
        $dateAff4 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(dateAffectation) =  4 "));
        $dateAff5 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(dateAffectation) =  5  "));
        $dateAff6 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(dateAffectation) =  6  "));
        $dateAff7 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(dateAffectation) =  7 "));
        $dateAff8 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where MONTH(dateAffectation) =  8  "));
        $dateAff9 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(dateAffectation) =  9 "));
        $dateAff10 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(dateAffectation) =  10  "));
        $dateAff11 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(dateAffectation) =  11 "));
        $dateAff12 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where  MONTH(dateAffectation) =  12  "));




    ?>

        <script>
            jQuery(function($) {


                setInterval(function() {
                    Stats1()
                }, 1000);




                function Stats1() {

                    $.ajax({
                        url: "<?php echo url('StatsCHEF') ?>",
                        data: {
                            query: "stats",



                        },
                        type: "GET",
                        success: function(response) {
                            var data = $.parseJSON(response);
                            $('#attente').html('<i class="fa fa-pause-circle"></i> en attente <br> ' + data.att);
                            $('#encours').html('<i class="fa fa-hourglass-end"></i> en cours <br> ' + data.encours);
                            $('#done').html('<i class="fa fa-check"></i> complètes <br> ' + data.done);
                            $('#rejete').html('<i class="fa fa-ban"></i> rejetées <br> ' + data.rejete);


                        }

                    })
                }
            });
        </script>
        <div class="row">
            <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-warning card-img-holder text-white" onclick="document.getElementById('ajoute').style.display='block'">

                    <img src="CSS/Image/circle.png" class="card-img-absolute" alt="circle-image" />

                    <h2 style="color:white;font-size:18px;padding:40px;text-align:center;font-weight: 700;" id="attente"></h2>

                </div>
            </div>
            <div class="col-md-3 stretch-card grid-margin">

                <div class="card bg-gradient-info card-img-holder text-white">

                    <img src="CSS/Image/circle.png" class="card-img-absolute" alt="circle-image" />

                    <h2 style="color:white;font-size:18px;padding:40px;text-align:center;font-weight: 700;" id="encours"> </h2>


                </div>
            </div>


            <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">

                    <img src="CSS/Image/circle.png" class="card-img-absolute" alt="circle-image" />

                    <h2 style="color:white;font-size:18px;padding:40px;text-align:center;font-weight: 700;" id="done"> </h2>


                </div>
            </div>
            <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">

                    <h2 style="color:white;font-size:18px;padding:40px;text-align:center;font-weight: 700;" id="rejete"> </h2>

                    <img src="CSS/Image/circle.png" class="card-img-absolute" alt="circle-image" />



                </div>
            </div>


        </div>

        <script type="text/javascript">
            $(document).ready(function() {



                $('#calendar').fullCalendar({

                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,basicWeek,basicDay'
                    },

                    locale: 'fr',
                    eventLimit: true, // for all non-TimeGrid views
                    eventLimit: 3, // adjust to 6 only for timeGridWeek/timeGridDay
                    eventLimitText: "plus",

                    events: "Calendar",
                    eventTextcolor: "#fff",
                    eventClick: function(calEvent, jsEvent, view) {
                        alert(calEvent.event.title)
                    },


                    eventAfterRender: function(event, element) {
                        console.log(event); // Debug
                        if (event.title.indexOf("ATCT") > -1) { // if title contains "Pending"
                            element.css({
                                'background-color': '#ffcce7',
                                'border': '1px solid #ffcce7',
                                'color': "#000"
                            });
                        } else if (event.title.indexOf("immatriculation") > -1) { // if title contains "Pending"
                            element.css({
                                'background-color': '#316879',
                                'border': '1px solid #316879',
                                'color': "#fff"
                            });
                        } else if (event.title.indexOf("Demande de recul de l âge de la mise à la retraite") > -1) { // if title contains "Pending"
                            element.css({
                                'background-color': '#daf2dc',
                                'border': '1px solid #daf2dc',
                                'color': "#000"
                            });
                        } else if (event.title.indexOf("Nouvelle affiliation") > -1) { // if title contains "Pending"
                            element.css({
                                'background-color': '#f47a60',
                                'border': '1px solid #f47a60',
                                'color': "#000"
                            });
                        } else if (event.title.indexOf("Mise à jour des données administratives") > -1) { // if title contains "Pending"
                            element.css({
                                'background-color': '#7fe7dc                                ',
                                'border': '1px solid #7fe7dc',
                                'color': "#000"
                            });
                        } else if (event.title.indexOf("Prêts universitaire") > -1) { // if title contains "Pending"
                            element.css({
                                'background-color': '#81b7d2',
                                'border': '1px solid #81b7d2',
                                'color': "#000"
                            });
                        } else if (event.title.indexOf("Mise à la retraite anticipee") > -1) { // if title contains "Pending"
                            element.css({
                                'background-color': '#4d5198',
                                'border': '1px solid #4d5198',
                                'color': "#fff"
                            });
                        } else if (event.title.indexOf("Prêts Personnels") > -1) { // if title contains "Pending"
                            element.css({
                                'background-color': '#ced7d8',
                                'border': '1px solid #ced7d8',
                                'color': "#000"
                            });
                        }
                    }


                });

            })
        </script>
        <style>
            #calendar {
                font-size: 13px;
                overflow: hidden;
            }

            .details {
                list-style: none;
                padding: 0;
                margin: 0;
                font-size: 13px;
            }

            .details li {
                padding-left: 16px;
            }

            .details li:before {
                content: "\f0c8";
                font-family: 'Font Awesome 5 Free';
                display: inline-block;
                font-weight: bold;



                padding: 5px;
                color: green;
            }

            .details li:nth-child(1):before {
                color: #ffcce7;
            }

            .details li:nth-child(2):before {
                color: #f47a60;
            }

            .details li:nth-child(3):before {
                color: #4d5198;
            }

            .details li:nth-child(4):before {
                color: #316879;
            }

            .details li:nth-child(5):before {
                color: #daf2dc;
            }

            .details li:nth-child(6):before {
                color: #7fe7dc;
            }

            .details li:nth-child(7):before {
                color: #81b7d2;
            }

            .details li:nth-child(8):before {
                color: #ced7d8;
            }
        </style>

        <div class="row" style="width: 70%;float:left;height:auto;background-color: #fff;padding: 20px;margin-bottom: 50px;">

            <div id="calendar" style="overflow: hidden;"></div>
        </div>
        <div class="row" style="width: 30%;float:right;height:400px;background-color: #fff;padding: 40px;margin-bottom: 50px;">
            <ul class="details">
                <li>ATCT</li>
                <li>Nouvelle affiliation</li>
                <li>Mise à la retraite anticipee</li>
                <li>immatriculation</li>
                <li>Recul de l'âge de la mise à la retraite</li>
                <li>Mise à jour des données administratives</li>
                <li>Prêts universitaire </li>
                <li>Prêts Personnels </li>




            </ul>

        </div>
        <div class="row" id="" style="width:31%;float: right;height:200px;overflow: hidden;">

            <div class="col-md-12 grid-margin" style="width:100%">
                <div class="card" style="width:100%">
                    <div class="card-body" style="height:170px;overflow:hidden ;">
                        <div class="d-flex justify-content-between align-items-center activity">
                            <div><span class="activity-done"><i class="fas fa-star"></i> Tâche la plus affectée du mois <?php echo date('F'); ?>
                                </span></div>


                            <div><span class="ml-2"></span></div>

                        </div>
                        <div class="mt-3">

                            <ul class="list list-inline">

                                <?php

                                $m = date("m");

                                $req = "SELECT tache, COUNT(*) AS magnitude 
                                FROM historique
                                GROUP BY tache
                                ORDER BY magnitude DESC
                                LIMIT 1";
                                $month = mysqli_fetch_array(mysqli_query($connect, $req));
                                if ($month) { ?>
                                    <li class='d-flex justify-content-between'>
                                        <div class='d-flex flex-row align-items-center'><i class='fas fa-medal' style='font-size: 12px;color:goldenrod'></i>
                                            <div class='ml-2'>
                                                <h6 class='mb-0' style="font-size: 14px;"><?php echo $month["tache"];  ?></h6>

                                            </div>
                                        </div>
                                        <div class='d-flex flex-row align-items-center'>

                                            <div class='d-flex flex-column mr-2'>
                                                <span> <?php echo $month[1]; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                <?php } else {
                                    echo "<li class='d-flex justify-content-between'>Aucun enregistrement</li>";
                                } ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>







        <style>
            .custom {
                height: 20px;
            }

            .fc-more-popover {
                max-height: 50%;
                overflow-y: auto;
                margin-top: -190;

            }
        </style>





        <div id="myModall" class="modal" style="z-index:9999999999999999999999999;<?php if (Input::has("EditTache")) {
                                                                                        echo "display:block;";
                                                                                    } ?>">

            <!-- Modal content -->
            <div class="modal-content1">
                <span class="close1">&times;</span>
                <div class="user">
                    <header class="user__header">
                        <h1 class="user__title" style="font-size:20px"><?php if (Input::has("EditTache")) {
                                                                            echo "Modifier ";
                                                                        } else {
                                                                            echo "Ajouter ";
                                                                        } ?>une tâche</h1>
                    </header>

                    <form class="form" method="POST" >
                        <hr>
                        <?php if (Input::has("EditTache")) {
                            $idtache = Input::get("EditTache");
                            $tache = mysqli_fetch_array(mysqli_query($connect, "SELECT * from tache where id like $idtache"));
                        } ?>


                        <div class="form__group">
                            <label>Nom de tâche</label>

                            <input <?php if (Input::has("EditTache")) {
                                        echo "value='" . $tache["tache"] . "'";
                                    } ?> type="text" minlength="4" name="tache" placeholder="Tâche" minlength="" class="input100" required title="Veuillez saisir un nom de tache valide" />
                        </div>

                        <hr>

                        <input type="hidden" name="idTache" value="<?php if (Input::has("EditTache")) {
                                                                        echo $idtache;
                                                                    }  ?>">



                        <div class="form__group">
                            <label class="">Responsable</label>
                            <select name="type" class="input100" required>
                                <?php if (isset($_GET['EditTache'])) { ?>
                                    <option id="typeTACHE" <?php
                                                            echo "value='" . $tache["type"] . "'";
                                                            ?>><?php if (isset($_GET['EditTache'])) {
                                                                    if ($tache["type"] == "CONTROLER") {
                                                                        echo "Contrôleur";
                                                                    } else {
                                                                        echo "Liquidateur";
                                                                    }
                                                                } ?></option> <?php } ?>
                                <option id="Liquid" value="LIQUIDER">Liquidateur</option>
                                <option id="Ctrl" value="CONTROLER">Contrôleur</option>
                            </select>
                        </div>
                        <hr>
                        <div class="form__group">
                            <label class="">Priorité</label>
                            <select name="priorite" id="priorite" class="input100" required>
                                <?php if (isset($_GET['EditTache'])) { ?>
                                    <option id="priorite" <?php
                                                            echo "value='" . $tache["importante"] . "'";
                                                        } ?>><?php if (Input::has("EditTache")) {
                                                                    if ($tache["importante"] == "OUI") {
                                                                        echo "Elevée";
                                                                    } else {
                                                                        echo "Faible";
                                                                    }
                                                                ?></option><?php } ?>
                                <option id="Elevé" value="OUI">Elevée</option>
                                <option id="Faible" value="NON">Faible</option>
                            </select>
                        </div>
                        <hr>

                        <hr>



                        <button class="btn" <?php if (Input::has("EditTache")) {
                                                echo "name='modifier_tache' formaction='ModifierTache'";
                                            } else {
                                                echo "name='ajout_tache' formaction='AjouterTache'";
                                            } ?> type="submit"><?php if (Input::has("EditTache")) {
                                                                    echo "Modifier";
                                                                } else {
                                                                    echo "Ajouter";
                                                                } ?></button>
<input type="hidden" value="{{ Session::token() }}" name="_token">

                    </form>




                        @if (Input::has("EditTache")) 

                    <script>
                        
                            var type = document.getElementById("typeTACHE");
                            var Liquidateur = document.getElementById("Liquid");
                            var Controleur = document.getElementById("Ctrl");

                            var priorite = document.getElementById("priorite");
                            var Eleve = document.getElementById("Elevé");
                            var Faible = document.getElementById("Faible");



                            if (type.value == Liquidateur.value) {
                                Liquidateur.style.display = "none";
                            } else if (type.value == Controleur.value) {
                                Controleur.style.display = "none";
                            }

                            if (priorite.value == "OUI") {
                                Eleve.style.display = "none";
                            } else if (priorite.value == "NON") {
                                Faible.style.display = "none";

                            }
                        
                    </script>
                    @endif

                    <?php


                    if (isset($_POST['ajout_tache'])) {

                        $tache = $_POST['tache'];
                        $type = $_POST['type'];
                        $priorite = $_POST["priorite"];

                        $sql = "INSERT INTO tache (tache,type,importante) VALUES ('$tache','$type','$priorite') ";
                        $verif = mysqli_num_rows(mysqli_query($connect, "SELECT * from tache where tache like '$tache'"));
                        if ($verif == 0) {


                            if (mysqli_query($connect, $sql)) {
                                echo ("<meta http-equiv='refresh' content='0;  URL =?TacheAjoute'/>");
                            } else {
                                echo mysqli_error($connect);
                                echo ("<meta http-equiv='refresh' content='0;  URL =?TacheNonAjoute'/>");
                            }
                        } else {
                            echo ("<meta http-equiv='refresh' content='0;  URL =?NomExist&#taches'/>");
                        }
                    } elseif (isset($_POST['modifier_tache'])) {
                        $idtache = $_POST["idTache"];
                        $tache = $_POST['tache'];
                        $type = $_POST['type'];
                        $priorite = $_POST["priorite"];
                        $task = mysqli_fetch_array(mysqli_query($connect, "SELECT * from tache where id like $idtache"));

                        if ($task["tache"] == $tache) {
                            $verif = 0;
                            $sql = "UPDATE tache SET type='$type',importante='$priorite' where id like $idtache";
                        } else {
                            $verif = mysqli_num_rows(mysqli_query($connect, "SELECT * from tache where tache like '$tache'"));

                            $sql = "UPDATE tache SET tache='$tache',type='$type',importante='$priorite' where id like $idtache";
                        }


                        if ($verif == 0) {



                            if (mysqli_query($connect, $sql)) {
                                mysqli_query($connect, "UPDATE historique SET tache='$tache' where idtache like $idtache");

                                echo ("<meta http-equiv='refresh' content='0;  URL =?TacheModifier&#taches'/>");
                            } else {
                                echo mysqli_error($connect);
                                echo ("<meta http-equiv='refresh' content='0;  URL =?TacheNonModifier&#taches'/>");
                            }
                        } else {
                            echo ("<meta http-equiv='refresh' content='0;  URL =?NomExist&#taches'/>");
                        }
                    } ?>
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
                font-weight: 600
            }

            .list-group li {
                margin-bottom: 12px;

            }


            .list li {
                list-style: none;
                padding: 10px;
                border: 1px solid #e3dada;
                margin-top: 12px;
                border-radius: 5px;
                background: #fff
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

            .row {
                width: 100%;
            }
        </style>




        <br>

        <style>
            .tableFixHead {
                overflow: auto;
                max-height: 400px;


            }

            .tableFixHead thead th {
                position: sticky;
                top: 0;
                z-index: 5;
                background-color: white;
                height: 60px;
            }
        </style>
        <br>
        <br>
           
          
 <!-- <select name="chart" onchange="myfunction()" class="form-control" id="chart"> 
<option value="pie">pie</option>
<option value="pyramid">pyramid</option>
<option value="column">column</option>
<option value="spline">spline</option>
<option value="bar">bar</option>
<option value="area">area</option>

</select> -->
<div class="row" style="width: 60%;float: left;height:650px">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body" style="height:550px">
                        <div id="chartContainer" style="height: 450px; width: 100%;border-radius:10px;float : right;margin:auto;"></div>

                        <script type="text/javascript">
                       
                          /*  var chartType = document.getElementById("chart").value; */

                            var chart = new CanvasJS.Chart("chartContainer", {
                                theme: "light2", // "light2", "dark1", "dark2"
                                animationEnabled: true, // change to true		
                                exportEnabled: true,
                               
                                title: {
                                    text: "Tâches complètes par mois",
                                    fontSize: 25
                                },
                                data: [{
                                        // Change type to "bar", "area", "spline", "pie",etc.
                                        type: "column",
                                        
                                      dataPoints:

                                            [


                                                 {
                                                    label: "janvier",
                                                    y: {{$date }}
                                                },
                                                {
                                                    label: "février",
                                                    y:{{$date2 }}
                                                },

                                                {
                                                    label: "Mars",
                                                    y: {{$date3 }}
                                                },
                                                {
                                                    label: "Avril",
                                                    y: {{$date4 }}
                                                },
                                                {
                                                    label: "Mai",
                                                    y: {{$date5 }}
                                                },
                                                {
                                                    label: "Juin",
                                                    y: {{$date6 }}
                                                },
                                                {
                                                    label: "Juillet",
                                                    y: {{$date7}}
                                                },
                                                {
                                                    label: "Août",
                                                    y: {{$date8 }}
                                                },
                                                {
                                                    label: "Septembre",
                                                    y: {{$date9 }}
                                                },
                                                {
                                                    label: "Octobre",
                                                    y: {{$date10 }}
                                                },
                                                {
                                                    label: "Novembre",
                                                    y: {{$date11 }}
                                                },
                                                {
                                                    label: "Decembre",
                                                    y: {{$date12 }}
                                                },



                                            ]
                               
                                }]
                            });
                            chart.render();
                       
                        </script>
                    </div>
                </div>
            </div>
        </div>   
        
    

        
        <div class="row" style="width: 40%;float: right;height:550px">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body" style="height:550px">
                        <div id="chartContainer2" style="height: 450px; width: 100%;border-radius:10px;float : right;margin:auto;"></div>

                        <script type="text/javascript">

                            var chart2= new CanvasJS.Chart("chartContainer2", {
                                title: {
                                    text: "Tâches affectés par mois",
                                    fontSize: 25
                                },
                                theme: "light2", // "light2", "dark1", "dark2"
                                animationEnabled: true, // change to true
                                exportEnabled: true,
                                data: [{
                                    type: "spline",
                                    

                                    dataPoints:

                                        [


                                            {
                                                label: "janvier",
                                                y: {{$dateAff }}
                                            },
                                            {
                                                label: "février",
                                                y: {{$dateAff2 }}
                                            },

                                            {
                                                label: "Mars",
                                                y: {{$dateAff3 }}
                                            },
                                            {
                                                label: "Avril",
                                                y: {{$dateAff4 }}
                                            },
                                            {
                                                label: "Mai",
                                                y: {{$dateAff5 }}
                                            },
                                            {
                                                label: "Juin",
                                                y: {{$dateAff6 }}
                                            },
                                            {
                                                label: "Juillet",
                                                y:{{$dateAff7 }}
                                            },
                                            {
                                                label: "Août",
                                                y: {{$dateAff8 }}
                                            },
                                            {
                                                label: "Septembre",
                                                y: {{$dateAff9 }}
                                            },
                                            {
                                                label: "Octobre",
                                                y: {{$dateAff10 }}
                                            },
                                            {
                                                label: "Novembre",
                                                y: {{$dateAff11 }}
                                            },
                                            {
                                                label: "Decembre",
                                                y: {{$dateAff12 }}
                                            },



                                        ]
                                }] 
                            });
                            chart2.render();
                        
                        </script>
                    </div>
                </div>
            </div>
        </div>



        <div class="row" id="taches" style="height:550px;width: 60%;float:left">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">


                    <style>
                        .fix {
                            position: sticky;
                            top: 0;
                            background-color: white;
                            z-index: 5;
                        }
                    </style>
                    <div class="card-body">

                        <div class="fix">
                            <button id="myBtn3" class="add_task"><i class="fa fa-plus"></i></button>

                            <h4 class="card-title"><i class="fa fa-tasks"></i> Les Tâches </h4>

                            <div id="hideMe" style="position: relative;">
                                <h5 style="text-align:center;color:red;font-size: 15px;font-weight: 700;<?php if (isset($_GET["NonAffecter"])) {
                                                                                                            echo "display:block";
                                                                                                        } else {
                                                                                                            echo "display:none";
                                                                                                        } ?>">Cette tâche est déjà affecter à cet utilisateur!</h5>
                                <h5 style="text-align:center;color:limegreen;font-size: 15px;font-weight: 700;<?php if (isset($_GET["Affecter"])) {
                                                                                                                    echo "display:block";
                                                                                                                } else {
                                                                                                                    echo "display:none";
                                                                                                                } ?>">Tâche affectée avec succées.</h5>

                                <h5 style="text-align:center;color:red;font-size: 15px;font-weight: 700;<?php if (isset($_GET["NomExist"])) {
                                                                                                            echo "display:block";
                                                                                                        } else {
                                                                                                            echo "display:none";
                                                                                                        } ?>">Cette tâche est déja ajoutée.</h5>

                                <h5 style="text-align:center;color:limegreen;font-size: 15px;font-weight: 700;<?php if (isset($_GET["TacheModifier"])) {
                                                                                                                    echo "display:block";
                                                                                                                } else {
                                                                                                                    echo "display:none";
                                                                                                                } ?>">Tâche modifiée avec succées.</h5>

                                <h5 style="text-align:center;color:red;font-size: 15px;font-weight: 700;<?php if (isset($_GET["TacheNonModifier"])) {
                                                                                                            echo "display:block";
                                                                                                        } else {
                                                                                                            echo "display:none";
                                                                                                        } ?>">Tâche non modifiée.</h5>

                                <h5 style="text-align:center;color:limegreen;font-size: 15px;font-weight: 700;<?php if (isset($_GET["Delete"])) {
                                                                                                                    echo "display:block";
                                                                                                                } else {
                                                                                                                    echo "display:none";
                                                                                                                } ?>">Tâche Supprimée avec succées.</h5>


 <h5 style="text-align:center;color:limegreen;font-size: 15px;font-weight: 700;<?php if (Session::has("TacheAjout")) {
                                                                                                                    echo "display:block";
                                                                                                                } else {
                                                                                                                    echo "display:none";
                                                                                                                } ?>">Tâche ajoutée avec succées.</h5>





                            </div>

                            <div class="input-group md-form form-sm form-2 pl-0">
                                <input onkeyup="Search('input2','data2')" style="border:1px solid purple;z-index:0" class="form-control my-0 py-1 pl-3 purple-border" type="text" placeholder="Recherche..." id="input2" aria-label="Search">
                                <span id='btn' class="input-group-addon waves-effect purple lighten-2" id="basic-addon1"><a><i class="fa fa-search white-text" aria-hidden="true"></i></a></span>
                            </div>

                        </div>


                        <div class="table-responsive">
                            <div class="tableFixHead" style="height:400px">
                                <table class="table" id="myTable">
                                    <style>

                                    </style>
                                    <thead style="text-align:center;font-size:13px;">
                                        <tr>


                                            <th> Tâche </th>
                                            <th> Priorité</th>
                                            <th> Responsable</th>
                                            <th> Affectation </th>
                                            <th> Action</th>
                                        </tr>
                                    </thead>
                                    <form action="" method="POST">

                                        <tbody style="text-align:center;font-size: 13px;">
                                            <?php
                                            $array = runQuery("SELECT * from tache order by importante desc ");
                                            if (!empty($array)) {
                                                foreach ($array as $key => $value) {
                                            ?>
                                                    <tr class="data2">
                                                        <td><?php echo $array[$key]["tache"]  ?></td>

                                                        <td><label class="<?php if ($array[$key]["importante"] == "OUI") {
                                                                                echo "badge badge-gradient-danger";
                                                                            } else {
                                                                                echo "badge badge-gradient-info";
                                                                            } ?>"><?php if ($array[$key]["importante"] == "OUI") {
                                                                                        echo "élevée";
                                                                                    } else {
                                                                                        echo "faible";

                                                                                    }  ?></label></td>

                                                        <td><?php if ($array[$key]["type"] == "CONTROLER") {
                                                                echo "Contrôleur";
                                                            } else {
                                                                echo "Liquidateur";
                                                            }  ?></td>
                                                            

                                                        <td style="padding:15px"> <a href="?idtache=<?php echo $array[$key]["id"] ?>&#taches"> <i class="far fa-share-square" style="font-size:20px;"></i></a></td>
                                                        <td style="font-size:20px;padding:15px;display: inline-block;width:150px;white-space: nowrap;">
                                                            <form method="GET" action="SupprimerTache">
                                                            <a href="?EditTache=<?php echo $array[$key]["id"] ?>&#taches"><i class="far fa-edit" style="color: limegreen;"></i></a>
                                                            <input type="hidden" name="id" value="<?php echo $array[$key]["id"]; ?>"/> <button type="submit" onclick="return confirm('Vous êtes sur de supprimer cette tâche ?'); " name="supprimer_tache"><i class="fas fa-trash" style="color: red;"></i></a></form>

                                                        </td>

                                                    </tr>
                                                    <?php
                                                  
                                                  
                                                    ?>


                                            <?php }
                                            } ?>
                                    </form>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="row" id="user" style="width:40%;float: right;height:300;overflow: hidden;">

            <div class="col-md-12 grid-margin" style="width:100%">
                <div class="card">
                    <div class="card-body" style="height:300px;overflow:hidden ;">
                    



                        <div class="d-flex justify-content-between align-items-center activity">
                            <div><span class="activity-done" id="connected"></span></div>

                            <div><i class="fas fa-clock"></i><span class="ml-2" id="time"></span></div>
                        </div>
                        <div class="mt-3" style="overflow: auto;">
                            <ul class="list list-inline" id="user_conn" style="overflow: auto;max-height: 300px;height:auto">


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="" style="width:40%;float: right;height:200px;overflow: hidden;margin-top: 10px;">

            <div class="col-md-12 grid-margin" style="width:100%">
                <div class="card" style="width:100%">
                    <div class="card-body" style="height:170px;overflow:hidden ;">
                        <div class="d-flex justify-content-between align-items-center activity">
                            <div><span class="activity-done"><i class="fas fa-star"></i> Utilisateur le plus active du mois <?php echo date('F'); ?>
                                </span></div>



                        </div>
                        <div class="mt-3">

                            <ul class="list list-inline">

                                <?php

                                $m = date("m");

                                $req = "SELECT utilisateurAncien, COUNT(*) AS magnitude 
                                FROM historique
                                Where utilisateurAncien!='' and Month(datePassation)='$m'
                                GROUP BY utilisateurAncien
                                ORDER BY magnitude DESC
                                LIMIT 1";
                                 function GetName($id)
    {
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $username = mysqli_fetch_array(mysqli_query($connect, "SELECT Nom from utilisateurs where id like $id"));
        return $username[0];
    }
                                $month = mysqli_fetch_array(mysqli_query($connect, $req));
                                if ($month) { ?>
                                    <li class='d-flex justify-content-between'>
                                        <div class='d-flex flex-row align-items-center'><i class='fas fa-medal' style='font-size: 12px;color:goldenrod'></i>
                                            <div class='ml-2'>
                                                <h6 class='mb-0' style="font-size: 14px;"><?php echo GetName($month["utilisateurAncien"])  ?></h6>

                                            </div>
                                        </div>
                                        <div class='d-flex flex-row align-items-center'>

                                            <div class='d-flex flex-column mr-2'>
                                                <?php echo$month[1]  . " tâches passées"; ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php } else {
                                    echo "<li class='d-flex justify-content-between'>Aucun enregistrement</li>";
                                } ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="liste" style="max-height:600px;width:100%;">
            <div class="col-md-12 grid-margin">
                <div class="card">

                    <div class="card-body" style="height:600px">
                        <div class="fix">
                            <h4 class="card-title" style="color:green">
                                <a>
                                    <i class="fa fa-check"></i> Liste des tâches affectés
                                </a>
                            </h4>

                            <div id="hideMe" style="position: relative;">
                                <h5 style="text-align:center;color:limegreen;font-size: 15px;font-weight: 700;<?php if (isset($_GET["Reafecter"])) {
                                                                                                                    echo "display:block";
                                                                                                                } else {
                                                                                                                    echo "display:none";
                                                                                                                } ?>">Tâche reaffectée avec succées!</h5>

                                <h5 style="text-align:center;color:limegreen;font-size: 15px;font-weight: 700;<?php if (isset($_GET["SuppTache"])) {
                                                                                                                    echo "display:block";
                                                                                                                } else {
                                                                                                                    echo "display:none";
                                                                                                                } ?>">Tâche Supprimée avec succées!</h5>

                            </div>
                            <div class="input-group md-form form-sm form-2 pl-0">
                                <input onkeyup="Search('input1','data1')" style="border:1px solid purple;z-index:0" class="form-control my-0 py-1 pl-3 purple-border" type="text" placeholder="Recherche..." id="input1" aria-label="Search">
                                <span id='btn' class="input-group-addon waves-effect purple lighten-2" id="basic-addon1"><a><i class="fa fa-search white-text" aria-hidden="true"></i></a></span>
                            </div>
                        </div>



                        <div class="table-responsive" style="font-size: 15px;">
                            <div class="tableFixHead">
                             
                                <table class="table" id="list">



                                    <thead style="text-align:center;font-size: 15px;">

                                        <tr>

                                            <th>
                                                Responsable
                                            </th>
                                            <th> Tâche </th>
                                            <th> Statut </th>
                                            <th> Dossiers à traiter</th>
                                            <th>Dossiers Traités</th>
                                            <th>Matricules </th>
                                            <th> Date d'affectation</th>
                                            <th> Echéance </th>
                                            <th> Date de résiliation </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align:center;font-size:15px;" id="affecté">





                                        <?php if (isset($_GET["Supp"])) {
                                            $id_tache = $_GET["Supp"];
                                            $hist = mysqli_fetch_array(mysqli_query($connect, "SELECT * from historique where id like $id_tache "));
                                            $idtache = $hist["idtache"];
                                            $nom = $hist["utilisateur"];

                                            $del = "DELETE FROM historique where id like $id_tache";
                                            $del2 = "DELETE FROM dossierTache where idtache=$idtache and utilisateur like '$nom'";

                                            mysqli_query($connect, $del);
                                            mysqli_query($connect, $del2);


                                            echo ("<meta http-equiv='refresh' content='0;  URL =Tache?SuppTache&#liste'/>");
                                        } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div id="modalReaffect" class="modal" style="z-index:999999">

            <!-- Modal content -->
            <div class="modal-content1">
                <span class="close6">&times;</span>
                <div class="user">
                    <header class="user__header">
                        <h1 class="user__title" style="font-size:20px">reAffecter une tâche</h1>
                    </header>
 <script>
                            datePickerId = document.getElementById("rea");
                            datePickerId.min = new Date().toISOString().split("T")[0];
        </script>
                    <form class="form" method="POST" action="ReAffect">
                                                {{ csrf_field() }}

                        <hr>


                        <div class="form__group">
                            <label>Nouvelle échéance</label>


                            <input id="rea" type="date" name="date" placeholder="" class="input100" required title="Veuillez saisir un datevalide" />
                        </div>
                        <input type="hidden" name="idtache" value="<?php echo Input::get("reAffect"); ?>">
                        
                        <hr>


                        <button class="btn" name="reaff" type="submit">ReAffecter</button>
                    </form>
                   

                </div>

            </div>
        </div>

        <div class="row" id="passée" style="max-height:600px;">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body" style="height:500px">

                        <h4 class="card-title" style="position:sticky">
                            <a>
                                <i class="fa fa-share-square"></i> Liste des tâches Passées
                            </a>
                        </h4>
                        <div class="table-responsive">
                            <div class="input-group md-form form-sm form-2 pl-0">
                                <input onkeyup="Search('input8','data8')" style="border:1px solid purple;z-index:0" class="form-control my-0 py-1 pl-3 purple-border" type="text" placeholder="Recherche..." id="input8" aria-label="Search">
                                <span id='btn' class="input-group-addon waves-effect purple lighten-2" id="basic-addon1"><a><i class="fa fa-search white-text" aria-hidden="true"></i></a></span>
                            </div>
                            <div class="tableFixHead">
                                <table class="table" id="taskPassed">
                                           
                                    <thead style="text-align:center;">
                                        <tr>
                                            <th> Tâche </th>

                                            <th> Responsable </th>
                                            <th>Passée Vers </th>
                                            <th>Date de passation</th>
                                            <th> Statut actuel </th>
                                            <th>Matricules des dossiers</th>
                                            <th> Date d'affectation</th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <form action="POST" onsubmit="return false;">
                                        <tbody style="text-align:center;font-size:14px;" id="passe">

                                        </tbody>
                                    </form>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="dossier" style="height:600px;width:60% ;float: left;">


            <div class=" col-md-12 grid-margin stretch-card">
                <div class="card" style="overflow-x:hidden">
                    <div class="card-body" style="height:600px">
                        <div class="fix">
                            <h4 class="card-title">
                                <h4 class="card-title"><i class="fa fa-search"></i> Suivi Des Dossiers</h4>
                            </h4>
                            <div class="input-group md-form form-sm form-2 pl-0">
                                <input onkeyup="Search('input10','data10')" style="border:1px solid purple;z-index:0" class="form-control my-0 py-1 pl-3 purple-border" type="text" placeholder="Recherche..." id="input10" aria-label="Search">
                                <span id='btn' class="input-group-addon waves-effect purple lighten-2" id="basic-addon1"><a><i class="fa fa-search white-text" aria-hidden="true"></i></a></span>
                            </div>
                        </div>

                        <div class="table-responsive" >
                            <div class="tableFixHead">
                                <table class="table" id="Folder">
                      
     

                                    <thead style="text-align:center;font-size:13px">
                                        <tr>
                                            <th> Matricule </th>
                                            <th> Responsable</th>
                                            <th>Passé de </th>
                                            <th>Tâche</th>
                                            <th> Etat</th>
                                            <th>Date Résiliation</th>
                                        </tr>
                                    </thead>

                                    <tbody style="text-align:center;font-size: 13px;" id="suiviDossier">

                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="progres" style="height:600px;width:40%;float:right">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body" style="height:600px">
                        <div class="fix">
                            <h4 class="card-title" style="color:#9a55ff"><i class="fa fa-spinner"></i> Progrés des tâches </h4>

                            <div class="input-group md-form form-sm form-2 pl-0">
                                <input onkeyup="Search('input6','data3')" style="border:1px solid purple;z-index:0" class="form-control my-0 py-1 pl-3 purple-border" type="text" placeholder="Recherche..." id="input6" aria-label="Search">
                                <span id='btn' class="input-group-addon waves-effect purple lighten-2" id="basic-addon1"><a><i class="fa fa-search white-text" aria-hidden="true"></i></a></span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div class="tableFixHead">
                                <table class="table" id="progress">
                        
                                    <thead style="font-size: 13px;">
                                        <tr>

                                            <th> Responsable </th>
                                            <th>Nom de la tâche</th>
                                            <th>Progrés
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size:13px" id="progresDossier">





                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
           

            @if (Input::has("idtache"))
            <div id="myModal2" class="modal" style="z-index:999999;overflow: hidden;">

                <div class="modal-content1" style="width:40%;overflow-y: auto;height: auto;max-height:600px">
                    <span class="close2">&times;</span>
                    <div class="user">
                        <header class="user__header">
                            <h1 class="user__title" style="font-size:20px">Affecter une tâche </h1>
                        </header>

                        <form class="form" method="POST" action="AffecterTache">
                            <hr>




                            <style>
                                .input100 {
                                    max-width: 200px;
                                }

                                label {
                                    width: 100px;
                                }
                            </style>
                            <div class="form__group">
                                <label class="">Responsable</label>
                                <select name="utilisateur" id="select" class="input100" required>


                                    <?php
                                    $idtache = Input::get("idtache");
                                    $nomtache = mysqli_fetch_array(mysqli_query($connect, "SELECT * from tache where id like $idtache"));
                                    $typetache = $nomtache["type"];





                                    $array = runQuery("SELECT * from utilisateurs where type like '$typetache' order by Nom asc ");
                                    if (!empty($array)) {
                                        foreach ($array as $key => $value) {
                                    ?>
                                            <option value="<?php echo $array[$key]["id"] ?>"> <?php echo $array[$key]["Nom"] ?> </option>
                                    <?php }
                                    } ?>
                                </select>
                                <br>

                                <label class="">Echéance</label>
                                <input id="datePickerId" name="datefin" class="input100" type="date" min="<?php echo date("d-m-Y"); ?>" required>
                                <script>
                                    datePickerId = document.getElementById("datePickerId");
                                    datePickerId.min = new Date().toISOString().split("T")[0];
                                </script>

                                <br>


                                <label for="">Nombre des Dossiers </label>



                                <select id='Dossier' name="numDossier" class="input100" style="width: 20%;" required>
                                    <?php
                                    for ($i = 1; $i <= 10; $i++) {
                                    ?> <option><?php echo $i ?></option><?php } ?>
                                </select>
                                <style>
                                    .add {
                                        margin: auto 0px;
                                        font-size: 20px;
                                        background-color: #05324f;
                                        color: white;
                                        cursor: pointer;
                                        padding-right: 15px;
                                        padding-left: 15px;
                                        padding-top: 8px;
                                        padding-bottom: 10px;

                                        border-radius: 50%;


                                    }

                                    .add:hover {
                                        color: white;
                                        background-color: #2f4f4f;

                                    }
                                </style>
                                &nbsp;&nbsp;



                                <?php if ($nomtache["tache"] != "immatriculation" || $nomtache["tache"] != "Nouvelle affiliation") { ?>

                                    <a class="add" style="color:white;" name="ajouterDossier" id="ajouterDossier" onclick="Dossier(this)"> + </a>
                                <?php } ?>

                                <script>
                                    function maxLengthCheck(object) {
                                        if (object.value.length > object.maxLength) {
                                            object.value = object.value.slice(0, 10)


                                        }
                                    }

                                    function Dossier(item) {
                                        var num = document.getElementById('Dossier').value;
                                        var container = document.getElementById("formm");
                                        if (num == '' || num == "0") {
                                            container.innerHTML = '';
                                        }



                                        container.innerHTML = '';

                                        for (var i = 0; i < num; i++) {
                                            var input = document.createElement("input");
                                            input.type = "number";
                                            input.name = "Matricule[]";
                                            input.className = 'input100';
                                            input.required = "true";
                                            input.oninput = function() {
                                                maxLengthCheck(input);
                                            }

                                            input.placeholder = 'Matricule' + (i + 1);
                                            container.appendChild(input);




                                        }



                                        item.innerHTML = '';
                                        item.innerHTML = '-';
                                        item.onclick = function() {
                                            container.innerHTML = ''
                                            item.innerHTML = '+';
                                            item.onclick = function() {
                                                Dossier(item);
                                            }

                                        }




                                    }
                                </script>

                            </div>
                            <hr>
                            <div id="formm" class="form__group" style="padding:30px;">
                            </div>
                            <hr>
                            <input type="hidden" value="<?php echo $_GET['idtache'] ?>" name="idtache">

                            <button class="btn" name="affecter" type="submit">Affecter</button>
                            {{csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
                        
 
            
             @endif
           

        <?php } elseif ($type == "LIQUIDER" || $type == "CONTROLER") {

        $nom = Session::get("id1");
        $attente = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where utilisateur like $nom and etat like 'en attente' "));
        $encours = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where utilisateur like $nom and etat like 'en cours' "));
        $current = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where utilisateur like $nom and etat like 'complete' "));
        $old = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where utilisateurAncien like $nom and etat like 'complete' "));
        $complete=$current+$old;

        $rejete = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where utilisateur like '$nom' and  etat like 'rejete'"));

        ?>

            <style>
                h2 {
                    white-space: nowrap;
                }

                .tableFixHead {
                    overflow-y: auto;
                    height: 400px;
                }

                .tableFixHead thead th {
                    position: sticky;
                    top: 0;
                }
            </style>



            <div class="row">
                <div class="col-md-3 stretch-card grid-margin">
                    <div class="card bg-gradient-warning card-img-holder text-white">

                        <h2 style="color:white;font-size:18px;padding:40px;text-align:center;font-weight: 700;"><i class="fa fa-pause-circle"></i> En attente <br><?php echo $attente ?></h2>

                        <img src="CSS/Image/circle.png" class="card-img-absolute" alt="circle-image" />



                    </div>
                </div>
                <div class="col-md-3 stretch-card grid-margin">

                    <div class="card bg-gradient-info card-img-holder text-white">

                        <img src="CSS/Image/circle.png" class="card-img-absolute" alt="circle-image" />

                        <h2 style="color:white;font-size:18px;text-align:left;margin-left:10px;padding:40px;text-align:center;font-weight: 700"><i class="fa fa-hourglass-end"></i> En cours<br><?php echo $encours ?> </h2>


                    </div>
                </div>
                <div class="col-md-3 stretch-card grid-margin">
                    <div class="card bg-gradient-success card-img-holder text-white">

                        <img src="CSS/Image/circle.png" class="card-img-absolute" alt="circle-image" />

                        <h2 style="color:white;font-size:18px;text-align:left;margin-left:10px;padding:40px;text-align:center;font-weight: 700"><i class="fa fa-check"></i> Complètes <br><?php echo $complete ?></h2>


                    </div>
                </div>

                <div class="col-md-3 stretch-card grid-margin">
                    <div class="card bg-gradient-danger card-img-holder text-white">

                        <img src="CSS/Image/circle.png" class="card-img-absolute" alt="circle-image" />

                        <h2 style="color:white;font-size:18px;text-align:left;margin-left:10px;padding:40px;text-align:center;font-weight: 700"><i class="fa fa-ban"></i> Rejetées<br><?php echo $rejete ?></h2>

                    </div>
                </div>
            </div>

            <div class="row" style="width: 50%;height:550px;float: left">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body" style="height:550px">
                            <div id="chartContainer2" style="height: 450px; width: 100%;border-radius:10px;float : right;margin:auto;"></div>

                            <script type="text/javascript">
                                var chart2 = new CanvasJS.Chart("chartContainer2", {
                                    title: {
                                        text: "Tâches complètes",
                                        fontSize: 25
                                    },
                                    axisY: {
                                        labelFontSize: 13,
                                    },
                                    theme: "light2", // "light2", "dark1", "dark2"
                                    animationEnabled: true, // change to true
                                    exportEnabled : true,
                                     showInLegend: true,
                                    data: [{
                                        type: "stackedArea",
                                        dataPoints:

                                            [


                                                {
                                                    label: "ATCT",
                                                    y: <?php 
                                                        echo mysqli_num_rows(mysqli_query($connect, "SELECT * from historique where tache='ATCT' and utilisateur like '$nom' and etat like 'complete' OR tache='ATCT' and utilisateurAncien like '$nom' and  etatAncien like 'complete'")) ?>
                                                },
                                                {
                                                    label: "Nouvelle Affiliation",
                                                    y: <?php echo mysqli_num_rows(mysqli_query($connect, "SELECT * from historique where tache='Nouvelle Affiliation' and utilisateur like '$nom' and etat like 'complete' OR tache='Nouvelle Affiliation' and utilisateurAncien like '$nom' and  etatAncien like 'complete'")) ?>
                                                },

                                                {
                                                    label: "Mise à la retraite anticipee",
                                                    y: <?php echo mysqli_num_rows(mysqli_query($connect, "SELECT * from historique where tache='Mise à la retraite anticipee' and utilisateur like '$nom' and etat like 'complete' OR tache='Mise à la retraite anticipee' and utilisateurAncien like '$nom' and  etatAncien like 'complete'")) ?>
                                                },
                                                {
                                                    label: "immatriculation",
                                                    y: <?php echo mysqli_num_rows(mysqli_query($connect, "SELECT * from historique where tache='immatriculation' and utilisateur like '$nom' and etat like 'complete' OR tache='immatriculation' and utilisateurAncien like '$nom' and  etatAncien like 'complete'")) ?>
                                                },
                                                {
                                                    label: "Recul de l'âge de la mise à la retraite",
                                                    y: <?php echo mysqli_num_rows(mysqli_query($connect, "SELECT * from historique where tache='Demande de recul de l âge de la mise à la retraite' and utilisateur like '$nom' and etat like 'complete' OR tache='Demande de recul de l âge de la mise à la retraite' and utilisateurAncien like '$nom' and  etatAncien like 'complete'")) ?>
                                                },
                                                {
                                                    label: "Mise à jour des données administratives",
                                                    y: <?php echo mysqli_num_rows(mysqli_query($connect, "SELECT * from historique where tache='Mise à jour des données administratives' and utilisateur like '$nom' and etat like 'complete' OR tache='Mise à jour des données administratives' and utilisateurAncien like '$nom' and  etatAncien like 'complete'")) ?>
                                                },
                                                {
                                                    label: "Prêts universitaire",
                                                    y: <?php echo mysqli_num_rows(mysqli_query($connect, "SELECT * from historique where tache='Prêts universitaire' and utilisateur like '$nom' and etat like 'complete' OR tache='Prêts universitaire' and utilisateurAncien like '$nom' and  etatAncien like 'complete'")) ?>
                                                },
                                                {
                                                    label: "Prêts Personnels",
                                                    y: <?php echo mysqli_num_rows(mysqli_query($connect, "SELECT * from historique where tache='Prêts Personnels' and utilisateur like '$nom' and etat like 'complete' OR tache='Prêts Personnels' and utilisateurAncien like '$nom' and  etatAncien like 'complete'")) ?>
                                                },





                                            ]
                                    }]
                                });
                                chart2.render();
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="width: 50%;height:550px;">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body" style="height:550px">
                            <div id="chartContainer3" style="height: 450px; width: 100%;border-radius:10px;margin:auto;"></div>

                            <script type="text/javascript">
                                var chart3 = new CanvasJS.Chart("chartContainer3", {
                                    title: {
                                        text: "Nombre des dossiers traités par tâche",
                                        fontSize: 21,
                                    },
                                    axisX: {
                                        labelFontSize: 13,
                                    },
                                    theme: "light2", // "light2", "dark1", "dark2"
                                    animationEnabled: true, // change to true
                                    exportEnabled : true,
                                    data: [{
                                        type: "bar",

                                        dataPoints:

                                            [


                                                {
                                                    label: "ATCT",
                                                    y: <?php
                                                        $nom=Session::get("id1");
                                                        $array1 = runQuery("SELECT * from historique where tache='ATCT' and utilisateur like '$nom' and etat like 'complete' OR tache='ATCT' and utilisateurAncien like '$nom' and  etatAncien like 'complete'");
                                                        $nombre1 = 0;
                                                        if (!empty($array1)) {
                                                            foreach ($array1 as $k => $v) {
                                                                $nombre1 += $array1[$k]["numDossier"];
                                                            }
                                                        }
                                                        echo $nombre1;



                                                        ?>
                                                },
                                                {
                                                    label: "Nouvelle Affiliation",
                                                    y: <?php
                                                        $array1 = runQuery("SELECT * from historique where tache='Nouvelle Affiliation' and utilisateur like '$nom' and etat like 'complete' OR tache='Nouvelle Affiliation' and utilisateurAncien like '$nom' and  etatAncien like 'complete'");
                                                        $nombre1 = 0;
                                                        if (!empty($array1)) {
                                                            foreach ($array1 as $k => $v) {
                                                                $nombre1 += $array1[$k]["numDossier"];
                                                            }
                                                        }
                                                        echo $nombre1;



                                                        ?>
                                                },

                                                {
                                                    label: "Mise à la retraite anticipee",
                                                    y: <?php
                                                        $array1 = runQuery("SELECT * from historique where tache='Mise à la retraite anticipee' and utilisateur like '$nom' and etat like 'complete' OR tache='Mise à la retraite anticipee' and utilisateurAncien like '$nom' and  etatAncien like 'complete'");
                                                        $nombre1 = 0;
                                                        if (!empty($array1)) {
                                                            foreach ($array1 as $k => $v) {
                                                                $nombre1 += $array1[$k]["numDossier"];
                                                            }
                                                        }
                                                        echo $nombre1;



                                                        ?>
                                                },
                                                {
                                                    label: "immatriculation",
                                                    y: <?php
                                                        $array1 = runQuery("SELECT * from historique where tache='immatriculation' and utilisateur like '$nom' and etat like 'complete' OR tache='immatriculation' and utilisateurAncien like '$nom' and  etatAncien like 'complete'");
                                                        $nombre1 = 0;
                                                        if (!empty($array1)) {
                                                            foreach ($array1 as $k => $v) {
                                                                $nombre1 += $array1[$k]["numDossier"];
                                                            }
                                                        }
                                                        echo $nombre1;



                                                        ?>
                                                },
                                                {
                                                    label: "Recul de l'âge de la mise à la retraite",
                                                    y: <?php
                                                        $array1 = runQuery("SELECT * from historique where tache='Demande de recul de l âge de la mise à la retraite' and utilisateur like '$nom' and etat like 'complete' OR tache='Demande de recul de l âge de la mise à la retraite' and utilisateurAncien like '$nom' and  etatAncien like 'complete'");
                                                        $nombre1 = 0;
                                                        if (!empty($array1)) {
                                                            foreach ($array1 as $k => $v) {
                                                                $nombre1 += $array1[$k]["numDossier"];
                                                            }
                                                        }
                                                        echo $nombre1;



                                                        ?>
                                                },
                                                {
                                                    label: "M.A.J des données administratives \n",
                                                    y: <?php
                                                        $array1 = runQuery("SELECT * from historique where tache='Mise à jour des données administratives' and utilisateur like '$nom' and etat like 'complete' OR tache='Mise à jour des données administratives' and utilisateurAncien like '$nom' and  etatAncien like 'complete'");
                                                        $nombre1 = 0;
                                                        if (!empty($array1)) {
                                                            foreach ($array1 as $k => $v) {
                                                                $nombre1 += $array1[$k]["numDossier"];
                                                            }
                                                        }
                                                        echo $nombre1;



                                                        ?>
                                                },
                                                {
                                                    label: "Prêts universitaire",
                                                    y: <?php
                                                        $array1 = runQuery("SELECT * from historique where tache='Prêts universitaire' and utilisateur like '$nom' and etat like 'complete' OR tache='Prêts universitaire' and utilisateurAncien like '$nom' and  etatAncien like 'complete'");
                                                        $nombre1 = 0;
                                                        if (!empty($array1)) {
                                                            foreach ($array1 as $k => $v) {
                                                                $nombre1 += $array1[$k]["numDossier"];
                                                            }
                                                        }
                                                        echo $nombre1;



                                                        ?>
                                                },
                                                {
                                                    label: "Prêts Personnels",
                                                    y: <?php
                                                        $array1 = runQuery("SELECT * from historique where tache='Prêts Personnels' and utilisateur like '$nom' and etat like 'complete' OR tache='Prêts Personnels' and utilisateurAncien like '$nom' and  etatAncien like 'complete'");
                                                        $nombre1 = 0;
                                                        if (!empty($array1)) {
                                                            foreach ($array1 as $k => $v) {
                                                                $nombre1 += $array1[$k]["numDossier"];
                                                            }
                                                        }
                                                        echo $nombre1;



                                                        ?>
                                                },





                                            ]
                                    }]
                                });
                                chart3.render();
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row " id="enattente">
                <div class="col-12 grid-margin">
                    <div class="card">

                        <script>
                            jQuery(function($) {

                                var interval = setInterval(function() {
                                    Tache_enattente()
                                }, 1000);

                                $('#input_attente').on("focus", function(event) {
                                    clearInterval(interval);

                                });


                                function Tache_enattente() {

                                    $.ajax({
                                        url: "ConsulterTache",
                                        data: {
                                            query: "enattente",
                                            nom: "<?php echo Session::get("id1") ?>"

                                        },
                                        type: "GET",
                                        success: function(data) {
                                            $("#enattente1").empty().append(data);;



                                        }

                                    })
                                }
                            })(jQuery);
                        </script>
                        <div class="card-body">
                            <div class="fix">
                                <h4 class="card-title" style="font-weight:700;color:#ffd500">
                                    <li class="fa fa-pause-circle"></li> Tâches en attente
                                </h4>

                                </h4>
                                <style>
                                    .input100:focus {
                                        outline: auto;
                                    }
                                </style>
                                <div class="input-group md-form form-sm form-2 pl-0">
                                    <input onkeyup="Search('input_attente','data_attente')" style="z-index:0" class="form-control inp_search " type="text" placeholder="Recherche..." id="input_attente" aria-label="Search">
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
                                    z-index: 1;
                                    background-color: white;
                                }
                            </style>



                            <div class="table-responsive">

                                <div class="tableFixHead">

                                    <table class="table">
                                        <thead style="text-align:center;">
                                            <tr>
                                                <th> Tâche </th>
                                                <th> Date affectation</th>
                                                <th> Echéance </th>
                                                <th> Dossiers à traiter</th>
                                                <th> Matricules des dossiers</th>
                                                <th>Priorité</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align:center;font-size:14px;" id="enattente1">
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row " id="encours">
                <div class="col-12 grid-margin">
                    <div class="card" style="max-height:500px;overflow: auto;">
                        <div class="card-body">
                            <div class="fix">
                                <h4 class="card-title" style="font-weight:700;color:#047edf">
                                    <li class="fa fa-hourglass-end"></li> Tâches en cours
                                </h4>


                                <div id="hideMe" style="position: relative;">
                                    <h5 style="text-align:center;color:limegreen;font-size: 15px;font-weight: 700;<?php if (isset($_GET["Commencé"])) {
                                                                                                                        echo "display:block";
                                                                                                                    } else {
                                                                                                                        echo "display:none";
                                                                                                                    } ?>">Vous avez commencer la tâche!</h5>


                                    <h5 style="text-align:center;color:limegreen;font-size: 15px;font-weight: 700;<?php if (isset($_GET["MAJ"])) {
                                                                                                                        echo "display:block";
                                                                                                                    } else {
                                                                                                                        echo "display:none";
                                                                                                                    } ?>">Progrés mis à jour!</h5>




                                </div>

                                <div class="input-group md-form form-sm form-2 pl-0">
                                    <input onkeyup="Search('encours1','encours1')" style="z-index:0" class="form-control inp_search " type="text" placeholder="Recherche..." id="encours1" aria-label="Search">
                                </div>
                            </div>
                            <div class="tableFixHead">
                                <table class="table">

                                    <thead style="text-align:center;font-size:15px">




                                        <div class="table-responsive">

                                            <tr>
                                                <th> Nom de la tâche </th>
                                                <th> Date affectation</th>
                                                <th> Echéance </th>
                                                <th> Dossiers à traiter</th>
                                                <th> Matricules des dossiers</th>
                                                <th>Dossiers traités</th>
                                                <th>Priorité</th>
                                                <th>Action</th>
                                                </th>
                                            </tr>
                                    </thead>
                                    <tbody style="text-align:center;font-size:14px;white-space: nowrap;">
                                        <?php
                                        $idUser=Session::get("id1");




                                        $array = runQuery("SELECT  *  from historique where utilisateur like $idUser and etat like 'en cours' ORDER BY importante desc");
                                        if (!empty($array)) {
                                            foreach ($array as $key => $value) {
                                                $id = $array[$key]["id"];
                                        ?>
                                                <tr class="encours1" style="text-align:center">

                                                    <td><?php echo $array[$key]["tache"] ?></td>
                                                    <td><?php echo $array[$key]["dateAffectation"] ?></td>





                                                    <td><?php echo $array[$key]["datefin"] ?></td>
                                                    <td>
                                                        <?php echo $array[$key]["numDossier"];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $nom = $array[$key]["utilisateur"];
                                                        $idtache = $array[$key]["idtache"];

                                                        $req = runQuery("SELECT * from dossierTache WHERE utilisateur like '$nom' and idhist like $id ");
                                                        if (!empty($req)) {
                                                            foreach ($req as $k => $v) {
                                                                echo $req[$k]["matricule"] . "<br>";
                                                            }
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($array[$key]["numDossierTraiter"] == NULL) {
                                                            echo 0;
                                                        } else {
                                                            echo $array[$key]["numDossierTraiter"];
                                                        } ?>
                                                    </td>
                                                    <td><label class="<?php if ($array[$key]["importante"] == "OUI") {
                                                                            echo "badge badge-gradient-danger";
                                                                        } else {
                                                                            echo "badge badge-gradient-info";
                                                                        } ?>"><?php if ($array[$key]["importante"] == "OUI") {
                                                                                    echo "élevée";
                                                                                } else {
                                                                                    echo "faible";
                                                                                }  ?></label></td>

                                                    <td>
                                                        <a id="MAJ" href="?MiseAjour=<?php echo $array[$key]["id"] ?>&#encours"><i class="fa fa-edit" style="color:darkblue;font-size:20px"></i></a> &nbsp


                                                        <a id="PROL" href="?Demande=<?php echo $array[$key]["id"] ?>&#encours"> <i class="far fa-clock" style="color: darkred;font-size:20px"></i></a>
                                                    </td>







                                                </tr>

                                            <?php }
                                        } else { ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style='padding:10px'>Aucune Tâche</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($_GET['MiseAjour'])) { ?>
                <div id="modalMAJ" class="modal" style="z-index:999999">

                    <div class="modal-content1">
                        <span class="close4">&times;</span>
                        <div class="user">
                            <header class="user__header">
                                <h1 class="user__title" style="font-size:20px">Mise à jour</h1>
                            </header>

                            <form class="form" method="POST" action="MiseAjour">
                                 {{ csrf_field() }}
                                <hr>


                                <div class="form__group">
                                    <?php if (isset($_GET["MiseAjour"])) {
                                        $id = $_GET["MiseAjour"];
                                        $query = mysqli_fetch_array(mysqli_query($connect, "SELECT * from historique where id like $id"));
                                        $numDossier = $query["numDossier"];
                                        $numDossiertraite = $query["numDossierTraiter"];
                                        $idtache = $query["id"];
                                        $nomUs = $query["utilisateur"];

                                    ?>

                                         @if (mysqli_num_rows(mysqli_query($connect, "SELECT * from dossierTache where idhist like $idtache and utilisateur like '$nomUs'")) == 0)
                                             
                                            <label>Nombre des dossiers traités</label>

                                            <input type="number" min="1" max="<?php echo $numDossier - $numDossiertraite ?>" name="nombreD" placeholder="" class="input100" required title="Veuillez saisir un numero valide" />
                                         @endif

                                            <?php 
                                        echo "</div>";

                                        $array = runQuery("SELECT * from dossierTache where utilisateur like '$nom' and idhist like $id  and etat!='rejete'   ");
                                        if (!empty($array)) {
                                            $i = 0;
                                            echo "<div class='form__group' style='display:inline'>
                                            <label>Cochez les dossiers traités:</label><br>";
                                            foreach ($array as $keyy => $vall) {
                                                $i++;
                                            ?>
                                                &nbsp;
                                                <input <?php if ($array[$keyy]['etat'] == "complete") {
                                                            echo "checked disabled  ";
                                                        } ?> class="checkbox" value="<?php echo $array[$keyy]['matricule'] ?>" type="checkbox" name="mat[]"><?php echo $array[$keyy]['matricule'] ?>




                                    <?php
                                            }
                                            echo "</div>";
                                        }
                                    } ?>


                                    <input type="hidden" name="idtache" value="<?php echo $idtache ?>">
                                    <input type="hidden" name="username" value="<?php echo $nom ?>">
                                    <input type="hidden" name="idhist" value="<?php echo $id ?>">


                                    <hr>






                                    <button class="btn" name="MAJ" type="submit">Mettre à jour</button>
                            </form>

                          
                        </div>

                    </div>
                </div>
            <?php } ?>
            <?php if (isset($_GET['Demande'])) { ?>
                <div id="modalPROL" class="modal" style="z-index:999999">

                    <div class="modal-content1">
                        <span class="close5">&times;</span>
                        <div class="user">
                            <header class="user__header">
                                <h1 class="user__title" style="font-size:20px">Demande prolongation</h1>
                            </header>

                            <form class="form" method="POST" action="AjouterDemande">
                                <hr>

<input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form__group">
                                    <label>Nombre de jours de prolongation</label>
                                    <select class="input100" name="nbjour" id="">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                    </select>

                                </div>
                                <hr>
                                <div class="form__group">
                                    <label for="">Cause de prolongation : </label>
                                    <input type="text" minlength="5" name="cause" placeholder="..." class="input100" required />
                                </div>
                             <input type="hidden" name="nameUsr" value="<?php echo Session::get("nom"); ?>">


                                <input type="hidden" name="idtache" value="<?php if (isset($_GET["Demande"])) {
                                                                                echo $_GET["Demande"];
                                                                            }  ?>">

                                <hr>






                                <button class="btn" name="PROL" type="submit">Soumettre la demande</button>
                            </form>

                            <?php  ?>
                        </div>

                    </div>
                </div>
            <?php } ?>
            <div class="row " id="complete">
                <div class="col-12 grid-margin">
                    <div class="card" style="max-height:500px;overflow: auto;">
                        <div class="card-body">
                            <div class="fix">
                                <h4 class="card-title" style="font-weight:700;color:#1bcfb4">
                                    <li class="fa fa-check"></li> Tâches complètes
                                </h4>
                                <div id="hideMe" style="position: relative;">

                                    <h5 style="text-align:center;color:limegreen;font-size: 15px;font-weight: 700;<?php if (isset($_GET["MAJfin"])) {
                                                                                                                        echo "display:block";
                                                                                                                    } else {
                                                                                                                        echo "display:none";
                                                                                                                    } ?>">Vous avez terminer la tâche!</h5>

                                    <h5 style="text-align:center;color:limegreen;font-size: 15px;font-weight: 700;<?php if (isset($_GET["PasséAvecSuccés"])) {
                                                                                                                        echo "display:block";
                                                                                                                    } else {
                                                                                                                        echo "display:none";
                                                                                                                    } ?>">Tâche passée avec succées!</h5>

                                    <h5 style="text-align:center;color:red;font-size: 15px;font-weight: 700;<?php if (isset($_GET["NonPassée"])) {
                                                                                                                echo "display:block";
                                                                                                            } else {
                                                                                                                echo "display:none";
                                                                                                            } ?>">cette tâche est déjà affectée à cet utilisateur!</h5>






                                </div>

                                <div class="input-group md-form form-sm form-2 pl-0">
                                    <input onkeyup="Search('complete1','complete1')" style="z-index:0" class="form-control inp_search " type="text" placeholder="Recherche..." id="complete1" aria-label="Search">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <div class="tableFixHead">


                                    <table class="table">
                                        <thead style="text-align:center;font-size:15px;">
                                            <tr>
                                                <th> Nom de la tâche </th>
                                                <th> Date affectation</th>
                                                <th> Echéance </th>
                                                <th> Date de résiliation</th>
                                                <th> Dossiers à traiter</th>
                                                <th> Matricule des dossiers</th>
                                                <th> Priorité </th>
                                                <th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align:center;font-size:14px;white-space: nowrap;">
                                            <?php




                                            $array = runQuery("SELECT  *  from historique where utilisateur like $idUser and etat='complete' or   utilisateurAncien like '$nom' and   etatAncien='complete' ORDER BY dateAffectation desc");
                                            if (!empty($array)) {
                                                foreach ($array as $key => $value) {
                                                    $id = $array[$key]["id"];
                                            ?>
                                                    <tr class="complete1" style="text-align:center">

                                                        <td><?php echo $array[$key]["tache"] ?></td>
                                                        <td><?php echo $array[$key]["dateAffectation"] ?></td>




                                                        <td><?php echo $array[$key]["datefin"] ?></td>
                                                        <td><?php if ($array[$key]["datePassation"] != "") {
                                                                echo $array[$key]["datePassation"];
                                                            } else {
                                                                echo $array[$key]["datefintravail"];
                                                            } ?></td>

                                                        <td>
                                                            <?php if ($array[$key]["numDossier"] == "") {
                                                                echo "<i style='color:red' class='fa fa-times'></i>";
                                                            } else {
                                                                echo $array[$key]["numDossier"];
                                                            }  ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $nom = $array[$key]["utilisateur"];
                                                            $idtache = $array[$key]["idtache"];

                                                            $req = runQuery("SELECT * from dossierTache WHERE utilisateur like '$nom' and idhist like $id ");
                                                            if (!empty($req)) {
                                                                foreach ($req as $k => $v) {
                                                                    echo $req[$k]["matricule"] . "<br>";
                                                                }
                                                            } else {
                                                                echo "------";
                                                            } ?></td>

                                                        <td><label class="<?php if ($array[$key]["importante"] == "OUI") {
                                                                                echo "badge badge-gradient-danger";
                                                                            } else {
                                                                                echo "badge badge-gradient-info";
                                                                            } ?>"><?php if ($array[$key]["importante"] == "OUI") {
                                                                                        echo "élevée";
                                                                                    } else {
                                                                                        echo "faible";
                                                                                    }  ?></label></td>

                                                        <td style="padding:15px;font-size:15px">

                                                            <?php $ancien = $array[$key]["utilisateurAncien"];
                                                            $nom2 = Session::get('id1');

                                                            if ($ancien == $nom2) {
                                                                echo "------";
                                                            } else { ?>

                                                                <a href="?Passer=<?php echo $array[$key]["id"] ?>&#complete"><i class="fas fa-share-square"></i></a>
                                                            <?php } ?>

                                                        </td>







                                                    </tr>
                                                    <?php if (isset($_GET['Termine'])) {
                                                        $id_tache = $_GET['Termine'];
                                                        mysqli_query($connect, "UPDATE historique SET etat='complete' where id like $id_tache");
                                                        echo ("<meta http-equiv='refresh' content='0;  URL =tache.php#encours'");
                                                    } ?>
                                            <?php }
                                            } else {
                                                echo " <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style='padding:10px'>Aucune Tâche</td>
                                            </tr>";
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

    
{{-- modal de passation de taches --}}
            <div id="modalPASS" class="modal" style="z-index:999999;<?php if (isset($_GET["Passer"])) {
                                                                        echo "display:block;";
                                                                    } ?>">


                <div class="modal-content1">
                    <span class="close8">&times;</span>
                    <div class="user">
                        <header class="user__header">
                            <h1 class="user__title" style="font-size:20px">Passer la tâche</h1>
                        </header>

                        <form class="form" method="POST" action="PasserTache">
                            <hr>


                            <div class="form__group">

                                <label>Passer la tâche à</label>
                                <?php
                                if(Input::has("Passer")){

                                $idhist = $_GET["Passer"];
                                $hist = mysqli_fetch_array(mysqli_query($connect, "SELECT * from historique where id like $idhist"));
                                $nomtache = $hist["tache"];
                                $nomuser = $hist["utilisateur"];
                                $idtache = $hist["idtache"];
                                $tache = mysqli_fetch_array(mysqli_query($connect, "SELECT * from tache where id like $idtache  "));
                                $type = $tache["type"];





                                ?>

                                <div class="form__group">

                                    <select name="passerA" class="input100" id="" required>
                                        <?php $requete = runQuery("SELECT * from utilisateurs where type!='CONSULTER' and type!='CHEF CENTRE' and Nom!='$nom' order by Nom asc");
                                        if (!empty($requete)) {
                                            foreach ($requete as $kk => $vv) { ?>

                                                <option value="<?php echo $requete[$kk]["id"] ?>"><?php echo $requete[$kk]["Nom"] ?></option>

                                        <?php }
                                        } ?>


                                    </select>
                                </div>



                                &nbsp;



                                <input type="hidden" name="idhist" value="<?php echo $idhist ?>">
                                <input type="hidden" name="oldusername" value="<?php echo $nomuser ?>">
                                <input type="hidden" name="idtache" value="<?php echo $idtache ?>">


                                <hr>
                                {{csrf_field()}}





                                <button class="btn" name="PASS" type="submit">Passer</button>
                        </form>
                        <?php } if (isset($_POST["PASS"])) {
                            
                        } ?>


                    </div>

                </div>
            </div>
        </div>
        <div class="row " id="rejete">
            <div class="col-12 grid-margin">
                <div class="card" style="max-height:500px;overflow: auto;">
                    <div class="card-body">
                        <div class="fix">
                            <h4 class="card-title" style="font-weight:700;color:#fe7096">
                                <li class="fa fa-ban"></li> Tâches rejetés
                            </h4>

                            <div class="input-group md-form form-sm form-2 pl-0">
                                <input onkeyup="Search('rejete1','rejete1')" style="z-index:0" class="form-control inp_search " type="text" placeholder="Recherche..." id="rejete1" aria-label="Search">
                            </div>

                        </div>

                        <div class="table-responsive">
                            <div class="tableFixHead">

                                <table class="table">

                                    <thead style="text-align:center;font-size:15px">
                                        <tr>
                                            <th> Tâche </th>
                                            <th> Date affectation</th>
                                            <th> Echéance </th>
                                            <th> Dossiers à traiter</th>
                                            <th> Matricule des dossiers</th>

                                            <th>Priorité</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align:center;font-size:14px;">
                                        <?php




                                        $array = runQuery("SELECT  *  from historique where utilisateur like $idUser and etat like 'rejete' ORDER BY importante desc");
                                        if (!empty($array)) {
                                            foreach ($array as $key => $value) {
                                        ?>
                                                <tr class="rejete1" style="text-align:center">

                                                    <td><?php echo $array[$key]["tache"] ?></td>
                                                    <td><?php echo $array[$key]["dateAffectation"] ?></td>




                                                    <td><?php echo $array[$key]["datefin"] ?></td>
                                                    <td>
                                                        <?php if ($array[$key]["numDossier"] == "") {
                                                            echo "<i style='color:red' class='fa fa-times'></i>";
                                                        } else {
                                                            echo $array[$key]["numDossier"];
                                                        }  ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $nom = $array[$key]["utilisateur"];
                                                        $idtache = $array[$key]["idtache"];

                                                        $req = runQuery("SELECT * from dossierTache WHERE utilisateur like '$nom' and idtache like $idtache and etat like 'rejete' ");
                                                        if (!empty($req)) {
                                                            foreach ($req as $k => $v) {
                                                                echo $req[$k]["matricule"] . "<br>";
                                                            }
                                                        } ?></td>

                                                    <td><label class="<?php if ($array[$key]["importante"] == "OUI") {
                                                                            echo "badge badge-gradient-danger";
                                                                        } else {
                                                                            echo "badge badge-gradient-info";
                                                                        } ?>"><?php if ($array[$key]["importante"] == "OUI") {
                                                                                    echo "élevée";
                                                                                } else {
                                                                                    echo "faible";
                                                                                }  ?></label></td>








                                                </tr>
                                                <?php if (isset($_GET['Termine'])) {
                                                    $id_tache = $_GET['Termine'];
                                                    mysqli_query($connect, "UPDATE historique SET etat='complete' where id like $id_tache");
                                                    echo ("<meta http-equiv='refresh' content='0;  URL =tache.php#encours'");
                                                } ?>
                                        <?php }
                                        } else {
                                            echo " <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style='padding:10px'>Aucune Tâche</td>
                                        </tr>";
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 <?php
} else { ?>
    @include("Error");
<?php }
?>



</body>
    <script>
                            jQuery(function($) {





                                var inter = setInterval(function() {
                                    Tache_Passe(), SuiviDossier(), Tache_Affecte(), User_connected(), NUMBER_User(), Progres(), NUMBER_User(), Time()

                                }, 2000);


                                $('#input1').on("focus", function(event) {
                                    clearInterval(inter);

                                });
                                $('#input8').on("focus", function(event) {
                                    clearInterval(inter);

                                });
                                $('#input10').on("focus", function(event) {
                                    clearInterval(inter);

                                });
                                $('#input6').on("focus", function(event) {
                                    clearInterval(inter);

                                });
                              /* $('th').on("focus", function(event) {
                                    clearInterval(inter);

                                });*/







                                function NUMBER_User() {

                                    $.ajax({
                                        url: "<?php echo url("Connected") ?>",
                                        data: {
                                            query: "user_number"

                                        },
                                        type: "GET",
                                        success: function(data) {
                                            if (data > 0) {
                                                document.getElementById("connected").innerHTML = "<i class='fas fa-user'></i> en ligne (" + data + ")";
                                                document.getElementById("connected").style.color = "limegreen";

                                            } else {
                                                document.getElementById("connected").innerHTML = "<i class='fas fa-user'></i> en ligne (" + data + ")";
                                                document.getElementById("connected").style.color = "#b5b3b3";


                                            }


                                        }

                                    })
                                }

                                function SuiviDossier() {

                                    $.ajax({
                                        url: "<?php echo url('ConsulterTache') ?>",
                                        data: {
                                            query: "suiviDossier"

                                        },
                                        type: "GET",
                                        success: function(data) {

                                            $("#suiviDossier").empty().append(data);

                                        }

                                    })
                                }

                                function Progres() {

                                    $.ajax({
                                        url: "<?php echo url('ConsulterTache') ?>",
                                        data: {
                                            query: "progres"

                                        },
                                        type: "GET",
                                        success: function(data) {

                                            $("#progresDossier").empty().append(data);

                                        }

                                    })
                                }

                                function User_connected() {

                                    $.ajax({
                                        url: "<?php echo url("Connected") ?>",
                                        data: {
                                            query: "user_connected"

                                        },
                                        type: "GET",
                                        success: function(data) {
                                            $("#user_conn").empty().append(data);



                                        }

                                    })
                                }

                                function Tache_Affecte() {
 
                                    $.ajax({
                                        
                                        url: "<?php echo url('ConsulterTache') ?>",
                                        data: {
                                            query: "tache_affecte"

                                        },
                                        
                                        type: "GET",
                                        success: function(data) {
                                            $("#affecté").empty().append(data);
                                            $(".dellt").unbind('click').click(function(event) {
                                                if (!confirm('Vous êtes sur de supprimer cette tâche?'))
                                                    event.preventDefault();
                                            });



                                        }

                                    })
                                }

                                function Tache_Passe() {

                                    $.ajax({
                                        url: "<?php echo url('ConsulterTache') ?>",
                                        data: {
                                            query: "tache_passe"

                                        },
                                        type: "GET",
                                        success: function(data) {
                                            $("#passe").empty().append(data);
                                            $(".dell").unbind('click').click(function(event) {
                                                if (!confirm('Vous êtes sur de supprimer cette tâche?'))
                                                    event.preventDefault();
                                            });




                                        }

                                    })
                                }

                                function Time() {

                                    $.ajax({
                                        url: "<?php echo url("Connected") ?>",
                                        data: {
                                            query: "time"

                                        },
                                        type: "GET",
                                        success: function(data) {
                                            $("#time").empty().append(data);





                                        }

                                    })
                                }


                            });
                        </script>

<script src="js/canvasjs.min.js"></script>
<script src="js/off-canvas.js"></script>

<script src="js/bootstrap.min.js"></script>
<script>
    var modal2 = document.getElementById("myModall");

    // Get the button that opens the modal
    var btn2 = document.getElementById("myBtn3");

    // Get the <span> element that closes the modal
    var span2 = document.getElementsByClassName("close1")[0];

    // When the user clicks the button, open the modal 
    btn2.onclick = function() {
        modal2.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span2.onclick = function() {

        modal2.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal2) {

            modal2.style.display = "none";

        }
    }
</script>
<script>
    var modal3 = document.getElementById("myModal2");
    var span3 = document.getElementsByClassName("close2")[0];

    <?php if (isset($_GET["idtache"])) { ?>
        modal3.style.display = "block";
        span3.onclick = function() {

            modal3.style.display = "none";
        }
    <?php } ?>

    // Get the button that opens the modal
    var btn3 = document.getElementById("myBtn4");

    // Get the <span> element that closes the modal

    // When the user clicks the button, open the modal 
    btn3.onclick = function() {
        modal3.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span3.onclick = function() {

        modal3.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal3) {

            modal3.style.display = "none";

        }
    }
</script>

<script>
    var modal4 = document.getElementById("modalMAJ");
    var span4 = document.getElementsByClassName("close4")[0];

    <?php if (isset($_GET["MiseAjour"])) { ?>
        modal4.style.display = "block";
        span4.onclick = function() {

            modal4.style.display = "none";
        }
    <?php } ?>

    // Get the button that opens the modal
    var btn4 = document.getElementById("MAJ");

    // Get the <span> element that closes the modal

    // When the user clicks the button, open the modal 
    btn4.onclick = function() {
        modal4.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span4.onclick = function() {

        modal4.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal4) {

            modal4.style.display = "none";

        }
    }
</script>
<script>
    var modal5 = document.getElementById("modalPROL");
    var span5 = document.getElementsByClassName("close5")[0];

    <?php if (isset($_GET["Demande"])) { ?>
        modal5.style.display = "block";
        span5.onclick = function() {

            modal5.style.display = "none";
        }
    <?php } ?>

    // Get the button that opens the modal
    var btn5 = document.getElementById("PROL");

    // Get the <span> element that closes the modal

    // When the user clicks the button, open the modal 
    btn5.onclick = function() {
        modal5.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span5.onclick = function() {

        modal5.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal5) {

            modal5.style.display = "none";

        }
    }
</script>
<script>
    var modal6 = document.getElementById("modalReaffect");
    var span6 = document.getElementsByClassName("close6")[0];

    <?php if (isset($_GET["reAffect"])) { ?>
        modal6.style.display = "block";
        span6.onclick = function() {

            modal6.style.display = "none";
        }
    <?php } ?>

    // Get the button that opens the modal
    var btn6 = document.getElementById("reaff");

    // Get the <span> element that closes the modal

    // When the user clicks the button, open the modal 
    btn6.onclick = function() {
        modal5.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span6.onclick = function() {

        modal6.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal6) {

            modal6.style.display = "none";

        }
    }
</script>
<script>
    <?php if (isset($_GET["Passer"])) { ?>
        var span8 = document.getElementsByClassName("close8")[0];
        var modal8 = document.getElementById("modalPASS");
        span8.onclick = function() {

            modal8.style.display = "none";
        }

    <?php } ?>
</script>

</html>
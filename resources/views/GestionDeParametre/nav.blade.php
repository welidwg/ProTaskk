<?php

use App\Http\Controllers\ParametreController;

if (Session::get('type') != '') {


Session::put('LAST_ACTIVITY', time()); //session expirée
$type = Session::get('type');
$tp = Session::get('tp');

$temp = date('Y-m-d | H:i', strtotime('+1 hours'));
$nom = Session::get('nom');

($connect = mysqli_connect('localhost', 'root', '')) or die(mysqli_error($connect));
mysqli_select_db($connect, 'cnrps');

function runQuery($query)
{
($connect = mysqli_connect('localhost', 'root', '')) or die(mysqli_error($connect));
mysqli_select_db($connect, 'cnrps');

$result = mysqli_query($connect, $query);
while ($row = mysqli_fetch_assoc($result)) {
$resultset[] = $row;
}
if (!empty($resultset)) {
return $resultset;
}
}

 ?>


<html lang="en">

<head>



    <script src="js/jquery.js" type="text/javascript"></script>
    <link rel="icon" href="css/Image/logo3.png" />
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link href="font-awesome-5.13/css/all.min.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="css/style.css">
    <meta name="csrf_token" content="{{ csrf_token() }}">


    <!-- SweetAlert2 -->



    <script>
        function msg() {
            var container = document.getElementById('msg');
            if (container.style.display == "block") {
                container.style.display = "none";
            } else {
                container.style.display = "block";
            }
        }
    </script>





    <style>
        body {
            background-image: url("CSS/Image/back6.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            animation: fadein 0.5s;
        }
    </style>

</head>

<body id="body">

    <script>
        jQuery(function($) {
            setInterval(function() {
                Session(), Rejete(), DateCorr()
            }, 10000);






            function Session() {

                $.ajax({
                    url: "<?php echo url('Session'); ?>",
                    data: {
                        activity: "<?php echo Session::get('LAST_ACTIVITY'); ?>",



                    },
                    type: "GET",
                    success: function(data) {
                        if (data.substr(0, 6) == "Logout") {
                            window.location.href = data;


                        }
                    }

                })
            }



            function Rejete() {

                $.ajax({
                    url: "<?php echo url('Rejete'); ?>",
                    data: {
                        query: "rejete",



                    },
                    type: "GET",
                    success: function(data) {
                        if (data == "done") {
                            <?php if(Session::get("type")=="CHEF CENTRE"){ ?>
                            alert("une tâche a dépassée l'échéance!");

                            <?php  } ?>

                        }
                    }

                })
            }

            function DateCorr() {

                $.ajax({
                    url: "DateCorres",
                    data: {
                        session: "<?php echo Session::get('type'); ?>",



                    },
                    type: "GET",
                    success: function(data) {
                        if (data == "dateCorrespondance" || data == "done1") {
                            alert(data);

                        }

                    }

                })
            }
        });
    </script>
    <script>
        function notif() {
            var container = document.getElementById('notif');
            if (container.style.display == "block") {
                container.style.display = "none";
            } else {
                container.style.display = "block";
            }
        }
    </script>





    <script>
        jQuery(function($) {



            setInterval(function() {
                NUMBER()
            }, 10000);




            function NUMBER() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name=_token]').attr('content')
                    }
                });
                $.ajax({

                    url: "<?php echo url('NotifNumber'); ?>",
                    data: {
                        type: "<?php echo $type; ?>",
                        tp: "<?php echo $tp; ?>",
                        nom: "<?php echo Session::get('nom'); ?>",
                        query: "notifNumber"

                    },
                    type: "GET",
                    success: function(data) {
                        if (data == 0) {
                            $("#vider").css("display", "none");


                        } else {
                            $("#vider").css("display", "block");

                        }

                        document.getElementById("number").innerHTML = data;

                    },


                })
            }


            setInterval(function() {
                ITEM()
            }, 10000);




            function ITEM() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name=_token]').attr('content')
                    }
                });
                $.ajax({
                    url: "<?php echo url('NotificationItems'); ?>",
                    data: {
                        type: "<?php echo $type; ?>",
                        tp: "<?php echo $tp; ?>",
                        nom: "<?php echo $nom; ?>",
                        query: "notifItem",

                    },


                    type: "GET",
                    success: function(data) {
                        $("#items").empty().append(data);



                        $(".button").click(function(event) {



                            if (!confirm('Vous êtes sur de supprimer cette notification ?')) {
                                event.preventDefault();
                            }

                        });
                        $(".conf").unbind('click').click(function(event) {
                            if (!confirm('Vous êtes sur de confirmer ce choix ?'))
                                event.preventDefault();
                        });







                    }

                })
            }

        })(jQuery);
    </script>


    <script>
        jQuery(function($) {

            $("#vider").click(function() {
                if (confirm('Vous êtes sur de vider la liste de notifications?')) {

                    $.ajax({
                        url: "<?php echo url('ViderNotif'); ?>",
                        data: {
                            query: "vider",
                            nom: "<?php echo $nom; ?>",
                            type: "<?php echo $type; ?>",
                            tp: "<?php echo $tp; ?>"



                        },
                        type: "GET",
                        success: function(response) {




                        }

                    })
                }
            });





        });
    </script>
    <script>
        function trop() {
            var x = document.getElementById("homeSubmenu");
            if (x.style.display == "block")

            {
                x.style.display = "none"
            } else {
                x.style.display = "block"
                document.getElementById("pageSubmenu").style.display = "none";



            }

        }

        function percu() {
            var x = document.getElementById("pageSubmenu");
            if (x.style.display == "block")

            {

                x.style.display = "none"
            } else {
                x.style.display = "block"
                document.getElementById("homeSubmenu").style.display = "none";


            }

        }
    </script>
    <nav class="menu">
        <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open" />
        <label class="menu-open-button" for="menu-open">
            <i class="fa fa-comment" style="position:absolute;left:21%;top:21%;color:#366532;font-size:19px"></i>
        </label>


        <a href="#/" onclick="openForm()" class="menu-item orange"> <i class="fa fa-plus"
                style="position:absolute;left:27%;top:21%;color:#fff;font-size:19px"></i> </a>
        <a href="Inbox?messages" class="menu-item lightblue"> <i class="fa fa-inbox"
                style="position:absolute;left:21%;top:21%;color:#fff;font-size:19px"></i> </a>
    </nav>


    <div id="hideMe">
        <?php if (isset($_GET['EditSuccess'])) { ?>
        <div class="alert" style="background-color:#12a820;">
            <h5 style="color:white;">Compte Modifié avec Succés ! </h5>

        </div>


        <?php } elseif (isset($_GET['Supprimer'])) { ?>
        <div class="alert" style="background-color:#12a820;">
            <h5 style="color:white;">Compte Supprimé avec Succés ! </h5>

        </div>
        <?php } elseif (isset($_GET['NonSupprimer'])) { ?>
        <div class="alert" style="background-color:#ed2345;">
            <h5 style="color:white;">Une erreur est survenue ! </h5>

        </div>
        <?php } ?>
        <?php if (isset($_GET['MessageEnvoye'])) { ?>
        <div class="alert success">
            <h5 style="color:white;">Message envoyé avec succés <i class="fa fa-check"></i> </h5>

        </div>
        <?php } elseif (isset($_GET['MessageNonEnvoyé'])) { ?>
        <div class="alert error">
            <h5 style="color:white;">Message non envoyé <i class="fa fa-close"></i> </h5>

        </div> <?php } ?>

        <?php if (isset($_GET['TacheAjoute'])) { ?>
        <div class="alert success">
            <h5 style="color:white;">Tâche ajoutée avec succés <i class="fa fa-check"></i> </h5>

        </div>
        <?php } elseif (isset($_GET['MessageNonEnvoyé'])) { ?>
        <div class="alert error">
            <h5 style="color:white;">Tâche non ajoutée <i class="fa fa-close"></i></h5>

        </div> <?php } elseif (isset($_GET['id_existant'])) { ?>
        <div class="alert error">
            <h5 style="color:white;">Compte déja existant ! </h5>

        </div>
        <?php } ?>


        <?php if (isset($_GET['DossierInexistant'])) { ?>
        <div class="alert error">
            <h5 style="color:white;">Dossier n'est pas existant <i class="fa fa-close"></i> </h5>

        </div>


        <?php } elseif (isset($_GET['SuccessEdit'])) { ?>
        <div class="alert success">
            <h5 style="color:white;">Dossier Modifié avec succées <i class="fa fa-check"></i> </h5>

        </div>

        <?php } elseif (isset($_GET['ErrorEdit1'])) {
        echo '<div class="alert error">
            <h5 style="color:white;">Erreur modification Dossier <i class="fa fa-close"></i> </h5>

        </div>';
        } elseif (isset($_GET['ErrorEdit2'])) {
        echo '<div class="alert error">
            <h5 style="color:white;">Erreur modification Paiement <i class="fa fa-close"></i> </h5>

        </div>';
        } elseif (isset($_GET['RecuExiste'])) {
        echo '<div class="alert error">
            <h5 style="color:white;">Le numero du reçu existe <i class="fa fa-close"></i> </h5>

        </div>';
        } ?>


        <?php if (isset($_GET['DossierAjouter'])) { ?>
        <div class="alert success">
            <h5 style="color:white;">Dossier Ajouté avec succés <i class="fa fa-check"></i> </h5>

        </div>

        <?php } elseif (isset($_GET['invalidMatricule'])) {
        echo '<div class="alert error">
            <h5 style="color:white;">La matricule est invalide ou déja utilisée <i class="fa fa-close"></i> </h5>

        </div>';
        } elseif (isset($_GET['invalidCIN'])) {
        echo '<div class="alert error">
            <h5 style="color:white;">Le numéro de cin est invalide ou déja utilisé <i class="fa fa-close"></i> </h5>

        </div>';
        } elseif (isset($_GET['DossierExiste'])) {
        echo '<div class="alert error">
            <h5 style="color:white;">Le dossier est existant <i class="fa fa-close"></i> </h5>

        </div>';
        } elseif (isset($_GET['InvalidCin'])) {
        echo '<div class="alert error">
            <h5 style="color:white;">numero de cin non valide <i class="fa fa-close"></i> </h5>

        </div>';
        } elseif (isset($_GET['InvalidMat'])) {
        echo '<div class="alert error">
            <h5 style="color:white;">matricule non valide <i class="fa fa-close"></i> </h5>

        </div>';
        } elseif (isset($_GET['DemandeEnvoyé'])) {
        echo '<div class="alert success">
            <h5 style="color:white;">Demande Envoyé <i class="fa fa-check"></i> </h5>

        </div>';
        } ?>

        <!-- CONTROLE -->
        <?php if (isset($_GET['BienControle'])) { ?>
        <div class="alert success">
            <h5 style="color:white;">Dossier contrôlé avec succés <i class="fa fa-check"></i> </h5>

        </div>

        <?php } elseif (isset($_GET['ErreurControle'])) {
        echo '<div class="alert error">
            <h5 style="color:white;">Erreur de contrôle <i class="fa fa-close"></i> </h5>

        </div>';
        } elseif (isset($_GET['Succes_Ajout'])) {
        echo '<div class="alert success">
            <h5 style="color:white;">Compte ajouté avec succées <i class="fa fa-check"></i> </h5>

        </div>';
        } elseif (isset($_GET['SuccessRec'])) {
        echo '<div class="alert success">
            <h5 style="color:white;">Reçu bien ajouté <i class="fa fa-check"></i> </h5>

        </div>';
        } ?>

    </div>

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="p-4 pt-5" style="position:fixed;width:300px;">
                <a href="#" class="img logo rounded-circle mb-5"
                    style="background-image: url(CSS/Image/logo.png); background-size:100%;background-position:50% 50%">
                </a>
                <ul class="list-unstyled components mb-5">
                    <li id="accueil" <?php if ($current == 'accueil') {
                        echo "class='active'";
                    }
                    ?>>

                        <a href="<?php echo url('Accueil'); ?>"> <i class="fa fa-home"> </i>
                            Accueil</a>
                    </li>
                    <?php
                    if ($type == 'LIQUIDER' && $tp == 'OUI') {
                    $req = "SELECT * from notification where Recepteur like 'LIQUIDERTP' or Recepteur like '$nom' ORDER
                    BY id DESC";
                    } elseif ($type == 'LIQUIDER' && $tp == 'NON') {
                    $req = "SELECT * from notification where Recepteur like 'LIQUIDER' or Recepteur like '$nom' ORDER BY
                    id DESC";
                    } elseif ($type == 'CONTROLER' && $tp == 'NON') {
                    $req = "SELECT * from notification where Recepteur like 'CONTROLER' or Recepteur like '$nom' ORDER
                    BY id DESC";
                    } elseif ($type == 'CONTROLER' && $tp == 'OUI') {
                    $req = "SELECT * from notification where Recepteur like 'CONTROLERTP' or Recepteur like '$nom' ORDER
                    BY id DESC";
                    } elseif ($type == 'CHEF CENTRE') {
                    $req = "SELECT * from notification where Recepteur like 'CHEF CENTRE' ORDER BY id DESC";
                    } else {
                    $req = '';
                    }
                    if ($type != 'CONSULTER') {
                    $notification = mysqli_num_rows(mysqli_query($connect, $req));

                    if ($notification != 0) { ?>
                    <li <?php if ($current == 'notification') {
                        echo "class='active'";
                    }
                    ?>>

                        <a href="<?php echo url('Notifications'); ?>"><i class="fa fa-bell">
                            </i> Liste des notifications </a>
                    </li>
                    <?php }
                    }
                    ?>




                    <?php if ($current != 'tache' && $current != 'inbox') { ?>
                    <li <?php if ($current != 'accueil') {
                        echo "class='active'";
                    } ?>>

                        <ul class=" list-unstyled" id="homeSubmenu" <?php if ($current != 'accueil' && $current != 'tache' && $current != 'notification' && $current != 'inbox') {
                            echo "style='display : block'";
                        } else {
                            echo "style='display : none'";
                        } ?>>
                            <?php if (isset($type)) {
                    if ($type == 'LIQUIDER' || ($type == 'CONSULTER' && $tp == 'OUI')) {
                    if ($type == 'LIQUIDER' && $tp == 'OUI') { ?>

                            <li <?php if ($current == 'ajouterDossier') {
                                echo "class='active'";
                            } ?>>
                                <a href="AjouterDossier"><i class="fa fa-plus"></i> Nouveau dossier</a>
                            </li>

                            <?php } ?>


                            <li <?php if ($current == 'ListeDossier') {
                                echo "class='active'";
                            } ?>>


                                <a href="ListeDossier" class="btn2"><i class="fa fa-folder"> </i> Liste des
                                    dossiers</a>
                            </li>


                            <?php
                    } elseif ($type == 'CONTROLER') { ?>
                            <li <?php if ($current == 'Controle') {
                                echo "class='active'";
                            } ?>>
                                <a href="Controle" class="btn2"><i class="fa fa-search"></i> Controle des dossiers
                                </a>
                            </li>




                            <?php }
                    } ?>

                            <?php } ?>

                            <li <?php if ($current == 'tache') {
                                echo "style='display : block'";
                            } else {
                                echo "style='display : none'";
                            } ?>>

                                <ul class="list-unstyled" id="pageSubmenu">
                                    <?php if ($type == 'CHEF CENTRE') { ?>
                                    <script>
                                        $(document).ready(function() {
                                            setInterval(function() {
                                                ACTIVE_Tache()

                                            }, 10000)

                                            function ACTIVE_Tache() {
                                                var hash = window.location.hash;

                                                if (hash == "#liste") {
                                                    $('#li').addClass('active');

                                                } else {
                                                    $('#li').removeClass('active');

                                                }

                                                if (hash == "#pass%C3%A9e") {
                                                    $('#pass1').addClass('active');

                                                } else {
                                                    $('#pass1').removeClass('active');

                                                }

                                                if (hash == "#taches") {
                                                    $('#tache').addClass('active');

                                                } else {
                                                    $('#tache').removeClass('active');

                                                }

                                                if (hash == "#dossier") {
                                                    $('#Dossiers').addClass('active');

                                                } else {
                                                    $('#Dossiers').removeClass('active');

                                                }

                                                if (hash == "#progres") {
                                                    $('#prog').addClass('active');

                                                } else {
                                                    $('#prog').removeClass('active');

                                                }
                                                if (hash == "#calendar") {
                                                    $('#cal').addClass('active');


                                                } else {
                                                    $('#cal').removeClass('active');

                                                }



                                            }
                                        });
                                    </script>
                                    <li id="cal">
                                        <a href="#calendar"><i class="fa fa-calendar"></i> Calendrier</a>
                                    </li>
                                    <li id="tache">
                                        <a href="#taches"><i class="fa fa-tasks"></i> Liste des tâches</a>
                                    </li>
                                    <li id="li">
                                        <a href="#liste" onclick="Active(this)"> <i class="fa fa-list-alt"></i>
                                            Tâches affectés</a>
                                    </li>
                                    <li id="pass1">
                                        <a href="#passée"> <i class="fa fa-share-square"></i> Tâches passées</a>
                                    </li>

                                    <li id="Dossiers">
                                        <a href="#dossier"><i class="fa fa-folder"></i> Les Dossiers</a>
                                    </li>
                                    <li id="prog">
                                        <a href="#progres"> <i class="fa fa-spinner"></i> Progrés des tâches</a>
                                    </li>



                                    <?php } elseif ($type == 'LIQUIDER' || $type == 'CONTROLER') { ?>
                                    <li>
                                        <a href="#enattente"><i class="fa fa-pause"></i> &nbsp;&nbsp;Tâches en
                                            attente</a>
                                    </li>
                                    <li>
                                        <a href="#encours"><i class="fa fa-hourglass-start"></i> &nbsp;&nbsp;Tâches en
                                            cours</a>
                                    </li>
                                    <li>
                                        <a href="#complete"><i class="fa fa-check"></i> &nbsp;&nbsp;Tâches
                                            complètes</a>
                                    </li>
                                    <li>
                                        <a href="#rejete"><i class="fa fa-ban"></i> &nbsp;&nbsp;Tâches rejetés</a>
                                    </li>

                                    <?php } ?>
                                </ul>
                            </li>
                        </ul>
                    </li>


                    <?php if ($type == 'CHEF CENTRE') { ?>
                    <?php if ($current == 'StatTP') { ?>
                    <li>
                        <style>

                        </style>
                        <script>
                            $(document).ready(function() {
                                setInterval(function() {
                                    ACTIVE_TP()

                                }, 10000)

                                function ACTIVE_TP() { // fonction pour mettre la active dans le menu (sidebar)
                                    var hash = window.location.hash;

                                    if (hash == "#ajoute") {
                                        $('#add1').addClass('active');


                                    } else {
                                        $('#add1').removeClass('active');

                                    }


                                    if (hash == "#controle") {
                                        $('#contr').addClass('active');


                                    } else {
                                        $('#contr').removeClass('active');

                                    }

                                    if (hash == "#nonPaye") {
                                        $('#nonP').addClass('active');


                                    } else {
                                        $('#nonP').removeClass('active');

                                    }

                                    if (hash == "#cloture") {
                                        $('#clot').addClass('active');


                                    } else {
                                        $('#clot').removeClass('active');

                                    }




                                }
                            });
                        </script>

                        <ul class="list-unstyled" id="pageSubmenu">
                            <li class="h" id="add1">
                                <a href="#ajoute" c> <i class="fa fa-plus"></i> Dossiers Ajoutés</a>
                            </li>
                            <li id="contr">
                                <a href="#controle"><i class="fa fa-search"></i> Dossiers Contrôlés</a>
                            </li>
                            <li id="nonP">
                                <a href="#nonPaye"> <i class="fa fa-ban"></i> Dossiers non payés</a>
                            </li>

                            <li id="clot">
                                <a href="#cloture"><i class="fa fa-check"> </i> Dossiers Clotûrés</a>
                            </li>
                        </ul>
                    </li>

                    <?php } ?>
                    <?php } ?>


                </ul>

                <div class="footer">
                    <p>
                        <script>
                            document.write(new Date().getFullYear());
                        </script> Tout Les droits reservés|<br> <a target="_blank"
                            href="https://www.facebook.com/amenyelokb"> El okb Ameny</a> & <a target="_blank"
                            href="https://www.facebook.com/welid.wg"> Gueddari welid</a>
                    </p>
                </div>

            </div>
        </nav>

        <!-- Page Content  -->
        <p id="top"></p>
        <style>
            .toggle {
                position: absolute;
                top: 0;
                right: 30;
                font-size: 10px
            }

            .switch1 {
                position: relative;
                display: inline-block;
                width: 40px;
                height: 14px;
            }

            .switch1 input {
                opacity: 0;
                width: 0;
                height: 0;

            }

            .slider1 {
                padding: 5px;

                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                -webkit-transition: .4s;
                transition: .4s;
            }

            .slider1:before {
                position: absolute;
                content: "";
                height: 9px;
                width: 9px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                -webkit-transition: .4s;
                transition: .4s;
            }

            input:checked+.slider1 {
                background-color: #2196F3;
            }

            input:focus+.slider1 {
                box-shadow: 0 0 1px #2196F3;
            }

            input:checked+.slider1:before {
                -webkit-transform: translateX(26px);
                -ms-transform: translateX(26px);
                transform: translateX(26px);
            }

            .slider1.round {
                border-radius: 34px;
            }

            .slider1.round:before {
                border-radius: 50%;
            }
        </style>



        <div id="content" class="p-4 p-md-5">



            <div style="text-align:left;margin-bottom:0px; margin-top:-20px" class="head">


                <?php if ($tp == 'OUI' || $type == 'CHEF CENTRE') { ?>
                <a class="home<?php if ($current != 'accueil' && $current != 'tache' && $current != 'notification' && $current != 'inbox' && $current != 'ListeDesComptes') {
                    echo 'active';
                } ?>" href="<?php if ($type == 'LIQUIDER' || ($type == 'CONTROLER' && $tp == 'OUI')) {
                    echo url('StatUser');
                } elseif ($type == 'CHEF CENTRE') {
                    echo url('Stats');
                } else {
                    echo '#homeSubmenu';
                } ?>" onclick="trop()"
                    style="background-color:rgba(0,0,0,0.2);padding:5px;border-radius: 8px;box-shadow:0px 2px 20px 0px rgba(0,0,0,0.41);"><i
                        class='fa fa-dollar-sign'></i>&nbsp;Trop Perçu </a> <?php } ?>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?php if ($type != 'CONSULTER') { ?>
                <a class="home<?php if ($current == 'tache') {
                    echo 'active';
                } ?>" href="<?php echo url('Tache'); ?>" onclick="percu()"
                    style="background-color:rgba(0,0,0,0.2);padding:5px;border-radius: 8px;box-shadow:0px 2px 20px 0px  rgba(0,0,0,0.41)"><?php if ($type == 'CHEF CENTRE') {
                        echo "<i class='fa fa-tasks'></i>&nbsp;Gestion des taches ";
                    } else {
                        $id = Session::get('id1');
                        $num = mysqli_num_rows(
                            mysqli_query(
                                $connect,
                                "SELECT * FROM historique WHERE etat like 'en attente'
                                        and utilisateur like $id",
                            ),
                        );
                    
                        if ($num == 0) {
                            echo "<i class='fa fa-tasks'></i>&nbsp;Gestion des taches ";
                        } else {
                            echo "<i class='fa fa-tasks'></i>&nbsp;Gestion des taches (" . $num . ')';
                        }
                    } ?></a>
                <?php } ?>


                <div id="nom1"
                    style="float:right;font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;"
                    class="date">

                    <a style="pointer-events: none;color:black" href=""><strong><i
                                class="fa fa-calendar-alt"></i> <?php echo date('Y-m-d'); ?></strong> </a>


                    <?php if ($type == 'LIQUIDER') {
                        $nom1 = Session::get('nom') . ' : Liquidateur';
                    } elseif ($type == 'CONTROLER') {
                        $nom1 = Session::get('nom') . ' : Contrôleur';
                    } elseif ($type == 'CONSULTER') {
                        $nom1 = 'Consulteur';
                    } elseif ($type == 'CHEF CENTRE') {
                        $nom1 = Session::get('nom') . ' : ' . $type;
                    } ?>

                    <a style="pointer-events: none;font-weight:0" href="" style="pointer-events: none;"> |</a>


                    <a style="pointer-events: none;color:#366532" href=""><i class="fa fa-user-circle"></i>
                        <strong><?php echo $nom1; ?></strong> </a>

                </div>
            </div>

            <br>
            <nav class="navbar navbar-expand-lg navbar-light " id="navbar"
                style="border-radius: 30px;position: sticky;z-index:55;top:0;">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fa fa-bars"></i>
                        <span class="sr-only">Toggle Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>



                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        &nbsp;&nbsp;
                        <li class="det" id="nom2"
                            style="display:none;color:black;font-weight: 700;background-color: white;border-radius: 30px;padding:5px">
                            <a style="pointer-events: none;color:black" href=""><strong><i
                                        class="fa fa-calendar-alt"></i> <?php echo date('Y-m-d') . ' |'; ?></strong> </a>

                            <?php if ($type == 'LIQUIDER') {
                                $nom1 = Session::get('nom') . ' : Liquidateur';
                            } elseif ($type == 'CONTROLER') {
                                $nom1 = Session::get('nom') . ' : Contrôleur';
                            } elseif ($type == 'CONSULTER') {
                                $nom1 = 'Consulteur';
                            } elseif ($type == 'CHEF CENTRE') {
                                $nom1 = Session::get('nom') . ' : ' . $type;
                            }
                            echo '<i class="fa fa-user-circle"></i> ' . $nom1; ?>
                        </li>

                        <ul class="nav navbar-nav ml-auto">



                            <?php if (($current == 'consulterCarte' && $type == 'LIQUIDER' &&
                            isset($_POST['submit'])) || isset($_GET['mat']) || isset($_GET['immat'])) { ?>
                            <?php if ($type == 'LIQUIDER') { ?>
                            <li class="nav-item">

                                <a class="nav-link" id="modif" href="#"><i class="fa fa-edit"></i>
                                    Modifier Dossier</a>

                            </li>
                            <li class="nav-item">

                                <a style="pointer-events: none;" class="nav-link" href="#"
                                    style="pointer-events: none;"> |</a>

                            </li>
                            <li class="nav-item">

                                <a class="nav-link" id="etat" target="_blank" href="#"><i
                                        class="fa fa-print"></i>
                                    Etat</a>

                            </li>
                            <li class="nav-item">

                                <a class="nav-link" href="#" style="pointer-events: none;"> |</a>

                            </li>
                            <li class="nav-item">

                                <a class="nav-link" id="carte" href="#" id="carte" target="_blank"><i
                                        class="fa fa-print"></i> Carte de suivi</a>

                            </li>
                            <li class="nav-item">

                                <a style="pointer-events: none;" class="nav-link" href=""
                                    style="pointer-events: none;">
                                    |</a>

                            </li>

                            <?php }} ?>
                            <?php if ($current == 'consulterDetail' && $type == 'CONTROLER') { ?>
                            <li class="nav-item">

                                <a class="nav-link" style="color:green" id="accepter" href=""
                                    onclick="return confirm('Vous êtes sur de contrôler sans erreurs ce dossier?'); "><i
                                        class="fa fa-check"></i> Contrôlé sans erreurs</a>

                            </li>
                            <li class="nav-item">

                                <a style="pointer-events: none;" class="nav-link" href=""
                                    style="pointer-events: none;">
                                    |</a>

                            </li>
                            <li class="nav-item">

                                <a class="nav-link" id="refuser" style="color:darkred" href=""
                                    onclick="return confirm('Vous êtes sur de contrôler avec erreurs ce dossier?'); "><i
                                        class="fa fa-times"></i> Contrôlé avec erreurs</a>

                            </li>
                            <li class="nav-item">

                                <a style="pointer-events: none;" class="nav-link" href=""
                                    style="pointer-events: none;">
                                    |</a>

                            </li>
                            <?php } ?>



                            <?php if ($type != 'CONSULTER') { ?>

                            <li class="nav-item">



                                <div class="notification dropdownn">


                                    <a onclick='notif()' href="#/" class="nav-link notification">
                                        <i class="fa fa-bell"></i>
                                        <span class="badge1" id="number">
                                        </span>
                                    </a>






                                    <div class="notification dropdownn-content" style="border-radius: 20px;zoom:1"
                                        id="notif">

                                        <form>
                                            <h5 style="float:left;font-size:18px;">Notifications</h5>
                                            <form id="formVider" method="GET" action="ViderNotif">
                                                <button id="vider" type="submit"
                                                    style="float:right;font-size:18px;color:red">
                                                    <i class="fa fa-trash"></i></button>
                                            </form>
                                            <br>

                                            <hr>










                                            <div id="items"
                                                style="height:auto;max-height: 300px;overflow: auto;zoom:1">
                                            </div>



                                        </form>






                                    </div>
                            </li>



                            <li class="nav-item">

                                <a style="pointer-events: none;" class="nav-link" href=""
                                    style="pointer-events: none;">
                                    |</a>

                            </li>
                            <?php } ?>
                            <li class="nav-item">


                                <div class="notification dropdownn">



                                    <?php if ($type != 'CONSULTER') { ?>

                                    <a onclick='msg()' href="#/" class=" nav-link notification">
                                        <i class="fa fa-comments"></i>
                                        <script>
                                            jQuery(function($) {


                                                setInterval(function() {
                                                    NUMBER_M()
                                                }, 10000);




                                                function NUMBER_M() {

                                                    $.ajax({
                                                        url: "<?php echo url('Messages'); ?>",
                                                        data: {
                                                            nom: "<?php echo $nom; ?>",
                                                            query: "message"

                                                        },
                                                        type: "GET",
                                                        success: function(data) {
                                                            $(".dell").unbind('click').click(function(event) {
                                                                if (!confirm('Vous êtes sur de supprimer ce message ?'))
                                                                    event.preventDefault();
                                                            });

                                                            document.getElementById("message").innerHTML = data;
                                                            document.getElementById("msgg").innerHTML =
                                                                " <i class='fa fa-envelope-open'></i>   " + data + " Messages";

                                                        }

                                                    })
                                                }
                                                setInterval(function() {
                                                    ITEM2()
                                                }, 10000);

                                                function ITEM2() {

                                                    $.ajax({
                                                        url: "<?php echo url('Messages'); ?>",
                                                        data: {

                                                            nom: "<?php echo $nom; ?>",
                                                            query: "messages",
                                                            current: "<?php echo $current; ?>",

                                                        },


                                                        type: "GET",
                                                        success: function(data) {
                                                            $("#messages").empty().append(data);

                                                            $(".button").unbind('click').click(function(event) {
                                                                if (!confirm('Vous êtes sur de supprimer cette notification ?'))
                                                                    event.preventDefault();
                                                            });







                                                        }

                                                    })
                                                }


                                            })(jQuery);
                                        </script>
                                        <span class="badge1" id="message"> </span>
                                    </a>


                                    <div class="notification dropdownn-content" style="border-radius: 20px;"
                                        id="msg">


                                        <h5 style="float:left;font-size:18px" id="msgg"> </h5>
                                        <br>
                                        <hr>
                                        <div id="messages" style="height: auto;max-height: 300px;overflow: auto;">
                                        </div>







                                    </div>

                                </div>

                            </li>
                            <?php } ?>
                            <li class="nav-item">

                                <a style="pointer-events: none;" class="nav-link" href="#"
                                    style="pointer-events: none;"> |</a>

                            </li>
                            <?php if ($type == 'CHEF CENTRE') { ?>


                            <li class="nav-item active">


                                <div class="dropdown">
                                    <a class="nav-link notification" href="#" style="font-weight:700;"><i
                                            class="fa fa-users-cog"></i> </a>
                                    <div class="dropdown-content">
                                        <a class="nav-link" id="myBtn" href="#"><i
                                                class="fa fa-user-plus"></i> Ajouter
                                            Un Compte</a>
                                        <a class="nav-link" href="<?php echo url('Accounts'); ?>"><i class="fa fa-users"></i>
                                            Liste des Comptes</a>

                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">

                                <a style="pointer-events: none;" class="nav-link" href=""
                                    style="pointer-events: none;">
                                    |</a>

                            </li>

                            <?php } ?>
                            <li class="nav-item">
                                <?php ?>
                                <a class="nav-link notification" href="Logout?log=<?php echo Session::get('id1'); ?>"
                                    style="color:red;font-weight:bold;"><i class="fa fa-sign-out-alt"></i></a>
                            </li>



                        </ul>
                    </div>
                </div>

            </nav>

            <div id="myModal" class="modal">

                <!-- Modal content -->
                <div class="modal-content1">
                    <span class="close">&times;</span>
                    <div class="user">
                        <header class="user__header">
                            <h1 class="user__title">Ajouter un compte</h1>
                        </header>
                        <hr>

                        <form class="form" method="POST" action="AddAccount">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form__group">
                                <input type="number" name="identifiant" oninput="maxLengthCheck(this)"
                                    placeholder="identifiant" class="form__input" required />
                            </div>

                            <div class="form__group">
                                <input type="text" pattern="[a-z A-Z]*" title="utilisez que les lettres"
                                    name="nom" placeholder="Nom et prenom" class="form__input" required />
                            </div>

                            <div class="form__group">
                                <input id="emailAjout" type="email" name="email" placeholder="Email(optionel)"
                                    minlength="6" title="l'email est obligatoire pour le chef centre"
                                    class="form__input" />
                            </div>
                            <div class="form__group">
                                <select onchange="requireEmail()" name="type" id="typeAjout" class="form__input"
                                    required>
                                    <option value="">Choisissez le type</option>
                                    <option value="CHEF CENTRE">Chef Centre</option>
                                    <option value="LIQUIDER">Liquidateur</option>
                                    <option value="CONTROLER">Contrôleur</option>
                                    <option value="CONSULTER">Consulteur</option>
                                </select>
                            </div>
                            <script>
                                function requireEmail() {
                                    var type = document.getElementById("typeAjout").value;
                                    var email = document.getElementById("emailAjout");
                                    if (type == "CHEF CENTRE") {
                                        email.required = "true";


                                    } else {
                                        email.required = "";

                                    }
                                }
                            </script>

                            <div class="form__group">
                                <input type="password" name="mdp" placeholder="Mot de passe" minlength="5"
                                    class="form__input" required />
                            </div>
                            <div class="form__group">
                                <input type="password" name="confirm" placeholder="Confirmer le mot de passe"
                                    minlength="5" class="form__input" required />
                            </div>
                            <div class="form__group" style="padding:10px;background-color: white;">
                                <hr>

                                <label style="float:left;font-weight:700">Trop Perçu &nbsp;&nbsp;&nbsp; </label>
                                <label class="switch">
                                    <input type="checkbox" name="TP" class="" value="OUI">
                                    <span class="slider round"></span>
                                </label>
                                <hr>
                            </div>

                            <button class="btn10" name="ajouter" type="submit">Ajouter</button>
                        </form>
                    </div>

                </div>
            </div>







            <?php if ($current == 'accueil') { ?>






            <?php } ?>







            <script src="js/jquery.min.js"></script>
            <script src="js/popper.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/main.js"></script>


            <script type="text/javascript">
                document.getElementById("logout").onclick = function() {
                    location.href = "Logout";
                };
            </script>

            <script>
                history.pushState(null, null, location.href);
                window.onpopstate = function() {
                    history.go(1);
                };
            </script>
            <style>
                .button {
                    border: none;
                    color: white;
                    padding: 5px 5px;
                    font-size: 15px;
                    cursor: pointer;
                    color: red
                }

                .button1 {
                    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                }

                .chat-popup {
                    display: none;
                    position: fixed;
                    bottom: 0;
                    right: 60px;
                    border: 1px solid whitesmoke;
                    border-radius: 10px;
                    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;

                    z-index: 9999999999999999999;
                    animation: fadein 0.5s;
                    box-shadow: 0px 1px 16px 2px rgba(0, 0, 0, 0.3);



                }

                .form-container {
                    max-width: 350px;
                    max-height: 600px;
                    overflow-y: auto;
                    padding: 10px;
                    background-color: white;
                    border-radius: 10px;


                }

                .form-container textarea {
                    width: 100%;
                    padding: 15px;
                    margin: 5px 0 22px 0;
                    border: none;
                    background: #f1f1f1;
                    resize: none;
                    min-height: 120px;
                    border-radius: 10px;
                }



                .form-container .btn {
                    background-color: #05324f;
                    color: white;
                    padding: 12px 15px;
                    border: none;
                    cursor: pointer;
                    width: 100%;
                    opacity: 0.8;
                    margin: 0px auto;
                }


                .form-container .cancel {
                    background-color: red;
                }

                .form-container .btn:hover,
                .open-button:hover {
                    opacity: 1;
                }

                .titlee {
                    color: #2f4f4f;

                    font-weight: normal;
                    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
                    font-size: 36px;
                    line-height: 42px;
                    text-transform: uppercase;
                    text-shadow: 0 3px white, 0 3px #777;
                    text-align: center;

                }
            </style>
            <div class="chat-popup" id="myForm" style="@if (isset($_GET['nom'])) display:block @endif">
                <form method="POST" action='MessageSend' class="form-container" enctype="multipart/form-data">
                    <button type="button" class="" style="float:right" onclick="closeForm()"><i
                            class="fa fa-times"></i></button>

                    <h1 style="font-size:20px" class="titlee">Envoyer Un message</h1>
                    <div style="background-color: rgba(0, 0, 0, 0.12);padding:5px;border-radius: 10px;">
                        <label for="cc" class="">à:</label>
                        <select type="text" class="form-control" name="recepteur" required>
                            <?php if (!isset($_GET['nom'])) {
                            $nomm = $nom;
                            $array = runQuery("SELECT * from utilisateurs where type !='CONSULTER' and Nom!='$nomm'
                            order by Nom asc");
                            if (!empty($array)) {
                            foreach ($array as $key => $value) { ?> <option> <?php echo $array[$key]['Nom']; ?></option> <?php } ?>
                            <option value=""><i class=' fas fa-circle' style='color:red'></i></option>
                            <?php
                            }
                            } else {
                            ?><option><?php echo $_GET['nom']; ?>
                            </option>
                            <?php
                            } ?>
                        </select>


                        <label for="bcc" class="">Sujet:</label>
                        <input type="text" minlength="5" maxlength="50" class="form-control" name="sujet"
                            placeholder="sujet" required>


                        <label for="msg"><b>Message:</b></label>
                        <textarea minlength="5" placeholder="Saisir le message.." name="message" required></textarea>
                        <style>
                            .file-input {
                                display: inline-block;
                                text-align: left;
                                padding: 16px;
                                width: 100%;
                                position: relative;
                                border-radius: 3px;
                            }

                            .file-input>[type='file'] {
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 50%;
                                height: 50%;
                                opacity: 0;
                                z-index: 10;
                                cursor: pointer;
                            }

                            .file-input>.button2 {
                                display: inline-block;
                                cursor: pointer;
                                background: #fff;
                                padding: 4px 10px;
                                border-radius: 2px;
                                font-size: 13px;
                                color: black
                            }

                            .file-input:hover>.button2 {
                                background: dodgerblue;
                                color: white;
                            }

                            .file-input>.label {
                                color: #333;
                                white-space: nowrap;
                                opacity: .3;
                            }

                            .file-input.-chosen>.label {
                                opacity: 1;
                            }
                        </style>


                        <label for=""><i class="fa fa-file-alt"></i> fichier</label>
                        <div class='file-input'>
                            <input type="file" name="FILE_UP" id="fichier">
                            <span class='button2'>Choisissez un fichier</span>
                            <span class='label' data-js-label>Aucun fichier</label>
                        </div>
                    </div>
                    <script>
                        var inputs = document.querySelectorAll('.file-input')

                        for (var i = 0, len = inputs.length; i < len; i++) {
                            customInput(inputs[i])
                        }

                        function customInput(el) {
                            const fileInput = el.querySelector('[type="file"]')
                            const label = el.querySelector('[data-js-label]')

                            fileInput.onchange =
                                fileInput.onmouseout = function() {
                                    if (!fileInput.value) return

                                    var value = fileInput.value.replace(/^.*[\\\/]/, '')
                                    el.className += ' -chosen'
                                    label.innerText = value
                                }
                        }
                    </script>
                    {{ csrf_field() }}

                    <button type="submit" name="envoyer" class="btn">Envoyer <i
                            class="fa fa-paper-plane"></i></button>
                </form>
            </div>
            <script></script>




</body>
<style>
    #Envoyer {
        display: block;
        position: fixed;
        bottom: 70px;
        right: 20px;
        z-index: 999999999999999999999;
        font-size: 24px;
        color: #366532;
        outline: none;
        width: 40px;
        cursor: pointer;
        padding: 10px;

    }

    .icon-bar {
        position: fixed;
        top: 50%;
        right: 0px;
        z-index: 99999988;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .icon-bar a {
        display: block;
        text-align: center;
        padding: 16px;
        transition: all 0.3s ease;
        color: white;
        font-size: 15px;
    }

    .icon-bar a:hover {
        background-color: #000;
    }

    .chat {
        background: #3B5998;
        color: white;
    }
</style>
<button onclick="topFunction()" id="UP" title="allez en haut "><i class="fa fa-angle-up"></i></button>


<script>
    if (isset($_GET["nom"])) {
        document.getElementById("myForm").style.display = "block";

    }

    function openForm() {
        document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
        document.getElemen
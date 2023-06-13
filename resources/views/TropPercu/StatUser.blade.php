<?php
$current = "StatUser";
$type=Session::get("type");
$tp=Session::get("tp");
 $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
if ($type == ('CONTROLER')  || $type== ('LIQUIDER') && $tp == "OUI") {
?>



    <html lang="en">

    <head>
        @include("GestionDeParametre.nav")

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ProTask | Statistiques</title>
        <style>
            html {
                zoom: 1
            }

            .page-todo .tasks {
                background: #fff;
                padding: 0;
                border-right: 1px solid #d1d4d7;
                width: 50%;


            }

            .page-todo .task-list {
                padding: 30px 15px;
                height: auto;

            }



            .page-todo .priority.high {
                background: #e6b3b3;
                margin-bottom: 1px;


            }

            .page-todo .priority.high span {
                background: #f86c6b;
                padding: 2px 10px;
                color: #fff;
                display: inline-block;
                font-size: 12px
            }

            .page-todo .priority.medium {
                background: #fff0ab;
                margin-bottom: 1px
            }

            .page-todo .priority.medium span {
                background: #f8cb00;
                padding: 2px 10px;
                color: #fff;
                display: inline-block;
                font-size: 12px
            }

            .page-todo .priority.low {
                background: #ffdb95;
                margin-bottom: 1px
            }

            .page-todo .priority.low span {
                background: orangered;
                padding: 2px 10px;
                color: #fff;
                display: inline-block;
                font-size: 12px;

            }

            .page-todo .task {
                border-bottom: 1px solid #e4e5e6;
                margin-bottom: 1px;
                position: relative;


            }

            .page-todo .task .desc {
                display: inline-block;
                width: 100%;
                padding: 10px 10px;
                font-size: 12px;
                font-weight: 300;
            }

            .page-todo .task .desc .title {
                font-size: 15px;
                margin-bottom: 5px;
                width: 70%;
                white-space: nowrap;


            }


            .page-todo .task.last {
                border-bottom: 1px solid transparent;
                white-space: nowrap;

            }

            .page-todo .task.high {
                border-left: 2px solid #f86c6b;
                white-space: nowrap;

            }

            .page-todo .task.medium {
                border-left: 2px solid #f8cb00;
                white-space: nowrap;

            }

            .page-todo .task.low {
                border-left: 2px solid orange;
                white-space: nowrap;


            }
        </style>
    </head>

    <body>
        <?php
        $DC2 = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM notification where titre='Date Correspondance 2 est depassee' "));
        $DC = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM notification where titre='Date Correspondance 1 est dé3passee' "));

        $id5 = Session::get("id1");
        if ($type == "CONTROLER") {
            $number = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where Controle is null "));
            $row = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) from Dossier "));
            $refuse = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where Controle like 'Refuser'"));
            $done = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where Controle like 'Accepter'"));
        } else {
            $number = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where AjoutePar='$id5' "));
            $row = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) from Dossier "));
            $refuse = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where Controle like 'Refuser'"));
            $done = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where Controle like 'Accepter' and Etat like 'Paye'"));
            $nonpaye = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where Etat='Non Paye'"));
            $encours = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM Dossier where Etat='en cours de paiement'"));
        }

        ?>
        <div class="container page-todo bootstrap snippets bootdeys" style="border-radius:30px;">


            <div style="height: auto; width: 47%;float : right;border-radius: 30px;"  id="chartContainer"></div>
        </div>
        <div class="container page-todo bootstrap snippets bootdeys">
            <div class="col-sm-7 tasks" style="border-radius:30px;">
                <div class="task-list" >
                    <h1 style="font-size : 18px"><i class="fa fa-tasks" style="color : green"> </i> A faire</h1>
                    <?php if ($type== "LIQUIDER") {
                        if ($refuse != 0) { ?>
                            <div class="priority low"><span style="width:70%">Dossiers Contrôlés avec erreurs</span></div>
                            <div class="task low">
                                <div class="desc">

                                    <div> <a href="DossiersRefuses"> Vous avez <?php echo $refuse; ?> dossiers contôlés avec erreurs </a></div>
                                </div>
                                <div class="time">
                                </div>
                            </div>
                        <?php }
                        ?>
                        <div class="priority medium"><span style="width:70%">Date correspondance 1 est dépassée</span></div>
                        <div class="task medium">
                            <div class="desc">

                                <div><?php $array = runQuery("SELECT * From Dossier  Where DateCorrespondance2 is NULL ");
                                            if (!empty($array)) {
                                            echo "Les dossiers avec les matricules suivantes <br> ";
                                            
                                                $dateCurrent5 = date("Y-m-d");

                                                foreach ($array as $key => $value) {
                                                    $basic = $array[$key]["DateCorrespondance"];
                                                    $basicPlus = date('Y-m-d', strtotime("+1 months", strtotime($basic)));
                                                    $date = date("Y-m-d", strtotime($basicPlus));
                                                    // Add 1 month to date
                                                    if ($array[$key]["Etat"] != "Paye" || $array[$key]["Etat"] != "en cours de paiement") {
                                                        if ($basic != NULL) {
                                                            if ($dateCurrent5 >= $date) {
                                                                echo "<a href='Consulter?immat=".$array[$key]["Matricule"] ."' >".$array[$key]["Matricule"] . "</a>,";
                                                            } else {
                                                                echo mysqli_error($connect);
                                                            }
                                                        }
                                                    }
                                                }
                                            } echo "ont passée la date de correspondance 1";
                                        ?> 
                                        
                                    </div>
                            </div>
                            <div class="time">


                            </div>
                        </div>
                        <div class="priority high"><span style="width:70%">Date correspondance 2 est dépassée</span></div>
                        <div class="task high">
                            <div class="desc">

                                <div><?php  $sql1 = "SELECT * From Dossier  Where DateCorrespondance2 !=''   ORDER BY id ASC ";
                                            $array1 = runQuery($sql1);
                                            if (!empty($array1)) {
                                                $matricules=array();

                                           

                                                $dateCurrent5 = date("Y-m-d");

                                                foreach ($array1 as $key => $value) {

                                                    $mat = $array1[$key]["Matricule"];

                                                    $basic = $array1[$key]["DateCorrespondance2"];
                                                    $basicPlus = date('Y-m-d', strtotime("+1 months", strtotime($basic)));
                                                    $date = date("Y-m-d", strtotime($basicPlus));


                                                    // Add 1 month to date
                                                    if ($dateCurrent5 > $date) {
                                                        $sql2 = "SELECT * From Paiement Where Matricule like $mat  ORDER BY id ASC";
                                                        $methode = mysqli_fetch_array(mysqli_query($connect, $sql2));

                                                        if ($methode["MethodePaiement"] != 'بطاقة إلزام' && $array1[$key]["Etat"] != "Paye" && $array1[$key]["Etat"] != "en cours de paiement") {
                                                            $matricules=array($array1[$key]["Matricule"]);


                                                        }
                                                    }
                                                }
                                                if(count($matricules)!=0){
                                                 echo "Les dossiers avec les matricules : ";


                                                    foreach($matricules as $mat){
                                                    echo "<a href='Consulter?immat=".$mat."'>". $mat." </a> ,";
                                                   }
                                                echo "<br> Ont passés la date de correspondance 2. ";

                                                }else{
                                                    echo "Aucun Dossier";
                                                }
                                                
                                            }
                                        ?></div>
                            </div>
                            <div class="time">

                            </div>
                        </div>
                    <?php } elseif (($type== "CONTROLER")) { ?>
                        <div class="priority low"><a href="Controle.php"><span>Dossiers à contrôler</span></div></a>
                        <div class="task low">
                            <div class="desc">

                                <div> <?php if ($number == 0) {
                                            echo "Aucun Dossier";
                                        } else { ?><a href="Controle"> Vous avez <?php echo $number ?> dossiers à controler ! </a> <?php } ?></div>
                            </div>
                            <div class="time">
                            </div>
                        </div> <?php } ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <script src="js/canvasjs.min.js"> </script>

        <script type="text/javascript">
            window.onload = function() {

                var chart = new CanvasJS.Chart("chartContainer", {
                    theme: "light1", // "light2", "dark1", "dark2"
                    animationEnabled: true, // change to true	
                    title: {
                        text: "Statistiques"
                    },
                  legend:{
		cursor: "pointer",
		itemclick: explodePie
	},
                    data: [{
                        // Change type to "bar", "area", "spline", "pie",etc.
                        type: "pie",
                        
		
                        dataPoints:

                            [
                                <?php if (($type == "CONTROLER")) { ?>

                                    {
                                        label: "Dossiers à controler", 
                                        y: <?php echo $number ?>
                                    },
                                    {
                                        label: "Dossiers controlés avec erreurs",
                                        y: <?php echo $refuse ?>
                                    },

                                    {
                                        label: "Dossiers contrôlés sans erreurs",
                                        y: <?php echo $done ?>
                                    },
                                <?php } elseif ($type == "LIQUIDER") { ?> {
                                        label: "Dossiers ajoutés",
                                        y: <?php echo $number ?>
                                    },
                                    {
                                        label: "Dossiers contrôlés avec erreurs",
                                        y: <?php echo $refuse ?>
                                    },

                                    {
                                        label: "Dossiers cloturés",
                                        y: <?php echo $done ?>
                                    },
                                    {
                                        label: "Dossiers en cours de paiement",
                                        y: <?php echo $encours ?>
                                    }
                                <?php } ?>

                            ]
                    }]
                });
                chart.render();

            }
            function explodePie (e) {
	if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
		e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
	} else {
		e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
	}
	e.chart.render();

}
        </script>
    </body>
<?php
} else { ?>
    @include("Error");
<?php }
?>

    </html>
<?php
$current = "notification";
$type=Session::get('type');
$tp=Session::get('tp');
$nom=Session::get('nom');
if ($type!= "CONSULTER") {
       if ($type == "LIQUIDER" && $tp == "OUI") {
                            $req = "SELECT * from notification where Recepteur like 'LIQUIDERTP' or Recepteur like '$nom' ORDER BY id DESC";
                        } elseif ($type == "LIQUIDER" && $tp == "NON") {
                            $req = "SELECT * from notification where Recepteur like 'LIQUIDER' or Recepteur like '$nom' ORDER BY id DESC";
                        } elseif ($type == "CONTROLER" && $tp == "NON") {
                            $req = "SELECT * from notification where Recepteur like 'CONTROLER' or Recepteur like '$nom' ORDER BY id DESC";
                        } elseif ($type == "CONTROLER" && $tp == "OUI") {
                            $req = "SELECT * from notification where Recepteur like 'CONTROLERTP' or Recepteur like '$nom' ORDER BY id DESC";
                        } elseif ($type == "CHEF CENTRE") {
                            $req = "SELECT * from notification where Recepteur like 'CHEF CENTRE' and titre !='Demande Prolongation' ORDER BY id DESC";
                        } else {
                            $req = "";
                        }
?>
    <html lang="en">
@include("GestionDeParametre.nav");

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>ProTask | notifications </title>
        <style>
            .fix {
                position: sticky;
                top: 0;
                background-color: white;
                z-index: 2;
            }

            .tableFixHead {
                height: 80px;
                display: block;
                position: sticky;
                top: 0;
                z-index: 1;
                overflow: hidden;
                border-bottom: 1px solid #e3dada;

            }

            .search {
                float: right;
                height: 30px;
                width: 200px;
                background-color: #e3dada;
                padding: 10px;
                border-radius: 30px;
            }
        </style>
        <style>
            .icons i {
                color: #b5b3b3;
                border: 1px solid #b5b3b3;
                padding: 6px;
                margin-left: 4px;
                border-radius: 5px;
                cursor: pointer
            }






            .list li {
                list-style: none;
                border: 1px solid #e3dada;
                margin-top: 12px;
                border-radius: 5px;
                background: #fff
            }
        </style>








        <style>
html{
    zoom:1
}
        </style>
    </head>

    <body style="zoom:1;">
        <div class="row" style="<?php if ($type == "CHEF CENTRE") {
                                    echo "width: 50%;float: left;";
                                } ?>">
            <div style="background-color: #fff;width: 100%;max-height: 500px;overflow: hidden;border-radius: 30px;">

                <div class="tableFixHead" style="background-color:white;width: 100%;padding: 20px;">
                    <div style="display: inline-flex;flex-direction: row;align-items: center;width: 100%;justify-content: space-between;">

                        <h2 style="font-weight:700;font-size:15px;color:darkgreen;background-color:white;z-index:5"><i class="fa fa-bell"> </i> Notifications</h2>
                        <input class="search" type="text" onkeyup="Search('inputS','notifItem')" class="" id="inputS" placeholder="Chercher...">
                    </div>


                </div>







                 <div style="height:auto;max-height: 300px;min-height: 300px ;overflow: auto;">
                     
                <?php
                $array11 = runQuery($req);
                     $tok = csrf_token(); 

                if (!empty($array11)) {
                    foreach ($array11 as $key => $value) {
                        $title = $array11[$key]["titre"];
                ?>

                

                        <form method="POST" action="DeleteNotif" style="">
                                 {{ csrf_field() }}
                                 <input type="hidden" name="_token" value="<?php echo $tok; ?>">


                            <div class="mt-3 ">
                                <div class="alerts1 notifItem">
                                    <div class="alert <?php if ($title == "Une tâche est complète" || $title == "Nouvelle tâche affectée" || $title == "Date Prolongée" || $title == "Un Dossier est contrôlé sans erreurs") {
                                                            echo "success";
                                                        } elseif ($title == "Tâche Rejetée"|| $title == "Un Dossier est contrôlé avec erreurs") {
                                                            echo "failed";
                                                        } else {
                                                            echo "request";
                                                        } ?> ">
                                        <span class="alert-icon"><i class="fas fa-exclamation"></i></span>
                                        <span class="alert-content">
                                            <span class="alert-close">
                                                <button name="deleteNotif" onclick="return confirm('Vous êtes sur de supprimer cette notification  ?'); " type="submit"> <i class="fa fa-trash" style="color:<?php if ($title == "Tâche Rejetée" || $title == "Un Dossier est contrôlé avec erreurs") {
                                                                                                                                                                                                                    echo "white";
                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                    echo "#c84346";
                                                                                                                                                                                                                } ?>"></i></button>
                                            </span>
                                            <span class="alert-title"><?php echo $array11[$key]["titre"]; ?></span>
                                            <span class="alert-subtitle">
                                                <?php echo $array11[$key]["sujet"]; ?> <ul class="little-list">
                                                    <li></li>

                                                </ul>
                                                <input type="hidden" value="<?php echo $array11[$key]["id"];  ?>" name="id">

                                            </span>
                                        </span>
                                    </div>
                                </div>



                            </div>
                     </form>





                    <?php }
                } else {
                    echo "<div class='alerts alert'>Aucune notification</div>";
                } ?>

                                      </div>
 

            </div>








        </div>
        <?php if ($type == "CHEF CENTRE") {

        ?>
            <div class="row" style="width: 50%;float: right;">
                <div style="background-color: #fff;width: 100%;max-height: 500px;overflow: auto;border-radius: 30px;">

                    <div class="tableFixHead" style="background-color:white;width: 100%;padding: 20px;">
                        <div style="display: inline-flex;flex-direction: row;align-items: center;width: 100%;justify-content: space-between;">

                            <h2 style="font-weight:700;font-size:15px;color:darkgreen;background-color:white;z-index:5"><i class="fa fa-clock"> </i> Demandes de prolongation</h2>
                            <input class="search" type="text" onkeyup="Search('inputS2','notifItem2')" class="" id="inputS2" placeholder="Chercher...">
                        </div>


                    </div>








                    <?php
                    $req = "SELECT * from notification where recepteur like 'CHEF CENTRE' and titre like 'Demande Prolongation'";
                    $array11 = runQuery($req);

                    if (!empty($array11)) {
                        foreach ($array11 as $key => $value) {
                            $title = $array11[$key]["titre"];
                    ?>

                            <form method="POST" action="DeleteNotif" style="min-height: 300px ;height:auto;max-height: 300px;overflow: auto;">
                                 {{ csrf_field() }}
                                <div class="mt-3 ">
                                    <div class="alerts1 notifItem2">
                                        <div class="alert <?php if ($title == "Une tâche est complète" || $title == "Nouvelle tâche affectée" || $title == "Date Prolongée") {
                                                                echo "success";
                                                            } elseif ($title == "Tâche Rejetée" ) {
                                                                echo "failed";
                                                            } else {
                                                                echo "request";
                                                            } ?> ">
                                            <span class="alert-icon"><i class="fas fa-exclamation"></i></span>
                                            <span class="alert-content">
                                                <span class="alert-close">
                                                    <button name="" onclick="return confirm('Vous êtes sur de supprimer cette notification  ?'); " type="submit"> <i class="fa fa-trash" style="color:<?php if ($title == "Tâche Rejetée") {
                                                                                                                                                                                                                        echo "white";
                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                        echo "#c84346";
                                                                                                                                                                                                                    } ?>"></i></button>
                                                </span>
                                                <span class="alert-title"><?php echo $array11[$key]["titre"]; ?></span>
                                                <span class="alert-subtitle">
                                                    <?php echo $array11[$key]["sujet"]; ?> <ul class="little-list">
                                                        <li></li>

                                                    </ul>
                                                    <input type="hidden" value="<?php echo $array11[$key]["id"];  ?>" name="id">

                                                </span>
                                            </span>
                                        </div>
                                    </div>



                                </div>

                            </form>





                        <?php }
                    } else {
                        echo "<div class='alerts alert'>Aucune demande</div>";
                    } ?>


                </div>
            </div>
            
        <?php } ?>
        
        <script>
            function Search(input, data) {
                var input = document.getElementById(input);
                var filter = input.value.toLowerCase();
                var element = document.getElementsByClassName(data);


                for (i = 0; i < element.length; i++) {

                    if (element[i].innerText.toLowerCase().includes(filter)) {
                        element[i].style.display = "flex";


                    } else {
                        element[i].style.display = "none";

                    }
                }
            }
        </script>

    </html>
<?php  } else {?>
    @include("Error");
<?php
} ?>
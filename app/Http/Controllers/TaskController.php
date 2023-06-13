<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use Illuminate\Support\Facades\Input;
use Redirect;
use DB;

class TaskController extends Controller
{

    function AjouterTache()
    {

        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');

        $tache = $_POST['tache'];
        $type = $_POST['type'];
        $priorite = $_POST["priorite"];

        $sql = "INSERT INTO tache (tache,type,importante) VALUES ('$tache','$type','$priorite') ";
        $verif = mysqli_num_rows(mysqli_query($connect, "SELECT * from tache where tache like '$tache'"));
        if ($verif == 0) {


            if (mysqli_query($connect, $sql)) {
              //  return redirect("/Tache#taches")->with('TacheAjout','Tache Ajoutée');
               echo ("<meta http-equiv='refresh' content='0;  URL =Tache?TacheAjoute&#taches'/>");
            } else {
                // return redirect("/Tache#taches")->with('TacheNonAjoute','Tache  non Ajoutée');

                echo ("<meta http-equiv='refresh' content='0;  URL =Tache?TacheNonAjoute&#taches'/>");
            }
        } else {
                // return redirect("/Tache#taches")->with('NomExist','Nom existe');

           echo ("<meta http-equiv='refresh' content='0;  URL =Tache?NomExist&#taches'/>");
        }
    }



    function ModifierTache()
    {
        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
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

                echo ("<meta http-equiv='refresh' content='0;  URL =Tache?TacheModifier&#taches'/>");
            } else {
                echo mysqli_error($connect);
                echo ("<meta http-equiv='refresh' content='0;  URL =Tache?TacheNonModifier&#taches'/>");
            }
        } else {
            echo ("<meta http-equiv='refresh' content='0;  URL =Tache?NomExist&#taches'/>");
        }
    }
    function SupprimerTache()
    {
        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $idtache = Input::get('id');
        $query = "DELETE FROM tache where id =$idtache";
        if (!mysqli_query($connect, $query)) {
            echo mysqli_error($connect);
        } else {
            mysqli_query($connect,"DELETE from historique where idtache like $idtache");
            mysqli_query($connect,"DELETE from dossierTache where idtache like $idtache");
            echo ("<meta http-equiv='refresh' content='0; URL=Tache?Delete&#taches'/>");
        }
    }

    function AffecterTache()
    {
        $temp = date('Y-m-d | H:i', strtotime("+1 hours"));

        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $idtache = $_POST["idtache"];
        $nom = $_POST["utilisateur"];

        $tache = mysqli_fetch_array(mysqli_query($connect, "SELECT * from tache where id like $idtache"));


        $nomtache = $tache["tache"];
        if (isset($_POST['datefin']) && $_POST['datefin'] != '') {
            $datefin = date('Y-m-d', strtotime($_POST['datefin']));
        } else {
            $datefin = 'NULL';
        }
        $numDossier = $_POST["numDossier"];

        if (isset($_POST['Matricule'])) {
            $Matricule1 = $_POST['Matricule'];
        } else {
            $Matricule1 = "";
        }




        $query = mysqli_num_rows(mysqli_query($connect, "SELECT * from historique where utilisateur like $nom and tache like '$nomtache' and etat!='complete'"));
        if ($query != 0) { // si l'utilisateur a cette tache
            echo ("<meta http-equiv='refresh' content='0;  URL =Tache?NonAffecter&#taches'/>");
        } else {

            $importante = $tache["importante"];
            $dateAffectation = date("Ymd");

            $upd = mysqli_query($connect, "INSERT INTO historique (idtache,tache,utilisateur,etat,dateAffectation,datefin,numDossier,importante) VALUES ($idtache,'$nomtache',$nom,'en attente','$dateAffectation','$datefin',$numDossier,'$importante') ");
            if ($upd) { // si l'insertion est effectué il verifie si cette tache a des mat des dossiers ou nn 
                $hist = mysqli_fetch_array(mysqli_query($connect, "SELECT id from historique order by id desc LIMIT 1 "));
                if (!empty($hist)) { // s'il existe id dans l atable historique
                    $idhist = $hist[0]; // idhist prend la valeur de cet id dans la table historique
                } else {
                    $idhist = 1; // s'il n'existe pas 
                }
                if ($Matricule1 != "") {

                    foreach ($Matricule1 as $mat) {
                        if (strlen($mat) < 8) { // si le mat est invalide 
                            mysqli_query($connect, "DELETE from historique where id like $idhist ");
                            echo ("<meta http-equiv='refresh' content='0;  URL =Tache?invalidMatricule=$mat'/>");

                            exit;
                        } else {

                            $check = mysqli_num_rows(mysqli_query($connect, "SELECT * from dossierTache where matricule like $mat and etat!='complete'"));
                            if ($check == 0) { // matricule inexistant


                                $sql = "INSERT INTO dossierTache (idtache,idhist,utilisateur,matricule,etat) values ('$idtache',$idhist,$nom,'$mat','en attente')";
                                mysqli_query($connect, $sql);
                            } else {
                                echo ("<meta http-equiv='refresh' content='0;  URL =Tache?DossierExiste=$mat'/>");
                                mysqli_query($connect, "DELETE from dossierTache where idhist like $idhist and matricule like $mat ");
                                exit;
                            }
                        }
                    }
                }
                $params = new ParametreController();


                $titre = "Nouvelle tâche affectée";
                $sujet = "Une nouvelle tâche a été affecté pour vous par le chef centre.<br><button type=\'submit\' name=\'Enattente\'   >Consulter les tâches </button> pour voir plus de details<br><br><h6 style=\'float:right\'>" . $temp . "<h6>";
                $emetteur = "CHEF CENTRE";
                $recepteur = $params->GetName($nom);
                $params->AddNotification($titre, $sujet, $emetteur, $recepteur);

                echo ("<meta http-equiv='refresh' content='0;  URL =Tache?Affecter&#taches'/>");
            } else {
                echo mysqli_error($connect);
            }
        }
    }

    function runQuery($query)
    {
        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $result = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        return $resultset;
    }

    function ConsulterTache()
    {
        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');


        if (Input::get("query") == "tache_affecte") {
            $array = $this->runQuery("SELECT  *  from historique ORDER BY etat desc");

            if (!empty($array)) {
                foreach ($array as $key => $v) {
                    $idusr = $array[$key]["utilisateur"];
                    $nomRes = mysqli_fetch_array(mysqli_query($connect, "SELECT Nom from utilisateurs where id like  $idusr"));


                    echo "
            <tr class='data1' style='text-align:center'>

            <td>" . $nomRes[0] . "</td> 
            <td>" . $array[$key]["tache"] . "</td>
            ";
                    echo '<td style="text-align:left">';
                    if ($array[$key]["etatAncien"] != "") {
                        echo '<label class="badge badge-gradient-primary">passée</label>';
                    } elseif ($array[$key]["etat"] == 'complete') {
                        echo  '<label class="badge badge-gradient-success">complete</label>';
                    } elseif ($array[$key]["etat"] == 'en cours') {
                        echo '<label class="badge badge-gradient-info">en cours</label>
                 ';
                    } elseif ($array[$key]["etat"] == 'rejete') {
                        echo '                <label class="badge badge-gradient-danger">rejetée</label>';
                    } elseif ($array[$key]["etat"] == 'en attente') {
                        echo '                <label class="badge badge-gradient-warning">en attente</label> ';
                    }
                    echo '</td>';
                    echo '<td>
            ' . $array[$key]["numDossier"] . '
        </td>';
                    echo '<td>';
                    if ($array[$key]["numDossierTraiter"] != 0) {
                        echo $array[$key]["numDossierTraiter"];
                    } else {
                        echo "---";
                    }

                    echo '</td>';
                    echo '<td>';




                    $idhist = $array[$key]["id"];
                    $nomUser = $array[$key]["utilisateur"];
                    $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
                    mysqli_select_db($connect, 'cnrps');
                    $Dossier = mysqli_query($connect, "SELECT matricule from dossierTache WHERE utilisateur like $nomUser and idhist like $idhist ");
                    while ($matricules = mysqli_fetch_assoc($Dossier)) {
                        foreach ($matricules as $mat) {
                            echo $mat . "<br>";
                        }
                    }


                    echo ' </td>';

                    echo '<td>' . $array[$key]["dateAffectation"] . '</td>';
                    echo '<td>' . $array[$key]["datefin"] . '</td>';
                    echo '<td>';
                    if ($array[$key]["datefintravail"] != NULL) {
                        echo $array[$key]["datefintravail"];
                    } else {
                        echo "--------";
                    }
                    echo '</td>';
                    echo '<td>';
                    if ($array[$key]["etat"] == "complete") {
                        echo '<a class="dellt" href="?Supp=' . $array[$key]["id"] . '"  ><i class="fa fa-trash" style="color:red"></i></a>';
                    } elseif ($array[$key]["etat"] == "rejete") {
                        echo '<a id="reaff" href="?reAffect=' . $array[$key]["id"] . '"><i class="fas fa-sync"></i></a> &nbsp';
                        echo '<a class="dellt" href="?Supp=' . $array[$key]["id"] . '"onclick="return confirm("Vous êtes sur de supprimer cette tâche ?"); "><i class="fa fa-trash" style="color: red;"></i></a>';
                    } else {
                        echo "-------";
                    }

                    echo ' </td>';



                    echo "</tr>";
                }
            } else {
                echo "<tr><td></td><td>Aucun enregistrement</td></tr>";
            }
        } elseif ($_GET["query"] == "suiviDossier") {
            $array = $this->runQuery("SELECT * from dossierTache order by etat desc ");
            $params = new ParametreController();
            if (!empty($array)) {
                foreach ($array as $key => $value) {
                    $idusr = $array[$key]["utilisateur"];
                    $idold = $array[$key]["utilisateurAncien"];


                    $idhist = $array[$key]["idhist"];
                    echo ' <tr class="data10">';

                    echo '<td style="font-weight:bolder">' . $array[$key]["matricule"] . '</td>';
                    echo '<td>' . $params->GetName($idusr) . '</td>';
                    echo "<td>";
                    if ($array[$key]["utilisateurAncien"] != "") {
                        echo $params->GetName($idold);
                    } else {
                        echo "<i class='fa fa-times' style='color:red'></i>";
                    }



                    echo ' <td>';
                    $name = mysqli_fetch_array(mysqli_query($connect, "SELECT  tache from historique where id like $idhist"));
                    echo $name[0];
                    echo '</td>';

                    echo '<td>';

                    if ($array[$key]["etat"] == 'complete') {
                        echo '<label class="badge badge-gradient-success">complete</label>';
                    } elseif ($array[$key]["etat"] == 'en cours') {
                        echo '<label class="badge badge-gradient-info">en cours</label>';
                    } elseif ($array[$key]["etat"] == 'rejete') {
                        echo ' <label class="badge badge-gradient-danger">rejetée</label>';
                    } elseif ($array[$key]["etat"] == 'en attente') {
                        echo '<label class="badge badge-gradient-warning">en attente</label>';
                    }
                    echo '</td>';
                    echo '<td>';
                    if ($array[$key]["datefintravail"] == "") {
                        echo "----";
                    } else {
                        echo $array[$key]["datefintravail"];
                    }
                    echo '</td>';



                    echo '</tr>';
                }
            } else {
                echo "<tr><td></td><td>Aucun Dossier</td></tr>";
            }
        } elseif ($_GET["query"] == "progres") {
            $array = $this->runQuery("SELECT * from historique where etat!='rejete' order by numDossierTraiter desc ");
            if (!empty($array)) {
                foreach ($array as $key => $value) {
                    $idusr = $array[$key]["utilisateur"];
                    $nomRes = mysqli_fetch_array(mysqli_query($connect, "SELECT Nom from utilisateurs where id like  $idusr"));

                    $per = ($array[$key]["numDossierTraiter"] / $array[$key]["numDossier"]) * 100;
                    echo '  <tr class="data3">';
                    echo '<td>' . $nomRes[0] . '</td>';
                    echo '<td>' . $array[$key]["tache"] . '</td>';
                    echo '<td>';
                    echo '<div class="progress">';

                    if ($array[$key]["etat"] == "en attente") {
                        echo '<div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>';
                    } elseif ($array[$key]["etat"] == "en cours") {
                        echo ' <div class="progress-bar bg-gradient-warning" role="progressbar" style="width:' . $per . '%;height:10px;font-size:10px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>';
                    } elseif ($array[$key]["etat"] == "complete") {
                        echo '<div class="progress-bar bg-gradient-info" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>';
                    }
                    echo '</div>';
                    echo ' <p style="font-size:10px">' . (int)$per . '%</p>';


                    echo '</td>';
                }
            } else {
                echo "<tr><td></td><td>Aucune tâche</td></tr>";
            }
        } elseif ($_GET["query"] == "tache_passe") {
            $array = $this->runQuery("SELECT  *  from historique where utilisateurAncien!='' ORDER BY id  asc");
            if (!empty($array)) {
                foreach ($array as $key => $value) {
                    $idusr = $array[$key]["utilisateur"];
                    $nomRes = mysqli_fetch_array(mysqli_query($connect, "SELECT Nom from utilisateurs where id like  $idusr"));
                    $idold = $array[$key]["utilisateurAncien"];
                    $nomOld = mysqli_fetch_array(mysqli_query($connect, "SELECT Nom from utilisateurs where id like  $idold"));

                    $id = $array[$key]["id"];
                    echo '<tr class="data8" style="text-align:center">';
                    echo '<td>' . $array[$key]["tache"] . '</td>';

                    echo '<td>' . $nomOld[0] . '</td>';
                    echo '<td>' . $nomRes[0] . '</td>';
                    echo '<td>' . $array[$key]["datePassation"] . '</td>';
                    echo '<td>';

                    if ($array[$key]["etat"] == 'complete') {
                        echo '<label class="badge badge-gradient-success">complete</label>';
                    } elseif ($array[$key]["etat"] == 'en cours') {
                        echo ' <label class="badge badge-gradient-info">en cours</label>';
                    } elseif ($array[$key]["etat"] == 'rejete') {
                        echo '<label class="badge badge-gradient-danger">rejetée</label>';
                    } elseif ($array[$key]["etat"] == 'en attente') {
                        echo '<label class="badge badge-gradient-warning">en attente</label>';
                    }
                    echo '</td>';

                    echo '<td>';
                    $nom = $array[$key]["utilisateur"];
                    $idtache = $array[$key]["idtache"];

                    $Dossier = mysqli_query($connect, "SELECT matricule from dossierTache WHERE utilisateur like $nom and idhist like $id");
                    if ($Dossier) {
                        while ($matricules = mysqli_fetch_assoc($Dossier)) {
                            foreach ($matricules as $mat) {
                                echo $mat . "<br>";
                            }
                        }
                    } else {
                        echo "-----";
                    }
                    echo '</td>';
                    echo '<td>';
                    echo $array[$key]["dateAffectation"];

                    echo '</td>';
                    echo '<td>';
                    if ($array[$key]["etat"] == "complete") {
                        echo '<a class="dellt" href="?Supp=' . $array[$key]["id"] . '"onclick="return confirm("Vous êtes sur de supprimer cette tâche ?"); "><i class="fa fa-trash" style="color: red;"></i></a>';
                    } else {
                        echo "---";
                    }
                    echo "</td>";
                    echo '</tr>';
                }
            } else {

                echo "Aucun enregistrement";
            }
        } elseif ($_GET["query"] == "enattente") {
            $nomUser = $_GET['nom'];
            $array = $this->runQuery("SELECT  *  from historique where utilisateur like $nomUser and etat like 'en attente' ORDER BY importante desc");
            $count = mysqli_num_rows(mysqli_query($connect, "SELECT  *  from historique where utilisateur like $nomUser and etat like 'en attente' ORDER BY importante desc"));

            if ($count > 0) {

                foreach ($array as $key => $value) {
                    echo ' <tr class="data_attente" style="text-align:center"> ';
                    echo ' <td>' . $array[$key]["tache"] . '</td>';
                    echo ' <td> ' . $array[$key]["dateAffectation"] . '</td>';
                    echo '<td>' . $array[$key]["datefin"] . '</td>';
                    echo ' <td>' . $array[$key]["numDossier"] . '</td>';
                    echo  '<td>';
                    $nom2 = $array[$key]["utilisateur"];
                    $idhist = $array[$key]["id"];
                    $Dossier = mysqli_query($connect, "SELECT matricule from dossierTache WHERE utilisateur like $nom2 and idhist=$idhist");
                    while ($matricules = mysqli_fetch_assoc($Dossier)) {
                        foreach ($matricules as $mat) {
                            echo $mat . "<br>";
                        }
                    }
                    echo '</td>';
                    echo ' <td><label class=" ';
                    if ($array[$key]["importante"] == "OUI") {
                        echo "badge badge-gradient-danger";
                    } else {
                        echo "badge badge-gradient-info";
                    }
                    echo '">';
                    if ($array[$key]["importante"] == "OUI") {
                        echo "élevée";
                    } else {
                        echo "faible";
                    }
                    echo '</label>
                    </td>';
                    

                    echo '<td> <a href="CommencerTache?id=' . $array[$key]["id"] . '"><i class="fa fa-check" style="color: darkgreen"></i></a> &nbsp';
    echo ' <a id="PROL" href="Tache?Demande= ' . $array[$key]["id"]  . '&#enattente"> <i class="far fa-clock" style="color: darkred;font-size:20px"></i></a>
</td>';

                    echo '  </tr>';
                }
            } else {
                echo "<tr><td></td><td></td><td></td><td style='padding:10px'>Aucune Tâche</td></tr>";
            }
        }
    }

    function ReAffect()
    {
        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $temp = date('Y-m-d | H:i', strtotime("+1 hours"));

        $params = new ParametreController();

        $id_tache = $_POST["idtache"];
        if ($id_tache != '') {
            $hist = mysqli_fetch_array(mysqli_query($connect, "SELECT * from historique where id like $id_tache"));
            $nom = $hist["utilisateur"];
            $date = $_POST["date"];
            $curr = date("Y-m-d");

            mysqli_query($connect, "UPDATE historique set etat='en attente',datefin='$date',dateAffectation='$curr' where id like $id_tache");
            mysqli_query($connect, "UPDATE dossierTache SET etat='en attente' where idhist=$id_tache and utilisateur like $nom");


            $titre = "Tâche reAffectée";
            $sujet = "une tâche a été reaffecter pour vous par le chef centre.<br><button name=\'Enattente\' >Consulter les tâches</button> pour voir plus de details<br><br><h6>" . $temp . "</h6>";
            $emetteur = "CHEF CENTRE";
            $old = mysqli_fetch_array(mysqli_query($connect, "SELECT * from historique where id like $id_tache"));

            $recepteur = $old["utilisateur"];
            $params->AddNotification($titre, $sujet, $emetteur, $recepteur);
            echo ("<meta http-equiv='refresh' content='0;  URL =Tache?Reafecter&#liste'/>");
        }
    }

    function StatsCHEF()
    {
        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        if ($_GET["query"] == "stats") {
            $encours = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where etat like 'En cours'"));
            $done = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where etat like 'complete'"));
            $enattente = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where etat like 'en attente'"));
            $rejete = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM historique where etat like 'rejete'"));

            echo json_encode(array("att" => "$enattente", "encours" => $encours, "done" => $done, "rejete" => $rejete));
        }
    }
    function Calendar()
    {


        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $data = array();
        $params = new ParametreController();



        $query = $this->runQuery("SELECT * FROM historique where etat!='rejete' or etat !='complete' ");



        if (!empty($query)) {
            foreach ($query as $k => $v) {
                $name = $params->GetName($query[$k]["utilisateur"]);
                $data[] = array(
                    'id' => $query[$k]["id"],
                    'title'   => $name . "  :  " . $query[$k]["tache"],
                    'start'   => $query[$k]["dateAffectation"],
                    'end'   => $query[$k]["datefin"],
                    'className' => 'custom',
                    'overlap' => 'false',


                );
            }
        }



        echo json_encode($data);
    }



    function Connected()
    {

        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        if ($_GET["query"] == "user_connected") {
            $count = mysqli_num_rows(mysqli_query($connect, "SELECT * from utilisateurs where logged='true' and type!='CHEF CENTRE'  and type!='CONSULTER'"));

            if ($count > 0) {
                $array = $this->runQuery("SELECT * from utilisateurs where logged='true' and type!='CHEF CENTRE'  and type!='CONSULTER'");

                foreach ($array as $k => $v) {
                    echo "
            <li class='d-flex justify-content-between' style='border-radius:20px;background-color:rgba(0,0,0,0.1)'>
            <div class='d-flex flex-row align-items-center'><i class='fa fa-circle checkicon' style='font-size: 12px;'></i>
                <div class='ml-2'>
                    <h6 class='mb-0'>" . $array[$k]['Nom'] . "</h6>

                </div>
            </div>
            <div class='d-flex flex-row align-items-center'>
                <div class='d-flex flex-column mr-2'>
                    <a href='?nom=" . $array[$k]['Nom'] . "'><i class='fa fa-comments'></i></a>
                </div>
            </div>
        </li>
";
                }
            } else {
                echo "Aucun utilisateur est connecté";
            }
        } elseif ($_GET["query"] == "time") {
            $date = date("H:i", strtotime("+ 1 hour"));
            echo $date;
        } elseif ($_GET["query"] == "user_number") {
            $num = mysqli_num_rows(mysqli_query($connect, "SELECT * from utilisateurs where logged='true' and type!='CHEF CENTRE'  and type!='CONSULTER'"));
            echo $num;
        }
    }
    function MiseAjour()
    {
        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $tache = $_POST['idtache'];
        $nom = $_POST['username'];
        $temp = date('Y-m-d | H:i', strtotime("+1 hours"));
        $params = new ParametreController();


        $idhist = $_POST['idhist'];
        $old = mysqli_fetch_array(mysqli_query($connect, "SELECT * from historique where id like $idhist"));
        $ancien_num = $old['numDossierTraiter'];
        $datecurrent = date("Y-m-d");
        $dossier = mysqli_num_rows(mysqli_query($connect, "SELECT * from dossierTache where idhist like $idhist "));

        if ($dossier == 0) {
            $nouveau_num = $ancien_num + $_POST['nombreD'];

            if ($nouveau_num == $old["numDossier"]) {


                mysqli_query($connect, "UPDATE historique set numDossierTraiter=$nouveau_num, etat='complete',datefintravail='$datecurrent' where id like $idhist");

                echo ("<meta http-equiv='refresh' content='0;  URL =Tache?MAJfin&#complete'/>");
                $titre = "Une tâche est complète";
                $nom =  $params->GetName($old["utilisateur"]);
                $nomtache = $old["tache"];

                $sujet = "L\'utilisateur <strong>" . $nom . "</strong> a terminé la tâche <strong>" . $nomtache . "</strong><br><br>
                                        <h6 style=\'float:right;\'>" . $temp . "</h6>";
                $emetteur = $nom;
                $recepteur = "CHEF CENTRE";
                $params->AddNotification($titre, $sujet, $emetteur, $recepteur);
            } else {
                mysqli_query($connect, "UPDATE historique set numDossierTraiter=$nouveau_num where id like $idhist");

                echo ("<meta http-equiv='refresh' content='0;  URL =Tache?MAJ&#encours'/>");
            }
        } else {

            $DossierTache = $_POST["mat"];
            foreach ($DossierTache as $check) {
                $date = date("Y-m-d");
                mysqli_query($connect, "UPDATE dossierTache SET etat='complete',datefintravail='$date' where idhist like $idhist and matricule like $check and utilisateur like $nom");

                $numm = mysqli_fetch_array(mysqli_query($connect, "SELECT * from historique where id like $idhist"));
                $numDossier = $numm["numDossier"];
                $nouveau =  mysqli_num_rows(mysqli_query($connect, "SELECT * from dossierTache where etat like 'complete' and idhist=$idhist and utilisateur like $nom "));


                mysqli_query($connect, "UPDATE historique SET numDossierTraiter=$nouveau where id like $idhist ");

                if ($numDossier == $nouveau) {
                    mysqli_query($connect, "UPDATE historique SET etat='complete',datefintravail='$datecurrent' where id like $idhist ");
                    $titre = "Une tâche est complète";
                    $nom = $old["utilisateur"];
                    $nomtache = $old["tache"];
                    $nomRes = mysqli_fetch_array(mysqli_query($connect, "SELECT Nom from utilisateurs where id like  $nom"));


                    $sujet = "L\'utilisateur <strong>" . $nomRes[0] . "</strong> a terminé la tâche <strong>" . $nomtache . "</strong><br><br>
                                        <h6 style=\'float:right;\'>" . $temp . "</h6>";
                    $emetteur = $nomRes[0];
                    $recepteur = "CHEF CENTRE";
                    $params = new ParametreController();
                    $params->AddNotification($titre, $sujet,  $emetteur, $recepteur);
                    echo ("<meta http-equiv='refresh' content='0;  URL =Tache?MAJfin&#complete'/>");
                } else {
                    echo ("<meta http-equiv='refresh' content='0;  URL =Tache?MAJ&#encours'/>");
                }
            }
        }
    }

    function PasserTache()
    {
        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $temp = date('Y-m-d | H:i', strtotime("+1 hours"));

        $idhist = $_POST["idhist"];
        $oldusr = $_POST["oldusername"];
        $idtache = $_POST["idtache"];
        $nouvUsr = $_POST["passerA"];
        $datefintravail = 'NULL';
        $date = date('Y-m-d');
        $tache = mysqli_fetch_array(mysqli_query($connect, "SELECT * from tache where id like $idtache"));
        $nomtache = $tache["tache"];
        $verif = mysqli_num_rows(mysqli_query($connect, "SELECT * from historique where tache like '$nomtache' and utilisateur like $nouvUsr and etat like 'en attente' "));

        if ($verif == 0) {

            $verifDossier = mysqli_num_rows(mysqli_query($connect, "SELECT * from dossierTache where idhist like $idhist"));
            if ($verifDossier > 0) {
                mysqli_query($connect, "UPDATE dossierTache SET etat='en attente',etatAncien='complete', utilisateur=$nouvUsr, utilisateurAncien=$oldusr where idhist like $idhist and utilisateur like $oldusr");
            }






            $reslt2 = mysqli_query($connect, "UPDATE historique SET utilisateur=$nouvUsr,utilisateurAncien=$oldusr,etat='en attente',etatAncien='complete',datePassation='$date',datefintravail=$datefintravail,numDossierTraiter=0 where id like $idhist and utilisateur like $oldusr");
            if ($reslt2) {
                $params = new ParametreController();

                $nomRes = mysqli_fetch_array(mysqli_query($connect, "SELECT Nom from utilisateurs where id like  $oldusr"));
                $newRes = mysqli_fetch_array(mysqli_query($connect, "SELECT Nom from utilisateurs where id like  $nouvUsr"));

                $titre = "Nouvelle Tâche";
                $sujet = "L\'utilisateur <strong> " . $nomRes[0] . "</strong> a vous passé une tâche.<br> <button type=\'submit\' name=\'Enattente\' > <strong> Consulter les tâches</strong></button> pour voir plus de details <br><br><h6 style=\'float:right\'>" . $temp . "<h6>";
                $recepteur = $newRes[0];
                $emetteur = $nomRes[0];
                $titre1 = "Passation de tache";
                $sujet1 = "L\'utilisateur <strong> " . $nomRes[0] . "</strong> a  passé la tâche <strong>" . $nomtache . "</strong> vers <strong>" . $params->GetName($nouvUsr) . "</strong> <br> <button type=\'submit\' name=\'liste\'> <strong> Consulter les tâches</strong></button> pour voir plus de details <br><br><h6 style=\'float:right\'>" . $temp . "<h6>";
                $recepteur1 = "CHEF CENTRE";
                $emetteur1 = $nomRes[0];
                $params->AddNotification($titre, $sujet, $emetteur, $recepteur);
                $params->AddNotification($titre1, $sujet1, $emetteur1, $recepteur1);

                echo ("<meta http-equiv = 'refresh' content='0;  URL = Tache?PasséAvecSuccés&#complete'/>");
            } else {
                echo mysqli_error($connect);
            }
        } else {
            echo ("<meta http-equiv = 'refresh' content='0;  URL = Tache?NonPassée&#complete'/>");
        }
    }

    function Rejete()
    {
        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $temp = date('Y-m-d | H:i', strtotime("+1 hours"));
        $array10 = $this->runQuery("SELECT  *  from historique where etat!='rejete' and etat!='complete'  ");
        if (!empty($array10)) {

            $currentdate = date("Y-m-d");


            foreach ($array10 as $key => $value) {
                $dateFIN = date("Y-m-d", strtotime($array10[$key]["datefin"]));
                if ($currentdate > $dateFIN) {
                    $id = $array10[$key]["id"];
                    $nom_tache = $array10[$key]["tache"];
                    $nom_usr = $array10[$key]["utilisateur"];
                    $idtache = $array10[$key]["idtache"];
                    $upd = "UPDATE historique SET etat='rejete' where id like $id ";
                    $upd2 = "UPDATE dossierTache SET etat='rejete' where idhist=$id and utilisateur like $nom_usr";
                    mysqli_query($connect, $upd);

                    mysqli_query($connect, $upd2);
                    $nomRes = mysqli_fetch_array(mysqli_query($connect, "SELECT Nom from utilisateurs where id like  $nom_usr"));



                    $titre = "Tâche Rejetée";
                    $sujet = "une tâche a été rejeté suite au dépassement de la date finale à exécuter.<br><strong> Tache: </strong> " . $nom_tache . "<br> <strong>Utilisateur: </strong> " . $nomRes[0] . " <br><button type=\'submit\' name=\'liste\' >Consulter les tâches</button> pour voir plus de details<br><br><h6>" . $temp . "</h6>";

                    $recepteur = "CHEF CENTRE";
                    $emetteur = "";
                    $sujet1 = "une tâche a été rejeté suite au dépassement de la date finale à exécuter.<br><strong>Tache: </strong> " . $nom_tache . "<br><button type=\'submit\' name=\'rejete\'> Consulter les tâches</button> pour voir plus de details<br><br><h6>" . $temp . "</h6>";
                    $params = new ParametreController();

                    $recepteur1 = $params->GetName($nom_usr);
                    $params->AddNotification($titre, $sujet, $emetteur, $recepteur);
                    $params->AddNotification($titre, $sujet1, $emetteur, $recepteur1);

                    echo "done";
                }
            }
        }
    }

    function CommencerTache()
    {
        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $id_tache = $_GET["id"];
        $hist = mysqli_fetch_array(mysqli_query($connect, "SELECT * from historique where id like $id_tache"));
        $idtache = $hist["idtache"];
        $nom = $hist["utilisateur"];
        $idhist = $hist["id"];
        $upd = "UPDATE historique SET etat='en cours' where id like $id_tache";

        if (mysqli_query($connect, $upd)) {
            $count = mysqli_num_rows(mysqli_query($connect, "SELECT * from dossierTache where idhist like $idhist"));
            if ($count > 0) {
                $upd2 = "UPDATE dossierTache SET etat='en cours' where idhist like $id_tache and utilisateur like $nom";
                mysqli_query($connect, $upd2);
            }
        }
        echo ("<meta http-equiv = 'refresh' content='0;  URL = Tache?Commencé&#encours'/>");
    }

    //
}

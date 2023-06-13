<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\Input;




class ParametreController extends Controller
{
    //php artisan make:controller ParametreController


    function AddNotification($titre, $sujet, $emetteur, $recepteur)
    {
        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        if ($emetteur != "") {
            $req = "INSERT INTO notification (titre,sujet,emetteur,recepteur) values('$titre','$sujet','$emetteur','$recepteur') ";
        } else {
            $req = "INSERT INTO notification (titre,sujet,recepteur) values('$titre','$sujet','$recepteur') ";
        }

        mysqli_query($connect, $req);
    }


    function NumberNotif()
    {


        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $type = Input::get('type');
        $tp = Input::get('tp');
        $nom = Input::get('nom');


        if ($type == "LIQUIDER" && $tp == "OUI") {
            $req = "SELECT * from notification where Recepteur like 'LIQUIDERTP' or Recepteur like '$nom' ORDER BY id DESC";
        } elseif ($type == "LIQUIDER" && $tp == "NON") {
            $req = "SELECT * from notification where Recepteur like 'LIQUIDER' or Recepteur like '$nom' ORDER BY id DESC";
        } elseif ($type == "CONTROLER" && $tp == "NON") {
            $req = "SELECT * from notification where Recepteur like 'CONTROLER' or Recepteur like '$nom' ORDER BY id DESC";
        } elseif ($type == "CONTROLER" && $tp == "OUI") {
            $req = "SELECT * from notification where Recepteur like 'CONTROLERTP' or Recepteur like '$nom' ORDER BY id DESC";
        } elseif ($type == "CHEF CENTRE") {
            $req = "SELECT * from notification where Recepteur like 'CHEF CENTRE' ORDER BY id DESC";
        } else {
            $req = "";
        }

        $number = mysqli_num_rows(mysqli_query($connect, $req)) or die(mysqli_error($connect));



        // echo json_encode(array("num" => "$number", "check" => "$checked"));
        echo $number;
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
    function Notification_Items() // fonction d'affichage de notification dans le navbar
    {

        $type = Input::get('type');
        $tp = Input::get('tp');
        $nom = Input::get('nom');
        if ($type == "LIQUIDER" && $tp == "OUI") {
            $req = "SELECT * from notification where Recepteur like 'LIQUIDERTP' or Recepteur like '$nom' ORDER BY id DESC";
        } elseif ($type == "LIQUIDER" && $tp == "NON") {
            $req = "SELECT * from notification where Recepteur like 'LIQUIDER' or Recepteur like '$nom' ORDER BY id DESC";
        } elseif ($type == "CONTROLER" && $tp == "NON") {
            $req = "SELECT * from notification where Recepteur like 'CONTROLER' or Recepteur like '$nom' ORDER BY id DESC";
        } elseif ($type == "CONTROLER" && $tp == "OUI") {
            $req = "SELECT * from notification where Recepteur like 'CONTROLERTP' or Recepteur like '$nom' ORDER BY id DESC";
        } elseif ($type == "CHEF CENTRE") {
            $req = "SELECT * from notification where Recepteur like 'CHEF CENTRE' ORDER BY id DESC";
        } else {
            $req = "";
        }

        $array = $this->runQuery($req);
        if (count($array)>0) {
            foreach ($array as $key => $value) {
                $title = $array[$key]["titre"];

                $tok = csrf_token(); // obligatoire dans tous les forms
                echo '
<form method="POST" action="DeleteNotif">

<input type="hidden" name="_token" value="' . $tok . '">
';

                echo '  <div class="alerts1"style="width:100%;font-size:15px"   >';
                echo ' <div style="width:100%"  class="alert ';
                if ($title == "Une tâche est complète" || $title == "Nouvelle tâche affectée" || $title == "Date Prolongée" || $title == "Un Dossier est contrôlé sans erreurs") {
                    echo 'success">';
                } elseif ($title == "Tâche Rejetée" || $title == "Un Dossier est contrôlé avec erreurs") {
                    echo 'failed ">';
                } else {
                    echo 'request"> ';
                }
                echo ' <span class="alert-icon"><i class="fas fa-exclamation"></i></span>
                                        <span class="alert-content">
                                            <span class="alert-close">
                                                <button name="deleteNotif" class="button" id="dell"  type="submit"> <i class="fa fa-trash" style="color:';
                if ($title == "Tâche Rejetée" || $title == "Un Dossier est contrôlé avec erreurs") {
                    echo "white";
                } else {
                    echo "#c84346";
                }
                echo ' "></i></button> 
                                            </span>
                                            <span class="alert-title"> ' . $array[$key]["titre"] . '</span>
                                            <span class="alert-subtitle">
                                                ' . $array[$key]["sujet"] . ' <ul class="little-list">
                                                    <li></li>

                                                </ul>
                                                        <input type="hidden" name="id" value="' . $array[$key]['id'] . '">


                                            </span>
                                        </span>
                                    </div>
                                </div>

        
    </form>
    
   
    
    <hr> ';
            }
        } else {
            echo "Aucune notification";
        }
    }

    function DeleteNotif()
    {
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');

        $idN = Input::get("id");
        $del = "DELETE FROM notification Where id like $idN ";
        mysqli_query($connect, $del);
        echo ("<meta http-equiv='refresh' content='0;  URL =" . url()->previous() . "?Refresh'/>");

        $temp = date('Y-m-d | H:i', strtotime("+1 hours"));
        if (isset($_POST["Enattente"])) {
            echo ("<meta http-equiv='refresh' content='0;  URL =Tache?#enattente'/>"); // redirect vers la page des taches en attentes et supprimer la notif
        } elseif (isset($_POST["liste"])) {
            echo ("<meta http-equiv='refresh' content='0;  URL =Tache?#liste'/>");
        } elseif (isset($_POST["rejete"])) {
            echo ("<meta http-equiv='refresh' content='0;  URL =Tache?#rejete'/>");
        } elseif (isset($_POST["ConsulterLiquid"])) {
            $mat = $_POST["mat"];
            echo ("<meta http-equiv='refresh' content='0;  URL =Consulter?mat=" . $mat . "'/>");
        } elseif (isset($_POST["Controlctrl"])) {
            $mat = $_POST["mat"];
            echo ("<meta http-equiv='refresh' content='0;  URL =ConsulterDetail?matricule=" . $mat . "'/>");
        } elseif (isset($_POST["deleteNotif"])) {
            echo ("<meta http-equiv='refresh' content='0;  URL =" . url()->previous() . "'/>");

        } elseif (isset($_POST["deleteN"])) { // l'ajout d'une notification d'une demande refusée et supprimer la notification actuelle
            $idtache = Input::get("No");

            $tache = mysqli_fetch_array(mysqli_query($connect, "SELECT * from historique where id like $idtache"));
            $nomtache = $tache["tache"];
            $titre = "Date non Prolongé";
            $sujet = "Le chef centre a réfusé de prolongé l\'échéance de votre tâche <strong>" . $nomtache . "</strong><br><br>
                                                    <h6 >" . $temp . "</h6>";
            $emetteur = "CHEF CENTRE";

            $recepteur = $this->GetName($tache["utilisateur"]);
            $this->AddNotification($titre, $sujet, $emetteur, $recepteur);
                        echo ("<meta http-equiv='refresh' content='0;  URL =" . url()->previous() . "'/>");

        }






       
    }

    function GetName($id)
    {
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $username = mysqli_fetch_array(mysqli_query($connect, "SELECT Nom from utilisateurs where id like $id"));
        return $username[0];
    }

    function UpdateDate() // demande prolongation acceptée et date modifiée
    {
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $idN = Input::get("id");
        $del = "DELETE FROM notification Where id like $idN ";
        mysqli_query($connect, $del);
        $temp = date('Y-m-d | H:i', strtotime("+1 hours"));

        echo ("<meta http-equiv='refresh' content='0;  URL =" . url()->previous() . "?Refresh'/>");
        if (isset($_POST["deleteY"])) {
            $idtache = Input::get("OK");
            $nbjour = Input::get("nbjr");
            $tache = mysqli_fetch_array(mysqli_query($connect, "SELECT * from historique where id like $idtache"));
            $nomtache = $tache["tache"];
            $datefin_old = date("Ymd", strtotime($tache["datefin"]));
            $datefin_nouveau = date("Y-m-d", strtotime($datefin_old . ' + ' . $nbjour . ' days '));
            mysqli_query($connect, "UPDATE historique SET datefin='$datefin_nouveau' where id like $idtache");
            $titre = "Date Prolongée";
            $sujet = "Le chef centre a accepté de prolongé l\'échéance de votre tâche <strong>" . $nomtache . "</strong> <br> Le nouveau date est : <strong>" . $datefin_nouveau . "</strong><br><br>
                                                    <h6 >" . $temp . "</h6>";
            $emetteur = "CHEF CENTRE";
            $id = $tache["utilisateur"];


            $recepteur = $this->GetName($id);

            $this->AddNotification($titre, $sujet, $emetteur, $recepteur);
        }
    }
    function ViderNotif()
    {
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $nom = Session::get("nom");
        $type = Session::get("type");
        $tp = Session::get("tp");

        if ($type == "LIQUIDER" && $tp == 'OUI') {

            $vider = "DELETE From notification WHERE Recepteur like 'LIQUIDERTP' or Recepteur like '$nom'";
        } elseif ($type == "LIQUIDER" && $tp == 'NON') {
            $vider = "DELETE From notification WHERE Recepteur like 'LIQUIDERTP' or Recepteur like '$nom'";
        } elseif ($type == "CONTROLER" && $tp == 'OUI') {

            $vider = "DELETE From notification WHERE Recepteur like 'CONTROLERTP' or  Recepteur like '$nom'";
        } elseif ($type == "CONTROLER" && $tp == 'NON') {
            $vider = "DELETE From notification WHERE Recepteur like 'CONTROLER' or Recepteur like '$nom'";
        } elseif ($type == "CHEF CENTRE") {
            $vider = "DELETE From notification WHERE Recepteur like 'CHEF CENTRE' or Recepteur like '$nom'";
        }
        mysqli_query($connect, $vider);
        echo ("<meta http-equiv='refresh' content='0;  URL =" . url()->previous() . "?Refresh'/>");
    }


    function MessageSend()
    {
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $message = $_POST['message'];
        $new_message = str_replace("'", "''", "$message");
        $sujet = $_POST['sujet'];
        $new_sujet = str_replace("'", "''", "$sujet");
        $emetteur = Session::get("nom");
        $recepteur = $_POST['recepteur'];
        $date = date('Y-m-d | H:i', strtotime("+1 hours"));

        $emetteur1 = Session::get("nom");
        $valueFILE = $_FILES["FILE_UP"]["name"];
        if (isset($valueFILE) && !empty($valueFILE)) {


            $file = $_FILES["FILE_UP"]["name"];
            $destination = "./uploads/" .  $file;
            $destination1 = "uploads/" .  $file;

            $size = $_FILES['FILE_UP']['size'];
            if ($_FILES['FILE_UP']['size'] > 30000000) { // file shouldn't be larger than 10Megabyte
                echo ("<meta http-equiv='refresh' content='0;  URL =" . url()->previous() . "?FichierLarge'/>");
            } else {
                move_uploaded_file($_FILES["FILE_UP"]["tmp_name"], $destination);

                $sql = "INSERT INTO message (message,sujet,emetteur,emetteur1,recepteur,recepteur1,date,fichier,nomfichier) values('$new_message','$new_sujet','$emetteur','$emetteur','$recepteur','$recepteur','$date','$destination1','$file')";
            }
        } else {
            $sql = "INSERT INTO message (message,sujet,emetteur,emetteur1,recepteur,recepteur1,date) values('$new_message','$new_sujet','$emetteur','$emetteur','$recepteur','$recepteur','$date')";
        }

        $done = mysqli_query($connect, $sql) or die(mysqli_error($connect));

        if ($done) {
            echo ("<meta http-equiv='refresh' content='0;  URL =Inbox?envoyé&MessageEnvoye'/>");
        } else {
            echo mysqli_error($connect);
            echo ("<meta http-equiv='refresh' content='0;  URL =Inbox?envoyé&MessageNonEnvoye'/>");
        }
    }


    function Messages()
    {
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        if ($_GET["query"] == "message") {
            $name = Input::get('nom');
          

            $requete = "SELECT * from message where recepteur like '$name' ";
            $message = mysqli_num_rows(mysqli_query($connect, $requete));
            $requete2 = "SELECT * from message where emetteur like '$name' ";

            echo $message;
        } elseif ($_GET["query"] == "messages") {
            $user = $_GET["nom"];
            $current=$_GET["current"];

            $msg = $this->runQuery("SELECT * from message where recepteur like '$user' order by date desc");
            if (count($msg)>0) {

                foreach ($msg as $key => $value) {

                    $date = date("d/M/Y | H:i", strtotime($msg[$key]["date"]));

                    echo '<form method="POST" action="DeleteMessage">';
                    echo csrf_field();

                    echo '<div class="alerts" >
            <div class="alert wait">    
              ';
                    echo ' <span class="alert-content" >';

                    echo '<span class="alert-title"><i class="fas fa-user-circle"></i> ' . $msg[$key]["emetteur1"] . ' </span>';
                    echo "<div class='box3 sb14' style='min-height:80px;height:auto;'>";
                    echo ' <span class="alert-subtitle"><h5 style="font-size:1.2em;font-weight:700;z-index: 5;font-family:Lucida">' . $msg[$key]["sujet"] . ' </h5>
              <ul class="little-list" style="display:inline;word-wrap:break-word">
                        &nbsp;' . $msg[$key]["message"] . '<br><br>';
                    if ($msg[$key]["fichier"] != "") {
                        echo "<a style='font-size: 10px;color:#05324f;' href='" . $msg[$key]["fichier"] . "' download> <i class='far fa-file-alt' ></i> " . $msg[$key]["nomfichier"] . "
                                        </a>
                                    <br><br> 
                                  "; 
                    }
                    echo "  <h6 style='color:rgba(0,0,0,0.5);font-size:0.9em;font-weight:900'>" . $date . "</h6> ";
                    echo "</div><br>";


                    echo  '
                      </ul>
              
                   </span>
                   </span>  ';

                   if($current=="consulterCarte" || $current=="consulterDetail" || $current=="modifierDossier"   )
                   {
                   echo '<span class="alert-icon"><a href="'.url()->previous().'&nom=' . $msg[$key]['emetteur'] . '" style="color:#05324f;font-size:inherit;font-weight:inherit"> <i class="fas fa-reply"></i> </a>';
                       
                   }else{
                   echo '<span class="alert-icon"><a href="?nom=' . $msg[$key]['emetteur'] . '" style="color:#05324f;font-size:inherit;font-weight:inherit"> <i class="fas fa-reply"></i> </a>';

                   }

                  echo ' <span class="alert-close"><button class="dell" name="deleteMessage" style="color:#05324f"  type="submit" ><i class="fa fa-trash"></i></button>
              </span>
              </span>   
              
                   </div>
                 </div>';
                                     echo "<input type='hidden' name='IDmessage' value=" . $msg[$key]["id"] . ">";

                 echo "</form>";

                }
            } else {
                echo "Aucun message";
            }
        }
    }
    function DeleteMessage()
    {
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');


        $idm = Input::get("IDmessage");
        $nomUser = Session::get('nom');

        $rslt = "UPDATE message SET   recepteur=''   Where id like $idm and recepteur1 like '$nomUser'";
        if (mysqli_query($connect, $rslt)) {
            $msg = mysqli_fetch_array(mysqli_query($connect, "SELECT * from message where id like $idm and emetteur like '' and recepteur like ''"));

            if (!empty($msg)) {
                mysqli_query($connect, "DELETE from message where id like $idm");
            }
            echo ("<meta http-equiv='refresh' content='0;URL=Inbox?done '/>");
        }
    }
    function DeleteMessageEnv()
    {
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $in = Input::get("in");
        $nom = Session::get("nom");
        $rss = "UPDATE message SET emetteur='' Where id like $in and emetteur1 like '$nom' ";

        if (mysqli_query($connect, $rss)) {
            $msg2 = mysqli_fetch_array(mysqli_query($connect, "SELECT * from message where id like $in and emetteur like '' and recepteur like ''"));
            if (!empty($msg2)) {
                mysqli_query($connect, "DELETE from message where id like $in");
            }
            echo ("<meta http-equiv='refresh' content='0;URL=Inbox?envoyé '/>");
        }
    }


    function AjouterDemande()
    {
        $temp = date('Y-m-d | H:i', strtotime("+1 hours"));

        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $tache = $_POST['idtache'];
        $nombre = $_POST["nbjour"];
        $nomUsr = $_POST["nameUsr"];

        $ca = $_POST["cause"];
        $cause = str_replace("'", "''", "$ca");


        $old = mysqli_fetch_array(mysqli_query($connect, "SELECT * from historique where id like $tache"));
        $nomtache = $old['tache'];
        $nomutil = $old["utilisateur"];
        $utili = mysqli_fetch_array(mysqli_query($connect, "SELECT * from utilisateurs where id like $nomutil"));
        $idutil = $utili["id"];

        $recepteur = "CHEF CENTRE";
        $emetteur = $nomUsr;
        $titre = "Demande Prolongation";


        $sujet = "L'utilisateur <strong> "
            . $nomUsr . "</strong> a demandé de prolonger son échéance d'executer la tache 
         <strong>" . $nomtache . "</strong> de <strong>" . $nombre . "</strong> jours et son cause c'est : <br> 
         " . $cause . "<br> <br>

        <input name='OK' type='hidden' value='" . $tache . "' /> <input name='nbjr' type='hidden' value='" . $nombre . "' />   <button class='conf' formaction='UpdateDate'  type='submit' name='deleteY' style='float:left;'>Accepter</button>|   <input type='hidden' name='No' value='" . $tache . "' /> <input type='hidden' name='usr' value='" . $idutil . "' />  <button class='conf' name='deleteN' type='submit' style= 'color:red;  '>Refuser</button><br><br>
        <h6 style='float:right'>" . $temp . "</h6>";
        $sujet1 = str_replace("'", "''", "$sujet");
        $this->AddNotification($titre, $sujet1, $emetteur, $recepteur);
        $datecurrent = date("Ymd");


        echo ("<meta http-equiv='refresh' content='0;URL=Tache?DemandeEnvoyé'/>");
    }

    function Session()
    {

        $session = $_GET["activity"];
        // update last activity time stamp


        if (time() - $session > 900) {

            $id = Session::get("id1");
            echo "Logout?Session_Expired=$id"; //data
        }
    }
}

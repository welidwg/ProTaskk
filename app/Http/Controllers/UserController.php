<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use Illuminate\Support\Facades\Input;
use Redirect;
use PHPMailer\PHPMailer;


class UserController extends Controller
{


    //
    function Auth()
    {
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');

        $mdp = $_POST['mdp'];
        $id = $_POST['identifiant'];


        $sql = "SELECT * from utilisateurs where  identifiant like '$id'  ";
        $result = mysqli_query($connect, $sql);
        $count = mysqli_num_rows($result);


        if ($count == 1) {
            $user = mysqli_fetch_array($result);
            $mpas = $user["mdp"];
            if (md5($mdp) == $mpas) {

                Session::put("type", $user['type']); // besh taaml session jdidaa 
                Session::put("id", $user['identifiant']);
                Session::put("nom", $user['Nom']);
                Session::put("tp", $user['TropPercu']);
                Session::put("id1", $user['id']);
                $id = $user["id"];
                mysqli_query($connect, "UPDATE utilisateurs SET logged='true' where id like $id");
                $nom = $user['Nom'];
                $type = $user["type"];
                $numm = mysqli_num_rows(mysqli_query($connect, "SELECT * from notification where Recepteur like '$nom' or Recepteur like '$type' "));

                echo ("<meta http-equiv = 'refresh' content='0;  URL = Accueil?Success'/>");
            } else {
                echo ("<meta http-equiv='refresh' content='0;  URL =index?ErreurMDP'/>");
            }
        } else {
            $sql_id = "SELECT * from utilisateurs where identifiant='$id'";
            $result_id = mysqli_query($connect, $sql_id);
            $count_id = mysqli_num_rows($result_id);

            $sql_mdp = "SELECT mdp from utilisateurs where identifiant='$id'";
            $result_mdp = mysqli_query($connect, $sql_mdp);
            $mdp_local = mysqli_fetch_array($result_mdp);

            if ($count_id == 0) {
                echo ("<meta http-equiv='refresh' content='0;  URL =index?ErreurID'/>");
            } elseif ($count_id == 1) {
                if (md5($mdp) != $mdp_local[0]) {
                    echo ("<meta http-equiv='refresh' content='0;  URL =index?ErreurMDP'/>");
                }
            } else {
                echo ("<meta http-equiv='refresh' content='0;  URL =index?Notfound'/>");
            }
        }
    }

    function Logout()
    {
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');


        $id = Session::get("id");

        Auth::logout();
        Session::flush(); //session destroy


        

        if (Input::has("Session_Expired")) {
            $id = Input::get("Session_Expired");
            mysqli_query($connect, "UPDATE utilisateurs SET logged='false' where id like $id ");

            return Redirect::to('/index?Session_Expired');
        } else {
            if (Input::has("log")) {
                $id = Input::get("log");
                mysqli_query($connect, "UPDATE utilisateurs SET logged='false' where id like $id ");
            }
            return Redirect::to('/index?LoggedOut');
        }


        exit();
    }

    function check_internet($domain)
    {
        $file = @fsockopen($domain, 80);

        return ($file);
    }

    function generateRandomString($length =6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

    function PasswordRecovery()
    {
        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');

        $temp = date('Y-m-d | H:i', strtotime("+1 hours"));

        $identifiant = $_POST["id"];
        if (strlen($identifiant) >= 8) {
            $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from utilisateurs where identifiant like $identifiant"));
            if (!empty($user)) {
                $nom = $user["Nom"];
                $mail =  new PHPMailer\PHPMailer();;

                if ($user["type"] == "CHEF CENTRE") {
                    if (@fopen("https://google.com", "r")) {
                         $rand=$this->generateRandomString();

                        $mdp = md5($rand);

                        $email=$user["email"];

                        $mail->isSMTP();
                        $mail->SMTPAuth = true;
                        $mail->SMTPSecure = "ssl";
                        $mail->Host = 'smtp.gmail.com';
                        $mail->Port = '465';
                        $mail->isHTML();
                        $mail->Username = "ProTaskManager@gmail.com";
                        $mail->Password = "ProTask1899";
                        $mail->SetFrom('no-reply@protask.com');
                        $mail->Subject = "Recuperation du mot de passe";
                        $mail->Body = "Bonjour monsieur " . $nom . "<br>
						Vous avez demandé de réupérer votre mot de passe.<br>
						Votre nouveau mot de passe devient : <strong style='color:darkred'>".$rand."</strong><br><br>ProTask";
                        $mail->AddAddress($email);
                        $mail->Send();
                        $nom = $user["Nom"];
                        $titre = "Récuperation mot de passe";
                        $sujet = "Vous avez recupérez votre mot de passe <br><br>
		<h6 >" . $temp . "</h6>";
                        $emetteur = $nom;
                        $recepteur = "CHEF CENTRE";

                        $params = new ParametreController();
                        $params->AddNotification($titre, $sujet, $emetteur, $recepteur);
                       
                        mysqli_query($connect, "UPDATE utilisateurs SET mdp='$mdp' where Nom like '$nom' and type like 'CHEF CENTRE' ");
                        return Redirect::to('/index?DoneCHEF');
                    } else {
                        return Redirect::to('/index?Connexion');
                    }
                } else {
                    $nom = $user["Nom"];
                    $titre = "Récuperation mot de passe";
                    $sujet = "L\'utilisateur <strong>" . $nom . "</strong> a demandé de recupérer son mot de passe.<br>
		<h6 >" . $temp . "</h6>";
                    $emetteur = $nom;
                    $recepteur = "CHEF CENTRE";

                      $params = new ParametreController();
                        $params->AddNotification($titre, $sujet, $emetteur, $recepteur);
                    return Redirect::to('/index?Done');
                }
            } else {
                return Redirect::to('/index?ErreurID');
            }
        } else {
            return Redirect::to('/index?ErreurID');
        }
    }

    function AddAccount(Request $req)
    {

        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');

        $id = $_POST["identifiant"];
        $nom = $_POST["nom"];
        $email = $_POST["email"];
        $type = $_POST["type"];
        $mdp = $_POST["mdp"];
        $confirm = $_POST["confirm"];
        if (Input::has("TP")) {
            if ($_POST['TP'] == "OUI") {
                $TP = $_POST['TP'];
            } else {
                $TP = "NON";
            }
        } else {
            $TP = "NULL";
        }
        if (isset($_POST['TP'])) {
            if ($_POST['TP'] == "OUI") {
                $TP = $_POST['TP'];
            } else {
            }
        }

        if (strlen($id) < 8) {
            //return Redirect::to('?InvalidID');

            echo ("<meta http-equiv='refresh' content='0;  URL =" . url()->previous() . "?InvalidID'/>");
        } else {



            $result_id = mysqli_query($connect, "SELECT  * FROM utilisateurs WHERE identifiant='$id'");
            $hash = md5($confirm);

            $id_exist = mysqli_num_rows($result_id);
            if ($email != "") {
                $add = "INSERT INTO utilisateurs (identifiant,Nom,type,email,mdp,TropPercu)  values ('$id','$nom','$type','$email','$hash','$TP')";
                $email_exist = mysqli_num_rows(mysqli_query($connect, "SELECT  * FROM utilisateurs WHERE email='$email'"));
            } else {
                $add = "INSERT INTO utilisateurs(identifiant,Nom,type,mdp,TropPercu) values ('$id','$nom','$type','$hash','$TP')";
                $email_exist = 0;
            }

            if ($id_exist == 1) {
                //return Redirect::to('?id_existant');
                echo ("<meta http-equiv='refresh' content='0;  URL =" . url()->previous() . "?id_existant'/>");
            } elseif ($email_exist == 1) {
                // return Redirect::to('?email_existant');

                echo ("<meta http-equiv='refresh' content='0;  URL =" . url()->previous() . "?email_existant'/>");
            } elseif ($id_exist == 0 && $email_exist == 0) {
                if ($mdp == $confirm) {



                    if (mysqli_query($connect, $add)) {
                        //  return Redirect::to('?Succes_Ajout');

                        echo ("<meta http-equiv='refresh' content='0;  URL =Accounts?Succes_Ajout'/>");
                    } else {
                        die(mysqli_error($connect));
                    }
                } else {
                    // return Redirect::to('?Confirm_mdp');

                    echo ("<meta http-equiv='refresh' content='0;  URL =" . url()->previous() . "?Confirm_mdp'/>");
                }
            }
        }
    }

    function DeleteAccount()
    {
        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        if (Input::has('id')) {
            $idn = Input::get('id');
            $sql = "DELETE FROM utilisateurs where id=$idn";
            if (mysqli_query($connect, $sql)) {
                echo ("<meta http-equiv='refresh' content='0;  URL =Accounts?Supprimer'/>");
            } else {
                echo ("<meta http-equiv='refresh' content='0;  URL =Accounts?NonSupprimer'/>");
            }
        }
    }

    function EditAccount()
    {
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $nom = $_POST["nom"];
        $email = $_POST["email"];
        $mdp = $_POST["mdp2"];
        $hash = $_POST["mdp2"];
        if (!empty($_POST["mdp"])) {
            $mdp = $_POST["mdp"];
            $hash = md5($mdp);
        }
        $type = $_POST["type"];
        $idn = $_POST["id_usr"];
        $old_name = $_POST["old_name"];
        $TP = "NON";

        if (Input::has("TP")) {
            if ($_POST["TP"] == "OUI") {
                $TP = "OUI";
            }
        }
        $id=$_POST["idusr"];

         $query = "SELECT * from utilisateurs where id=$id";
         $rslt = mysqli_query($connect, $query);
         $row = mysqli_fetch_array($rslt);


        if ($email != "") {
            $query = "SELECT * FROM utilisateurs where email like '$email'";
            $verif_email = mysqli_num_rows(mysqli_query($connect, $query));
        } else {
            $verif_email = 0;
        }


        if ($verif_email == 1 && $email != $row["email"]) {
            echo ("<meta http-equiv='refresh' content='0;  URL =Accounts?Exist'/>");
        } else {
            $sql = "UPDATE utilisateurs set Nom='$nom',email='$email',mdp='$hash',type='$type',TropPercu='$TP' where id='$idn'";



            if (mysqli_query($connect, $sql)) {
            

                $compte = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM utilisateurs where id like $idn "));
                $dateCurrent = date('Y-m-d H:i:s');
                $hist = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM historique where utilisateur like '$old_name' or utilisateurAncien like '$old_name' "));
                if (!empty($hist)) {
                    if ($hist["utilisateur"] == $old_name) {

                        $req = "UPDATE historique SET utilisateur='$nom' where utilisateur like '$old_name' ";
                        mysqli_query($connect, $req);
                    } elseif ($hist["utilisateurAncien"] == $old_name) {
                        $req = "UPDATE historique SET utilisateurAncien='$nom' where utilisateurAncien like '$old_name' ";
                        mysqli_query($connect, $req);
                    }
                }

                $dossier = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM dossierTache where utilisateur like '$old_name' or utilisateurAncien like '$old_name' "));
                if (!empty($dossier)) {
                    if ($dossier["utilisateur"] == $old_name) {

                        $req2 = "UPDATE dossiertache SET utilisateur='$nom' where utilisateur like '$old_name' ";
                        mysqli_query($connect, $req2);
                    } elseif ($dossier["utilisateurAncien"] == $old_name) {
                        $req2 = "UPDATE dossiertache SET utilisateurAncien='$nom' where utilisateurAncien like '$old_name' ";
                        mysqli_query($connect, $req2);
                    }
                }


                $dossierTP = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM dossier where AjoutePar like '$old_name' or ControlePar like '$old_name' "));
                if (!empty($dossierTP)) {
                    if($dossierTP["AjoutePar"]=="$old_name"){
                        $req2 = "UPDATE dossier SET AjoutePar='$nom' where AjoutePar like '$old_name' ";

                    } elseif($dossierTP["ControlePar"] == "$old_name"){
                        $req2 = "UPDATE dossier SET ControlePar='$nom' where ControlePar like '$old_name' ";

                    }

                        mysqli_query($connect, $req2);
                    }

                echo ("<meta http-equiv='refresh' content='0;  URL =Accounts?EditSuccess'/>");
            }
        }
    }
}

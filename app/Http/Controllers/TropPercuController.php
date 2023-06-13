<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;


use Session;
use Illuminate\Support\Facades\Input;

class TropPercuController extends Controller
{
    //
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
    function ProcessControl()
    {
        $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $params = new ParametreController();



        $Matricule = $_GET["matricule"];
        $Action = $_GET["action"];
        $dateCurrent = date('Ymd');
        $dateCurrent2 = date('Y-m-d');
        $Nom = Session::get("id1");



        if ($Action == "accepter") {
            $Update = "UPDATE dossier SET Controle='Accepter',ControlePar='$Nom', DateControle=$dateCurrent WHERE Matricule like $Matricule ";
        } else if ($Action == "refuser") {
            $Update = "UPDATE dossier SET Controle='Refuser',ControlePar='$Nom', DateControle=$dateCurrent WHERE Matricule like $Matricule ";
        }

        $temp = date('Y-m-d | H:i', strtotime("+1 hours"));

        if (mysqli_query($connect, $Update)) {
            if ($Action == "refuser") {
                $titre = "Un Dossier est contrôlé avec erreurs";
                $sujet = "Le dossier avec la matricule <strong> <button type=\'submit\' name=\'ConsulterLiquid\' ><input type=\'hidden\' name=\'mat\' value=\'" . $Matricule . "\'/> " . $Matricule . " </button></strong> est controlé avec erreurs par <strong> " . Session::get("nom") . "</strong> <br><br><h6>" . $temp . "</h6>";
                $emetteur = Session::get("nom");;
                $recepteur = "LIQUIDERTP";
                $params->AddNotification($titre, $sujet, $emetteur, $recepteur);
            } else {
                $titre = "Un Dossier est contrôlé sans erreurs";
                $sujet = "Le dossier avec la matricule <strong> <button type=\'submit\' name=\'ConsulterLiquid\' > " . $Matricule . " </button><input type=\'hidden\' name=\'mat\' value=\'" . $Matricule . "\'/></strong> est controlé sans erreurs par <strong> " . Session::get("nom") . "</strong> <br><br><h6>" . $temp . "</h6>";
                $emetteur = Session::get("nom");
                $recepteur = "LIQUIDERTP";
                $params->AddNotification($titre, $sujet, $emetteur, $recepteur);
            }

            echo ("<meta http-equiv='refresh' content='0;  URL =Controle?BienControle'/>");
        } else {
            echo ("<meta http-equiv='refresh' content='0;  URL =Controle?ErreurControle1'/>");
        }
    }

    function EditFolder()
    {
        $connect  = mysqli_connect('localhost', 'root', '') or die("Erreur de connexion avec la base de donnée");
        mysqli_select_db($connect, 'cnrps');
        $idDossier = $_POST["idDossier"];
        $matricule = $_POST["matricule"];
        $orgMat= $_POST["OrgMat"];
        $dateCurrent5 = date("Y-m-d");
        $date = $_POST["dateBasic"];

        if ($_POST["cin"] == "") {
            $cin1 = NULL;
        } else {

            $cin1 = $_POST["cin"];
        }
        if (strlen($cin1) < 8 && $cin1 != '') {
            echo ("<meta http-equiv='refresh' content='0;  URL =ModifierDossier?InvalidCin&matricule=" . $matricule . "'/>");
        } elseif (strlen($matricule) < 8) {
            echo ("<meta http-equiv='refresh' content='0;  URL =ModifierDossier?InvalidMat&matricule=" . $orgMat . "'/>");
        } else {
            $folder = mysqli_fetch_array(mysqli_query($connect, "SELECT * from dossier where id like $idDossier"));
            if ($folder["Matricule"] != $matricule) {
                $verifMAT = mysqli_num_rows(mysqli_query($connect, "SELECT * from dossier where Matricule like $matricule"));
            } else {
                $verifMAT = 0;
            }

            if ($folder["Cin"] != $cin1) {
                $verifCIN = mysqli_num_rows(mysqli_query($connect, "SELECT * from dossier where Cin like '$cin1'"));
            } else {
                $verifCIN = 0;
            }

            if ($verifMAT == 0) {
                if ($verifCIN == 0 || $cin1 == "") {

                    if ($_POST["montantRestitue"] == "") {
                        $montantRestitue = 0;
                    } else {
                        $montantRestitue = $_POST["montantRestitue"];
                    }

                    $methode = $_POST['Methode'];

                    $nomPrenom = $_POST["nomprenom"];
                    $typedette = $_POST["typedette"];
                    if ($_POST["montantDemande"] == "") {
                        $montantDemande = 0;
                    } else {
                        $montantDemande = $_POST["montantDemande"];
                    }

                    if ($_POST["montantBloque"] == "") {
                        $montantBloque = 0;
                    } else {
                        $montantBloque = $_POST["montantBloque"];
                    }
                    $etat = $_POST["etat"];

                    $dateCorrespondance = 'NULL';
                    $dateCorrespondance2 = 'NULL';

                    if ($corres1 = strtotime($_POST['dateCorrespondance'])) {
                        $dateCorrespondance = date("Ymd", $corres1);
                    }
                    $mat = $_POST["mat"];
                    $verif = mysqli_query($connect, "SELECT * from dossier where Matricule=' $mat'");
                    $row = mysqli_fetch_array($verif);
                    if ($dateCurrent5 >= $date) {
                        if ($corres2 = strtotime($_POST['dateCorrespondance2'])) {
                            $dateCorrespondance2 = date("Ymd", $corres2);
                        }
                    }




                    if ($dateCorrespondance2 != 'NULL') {
                        $update = "UPDATE dossier SET  DateCorrespondance=$dateCorrespondance ,DateCorrespondance2=$dateCorrespondance2, MontantRestitue=$montantRestitue, Matricule=$matricule,Cin='$cin1',NomPrenom='$nomPrenom',TypeDette='$typedette',MontantDemande=$montantDemande,MontantBloque=$montantBloque,Reste=$montantDemande-$montantRestitue,Etat='$etat',Controle=NULL,checked=NULL WHERE Matricule like  $mat";
                    } else {
                        $update = "UPDATE dossier SET  DateCorrespondance=$dateCorrespondance ,DateCorrespondance2=$dateCorrespondance2, MontantRestitue=$montantRestitue, Matricule=$matricule,Cin='$cin1',NomPrenom='$nomPrenom',TypeDette='$typedette',MontantDemande=$montantDemande,MontantBloque=$montantBloque,Reste=$montantDemande-$montantRestitue,Etat='$etat',Controle=NULL,checked=NULL WHERE Matricule like  $mat";
                    }











                    if (mysqli_query($connect, $update)) {
                        $montantMensuel = 0;
                        $montantAvance = 0;

                        if ($_POST['montantMensuel'] != "") {
                            $montantMensuel = $_POST['montantMensuel'];
                        }

                        if ($_POST['montantAvance'] != "") {
                            $montantAvance = $_POST['montantAvance'];
                        }


                        if ($_POST['DateDebut'] != "") {
                            $DateDebut = date('Ymd', strtotime($_POST['DateDebut']));
                        } else {
                            $DateDebut = NULL;
                        }


                        $Banque = $_POST['Banque'];

                        $du = date('Ymd', strtotime($_POST['du']));
                        $jusquau = date('Ymd', strtotime($_POST["jusquau"]));



                        if ($DateDebut != NULL) {

                            $update2 = "UPDATE paiement SET Matricule=$matricule,MethodePaiement='$methode',Banque='$Banque',MontantAPaye=$montantMensuel,MontantAvance=$montantAvance,DateDebut=$DateDebut,Du=$du,Jusquau=$jusquau WHERE Matricule like  $mat ";
                        } else {
                            $update2 = "UPDATE paiement SET Matricule=$matricule,MethodePaiement='$methode',Banque='$Banque',MontantAPaye=$montantMensuel,MontantAvance=$montantAvance,Du=$du,Jusquau=$jusquau WHERE Matricule like  $mat ";
                        }



                        if (mysqli_query($connect, $update2)) {
                            echo ("<meta http-equiv='refresh' content='0;  URL =Consulter?SuccessEdit&immat=$matricule'/>");
                            $dateCurrent = date('Y-m-d | H:i:s');

                            $titre = "Modification De Dossier";
                            $sujet = "Le dossier avec la matricule <strong><button type=\'submit\' name=\'Controlctrl\'  ><input type=\'hidden\' name=\'mat\' value=\'" . $matricule . "\'/> " . $matricule . "</button></strong> a été modifier le " . $dateCurrent . " par <strong>" . Session::get("nom") . "</strong> et il doit etre controle<br><br><h6>" . $dateCurrent . "</h6>";
                            $emetteur = Session::get("nom");
                            $recepteur = "CONTROLERTP";

                            $params = new ParametreController();
                            $params->AddNotification($titre, $sujet, $emetteur, $recepteur);
                        } else {
                            echo mysqli_error($connect);
                        }
                    } else {
                        echo mysqli_error($connect);
                    }
                } else {
                    echo (" <meta http-equiv='refresh' content='0;  URL =Consulter?invalidCIN&immat=$matricule' />");
                }
            } else {
                echo ("<meta http-equiv='refresh' content='0;  URL =Consulter?invalidMatricule&immat=$matricule'/>");
            }
        }
    }

    function DateCorres()
    {
        $session = $_GET["session"];
        $connect  = mysqli_connect('localhost', 'root', '') or die("Erreur de connexion avec la base de donnée");
        mysqli_select_db($connect, 'cnrps');
        $params = new ParametreController();
        $temp = date('Y-m-d | H:i', strtotime("+1 hours"));

        if ($session == "LIQUIDER") {
            $dateCurrent7 = date('Ymd H:i:s');

            $sql = "SELECT * From Dossier  Where DateCorrespondance2 is NULL ORDER BY id ASC ";
            $Dossier = mysqli_fetch_array(mysqli_query($connect, $sql));
            $array = $this->runQuery($sql);
            if (!empty($array)) {
                $dateCurrent5 = date("Y-m-d");

                foreach ($array as $key => $value) {
                    $basic = $array[$key]["DateCorrespondance"];
                    $basicPlus = date('Y-m-d', strtotime("+1 months", strtotime($basic)));
                    $date = date("Y-m-d", strtotime($basicPlus));
                    // Add 1 month to date
                    if ($array[$key]["Etat"] != "Paye" || $array[$key]["Etat"] != "en cours de paiement") {
                        if ($array[$key]["checked"] != 'true')
                            if ($basic != NULL) {
                                if ($dateCurrent5 > $date) {
                                    $id = $array[$key]["id"];
                                    mysqli_query($connect, "UPDATE dossier SET checked='true' where id like $id  ");
                                    $titre = "Date Correspondance 1 est dépassee";
                                    $sujet = "Le dossier avec la matricule <button type=\'submit\' name=\'ConsulterLiquid\' > <input type=\'hidden\' name=\'mat\' value=\'" . $array[$key]["Matricule"] . "\'/><strong>  " . $array[$key]["Matricule"] . "</strong></button> depasse la date de correspondance 1 : " . $array[$key]["DateCorrespondance"] . "<br><br><h6 style=\'float:right\'>" . $temp . "<h6>";
                                    $recepteur = "LIQUIDERTP";
                                    $emetteur = "";
                                    $params->AddNotification($titre, $sujet, $emetteur, $recepteur);
                                    echo "done2";


                                    $id = $array[$key]["id"];
                                    mysqli_query($connect, "UPDATE dossier SET checked='true' where id like $id  ");
                                }
                            }
                    }
                }
            }

            $sql1 = "SELECT * From Dossier  Where DateCorrespondance2 !='' ORDER BY id ASC ";
            $array1 = $this->runQuery($sql1);
            if (!empty($array1)) {

                $dateCurrent5 = date("Y-m-d");

                foreach ($array1 as $kk => $vv) {
                    $mat = $array1[$key]["Matricule"];

                    $basic = $array1[$kk]["DateCorrespondance2"];
                    $basicPlus = date('Y-m-d', strtotime("+1 months", strtotime($basic)));
                    $date = date("Y-m-d", strtotime($basicPlus));


                    // Add 1 month to date
                    if ($dateCurrent5 >= $date) {
                        $sql2 = "SELECT * From Paiement Where Matricule like $mat  ORDER BY id ASC";
                        $methode = mysqli_fetch_array(mysqli_query($connect, $sql2));

                        if ($methode["MethodePaiement"] != 'بطاقة إلزام' && $array1[$kk]["Etat"] != "Paye" && $array1[$kk]["Etat"] != "en cours de paiement") {
                            if ($array1[$kk]["checked"] != "true") {
                                $titre = "Date Correspondance 2 est depassée";
                                $sujet = "Le dossier avec la matricule
                                 <button type=\'submit\' name=\'ConsulterLiquid\' ><input type=\'hidden\' name=\'mat\' value=\'" . $array1[$kk]["Matricule"] . "\'/>  <strong>  " . $array[$kk]["Matricule"] . "</strong></button> depasse la date de correspondance 2 " . $array1[$kk]["DateCorrespondance2"] . "<br><br><h6> " . $temp . "</h6>";
                                $recepteur = "LIQUIDERTP";
                                $emetteur = "";
                                $params->AddNotification($titre, $sujet, $emetteur, $recepteur);
                                echo "done2";


                                $id = $array1[$kk]["id"];
                                mysqli_query($connect, "UPDATE dossier SET checked='true' where id like $id  ");
                            }
                        }
                    }
                }
            }
        }
    }


    function AjoutRecu()
    {
        $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
        mysqli_select_db($connect, 'cnrps');
        $matricule = $_GET["Matricule"];
        $num = $_POST["Rec"];
        $date = date('Ymd', strtotime($_POST["Date"]));
        $montant = $_POST["montant"];
        $etat=$_POST["etat"];



        $sql = "INSERT INTO recu (Matricule,NumRecu,Date,MontantPaye) values ($matricule,$num,$date,$montant)";
        $Result_rec = mysqli_query($connect, $sql);
        if ($Result_rec) {
            $select = "SELECT * from dossier where Matricule like $matricule ";

            $result_select = mysqli_query($connect, $select);
            if ($result_select) {
                $resultat = mysqli_fetch_array($result_select) or die(mysqli_error($connect));
                $totalpaye = $resultat["TotalPaye"];
                $nouveau = $totalpaye + $montant;
                $Update = "UPDATE dossier SET TotalPaye=$nouveau where  Matricule like $matricule ";


                $resultat_update = mysqli_query($connect, $Update);

                if ($resultat_update) {
                    $totalpaye =  mysqli_fetch_array(mysqli_query($connect, "SELECT * from dossier where Matricule like $matricule"));
                    $reste = mysqli_fetch_array(mysqli_query($connect, "SELECT * from dossier where Matricule like $matricule"));
                    $mnt = $reste["Reste"] - $totalpaye["TotalPaye"];

                    if ($mnt == 0) {
                        $update = mysqli_query($connect, "UPDATE dossier SET Etat='Paye' where Matricule like $matricule");
                    }
                    $Rec = "SELECT * from Recu WHERE Matricule like $matricule";
                    $count = mysqli_num_rows(mysqli_query($connect, $Rec));
                    if ($count != 0 && $reste['Etat'] == "Non Paye") {
                        $etat = "en cours de paiement";
                        $upd = "UPDATE dossier SET Etat='$etat' WHERE Matricule like $matricule";
                        mysqli_query($connect, $upd);
                    }
                    echo ("<meta http-equiv='refresh' content='0;  URL =Consulter?SuccessRec&immat=$matricule'/>");
                } else {
                    echo "Update" . mysqli_error($connect);
                }
            } else {
                echo "Dossier" . mysqli_error($connect);
            }
        } else {

            if($etat=="Paye" ){
            echo ("<meta http-equiv='refresh' content='0;  URL =Consulter?RecuExiste&matRec=".$matricule."#7'/>");

            }else{
            echo ("<meta http-equiv='refresh' content='0;  URL =Consulter?RecuExiste&immat=$matricule'/>");

            }

        }
    }


    function Process()
    {  $connect  = mysqli_connect('localhost', 'root', '') or die("Erreur de connexion avec la base de donnée");
        mysqli_select_db($connect, 'cnrps');

       


      
        $matricule = $_POST['matricule'];

        if ($_POST['cin'] == "") {
            $cin = '';
        } else {
            $cin = $_POST['cin'];
        }
        $methode = $_POST['Methode'];
        $nomPrenom = $_POST["nomprenom"];
        $typedette = $_POST["typedette"];
        $montantDemande = $_POST["montantDemande"];
        $montantBloque = $_POST["montantBloque"];
        $montantRestitue = $_POST['montantRestitue'];
        $ajoutepar = Session::get("id1");
        $etat = $_POST["etat"];
        $Banque = $_POST['Banque'];
        $dateCurrent = date('Ymd');
        $du = date('Ymd', strtotime($_POST['du']));
        $jusquau = date('Ymd', strtotime($_POST['jusquau']));
        $DateCorrespondance = 'NULL';
        if ($_POST['DateCorrespondance'] != "") {
            $DateCorrespondance = date('Ymd', strtotime($_POST['DateCorrespondance']));
        }








        if ($montantBloque == "") {
            $montantBloque = 0;
        }


        if ($methode != "بطاقة إلزام" && $methode != '') {




            if (strlen($matricule) < 8) {
                echo ("<meta http-equiv='refresh' content='0;  URL =AjouterDossier?invalidMatricule'/>");
            } else {

                $montantAvance = $_POST['montantAvance'];
                if ($montantAvance == "") {
                    $montantAvance = 0;
                }
               


                $reste = $montantDemande - $montantRestitue;
                $ajout1 = "INSERT INTO dossier (Matricule,Cin,NomPrenom,TypeDette,DateCorrespondance,MontantDemande,MontantBloque,MontantRestitue,Reste,Etat,AjoutePar,DateAjout) values($matricule,'$cin','$nomPrenom','$typedette',$DateCorrespondance,$montantDemande,$montantBloque,$montantRestitue,$reste,'$etat','$ajoutepar',$dateCurrent)";


                $verif_mat = "SELECT * from dossier where Matricule='$matricule'";
                $result_mat = mysqli_num_rows(mysqli_query($connect, $verif_mat));
                if ($cin != '') {
                    $verif_cin = "SELECT * from dossier where Cin='$cin'";
                    $result_cin = mysqli_num_rows(mysqli_query($connect, $verif_cin));
                } else {
                    $result_cin = 0;
                }

                if ($result_mat != 0 || $result_cin != 0) {
                    echo ("<meta http-equiv='refresh' content='0;  URL =AjouterDossier?DossierExiste'/>");
                } else {
                    $result1 = mysqli_query($connect, $ajout1);
                    if ($result1) {
                        $montantMensuel = $_POST['montantMensuel'];
                        if ($montantMensuel == "") {
                            $montantMensuel = 0;
                        }

                        if ($_POST['DateDebut'] == "") {
                            $DateDebut = 'NULL';
                        } else {
                            $DateDebut = date('Ymd', strtotime($_POST['DateDebut']));
                        }


                        $ajout2 = "INSERT INTO paiement (Matricule,MethodePaiement,Banque,MontantAPaye,MontantAvance,DateDebut,Du,Jusquau) Values($matricule,'$methode','$Banque',$montantMensuel,$montantAvance,$DateDebut,$du,$jusquau)";

$dateCurrent2 = date('Y-m-d h:i',strtotime(" +1 hour"));

                                $titre = "Un nouveau dossier doit être contrôlé";
                                $sujet = "Le dossier avec la matricule <button type=\'submit\' name=\'Controlctrl\' > <strong><input type=\'hidden\' name=\'mat\' value=\'" . $matricule . "\'/>  " . $matricule . "</strong></button> est bien ajouté le " . $dateCurrent2 . " et doit être controlé";
                                $emetteur = $ajoutepar;
                                $recepteur = "CONTROLERTP";
  $params = new ParametreController();

                        $result2 = mysqli_query($connect, $ajout2);
                        if ($result2) {
                              $params->AddNotification($titre, $sujet, $emetteur, $recepteur);

                                if($etat=="Paye" || $etat=="en cours de paiement"){
                                    return Redirect::to('Consulter?matRec='.$matricule.'&#7');


                                }else{
                                   return Redirect::to("Consulter?DossierAjouter&immat=".$matricule."");
                                
                                }
                                
                              
                          /*  $numRecu = $_POST["recu"];
                            if ($numRecu != "") {

                                $date = date('Ymd', strtotime($_POST["dateRecu"]));
                                $ajout3 = "INSERT INTO recu (Matricule,NumRecu,Date,MontantPaye) values ($matricule,$numRecu,$date,$MontantRecu)";


                                $done = mysqli_query($connect, $ajout3);
                                if ($done) {
                                    echo ("<meta http-equiv='refresh' content='0;  URL =AjouterDossier?DossierAjouter'/>");
                                    $dateCurrent2 = date('Y-m-d h:i');

                                    $titre = "Un nouveau dossier doit etre controlé";
                                    $sujet = "Le dossier avec la matricule <button type=\'submit\' name=\'Controlctrl\' > <strong><input type=\'hidden\' name=\'mat\' value=\'" . $matricule . "\'/>  " . $matricule . "</strong></button> est bien ajoute le " . $dateCurrent2 . " et doit etre controlee";
                                    $emetteur = $ajoutepar;
                                    $recepteur = "CONTROLERTP";
                                    $params = new ParametreController();
                                    $params->AddNotification($titre, $sujet, $emetteur, $recepteur);
                                } else {
                                    $DELETE1 = "DELETE from dossier where Matricule like $matricule";
                                    $DELETE2 = "DELETE from paiement where Matricule like $matricule";
                                    mysqli_query($connect, $DELETE1);
                                    mysqli_query($connect, $DELETE2);
                                    echo ("<meta http-equiv='refresh' content='0;  URL =AjouterDossier?RecuExiste'/>");
                                }
                            } else {
                                echo ("<meta http-equiv='refresh' content='0;  URL =AjouterDossier?DossierAjouter'/>");
                                $dateCurrent2 = date('Y-m-d h:i');

                                $titre = "Un nouveau dossier doit être contrôlé";
                                $sujet = "Le dossier avec la matricule <button type=\'submit\' name=\'Controlctrl\' > <strong><input type=\'hidden\' name=\'mat\' value=\'" . $matricule . "\'/>  " . $matricule . "</strong></button> est bien ajoute le " . $dateCurrent2 . " et doit etre controlee";
                                $emetteur = $ajoutepar;
                                $recepteur = "CONTROLERTP";
                                $params = new ParametreController();
                                $params->AddNotification($titre, $sujet, $emetteur, $recepteur);
                            } */
                        } else {
                            echo "Paiement " . mysqli_error($connect);
                            $DELETE1 = "DELETE from dossier where Matricule like $matricule";
                            mysqli_query($connect, $DELETE1);
                        }
                    } else {
                        echo "Dossier " . mysqli_error($connect);
                    }
                }
            }
        } else {
            $DateCorrespondance2 = 'NULL';
            if ($_POST['DateCorrespondance2'] != "") {
                $DateCorrespondance2 = date('Ymd', strtotime($_POST['DateCorrespondance2']));
            }

            $insert = "INSERT INTO dossier (Matricule,Cin,NomPrenom,TypeDette,DateCorrespondance,DateCorrespondance2,MontantDemande,MontantBloque,MontantRestitue,Etat,AjoutePar,DateAjout) values ($matricule,'$cin','$nomPrenom','$typedette',$DateCorrespondance,$DateCorrespondance2,$montantDemande,$montantBloque,$montantRestitue,'$etat','$ajoutepar',$dateCurrent)";
            $insert20 = "INSERT INTO paiement (Matricule,MethodePaiement,Banque,Du,Jusquau) values ($matricule,'$methode','$Banque',$du,$jusquau)";

            if (mysqli_query($connect, $insert)) {

                if (mysqli_query($connect, $insert20)) {
                    echo ("<meta http-equiv='refresh' content='0;  URL =Consulter?DossierAjouter&immat=".$matricule."'/>");
                    $dateCurrent2 = date('Y-m-d');

                    $titre = "Un nouveau dossier doit être contrôlé";
                    $sujet = "Le dossier avec la matricule <button type=\'submit\' name=\'Controlctrl\' > <strong> <input type=\'hidden\' name=\'mat\' value=\'" . $matricule. "\'/> " . $matricule . "</strong></button> est bien ajoute le " . $dateCurrent . " et doit etre controlée";
                    $emetteur = $ajoutepar;
                    $recepteur = "CONTROLER";
                    $params = new ParametreController();
                    $params->AddNotification($titre, $sujet, $emetteur, $recepteur);
                } else {
                    echo "paiement" . mysqli_error($connect);
                    $delete = "DELETE FROM dossier WHERE Matricule like $matricule";
                    mysqli_query($connect, $delete);
                }
            } else {
                echo "dossier" . mysqli_error($connect);
            }
        }
    
    }

    function VerifierExistance(){
       
        $connect  = mysqli_connect('localhost', 'root', '') or die("Erreur de connexion avec la base de donnée");
        mysqli_select_db($connect, 'cnrps');

        if(Input::has("query")){
 $query=Input::get("query");
          
        if($query=="matricule"){
  $val = Input::get("mat");
           
        return mysqli_num_rows(mysqli_query($connect,"SELECT * from dossier where Matricule like $val"));
    
        }elseif($query=="cin"){
 $val = Input::get("cin");
           
        return mysqli_num_rows(mysqli_query($connect,"SELECT * from dossier where Cin like $val"));
    
        }elseif($query=="recu"){
 $val = Input::get("recu");
           
        return mysqli_num_rows(mysqli_query($connect,"SELECT * from recu where NumRecu like $val"));
    
        }
      
    }
}
}

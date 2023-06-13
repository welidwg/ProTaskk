
<?php
$current = "consulterCarte";
$type=Session::get("type");
$tp=Session::get("tp");
use Illuminate\Support\Facades\Input;

if ($type == "LIQUIDER" && $tp== "OUI" || $type == "CONSULTER") {
?>

  <html lang="en">
@include("GestionDeParametre.nav");

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/GererDossier.css">

    <title>ProTask | Carte de suivi de dette</title>


  </head>

  <style>
 
        .styled-table {
            border-collapse: collapse;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            margin: auto;




        }

        .styled-table thead tr {
            background-color: #2f4f4f;
            color: #ffffff;
            text-align: center;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            text-align: center;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #2f4f4f;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #2f4f4f;
        }

        .styled-table tbody tr.active-row {
            font-weight: bold;
            color: #009879;
        }
  </style>

  <body>


    <?php
    $connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
    mysqli_select_db($connect, 'cnrps');

   



    if (isset($_GET["mat"]) || isset($_GET["immat"]) || isset($_GET['matRec']) ) {
      if (isset($_GET["mat"]) && Session::get('type') == "LIQUIDER") {
        $Input = $_GET["mat"];
      } elseif (isset($_GET["immat"])) {
        $Input = $_GET["immat"];
      }elseif (isset($_GET["matRec"])) {
        $Input = $_GET["matRec"];
      }
      else{
                $Input = 1;

      }
      $search1 = "SELECT * FROM dossier where Matricule like $Input ";
      $search2 = "SELECT * FROM Paiement where Matricule like $Input ";
      $search3 = "SELECT * FROM Recu where Matricule like $Input ";
      $matricule = $Input;

      $c = mysqli_fetch_array(mysqli_query($connect, "SELECT * from dossier where Matricule like $Input"));
      $cin = $c["Cin"];


      $result1 = mysqli_num_rows(mysqli_query($connect, $search1));

      $Dossier = mysqli_fetch_array(mysqli_query($connect, $search1));
      $Paiement = mysqli_fetch_array(mysqli_query($connect, $search2));
      $Recu = mysqli_fetch_array(mysqli_query($connect, $search3));








    ?>





      <fieldset>
        <legend>Données personnelles</legend>
        <ul class="list" style='list-style: none;'>

          <li> <label for="matricule">Matricule</label>

            <input class="input100" readonly value="<?php echo $Dossier["Matricule"] ?>" type="number" id="matricule" name="matricule" required="required" oninput="maxLengthCheck(this)" />
          </li>
          <li> <label for="cin">Carte d'Identité Nationale</label>
            <input class="input100" readonly value="<?php if ($Dossier["Cin"] == "") {
                                                      echo "Vide";
                                                    } else {
                                                      echo $Dossier["Cin"];
                                                    } ?>" type=" number" id="cin" name="cin" required="required" oninput="maxLengthCheck(this)" />
          </li>
          <br>

          <li>
            <label for="nom">Nom et prenom</label>
            <input class="input100" readonly  value="<?php echo $Dossier["NomPrenom"] ?>" type="text" name="nomprenom" minlength="6" required />
          </li>

          <li>
            <label for="">Type de la dette</label>
            <input class="input100" readonly value="<?php echo $Dossier["TypeDette"] ?>" type="text" name="" id="">
          </li>
          <br>
          <li>
            <label for="">Date Correspondance 1</label>
            <input class="input100" readonly value="<?php if ($Dossier["DateCorrespondance"] != NULL) {
                                                      echo $Dossier["DateCorrespondance"];
                                                    } else {
                                                      echo "Vide";
                                                    } ?>" type="text" name="" id="">
          </li>
          <li>
            <label for="">Date Correspondance 2</label>
            <input class="input100" readonly value="<?php if ($Dossier["DateCorrespondance2"] != NULL) {
                                                      echo $Dossier["DateCorrespondance2"];
                                                    } else {
                                                      echo "Vide";
                                                    } ?>" type="text" name="" id="">
          </li>
          <br>






        </ul>


      </fieldset>
      <fieldset>
        <legend>
          Paiement
        </legend>
        <ul class="list">

          <li>
            <label for="">Pension Servie Du</label>
            <input class="input100" readonly value="<?php echo $Paiement["Du"] ?>" type="text" name="" id="">
          </li>
          <li>
            <label for="">Jusqu'au</label>
            <input class="input100" readonly value="<?php echo $Paiement["Jusquau"] ?>" type="text" name="" id="">
          </li>
          <br>
          <li>
            <label for="">Méthode de paiement</label>
            <input id="methode" class="input100" readonly value="<?php if ($Paiement["MethodePaiement"] != '') {
                                                                    echo $Paiement["MethodePaiement"];
                                                                  } else {
                                                                    echo "Vide";
                                                                  }  ?> " type="text">
          </li>

          <li>
            <label for="">Banque</label>
            <input class="input100" readonly value="<?php echo $Paiement["Banque"] ?>" type="text">
          </li>
          <br>
          <li id="6">
            <label for="">Date debut</label>
            <input class="input100" readonly value="<?php if ($Paiement["DateDebut"] != NULL) {
                                                      echo $Paiement["DateDebut"];
                                                    } else {
                                                      echo "Vide";
                                                    }  ?> " name="DateDebut" type="text">
          </li>


        </ul>



      </fieldset>
      <fieldset>
        <legend>
          Les montants
        </legend>

        <ul class="list">

          <li>
            <label for="">Pension servie</label>
            <input class="input100" readonly value="<?php echo $Dossier["MontantDemande"]." DT" ?>" name="montantDemande" type="text">
          </li>


          <li>
            <label for="">Montant bloqué</label>
            <input class="input100" readonly value="<?php if ($Dossier["MontantBloque"] == "" || $Dossier["MontantBloque"] == 0) {
                                                      echo "----";
                                                    } else {
                                                      echo $Dossier["MontantBloque"]." DT";
                                                    } ?>" name="montantBloque" type="text">
          </li>
          <br>
          <li>
            <label for="">Montant restitué</label>
            <input class="input100" readonly value="<?php if ($Dossier["MontantRestitue"] == "" || $Dossier["MontantRestitue"] == 0) {
                                                      echo "----";
                                                    } else {
                                                      echo $Dossier["MontantRestitue"]." DT";
                                                    } ?>
              
              " name="montantrestitue" type="text">
          </li>

          <li id="1">
            <label for="">Reste</label>
            <input class="input100" readonly value="<?php if ($Dossier["Reste"] == "" || $Dossier["Reste"] == 0) {
                                                      echo "----";
                                                    } else {
                                                      echo $Dossier["Reste"]." DT";
                                                    } ?>" name="montantBloque" type="text">
          </li>
          <br>

          <li id="2">
            <label for="">Total Payé</label>
            <input class="input100" readonly value="<?php if ($Dossier["TotalPaye"] == "" || $Dossier["TotalPaye"] == 0) {
                                                      echo "----";
                                                    } else {
                                                      echo $Dossier["TotalPaye"]." DT";
                                                    } ?>" name="montantBloque" type="text">
          </li>




          <li id="3">
            <label for="">Reste pour cloture</label>
            <input class="input100" readonly value="<?php if($Dossier["MontantRestitue"]!="" && $Dossier["MontantRestitue"]!=0 ){echo $Dossier["Reste"] - $Dossier["TotalPaye"]." DT";}else{echo $Dossier["MontantDemande"]-$Dossier["TotalPaye"]." DT";}  ?>" name="montantBloque" type="text">
          </li>
          <br>


          <li id="4">

            <label for="">Montant par tranche/mois/trimestre</label>
            <input class="input100" readonly value="<?php if ($Paiement["MontantAPaye"] == "" || $Paiement["MontantAPaye"] == 0) {
                                                      echo "----";
                                                    } else {
                                                      echo $Paiement["MontantAPaye"]." DT";
                                                    } ?> " name='montantMensuel' type="text">
          </li>


          <li id="5">
            <label for="">Montant payé en avance</label>
            <input class="input100" readonly value="<?php if ($Paiement["MontantAvance"] == "" || $Paiement["MontantAvance"] == 0) {
                                                      echo "----";
                                                    } else {
                                                      echo $Paiement["MontantAvance"]." DT";
                                                    } ?> " name="montantAvance" type="text">
          </li>
        </ul>







      </fieldset>
      <fieldset>
        <legend>Etat de dossier</legend>
        <ul class="list">
          <li>
            <label for="">L'Etat du dossier:</label>
            <input style="max-width: 300px; width:auto" class="input100" readonly value="<?php echo $Dossier["Etat"] ?>" type="text" name="" id="">
          </li>
        </ul>

      </fieldset>
      <?php if ($Dossier["Etat"] == "en cours de paiement" || $Dossier["Etat"] == "Paye" ||isset($_GET["matRec"])) { ?>
        <fieldset class="Hist" id="7">

          <legend>Historique de paiement</legend>
          <ul class="list">
            <li>

              <table class="styled-table">
                <thead>
                  <tr>
                    <th>N° Reçu</th>
                    <th>Date</th>
                    <th>Montant Payé</th>

                  </tr>
                </thead>
                <tbody>


                  <?php

                  $array = runQuery("SELECT * from recu Where Matricule like $Input  ORDER BY id ASC");
                  $verif_etat = mysqli_fetch_array(mysqli_query($connect, "SELECT Etat from dossier where Matricule like $Input "));



                  if (!empty($array)) {
                    foreach ($array as $key => $value) {
                  ?>
                      <tr class="active-row">
                        <td><input readonly value="<?php echo $array[$key]["NumRecu"] ?>" type="text" name="recu" id=""></td>
                        <td><input readonly value="<?php echo $array[$key]["Date"] ?>" type="text" name="dateRecu" id=""></td>
                        <td><input readonly value="<?php echo $array[$key]["MontantPaye"] . " DT" ?>" type="text" name="montantRecu" id=""></td>
                      </tr>

                  <?php }
                  }
                  ?>

                  <!-- and so on... -->
                  <?php
                  if ($verif_etat[0] != "Paye" && $type == "LIQUIDER" || isset($_GET["matRec"])) {

                  ?>

                    <form action="AjoutRecu?<?php echo "Matricule=" . $matricule . ""; ?>" method="POST">
                    {{ csrf_field() }}
                      <tr class="recuAdd">
                        
                        <input type="hidden" value="<?php echo $Dossier["Etat"] ?>" name="etat">


                        <td><input placeholder="Numero reçu" type="number" name="Rec" required></td>
                        <td><input placeholder="Date" type="date" name="Date" required></td>
                        <td><input placeholder="Montant"  min="<?php if($Dossier["Etat"]!="Paye"){ if($Paiement["MontantAPaye"]!=""){echo $Paiement["MontantAPaye"];}}else{ if($Dossier["Reste"]!="" && $Dossier["Reste"]!=0){echo $Dossier["Reste"]; }else{echo $Dossier["MontantDemande"];}} ?>" type="number" name="montant" max="<?php   if($Dossier["Reste"]=="" && $Dossier["Reste"]==0){echo $Dossier["MontantDemande"];}else{echo $Dossier["Reste"] - $Dossier["TotalPaye"] ;}  ?>" required></td>

                      </tr>



                </tbody>
              </table>
              <button class="login100-form-btn" type="submit" name="ajoutRecu">Ajouter reçu</button>
              </form>
              <br>
              <?php if(isset($_GET["matRec"]) && !isset($_GET["RecuExiste"])){ ?>
                <div style="text-align: center;">
                <a href="" style="color:limegreen;padding:5px;font-size:15px">Dossier bien ajouté, vous pouvez ajouter un reçu maintenant.</a>
                <br>

               </div>

            <?php }elseif(isset($_GET["RecuExiste"])){ ?>
              <a href="" style="color:red;padding:5px;font-size:15px">Numéro de reçu existant !</a>
                <br>
           <?php }
          } ?>



            </li>
          </ul>
        </fieldset>
    <?php
      }
    }

    ?>

    <script src="choices.js"></script>
    <script>
      const choices = new Choices('[data-trigger]', {
        searchEnabled: false,
        itemSelectText: '',
      });

      function maxLengthCheck(object) {
        if (object.value.length > object.maxLength) {
          object.value = object.value.slice(0, 10)


        }
      }

      function show() {
        document.getElementById("tableRec").style.display = "block";
        document.getElementById("hist").onclick = function() {
          document.getElementById("tableRec").style.display = "none";

        };



      }
    </script>
    <script>
      document.getElementById("etat").href = "ImprimerEtat?Matricule=<?php echo $Dossier["Matricule"] ?>"
      document.getElementById("carte").href = "ImprimerCarteSuivi?Matricule=<?php echo $Dossier["Matricule"] ?>"

    </script>

    @if ($Dossier["Etat"] != "Paye" || $Dossier["Controle"] == "Refuser") { 
       <script>
        document.getElementById("modif").style.display = "block";
        document.getElementById("modif").href = "ModifierDossier?matricule=<?php echo $Dossier["Matricule"]; ?>"
       </script>
    @else
       <script>
                document.getElementById("modif").style.cursor="not-allowed"

       </script>
       @endif

  </body>
  <?php } else {?>
      @include("Error");
    <?php } ?>

  </html>
<?php
$current = "modifierDossier";
if (Session::get("type") == "LIQUIDER" && Session::get("tp")  == "OUI") {
?>

    <html lang="en">

    <head>
        @include("GestionDeParametre.nav");

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="Stylesheet" href="CSS/GererDossier.css" />


        <title>ProTask | Modifier Dossier</title>

    </head>

    <style>
       

       

        


        .login100-form-btn {
            font-family: Montserrat-Bold;
            font-size: 20px;
            line-height: 1.5;
            color: #fff;
            text-transform: uppercase;
            width: 3%;
            height: 50px;
            border-radius: 50%;
            background: #2f4f4f;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            position: fixed;
            bottom: 0;
            top: 50%;
            right: 2px;
            display: flex;
            align-self: center;
            justify-content: center;
            align-items: center;
            padding-top: 20px;
            padding-bottom: 20px;

            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;

        }

        .login100-form-btn:hover {
            background: #fff;
            color: #2f4f4f;
            border: solid 1px #2f4f4f;
        }
    </style>

    <body>
        <form action="EditFolder" method="POST">
            {{ csrf_field() }}
            <h1>Modifier dossier</h1>


            <?php
            $connect  = mysqli_connect('localhost', 'root', '') or die("Erreur de connexion avec la base de donnée");
            mysqli_select_db($connect, 'cnrps');

            $mat = $_GET['matricule'];

            $search1 = "SELECT * FROM dossier where Matricule like  $mat ";
            $search2 = "SELECT * FROM Paiement where Matricule like  $mat";
            $search3 = "SELECT * FROM Recu where Matricule like  $mat ";

            $Dossier = mysqli_fetch_array(mysqli_query($connect, $search1));
            $Paiement = mysqli_fetch_array(mysqli_query($connect, $search2));
            $Recu = mysqli_fetch_array(mysqli_query($connect, $search3));

            $exist = mysqli_num_rows(mysqli_query($connect, $search1));
            if ($exist != 0) {







            ?>
            <input type="hidden" name="mat" value="<?php echo $mat ?>">
                <fieldset>
                    <legend>Données personnelles</legend>
                    <ul class="list" style='list-style: none;'>

                        <li> <label for="matricule">Matricule</label>

                            <input value="<?php echo $Dossier["Matricule"]; ?>" class="input100" type="number" id="matricule" name="matricule" required="required" oninput="maxLengthCheck(this)" />
                        </li>
                        <li> <label for="cin">CIN</label>
                            <input pattern="([0-9]|[0-9]|[0-9])" min="1111111" max="999999999" value="<?php echo $Dossier["Cin"]; ?>" class="input100" type="number" id="cin" name="cin" oninput="maxLengthCheckCIN(this)" />
                        </li>
                        <br>
                        <li>
                            <label for="nom">Nom et prenom</label>


                            <input  value="<?php echo $Dossier["NomPrenom"]; ?>" class="input100" type="text" id="nom" name="nomprenom" minlength="6" required />


                        </li>

                        <script>
                            $(document).ready(function(){
                                $('#typeD > option:selected').each(function() {
                                    if($(this).text()=="Retraite"){
                                        $('#T2').css("display","none");
                                    }else if($(this).text()=="Veuve"){
                                        $('#T3').css("display","none");
                                    }else if($(this).text()=="Orphelin"){
                                        $('#T4').css("display","none");
                                    }

                                    
                                   });

                            });
                        </script>

                        <li>
                            <label for="">Type de la dette</label>
                            <select id="typeD" data-trigger=""  value="" name="typedette" class="input100">
                                <option ><?php echo $Dossier["TypeDette"]; ?></option>
                                <option id="T2">Retraite</option>
                                <option id="T3">Veuve</option>
                                <option id="T4">Orphelin</option>
                            </select>
                        </li>
                        <br>


                        <li>
                            <label for="nom">Date Correspondance</label>


                            <input value="<?php if ($Dossier["DateCorrespondance"] != "1970-01-01") {
                                                echo $Dossier["DateCorrespondance"];
                                            }  ?>" class="input100" type="date" name="dateCorrespondance" minlength="6" />


                        </li>

                        <?php $dateCurrent5 = date("Y-m-d");
                        $basic = $Dossier["DateCorrespondance"];
                        $basicPlus = date('Y-m-d', strtotime("+1 months", strtotime($basic)));
                        $date = date("Y-m-d", strtotime($basicPlus));

                        if ($dateCurrent5 >= $date) {



                        ?>

                            <li id="8">
                                <label for="nom">Date Correspondance 2</label>


                                <input value="<?php echo $Dossier["DateCorrespondance2"]; ?>" class="input100" type="date" name="dateCorrespondance2" minlength="6" />


                            </li>
                        <?php }
                        ?>

                        <input type="hidden" value="<?php echo $date ?>" name="dateBasic">

                    </ul>









                </fieldset>
                <fieldset>
                    <legend>
                        Paiement
                    </legend>
                    <ul class="list">
                        <li>
                            <label for="">Méthode de paiement</label>
                            <select id="Meth"  data-trigger="" name="Methode" class="input100">
                                <option value="<?php echo $Paiement["MethodePaiement"]; ?>"><?php echo $Paiement["MethodePaiement"]; ?></option>

                                <option id="m2" value="" >Aucune methode</option>
                                <option id="m3" value="une seule tranche">une seule tranche</option>
                                <option id="m4" value="Mensuelle">Mensuelle</option>
                                <option id="m5" value="Trimestrielle">Trimestrielle</option>
                                <option id="m6" value="Multi Tranches">Multi Tranches</option>
                                <option id="m7" value="بطاقة إلزام"> بطاقة إلزام</option>
                            </select>

                            <script>
                            $(document).ready(function(){
                                $('#Meth > option:selected').each(function() {
                                    if($(this).val()==""){
                                        $('#m2').css("display","none");
                                    }else if($(this).text()=="Multi Tranches"){
                                        $('#m6').css("display","none");
                                    }else if($(this).text()=="une seule tranche"){
                                        $('#m3').css("display","none");
                                    }
                                    else if($(this).text()=="Mensuelle"){
                                        $('#m4').css("display","none");
                                    }else if($(this).text()=="Trimestrielle"){
                                        $('#m5').css("display","none");
                                    }
                                    else if($(this).text()=="بطاقة إلزام"){
                                        $('#m7').css("display","none");
                                    }

                                    
                                   });

                            });
                        </script>
                        </li>

                        <li>
                            <label for="">Banque</label>
                            <select data-trigger="" name="Banque" class="input100">
                                <option><?php echo $Paiement["Banque"]; ?></option>
                                <option>STB</option>
                                <option>POSTE</option>
                                <option>BIAT</option>
                                <option>UIB</option>
                                <option>AMEN BANQUE</option>
                                <option>Banque d'Habitat BH</option>
                                <option>ATB</option>
                                <option>BTS</option>
                                <option>ZITOUNA BANQUE</option>
                                <option>WIFAK BANQUE</option>
                                <option>BNA</option>
                            </select>
                        </li>
                        <br>
                        <li>
                            <label for="">Pension Servi Du</label>
                            <input value="<?php echo $Paiement["Du"]; ?>" name="du" type="date" class="input100" required>
                        </li>
                        <li>
                            <label for="">Jusqu'au</label>
                            <input value="<?php echo $Paiement["Jusquau"]; ?>" name="jusquau" type="date" class="input100" required>
                        </li>
                        <br>
                        <li id="1">
                            <label for="">Date debut</label>
                            <input value="<?php if ($Paiement["DateDebut"] != "") {
                                                echo $Paiement["DateDebut"];
                                            }  ?>" name="DateDebut" type="date" class="input100">
                        </li>
                    </ul>



                </fieldset>
                <fieldset>
                    <legend>
                        Les montants
                    </legend>

                    <ul class="list">

                        <li>
                            <label for=""> Pension servie (DT)</label>
                            <input min="100" max="100000" value="<?php echo $Dossier["MontantDemande"]; ?>" name="montantDemande" type="number" class="input100" required>
                        </li>

                        <li>
                            <label for="">Montant bloqué (DT)</label>
                            <input min="0" max="100000" value="<?php echo $Dossier["MontantBloque"]; ?>" name="montantBloque" type="number" class="input100">
                        </li>
                        <br>

                        <li id="">
                            <label for="">Montant Restitué (DT)</label>
                            <input min="0" max="100000" value="<?php echo $Dossier["MontantRestitue"]; ?>" name="montantRestitue" type="number" class="input100">
                        </li>

                        <li id="MM">

                            <label for="">Montant par <br> Mois /Tranche/Trimestre (DT)</label>
                            <input min="0" max="2000" value="<?php echo $Paiement["MontantAPaye"]; ?>" name='montantMensuel' type="number" class="input100">
                        </li>
                        <br>

                        <li id="MA">
                            <label for="">Montant payé en avance (DT)</label>
                            <input min="0" max="2000" value="<?php echo $Paiement["MontantAvance"]; ?>" name="montantAvance" type="number" class="input100">
                        </li>

                    </ul>







                </fieldset>
                <fieldset>
                    <legend>Etat de dossier</legend>
                    <ul class="list">
                        <li>
                            <label for="">L'Etat du dossier:</label>
                            <select id="etat" data-trigger="collapse" name="etat" class="input100">
                                <option id="base"><?php echo $Dossier["Etat"]; ?></option>
                                <option id="paye" value="Paye">Payé</option>
                                <option id="nonpaye" value="Non Paye">non Payé</option>
                                <option id="encours">en cours de paiement</option>
                                <option id="correspondance">correspondance</option>
                            </select>
                        </li>

                        <script>
                            $(document).ready(function(){
                                $('#etat > option:selected').each(function() {
                                    if($(this).val()=="Paye"){

                                        $('#paye').css("display","none");

                                    }else if($(this).val()=="Non Paye"){

                                        $('#nonpaye').css("display","none");

                                    }else if($(this).text()=="en cours de paiement"){
                                        $('#encours').css("display","none");
                                    }
                                    else if($(this).text()=="correspondance"){
                                        $('#correspondance').css("display","none");
                                    }

                                    
                                   });

                            });
                        </script>

                        
                    </ul>

                </fieldset>
                <input type="hidden" name="OrgMat" value="<?php echo $Dossier["Matricule"] ?>">
                <input type="hidden" name="idDossier" value="<?php echo $Dossier["id"] ?>">
                <li>
                    <button id="edit" class="login100-form-btn" type="submit" name="modifier" style="cursor:pointer;"> <i class="fa fa-save"></i>
                    </button>
                </li>
        </form>
    <?php
               
            } else {
                echo "<h3>Dossier inexistant ! </h3>";
            }


    ?>




    </body>
    <script>
        function maxLengthCheck(object) {
            if (object.value.length > object.maxLength) {
                object.value = object.value.slice(0, 10)


            }
        }

        function maxLengthCheckCIN(object) {
            if (object.value.length > object.maxLength) {
                object.value = object.value.slice(0, 8)


            }
        }
    </script>
    <script>
        function Hide(that) {
            if (that.value == "Mensuelle" || that.value == "Trimestrielle" || that.value == "Multi Tranches") {
                document.getElementById("MM").style.display = "inline";

            } else {
                document.getElementById("MM").style.display = "none";
            }




            if (that.value == "بطاقة إلزام") {
                document.getElementById("MM").style.display = "none";
                document.getElementById("MA").style.display = "none";
                document.getElementById("1").style.display = "none";
                document.getElementById("8").style.display = "inline";



            } else if (that.value == "une seule tranche") {
                document.getElementById("MM").style.display = "none";
                document.getElementById("MA").style.display = "none";
                document.getElementById("8").style.display = "none";





            } else if (that.value == "") {
                document.getElementById("MM").style.display = "none";
                document.getElementById("MA").style.display = "none";
                document.getElementById("1").style.display = "none";
                document.getElementById("8").style.display = "none";


            } else {
                document.getElementById("MM").style.display = "inline";
                document.getElementById("MA").style.display = "inline";
                document.getElementById("1").style.display = "inline";

                document.getElementById("8").style.display = "none";

            }



        }
    </script>
    <script>
    $(document).ready(function(){

            $('#nom').on("keyup",function(){
var str = $(this).val();
  if(str.match(".*\\d.*")){
      $("#edit").attr("disabled",true);
      $("#edit").css("background-color","grey")
      $("#edit").css("cursor","not-allowed")
      $(this).css("color","red");


  }else{
      $("#edit").removeAttr("disabled");
            $("#edit").css("background-color","#002752");
            $("#edit").css("cursor","pointer");
      $(this).css("color","black");



  }
            })

  
  

    });
    </script>

<?php  } else {?>
    @include("Error");
<?php
} ?>




    </html>
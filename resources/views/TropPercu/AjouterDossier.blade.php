<?php
$current = "ajouterDossier";
    if (Session::get("type") == "LIQUIDER" && Session::get("tp") == "OUI") {
?>

        <html lang="en">
           @include("GestionDeParametre.nav");

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link rel="Stylesheet" href="CSS/GererDossier.css" />
                                               <script src="js/jquery.js" type="text/javascript"></script>





            <title>ProTask | Ajouter Dossier</title>

        </head>

        <style>
           
        </style>

        <body>

            <form action="Process" method="POST" >
                {{ csrf_field() }}

                <h1>Ajouter un dossier</h1>
                <fieldset>
                    <legend>Données personnelles</legend>
                    <ul class="list" style='list-style: none;'>

                        <li > <label for="matricule" id="labelMat">Matricule</label>

                            <input class="input100" type="number" id="matricule" name="matricule" required="required" oninput="maxLengthCheck(this)" />
                             
                        </li>
                        <li> <label for="cin">CIN</label>
                            <input class="input100" type="number" id="cin" name="cin" oninput="maxLengthCheckCIN(this)" />
                        </li>
                        
                        <br>
                    
                        <p style="color:red;padding: 5px;display: none;" id="length" >*Longueur de matricule non valide</p>
                       <p style="color:red;padding: 5px;display: none;" id="invalid" >*Matricule existante</p>

                       <p style="color:red;padding: 5px;display: none;" id="lengthCIN" >*Longueur de cin non valide</p>
                       <p style="color:red;padding: 5px;display: none;" id="invalidCIN" >*Cin existante</p>

                        <script>
                            
                            $(document).ready(function(){
                                
                                $('#matricule').on('keyup',function(){
                                    var val=$(this).val();
                                     $.ajax({
                    url: "<?php echo url('CHECK'); ?>",
                    data: {
                        mat: val,
                        query:"matricule"



                    },
                    type: "GET",
                    success: function(data) {

                        if(data>0){
                            $("#matricule").css("color","red");
                            
                         $("#invalid").css("display","block");
                        $("#length").css("display","none");

                        $("#subAjout").attr("disabled",true);




                        }else if(data==0) {
                            if(val.length <8){
  $("#matricule").css("color","red");
                           $("#length").css("display","block")
                            $("#invalid").css("display","none");
                        $("#subAjout").attr("disabled",true);



                            

                            }else{
  $("#matricule").css("color","limegreen");
                                $("#length").css("display","none")
                                 $("#invalid").css("display","none");
                                 $("#subAjout").removeAttr("disabled");


                            }
                          


                        }
                        
                        
                        
                    }

                })

                                })


                                   $('#cin').on('keyup',function(){
                                    var val=$(this).val();
                                     $.ajax({
                    url: "<?php echo url('CHECK'); ?>",
                    data: {
                        cin: val,
                        query:"cin"



                    },
                    type: "GET",
                    success: function(data) {
                        $("#lengthCIN").css("display","none")
                                 $("#invalidCIN").css("display","none");
                        if(val!=''){

                        if(data>0){
                            $("#cin").css("color","red");
                                                    $("#subAjout").attr("disabled",true);

                            
                         $("#invalidCIN").css("display","block");
                        $("#lengthCIN").css("display","none")



                        }else if(data==0) {
                            if(val.length <8){
  $("#cin").css("color","red");
                          $("#subAjout").attr("disabled",true);

                           $("#lengthCIN").css("display","block")
                            $("#invalidCIN").css("display","none");


                            

                            }else{
  $("#cin").css("color","limegreen");
                                $("#lengthCIN").css("display","none")
                                 $("#invalidCIN").css("display","none");
                                                         $("#subAjout").removeAttr("disabled");



                            }
                          


                        }
                    }
                        
                           
                    }

                })
                                                $('#cin').on('keydown',function(){
                               $("#lengthCIN").css("display","none")
                                 $("#invalidCIN").css("display","none");

                                                })

                                               


                                })

 $('#matricule').on('keydown',function(){
                               $("#length").css("display","none")
                                 $("#invalid").css("display","none");

                                                })

                               
                            })
                           
                        </script>
                        <li>
                            <label for="nom">Nom et prenom</label>


                            <input id="nom" class="input100" type="text" name="nomprenom" minlength="6" required />


                        </li>

                        <li>
                            <label for="">Type de la dette</label>
                            <select data-trigger="" name="typedette" class="input100">
                                <option>Retraite</option>
                                <option>Veuve</option>
                                <option>Orphelin</option>
                            </select>
                        </li>
                        <br>
                        <li>
                            <label for=""> Date de correspondance</label>
                            <input class="input100" type="date" name="DateCorrespondance" />

                        </li>
                        <li id="8" style="display:none;">
                            <label for=""> Date de correspondance 2</label>
                            <input class="input100" type="date" name="DateCorrespondance2" />

                        </li>

                    </ul>









                </fieldset>
                <fieldset>
                    <legend>
                        Paiement
                    </legend>
                    <ul class="list">
                        <li>
                            <label for="">Méthode de paiement</label>
                            <select onload="Hide(this)" onchange="Hide(this)" data-trigger="" name="Methode" class="input100">
                                <option value="">Aucune</option>
                                <option value="une seule tranche">une seule tranche</option>
                                <option value="Mensuelle">Mensuelle</option>
                                <option value="Trimestrielle">Trimestrielle</option>
                                <option value="Multi Tranches">Multi Tranches</option>
                                <option value="بطاقة إلزام">بطاقة إلزام</option>
                            </select>
                        </li>

                        <li>
                            <label for="">Banque</label>
                            <select data-trigger="" name="Banque" class="input100">
                                <option>STB</option>
                                <option>POSTE</option>
                                <option>BIAT</option>
                                <option>UIB</option>
                                <option>AMEN BANQUE</option>
                                <option>BH</option>
                                <option>ATB</option>
                                <option>BTS</option>
                                <option>ZITOUNA BANQUE</option>
                                <option>WIFAK BANQUE</option>
                                <option>BNA</option>
                            </select>
                        </li>
                        <br>


                        <li>
                            <label for="">Pension servie du</label>
                            <input name="du" type="date" class="input100" required>
                        </li>
                        <li>
                            <label for="">jusqu'au</label>
                            <input name="jusquau" type="date" class="input100" required>
                        </li>
                        <br>
                        <li id="1" style="display:none;">
                            <label for="">Date debut</label>
                            <input name="DateDebut" type="date" class="input100">
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
                            <input min="100" max="100000" name="montantDemande" type="number" class="input100">
                        </li>

                        <li>
                            <label for="">Montant bloqué</label>
                            <input min="0" max="100000" name="montantBloque" type="number" class="input100">
                        </li>
                        <br>
                        <li>
                            <label for="">Montant restitué</label>
                            <input min="0" max="100000" name="montantRestitue" type="number" class="input100" required>
                        </li>

                        <li id="MM" style="display:none;">

                            <label for="">Montant par <br> Mois /Tranche/Trimestre </label>
                            <input min="50" max="2000" name='montantMensuel' type="number" class="input100">
                        </li>


                        <br>

                        <li id="MA" style="display:none;">
                            <label for="">Monatnt payé en avance</label>
                            <input min="0" max="10000" name="montantAvance" type="number" class="input100">
                        </li>

                    </ul>







                </fieldset>
                <fieldset>
                    <legend>Etat de dossier</legend>
                    <ul class="list">
                        <li>
                            <label for="">L'Etat du dossier:</label>
                            <select onchange="Corress(this)" data-trigger="" name="etat" id="etat" class="input100">
                                <option>-------</option>
                                <option value="Paye">Payé</option>
                                <option value="Non Paye">non Payé</option>
                                <option>en cours de paiement</option>
                                <option value="correspondance">correspondance</option>
                            </select>
                        </li>
                    </ul>

                </fieldset>


                <!-- <fieldset id="2" style="display:none;">
                    <legend>Table de reçu</legend>
                    <ul class="list">
                        <li>
                            <table>
                                <tr>
                                    <td>
                                        <table class="styled-table" align="center">
                                            <thead>
                                                <tr>
                                                    <th>N° Reçu</th>
                                                    <th>Date</th>
                                                    <th>Montant Payé</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="active-row">
                                                    <td><input id="numRecu" type="text" name="recu" id="">
                                                </td>
                                                    <td><input type="date" name="dateRecu" id=""></td>
                                                    <td><input type="number" name="montantRecu" id=""></td>
                                                
                                                </tr>

                                                


                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr class='container'>

                                    <td>

                                     <p style="color:red;padding:4px;display:none" id="invalideRecu">*numéro de reçu existant</p>



                                    </td>
                                </tr>


                            </table>
                        </li>

                    </ul>

                </fieldset> -->
                <li>
                    <button id="subAjout" class="login100-form-btn" type="submit" name="ajouter" style="cursor:pointer;"> Ajouter
                    </button>
                </li>
            </form>



        </body>
        <script>
             $(document).ready(function(){

            $('#nom').on("keyup",function(){
var str = $(this).val();
  if(str.match(".*\\d.*")){
      $("#subAjout").attr("disabled",true);
      $("#subAjout").css("background-color","grey")
      $("#subAjout").css("cursor","not-allowed");
      $(this).css("color","red");


  }else{
      $("#subAjout").removeAttr("disabled");
            $("#subAjout").css("background-color","#002752");
            $("#subAjout").css("cursor","pointer");
      $(this).css("color","black");



  }
            })

  
  

    });
        </script>
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
            function Corress(that) {
                if (that.value == "correspondance" || that.value == "Non Paye") {
                    document.getElementById("2").style.display = "none";

                } else {
                    document.getElementById("2").style.display = "block";

                }
            }



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
                    document.getElementById("2").style.display = "none";
                    document.getElementById("8").style.display = "inline";



                } else if (that.value == "une seule tranche") {
                    document.getElementById("MM").style.display = "none";
                    document.getElementById("MA").style.display = "none";
                    document.getElementById("8").style.display = "none";
                    document.getElementById("2").style.display = "block";





                } else if (that.value == "") {
                    document.getElementById("MM").style.display = "none";
                    document.getElementById("MA").style.display = "none";
                    document.getElementById("1").style.display = "none";
                    document.getElementById("2").style.display = "none";
                    document.getElementById("8").style.display = "none";


                } else {
                    document.getElementById("MM").style.display = "inline";
                    document.getElementById("MA").style.display = "inline";
                    document.getElementById("1").style.display = "inline";
                    document.getElementById("2").style.display = "block";
                    document.getElementById("8").style.display = "none";

                }



            }
        </script>


<?php  } else {?>
    @include("Error");
<?php
} ?>







        </html>
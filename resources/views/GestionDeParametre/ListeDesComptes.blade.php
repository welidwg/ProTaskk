<?php
        use Illuminate\Support\Facades\Input;
$connect = mysqli_connect('127.0.0.1', 'root', '') or die(mysqli_error($connect));
mysqli_select_db($connect, 'cnrps');
$current = "ListeDesComptes";
if (Session::get('type')== "CHEF CENTRE") {

?>


    <html lang="en">
@include("GestionDeParametre.nav");

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ProTask | Liste des comptes</title>

        <style>
         


            /* Modal Content */
        </style>
    </head>

    <body>
        <div id="hideMe">



        </div>

        <main>
            <style>
                 html{zoom:1}
                .fix {
                    position: sticky;
                    top: 0;
                    background-color: white;
                    z-index: 1;
                }

                .tableFixHead {
                    overflow-y: auto;
                    height: 500px;

                }

                .tableFixHead thead th {
                    position: sticky;
                    top: 0;
                    z-index: 1;
                    background-color: white;
                }
            </style>
            <!--MDB Tables-->
            <div class="container" >




                <div class="card mb-4">
                    <div class="card-body">

                        <div class="fix" style="z-index:0">
                            <div class="row" >
                                <!-- Grid row -->
                                <!-- Grid column -->
                                <div class="col-md-12">

                                    <h2 style="color:grey; font-size:25px"><i class="fas fa-user-circle" style="color: green"> </i> Liste des comptes</h2>

                                    <div class="input-group md-form form-sm form-2 pl-0">
                                        <input onkeyup="Search()" class="form-control my-0 py-1 pl-3 purple-border" type="text" placeholder="Recherche..." id="input" aria-label="Search">
                                        <span id='btn' class="input-group-addon waves-effect purple lighten-2" id="basic-addon1"><a><i class="fa fa-search white-text" aria-hidden="true"></i></a></span>
                                    </div>
                                </div>
                                <!-- Grid column -->

                            </div>
                            <!-- Grid row -->
                            <!--Table-->
                            <div id="myTable" class="tableFixHead" style="height:300px">
                                <table class="table table-striped" style="overflow-y:scroll;height:400px;">
                                    <!--Table head-->
                                           <script>
                                        $(document).ready( function () {
    $('#myTable').DataTable({bFilter: false, bInfo: false,bPaginate: false});
} );</script>
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>Identifiant</th>
                                            <th>Nom et Prenom</th>
                                            <th>Type</th>
                                            <th>Email</th>
                                            <th>Accés au Trop Perçu</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <!--Table head-->
                                    <!--Table body-->
                                    <tbody>
                                        <?php



                                        $array = runQuery("SELECT * from utilisateurs ORDER BY id ASC");
                                        if (!empty($array)) {
                                            foreach ($array as $key => $value) {
                                        ?>
                                                <tr class="data" style="text-align: center;">
                                                    <th scope="row"><?php echo $array[$key]["identifiant"] ?></th>
                                                    <td><?php echo $array[$key]["Nom"] ?></td>
                                                    <td><?php echo $array[$key]["type"] ?></td>
                                                    <td><?php if ($array[$key]["email"] == "") {
                                                            echo "------";
                                                        } else {
                                                            echo $array[$key]["email"];
                                                        } ?></td>
                                                    <td><?php if ($array[$key]["TropPercu"] == "OUI") {
                                                            echo "<i style='color:green' class='fa fa-check'></i>";
                                                        } else {
                                                            echo "<i style='color:red' class='fa fa-times'></i>";
                                                        } ?> </td>
                                                    <td style="width: 100px;display: inline-flex;">
                                                              <a id="EDIT" href="?EDIT=<?php echo  $array[$key]["id"] ?>" class="myBtn" style="cursor : pointer;" name="edit " id="EDIT" value="edit"><i class="fa fa-edit" style="color:green;width:20px;font-size: 20px"></i>
                                                                    
                                                              </a>
                                                        
                                                        <form method="post" action="DeleteAccount">
                                                            <div>

                                                                <button style=" cursor:pointer;" type="submit" name="delete" onclick="return confirm('Vous êtes sur de supprimer ce compte ?'); " value="delete" formaction="DeleteAccount?id=<?php echo $array[$key]['id']; ?>"><i class="fa fa-trash" style="color:red;width:20px;font-size:20px"></i>
                                                                </button>


                                                            </div>
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                        </form>

                                                        <?php

                                                       
                                                        ?>
                                                    </td>

                                                </tr>
                                              


                                        <?php }
                                        } ?>
                                    </tbody>
                                    <!--Table body-->
                                </table>
                                <!--Table-->
                            </div>
                        </div>
                    </div>
             <?php

                        if (Input::has("EDIT")) {
                            $id = Input::get("EDIT");

                            $query = "SELECT * from utilisateurs where id=$id";
                            $rslt = mysqli_query($connect, $query);
                            $row = mysqli_fetch_array($rslt);
                        ?>
                    <div id="myModalEDIT" class="modal" style="z-index: 9999999999999999999999999;">

                        <!-- Modal content -->
           
                        <div class="modal-content1">
                            <span class="close7">&times;</span>
                            <div class="user">
                                <header class="user__header">
                                    <h1 class="user__title">Modifier Compte</h1>
                                </header>
                                <hr>
                    
                                <form class="form" action="EditAccount" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form__group" id="nom">
                                        <label>Nom</label>
                                        <input type="text" name="nom" placeholder="Nom et prenom" class="form__input" value="<?php echo $row['Nom']; ?>" required />
                                    </div>
                                    <div class="form__group" >
                                        <label>Email</label>
                                        <input title="l'email est obligatoire pour le chef centre" id="email" type="email" name="email" placeholder="Email(optionel)" class="form__input" value="<?php echo $row['email']; ?>" />
                                    </div>

                                    <div class="form__group">
                                        <label for="">Mot de passe</label>

                                        <input type="password" minlength="5" name="mdp" placeholder="Nouveau mot de passe" minlength="5" class="form__input" value="" />
                                        <input type="hidden" value="<?php echo $row['mdp']; ?>" name="mdp2">
                                        <input type="hidden" value="<?php echo $id ?>" name="idusr">

                                    </div>


                                    <div class="form__group">
                                        <label for="">Type</label>

                                        <select  name="type" id="type1"  class="form__input" required>
                                            <option  id="typeBase" value="<?php echo $row["type"] ?>"><?php if($row["type"] =="LIQUIDER"){echo "Liquidateur";} elseif($row["type"] =="CONTOLER"){echo "Contrôleur";}elseif($row["type"] =="CONSULTER"){echo "Consulteur";}?></option>
                                            <option id="chef" value="CHEF CENTRE">CHEF CENTRE</option>
                                            <option id="liquid" value="LIQUIDER">Liquidateur</option>
                                            <option id="ctrl" value="CONTROLER">Contrôleur</option>
                                            <option id="consulter" value="CONSULTER">Cosnulteur</option>
                                        </select>
                                    </div>
                                             <script>
                                function requireEmail() {
                                    var type = document.getElementById("type1").value;
                                    var email = document.getElementById("email");
                                    if (type == "CHEF CENTRE") {
                                        email.required = "true";


                                    } else {
                                        email.required = "";

                                    }
                                }
                                
                            </script>
                            <script>
                            $(document).ready(function(){
                                $('#type1').on('mousemove',function() {
                                    if($(this).val()=="CHEF CENTRE"){

                                        $('#email').attr("required",true);

                                    }else{
                                        $('#email').removeAttr("required");
                                    }

                                    
                                   });

                            });
                        </script>
                                    <script src="js/jquery.min.js"></script>
                                        <script src="js/jquery.js" type="text/javascript"></script>


                                    <br>
                                    <div class="form__group">
                                        <label style="float:left;">Trop Perçu &nbsp; &nbsp;</label>
                                        <label class="switch">
                                            <input type="checkbox" name="TP" class="" value="OUI" <?php if ($row["TropPercu"] == "OUI") {
                                                                                                        echo "checked";
                                                                                                    } ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <input type="hidden" name="id_usr" value="<?php echo $row["id"]; ?>">
                                    <input type="hidden" name="old_name" value="<?php echo $row["Nom"]; ?>">


                                    <button class="btn" name="editing" type="submit">Modifier </button>








                                </form>
                                   






                            </div>
                        </div>


                        <?php
                       

                    }



                        ?>
    </body>
    <script>
        var modal6 = document.getElementById("myModalEDIT");
        var span6 = document.getElementsByClassName("close7")[0];

        <?php if (isset($_GET["EDIT"])) { ?>
            modal6.style.display = "block";
            span6.onclick = function() {

                modal6.style.display = "none";
            }
        <?php } ?>

        // Get the button that opens the modal
        var btn6 = document.getElementById("EDIT");

        // Get the <span> element that closes the modal

        // When the user clicks the button, open the modal 
        btn6.onclick = function() {
            modal5.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span6.onclick = function() {

            modal6.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal6) {

                modal6.style.display = "none";

            }
        }
    </script>
    <script>
        function Search() {
            var input = document.getElementById("input");
            var filter = input.value.toLowerCase();
            var element = document.getElementsByClassName('data');


            for (i = 0; i < element.length; i++) {

                if (element[i].innerText.toLowerCase().includes(filter)) {
                    element[i].style.display = "table-row";

                } else {
                    element[i].style.display = "none";

                }
            }
        }
    </script>
    <script>
        var type = document.getElementById("typeBase");
        var chef = document.getElementById("chef");
        var liquid = document.getElementById("liquid");
        var ctrl = document.getElementById("ctrl");
        var consulter = document.getElementById("consulter");


        if (type.value == chef.value) {
            chef.style.display = "none";
        } else if (type.value == liquid.value) {
            liquid.style.display = "none";

        } else if (type.value == ctrl.value) {
            ctrl.style.display = "none";

        } else if (type.value == consulter.value) {
            consulter.style.display = "none";

        }
    </script>

<?php  } else {?>
    @include("Error");
<?php
} ?>

    </html>
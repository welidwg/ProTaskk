<?php

$current = "ListeDossier";
$type=Session::get('type');
$tp=Session::get("tp");
if ($type == "LIQUIDER" && $tp == "OUI" || $type == "CONSULTER") {

?>


    <html lang="en">
@include("GestionDeParametre.nav");

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <title>ProTask | Liste des dossiers</title>

        <style>
            html{zoom:1} 
            .hm-gradient {
                background-image: linear-gradient(to top, #f3e7e9 0%, #e3eeff 99%, #e3eeff 100%);
            }

            .darken-grey-text {
                color: #2E2E2E;
            }

            .input-group.md-form.form-sm.form-2 input {
                border: 1px solid #bdbdbd;
                border-top-left-radius: 0.25rem;
                border-bottom-left-radius: 0.25rem;
                z-index: 0;
            }

            .input-group.md-form.form-sm.form-2 input.purple-border {
                border: 1px solid #9e9e9e;
            }

            .input-group.md-form.form-sm.form-2 input[type=text]:focus:not([readonly]).purple-border {
                border: 1px solid #ba68c8;
                box-shadow: none;
            }

            .form-2 .input-group-addon {
                border: 1px solid #ba68c8;
            }

            .danger-text {
                color: #ff3547;
            }

            .success-text {
                color: #00C851;
            }

            .table-bordered.red-border,
            .table-bordered.red-border th,
            .table-bordered.red-border td {
                border: 1px solid #ff3547 !important;
            }

            .table.table-bordered th {
                text-align: center;
            }

            td {
                text-align: center;
            }

            td button {
                background-color: transparent;
                border: none;
            }

            td button:focus {

                outline: none;
            }


            th {
                text-align: center;
            }

            

            /* Modal Content */
        </style>
    </head>

    <body>


        <main style="zoom:0.9">
            <style>
                .fix {
                    position: sticky;
                    top: 0;
                    background-color: white;
                    z-index: 1;
                }

                .tableFixHead {
                    overflow-y: auto;
                    height: 300px;

                }

                .tableFixHead thead th {
                    position: sticky;
                    top: 0;
                    z-index: 2;
                    background-color: white;
                    height: 60px;
                }

                .card {
                    border-radius: 20px;
                    box-shadow: 0px 0px 15px -2px rgba(0, 0, 0, 0.4);
                }

                .wrapper .search_box {
                    width: 500px;
                    background: #fff;
                    border-radius: 5px;
                    height: 65px;
                    display: flex;
                    padding: 10px;
                    box-shadow: 0 8px 6px -10px #b3c6ff;
                    margin-left: 30%;
                }

                .wrapper .search_box .dropdown {
                    width: 150px;
                    color: #9fa3b1;
                    position: relative;
                    cursor: pointer;
                    height: 44px;
                    border: none;
                }

                .wrapper .search_box .dropdown:focus {
                    outline: none;
                }

                .wrapper .search_box .dropdown .default_option {
                    text-transform: uppercase;
                    padding: 13px 15px;
                    font-size: 14px;
                }

                .wrapper .search_box .dropdown option {
                    position: relative;
                    top: 70px;
                    left: -10px;
                    background: #fff;
                    width: 150px;
                    border-radius: 5px;
                    padding: 20px;
                    box-shadow: 8px 8px 6px -10px #b3c6ff;
                }

                .wrapper .search_box .dropdown select.active {
                    display: block;
                }

                .wrapper .search_box .dropdown select option {
                    padding-bottom: 20px;
                }

                .wrapper .search_box .dropdown select option:last-child {
                    padding-bottom: 0;
                }

                .wrapper .search_box .dropdown select option:hover {
                    color: #6f768d;
                }

                .wrapper .search_box .dropdown:before {
                    content: "";
                    position: absolute;
                    top: 18px;
                    right: 20px;
                    border: 8px solid;
                    border-color: #5078ef transparent transparent transparent;
                }

                .wrapper .search_box .search_field {
                    width: 350px;
                    height: 100%;
                    position: relative;
                }

                .wrapper .search_box .search_field .input {
                    width: 100%;
                    height: 100%;
                    border: 0px;
                    font-size: 16px;
                    padding-left: 20px;
                    padding-right: 38px;
                    color: #6f768d;
                }

                .wrapper .search_box .search_field .fas {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    font-size: 22px;
                    color: #5078ef;
                    cursor: pointer;
                }

                ::-webkit-input-placeholder {
                    /* Chrome/Opera/Safari */
                    color: #9fa3b1;
                }

                ::-moz-placeholder {
                    /* Firefox 19+ */
                    color: #9fa3b1;
                }

                :-ms-input-placeholder {
                    /* IE 10+ */
                    color: #9fa3b1;
                }
            </style>
            <!--MDB Tables-->
                <div class="wrapper">
                    <div class="search_box">

                        <div class="search_field">

                            <input type="text" name="valeur" class="input" oninput="maxLengthCheck(this)" id="valeur" onkeyup="Search('valeur','card')" placeholder="Chercher un dossier" value=>



                        </div>
                    </div>
                </div>
            <div class="container mt-4">



                <div class="card mb-4" >
                    <div class="card-body">
                        <!-- Grid row -->
                        <div class="row">
                            <!-- Grid column -->
                            <div class="col-md-12">
                                <div class="fix">
                                    <h2 style="color:grey;font-weight:700;font-size:20px"><i class="fa fa-check" style="color:green"> </i> Liste des dossiers Payés</h2>

                                    <div class="input-group md-form form-sm form-2 pl-0">
                                        <input id="input1" onkeyup="Search1('input1','data')" class="form-control my-0 py-1 pl-3 purple-border" type="text" placeholder="Recherche..." id="input"  aria-label="Search">
                                        <span id='btn' class="input-group-addon waves-effect purple lighten-2" id="basic-addon1"><a><i class="fa fa-search white-text" aria-hidden="true"></i></a></span>
                                    </div>
                                </div>
                                <!-- Grid column -->
                            </div>
                        </div>
                        <!-- Grid row -->
                        <!--Table-->
                        <div class="tableFixHead">
                            <table class="table table-striped">
                                <!--Table head-->
                                <thead>
                                    <tr>
                                        <th>Matricule</th>
                                        <th>Cin</th>
                                        <th>Nom et Prenom</th>
                                        <th>pension servie</th>
                                        <th>Etat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <!--Table head-->
                                <!--Table body-->
                                <tbody>
                                    <?php




                                    $array = runQuery("SELECT * from dossier WHERE etat='Paye' ORDER BY id ASC");
                                    if (!empty($array)) {
                                        foreach ($array as $key => $value) {
                                    ?>
                                            <tr class="data" id="testt">
                                                <th scope="row"><?php echo $array[$key]["Matricule"] ?></th>
                                                <td><?php if ($array[$key]["Cin"] != "") {
                                                        echo $array[$key]["Cin"];
                                                    } else {
                                                        echo "<p>--------</p>";
                                                    } ?></td>
                                                <td><?php echo $array[$key]["NomPrenom"] ?></td>
                                                <td><?php echo $array[$key]["MontantDemande"] ?></td>
                                                <td>
                                                    <?php echo "<p style='color:green'>" . $array[$key]["Etat"] . "</p>" ?>


                                                </td>
                                                <td>
                                                   
                                                    <a href="Consulter?immat=<?php echo $array[$key]["Matricule"] ?>"><i class="fa fa-eye"></i></a>
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
                <br>
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Grid row -->
                        <div class="row">
                            <!-- Grid column -->
                            <div class="col-md-12">
                                <div class="fix">

                                    <h2 style="color:grey;font-weight:700;font-size:20px"><i class="fa fa-exclamation-circle" style="color: red"> </i> Liste des dossiers non encore payés</h2>

                                    <div class="input-group md-form form-sm form-2 pl-0">
                                        <input id="input2" onkeyup="Search1('input2','data2')" class="form-control my-0 py-1 pl-3 purple-border" type="text" placeholder="Recherche..." id="input" aria-label="Search">
                                        <span id='btn' class="input-group-addon waves-effect purple lighten-2" id="basic-addon1"><a><i class="fa fa-search white-text" aria-hidden="true"></i></a></span>
                                    </div>
                                </div>
                                <!-- Grid column -->
                            </div>
                        </div>
                        <!-- Grid row -->
                        <!--Table-->
                        <div class="tableFixHead">
                            <table class="table table-striped">
                                <!--Table head-->
                                <thead>
                                    <tr>
                                        <th>Matricule</th>
                                        <th>Cin</th>
                                        <th>Nom et Prenom</th>
                                        <th>pension servie</th>
                                        <th>Etat</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <!--Table head-->
                                <!--Table body-->
                                <tbody>
                                    <?php


                                    $array = runQuery("SELECT * from dossier WHERE etat='Non Paye' or etat='correspondance' ORDER BY id ASC");
                                    if (!empty($array)) {
                                        foreach ($array as $key => $value) {
                                    ?>
                                            <tr class="data2">
                                                <th scope="row"><?php echo $array[$key]["Matricule"] ?></th>
                                                <td><?php if ($array[$key]["Cin"] != "") {
                                                        echo $array[$key]["Cin"];
                                                    } else {
                                                        echo "<p>--------</p>";
                                                    } ?></td>
                                                <td><?php echo $array[$key]["NomPrenom"] ?></td>
                                                <td><?php echo $array[$key]["MontantDemande"] ?></td>
                                                <td>
                                                    <?php if ($array[$key]["Etat"] == "Non Paye") {
                                                        echo "<p style='color:darkred'>" . $array[$key]["Etat"] . "</p>";
                                                    } elseif ($array[$key]["Etat"] == "correspondance") {
                                                        echo "<p style='color:red'>" . $array[$key]["Etat"] . "</p>";
                                                    } ?>


                                                </td>
                                                <td>
                                                    <a href="Consulter?immat=<?php echo $array[$key]["Matricule"] ?>"><i class="fa fa-eye"></i></a>
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
                <br>
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Grid row -->
                        <div class="row">
                            <!-- Grid column -->
                            <div class="col-md-12">
                                <div class="fix">
                                    <h2 style="color:grey;font-weight:700;font-size:20px"><i style="color:orange" class="fa fa-hourglass-end"></i> Liste des dossiers en cours de paiement</h2>

                                    <div class="input-group md-form form-sm form-2 pl-0" style="z-index: 0;">
                                        <input id="input3" onkeyup="Search1('input3','data3')" class="form-control my-0 py-1 pl-3 purple-border" type="text" placeholder="Recherche..." id="input" aria-label="Search">
                                        <span id='btn' class="input-group-addon waves-effect purple lighten-2" id="basic-addon1"><a><i class="fa fa-search white-text" aria-hidden="true"></i></a></span>
                                    </div>
                                </div>
                                <!-- Grid column -->
                            </div>
                        </div>
                        <!-- Grid row -->
                        <!--Table-->
                        <div class="tableFixHead">
                            <table class="table table-striped">
                                <!--Table head-->
                                <thead>
                                    <tr>
                                        <th>Matricule</th>
                                        <th>Cin</th>
                                        <th>Nom et Prenom</th>
                                        <th>pension servie</th>
                                        <th>Total Payé</th>
                                        <th>Etat</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <!--Table head-->
                                <!--Table body-->
                                <tbody>
                                    <?php




                                    $array = runQuery("SELECT * from dossier WHERE etat='En cours de paiement' ORDER BY id ASC");
                                    if (!empty($array)) {
                                        foreach ($array as $key => $value) {
                                    ?>
                                            <tr class="data3">
                                                <th scope="row"><?php echo $array[$key]["Matricule"] ?></th>
                                                <td><?php if ($array[$key]["Cin"] != "") {
                                                        echo $array[$key]["Cin"];
                                                    } else {
                                                        echo "<p>--------</p>";
                                                    } ?></td>
                                                <td><?php echo $array[$key]["NomPrenom"] ?></td>
                                                <td><?php echo $array[$key]["MontantDemande"] ?></td>
                                                <td><?php echo $array[$key]["TotalPaye"] ?></td>
                                                <td>
                                                    <?php echo "<p style='color:orange'>" . $array[$key]["Etat"] . "</p>" ?>


                                                </td>
                                                <td>
                                                    <a href="Consulter?immat=<?php echo $array[$key]["Matricule"] ?>"><i class="fa fa-eye"></i></a>
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
                <br>

                 <div class="card" id="error" style="display: none;">
                    <div class="card-body">
                        <!-- Grid row -->
                        <div class="row">
                            <!-- Grid column -->
                            <div class="col-md-12">
                                Aucune resultat ! 
                               
                                <!-- Grid column -->
                            </div>
                        </div>
                        <!-- Grid row -->
                        <!--Table-->
                        
                    </div>
                </div>

            </div>
        </main>

    </body>
    <style>
        .highlight{
            background-color: #00C851;
        }
    </style>
         <script src="js/jquery.js" type="text/javascript"></script>

    <script>
        function Search(input, data) {
            var input = document.getElementById(input);
            var filter = input.value.toLowerCase();
            var element = document.getElementsByClassName(data);


            var tab1=document.getElementsByClassName("data");
            var tab2=document.getElementsByClassName("data2");
            var tab3=document.getElementsByClassName("data3");
            console.log(tab1.innerText);



            for (i = 0; i < element.length; i++) {

                if (element[i].innerText.toLowerCase().includes(filter)) {
                    element[i].style.display = "block";
                    for (j = 0; j < tab1.length; j++) { 
                            if (tab1[j].innerText.toLowerCase().includes(filter)) {
                                tab1[j].style.display = "table-row";
                            }else{
                                tab1[j].style.display = "none";


                            }


                     }

                      for (k = 0; k < tab2.length; k++) { 
                            if (tab2[k].innerText.toLowerCase().includes(filter)) {
                                tab2[k].style.display = "table-row";
                            }else{
                                tab2[k].style.display = "none";


                            }


                     }


                     for (r = 0; r < tab3.length; r++) { 
                            if (tab3[r].innerText.toLowerCase().includes(filter)) {
                                tab3[r].style.display = "table-row";
                            }else{
                                tab3[r].style.display = "none";


                            }


                     }

                    


    
                } else {
                    element[i].style.display = "none";

                }
            }
        }

        function Search1(input, data) {
            var input = document.getElementById(input);
            var filter = input.value.toLowerCase();
            var element = document.getElementsByClassName(data);


            for (i = 0; i < element.length; i++) {

                if (element[i].innerText.toLowerCase().includes(filter)) {
                    element[i].style.display = "table-row";

                    



                } else {
                    element[i].style.display = "none";


                }

            }
        }
    </script>

<?php
} else { ?>
    @include("Error");
<?php }
?>

    </html>
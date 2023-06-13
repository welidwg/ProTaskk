<?php

use App\Http\Controllers\ParametreController;

$current = "Controle";

if (Session::get("type") == "CONTROLER" && Session::get("tp") == "OUI") {
    $params=new ParametreController();

?>


    <html lang="en">
@include("GestionDeParametre.nav");

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ProTask | Dossiers à contrôler</title>

        <style>
            html{zoom:1}
            body {
                overflow-x: hidden;
            }

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
                white-space: nowrap;

            }

            .table.table-bordered th {
                text-align: center;

            }

            td {
                text-align: center;
                white-space: nowrap;


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
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
                font-size: 16px;
                white-space: nowrap;

            }

            .fix {
                    position: sticky;
                    top: 0;
                    background-color: white;
                    z-index: 1;
                }

                .tableFixHead {
                    overflow-y: auto;
                    height: 400px;

                }

                .tableFixHead thead th {
                    position: sticky;
                    top: 0;
                    z-index: 2;
                    background-color: white;
                    height: 60px;
                }




            /* Modal Content */
        </style>
    </head>

    <body style="overflow: hidden;">


        <main>

            <!--MDB Tables-->



                <div class="card mb-4" style="border-radius: 30px;zoom:0.85">
                    <div class="card-body" style="">
                        <!-- Grid row -->
                        <div class="row">
                            <!-- Grid column -->
                            <div class="col-md-12">
                                <h2 style="color:grey;font-weight:700;font-size:20px"><i class="fa fa-search" style="color:orange"> </i> Liste des dossier à controler</h2>

                                <div class="input-group md-form form-sm form-2 pl-0">
                                    <input onkeyup="Search()" class="form-control my-0 py-1 pl-3 purple-border" type="text" placeholder="Recherche..." id="input" aria-label="Search">
                                    <span id='btn' class="input-group-addon waves-effect purple lighten-2" id="basic-addon1"><a><i class="fa fa-search white-text" aria-hidden="true"></i></a></span>
                                </div>
                            </div>
                            <!-- Grid column -->
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
                                    <th>pension servie (DT)</th>
                                    <th>Total Payé</th>
                                    

                                    <th>Etat</th>
                                    <th>Ajouté par</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <!--Table head-->
                            <!--Table body-->
                            <tbody>
                                <?php




                                $array = runQuery("SELECT * from dossier WHERE Controle is NULL ORDER BY id ASC");
                                if (!empty($array)) {
                                    foreach ($array as $key => $value) {
                                ?>
                                        <tr class="data">
                                            <th scope="row"><?php echo $array[$key]["Matricule"] ?></th>
                                            <td><?php if ($array[$key]["Cin"] != "") {
                                                    echo $array[$key]["Cin"];
                                                } else {
                                                    echo "<p >--------</p>";
                                                }  ?></td>
                                            <td><?php echo $array[$key]["NomPrenom"] ?></td>
                                            <td><?php echo $array[$key]["MontantDemande"] ?></td>
                                            <td><?php if ($array[$key]["TotalPaye"] == "" || $array[$key]["TotalPaye"] == 0) {
                                                    echo "<p>--------</p>";
                                                } else {
                                                    echo $array[$key]["TotalPaye"] . " DT";
                                                }  ?></td>
                                            <td>
                                                <?php if ($array[$key]["Etat"] == "Paye") {
                                                    echo "<p style='color:green'>" . $array[$key]["Etat"] . "</p>";
                                                } elseif ($array[$key]["Etat"] == "Non Paye") {
                                                    echo "<p style='color:darkred'>" . $array[$key]["Etat"] . "</p>";
                                                } elseif ($array[$key]["Etat"] == "en cours de paiement") {
                                                    echo "<p style='color:orange'>" . $array[$key]["Etat"] . "</p>";
                                                } elseif ($array[$key]["Etat"] == "correspondance") {
                                                    echo "<p style='color:red'>" . $array[$key]["Etat"] . "</p>";
                                                }  ?>


                                            </td>
                                            <td>
                                               <?php echo $params->GetName( $array[$key]["AjoutePar"]) ?> 
                                            </td>

                                            <td>
                                                <form action="">


                                                    <a href="ConsulterDetail?matricule=<?php echo $array[$key]["Matricule"] ?>"> Voir Details</a>

                                                </form>
                                            </td>

                                        </tr>


                                <?php }
                                } ?>
                            </tbody>
                            <!--Table body-->
                        </table>
                        </div>
                        <!--Table-->
                    </div>




    </body>
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

<?php } else {?>
@include("Error");
<?php }
?>

    </html>
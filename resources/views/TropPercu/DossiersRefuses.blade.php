<?php

use App\Http\Controllers\ParametreController;

$current = "Refuse";
$params=new ParametreController();
if (Session::get("type") == "LIQUIDER" && Session::get("tp") == "OUI") {

?>


    <html lang="en">

    <head>
        @include("GestionDeParametre.nav");

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <title>ProTask | Dossier contrôlés avec erreurs</title>

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


        <main>

            <!--MDB Tables-->
            <div class="container mt-4">



                <div class="card mb-4" style="border-radius: 30px;">
                    <div class="card-body">
                        <!-- Grid row -->
                        <div class="row">
                            <!-- Grid column -->
                            <div class="col-md-12">
                                <h2 style="color:grey;font-weight:700;font-size:20px"><i class="fa fa-times" style="color:red"> </i> Liste des dossiers contrôlés avec erreurs</h2>

                                <div class="input-group md-form form-sm form-2 pl-0">
                                    <input onkeyup="Search()" class="form-control my-0 py-1 pl-3 purple-border" type="text" placeholder="Recherche..." id="input" aria-label="Search">
                                    <span id='btn' class="input-group-addon waves-effect purple lighten-2" id="basic-addon1"><a><i class="fa fa-search white-text" aria-hidden="true"></i></a></span>
                                </div>
                            </div>
                            <!-- Grid column -->
                        </div>
                        <!-- Grid row -->
                        <!--Table-->
                        <table class="table table-striped">
                            <!--Table head-->
                            <thead>
                                <tr>
                                    <th>Matricule</th>
                                    <th>Cin</th>
                                    <th>Nom et Prenom</th>
                                    <th>Etat</th>
                                    <th>Contrôlé Par</th>
                                    <th>Date Controle</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <!--Table head-->
                            <!--Table body-->
                            <tbody>
                                <?php




                                $array = runQuery("SELECT * from dossier WHERE Controle like 'Refuser' ORDER BY id ASC");
                                if (!empty($array)) {
                                    foreach ($array as $key => $value) {
                                ?>
                                        <tr class="data">
                                            <th scope="row"><?php echo $array[$key]["Matricule"] ?></th>
                                            <td><?php if ($array[$key]["Cin"] != "") {
                                                    echo $array[$key]["Cin"];
                                                } else {
                                                    echo "<p>--------</p>";
                                                } ?></td>
                                            <td><?php echo $array[$key]["NomPrenom"] ?></td>
                                            <td><?php echo $array[$key]["Etat"] ?></td>
                                            <td><?php echo $params->GetName( $array[$key]["ControlePar"]) ?></td>
                                            <td><?php echo $array[$key]["DateControle"] ?></td>

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

<?php
} else { ?>
    @include("Error");
<?php }
?>

    </html>
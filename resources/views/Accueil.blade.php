<?php
$current = "accueil";
?>
    <html lang="en">
@include("GestionDeParametre.nav");

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> ProTask | Accueil</title>

    </head>


    <style>
        html {
            zoom: 1;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            font-family: 'Montserrat', sans-serif;


        }


        .Home {
            width: 100%;
            height: auto;
            -webkit-animation: fadein 2s;
            /* Safari, Chrome and Opera > 12.1 */
            -moz-animation: fadein 2s;
            /* Firefox < 16 */
            -ms-animation: fadein 2s;
            /* Internet Explorer */
            -o-animation: fadein 2s;
            /* Opera < 12.1 */
            animation: fadein 2s;
            


        }

        .Home img {
            width: 250px;
            height: 250px;



        }

        .Home h6 {
            text-align: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: 700;
            font-size: 30px;
            color: black;
        }

        .Home h4 {
            text-align: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: 700;
        }
    </style>




<body >
    <?php



?>

    
                    <div class="Home">
                        <p style="text-align:center">
                            <img src="CSS/Image/cnrps1.png" alt="">

                        </p>
                        <h6>Caisse Nationale de Retraite et de Prévoyance Sociale </h6>
                        <h4>Centre régionale de Sousse</h4>

                    </div>
            </div>


            <div id="hideMe">

                <?php if (isset($_GET["Success"])) {
                ?>

                    <div class="alert" style="background-color:#12a820;">

                        <h5 style="color:white"> <i class="fa fa-check"></i> Bienvenue <?php echo Session::get('nom') ?> </h5>

                    </div>
                <?php
                    }
                ?>
            </div>
</body>







    </html>
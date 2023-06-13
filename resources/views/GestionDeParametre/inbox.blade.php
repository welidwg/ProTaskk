<?php $current = "inbox";
if (Session::get('type') != "CONSULTER") {


?>
    <html lang="en">
@include("GestionDeParametre.nav")

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="CSS/style.css">
        <title>ProTask | Messages</title>

        <style>
            html{zoom:1}
           
              body {
  background-image: url("CSS/Image/back6.jpg");
  background-repeat: no-repeat;
  background-size: cover;
  background-attachment: fixed;
  animation: fadein 0.5s;
                  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;

}

            .email-app {
                display: flex;
                flex-direction: row;
                background: #fff;
                border: 1px solid #e1e6ef;
                font-size: small;
                border-radius: 30px;
                height: auto;
                max-height: 400px;
            }

            .email-app nav {
                flex: 0 0 200px;
                padding: 1rem;
                border-right: 1px solid #e1e6ef;
            }

            .email-app nav .btn-block {
                margin-bottom: 15px;
            }

            .email-app nav .nav {
                flex-direction: column;
            }

            .email-app nav .nav .nav-item {
                position: relative;
            }

            .email-app nav .nav .nav-item .nav-link,
            .email-app nav .nav .nav-item .navbar .dropdown-toggle,
            .navbar .email-app nav .nav .nav-item .dropdown-toggle {
                color: #151b1e;
                border-bottom: 1px solid #e1e6ef;
            }

            .email-app nav .nav .nav-item .nav-link i,
            .email-app nav .nav .nav-item .navbar .dropdown-toggle i,
            .navbar .email-app nav .nav .nav-item .dropdown-toggle i {
                width: 10px;
                margin: 0 1px 0 0;
                font-size: 12px;
                text-align: left;
            }

            .email-app nav .nav .nav-item .nav-link .badge a,
            .email-app nav .nav .nav-item .navbar .dropdown-toggle .badge a,
            .navbar .email-app nav .nav .nav-item .dropdown-toggle .badge a {
                float: right;
                margin-top: 4px;
                margin-left: 4px;
            }

            .email-app main {
                min-width: 0;
                flex: 1;
                padding: 1rem;
            }

            .email-app .inbox .toolbar {
                padding-bottom: 1rem;
                border-bottom: 1px solid #e1e6ef;
            }

            .email-app .inbox .messages {
                padding: 0;
                list-style: none;
            }

            .email-app .inbox .message {
                position: relative;

                cursor: pointer;
                border-bottom: 1px solid #e1e6ef;
            }

            .email-app .inbox .message:hover {
                background: #f9f9fa;
            }

            .email-app .inbox .message .actions {
                position: absolute;
                left: 0;
                display: flex;
                flex-direction: column;
            }

            .email-app .inbox .message .actions .action {
                width: 2rem;

                color: #c0cadd;
                text-align: center;
            }

            .email-app .inbox .message a {
                color: #000;
            }

            .email-app .inbox .message a:hover {
                text-decoration: none;
            }

            .email-app .inbox .message.unread .header,
            .email-app .inbox .message.unread .title {
                font-weight: bold;
                font-size: 16px;

            }

            .email-app .inbox .message .header {
                display: flex;
                flex-direction: row;
                margin-bottom: 0.5rem;
            }



            .email-app .inbox .message .title {
                margin-bottom: 0.5rem;
                overflow: hidden;
                text-overflow: ellipsis;

            }

            .email-app .inbox .message .description {
                font-size: 12px;
            }

            .email-app .message .toolbar {
                padding-bottom: 1rem;
                border-bottom: 1px solid #e1e6ef;
            }

            .email-app .message .details .title {
                padding: 1rem 0;
                font-weight: bold;
            }

            .email-app .message .details .header {
                display: flex;

                margin: 1rem 0;
                border-top: 1px solid #e1e6ef;
                border-bottom: 1px solid #e1e6ef;
            }

            .email-app .message .details .header .avatar {
                width: 40px;
                height: 40px;
                margin-right: 1rem;
            }

            .email-app .message .details .header .from {
                font-size: 12px;
                color: #9faecb;

            }

            .email-app .message .details .header .from span {
                display: block;
                font-weight: bold;
            }

            .email-app .message .details .header .date {
                margin-left: auto;
            }




            @media (max-width: 767px) {
                .email-app {
                    flex-direction: column;
                }

                .email-app nav {
                    flex: 0 0 100%;
                }
            }

            @media (max-width: 575px) {
                .email-app .message .header {
                    flex-flow: row wrap;
                }

                .email-app .message .header .date {
                    flex: 0 0 100%;
                }

            }

            input {
                border: 1px solid lightblue;
                padding: 6px;
                border-radius: 5px;
            }

            h2 {
                font-size: 20px;
                font-family: impact;
                margin-left: 10px;
                top: 0px
            }

            h4 {
                font-size: 15px;
                margin-left: 10px;
                top: 0px;

            }

            p {
                margin-left: 10px;
            }

            .email-app {
                display: flex;
                flex-direction: row;
                background: #fff;
                border: 1px solid #e1e6ef;
            }

            .email-app nav {
                flex: 0 0 200px;
                padding: 1rem;
                border-right: 1px solid #e1e6ef;
            }

            .email-app nav .btn-block {
                margin-bottom: 15px;
            }

            .email-app nav .nav {
                flex-direction: column;
            }

            .email-app nav .nav .nav-item {
                position: relative;
            }

            .email-app nav .nav .nav-item .nav-link,
            .email-app nav .nav .nav-item .navbar .dropdown-toggle,
            .navbar .email-app nav .nav .nav-item .dropdown-toggle {
                color: #151b1e;
                border-bottom: 1px solid #e1e6ef;
            }





            .email-app main {
                min-width: 0;
                flex: 1;
                padding: 1rem;
            }

            .email-app .inbox .toolbar {
                padding-bottom: 1rem;
                border-bottom: 1px solid #e1e6ef;
            }

            .email-app .inbox .messages {
                padding: 0;
                list-style: none;
                height: auto;
                max-height: 380px;
                overflow: auto;
            }

            .email-app .inbox .message {
                position: relative;
                padding: 1rem 1rem 0rem 0rem;
                cursor: pointer;
                border-bottom: 1px solid #e1e6ef;
            }

            .email-app .inbox .message:hover {
                background: #f9f9fa;
            }

            .email-app .inbox .message .actions {
                position: absolute;
                left: 0;
                display: flex;
                flex-direction: column;
            }

            .email-app .inbox .message .actions .action {
                width: 2rem;
                margin-bottom: 0.5rem;
                color: #c0cadd;
                text-align: center;
            }

            .email-app .inbox .message {
                color: #000;
            }

            .email-app .inbox .message:hover {
                text-decoration: none;
            }

            .email-app .inbox .message.unread .header,
            .email-app .inbox .message.unread .title {
                font-weight: bold;
            }

            .email-app .inbox .message .header {
                display: flex;
                flex-direction: row;
                margin-bottom: 0.5rem;
            }

            .email-app .inbox .message .header .date {
                margin-left: auto;
            }

            .email-app .inbox .message .title {
                margin-bottom: 0.5rem;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .email-app .inbox .message .description {
                font-size: 12px;
            }

            .email-app .message .toolbar {
                padding-bottom: 1rem;
                border-bottom: 1px solid #e1e6ef;
            }

            .email-app .message .details .title {
                padding: 1rem 0;
                font-weight: bold;
            }

            .email-app .message .details .header {
                display: flex;
                padding: 1rem 0;
                margin: 1rem 0;
                border-top: 1px solid #e1e6ef;
                border-bottom: 1px solid #e1e6ef;
            }

            .email-app .message .details .header .avatar {
                width: 40px;
                height: 40px;
                margin-right: 1rem;
            }

            .email-app .message .details .header .from {
                font-size: 12px;
                color: #9faecb;
                align-self: center;
            }

            .email-app .message .details .header .from span {
                display: block;
                font-weight: bold;
            }

            .email-app .message .details .header .date {
                margin-left: auto;
            }

            @media (max-width: 767px) {
                .email-app {
                    flex-direction: column;
                }

                .email-app nav {
                    flex: 0 0 100%;
                }
            }

            @media (max-width: 575px) {
                .email-app .message .header {
                    flex-flow: row wrap;
                }

                .email-app .message .header .date {
                    flex: 0 0 100%;
                }
            }



            .search {
                z-index: 0;
                border: 1px solid grey;
                float: right;
                border-radius: 20px;

            }

            .search:focus {
                border-radius: 20px;
                background-color: #e3dada;
                transition: all .5s;
                padding: 5px;

                z-index: 0;

            }

            .search::after {
                transition: all .5s;

            }
        </style>
        <style>
            .fix {
                position: sticky;
                top: 0;
                background-color: red;
                z-index: 0;
            }

            .icons i {
                color: #b5b3b3;
                border: 1px solid #b5b3b3;
                padding: 6px;
                margin-left: 4px;
                border-radius: 5px;
                cursor: pointer
            }



            .list-group li {
                margin-bottom: 12px
            }



            .list li {
                list-style: none;
                padding: 10px;
                border: 1px solid #e3dada;
                margin-top: 12px;
                border-radius: 5px;
                background: #fff
            }

            .checkicon {
                color: green;
                font-size: 19px
            }

            .date-time {
                font-size: 12px
            }
        </style>
    </head>

    <body>

        <div class="container bootdey">
            <div class="email-app">
                <?php
                    $connect = mysqli_connect('localhost', 'root', '') or die(mysqli_error($connect));
    mysqli_select_db($connect, 'cnrps');
                $nom=Session::get("nom");
                $requete = "SELECT * from message where recepteur like '$nom' ";
                $message = mysqli_num_rows(mysqli_query($connect, $requete));
                $requete2 = "SELECT * from message where emetteur like '$nom' ";
                $envoie = mysqli_num_rows(mysqli_query($connect, $requete2)); ?>

                <nav>
                    <a onclick="openForm()" class="btn btn-danger btn-block" style="color:white;cursor:pointer">Nouveau Message</a>
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="Inbox?messages" class="nav-link" <?php if (isset($_GET['messages'])) {
                                                                                echo "style='color:green'";
                                                                            } ?> name="message" id="message"><i class="fa fa-inbox"></i> reçus <span class="badge badge-danger"><?php echo $message ?></span></a>
                        </li>
                        <style>
                            .nav-link .active {

                                color: green;



                            }
                        </style>
                        <li class="nav-item">

                            <a href="Inbox?envoyé" name="envoyé" id="envoyé" class="nav-link" <?php if (isset($_GET['envoyé'])) {
                                                                                                        echo "style='color:green'";
                                                                                                    } ?> href="#"><i class="fa fa-rocket"></i> envoyés <span class="badge badge-danger"><?php echo $envoie ?></span></a>
                        </li>



                    </ul>
                </nav>


                <div class="container bootdey">


                    <main class="inbox">


                        <ul class="messages" style="height:550px;">





                                <style>
                                    .tableFixHead {
                                        overflow-y: auto;
                                        height: 100px;
                                        display: block;

                                        position: sticky;
                                        top: 0;
                                        z-index: 1;

                                    }


                                    .tableFixHead h1,
                                    .tableFixHead input {
                                        position: sticky;
                                        top: 0;
                                        z-index: 1;
                                        background-color: white;
                                        height: 40px;
                                        overflow: hidden;
                                    }
                                </style>








                                <?php if (isset($_GET['envoyé'])) { ?>

                                    <ul class="messages" style="overflow: auto;">
                                        <div class="tableFixHead" style="background-color:white;width: 100%;">


                                            <h1 style="float: left;font-size:20px;font-weight:700"> <i class="fa fa-envelope"></i> Messages Envoyés</h1>

                                            <input type="text" onkeyup="Search('input1','search1')" class="search" id="input1" placeholder="Chercher un message...">
                                            <br><br>
                                            <hr>

                                        </div>





                                        <?php
                                        $array11 = runQuery("SELECT * from message where emetteur like '$nom' ");
                                        if (!empty($array11)) {
                                            foreach ($array11 as $key => $value) { ?>
                                                <form action="DeleteMessageEnv" method="POST">
                                                    {{ csrf_field() }}

                                                    <div class="container mt-5 search1" style="zoom: 0.8;">
                                                        <div class="d-flex justify-content-between align-items-center activity">
                                                            <div><i class="fa fa-clock"></i><span class="ml-2"><?php echo $array11[$key]["date"]; ?></span></div>
                                                            <div class="icons"> <button name="del" onclick="return confirm('Vous êtes sur de supprimer ce message ?'); " type="submit"> <i class="fa fa-trash"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <ul class="list list-inline">
                                                                <li class="d-flex justify-content-between">

                                                                    <div class="ml-2">
                                                                        <p style="font-size:20px;margin-left:0;color:#05324f"><i class="far fa-user"></i> <?php echo $array11[$key]["recepteur1"]; ?></p> <br>
                                                                        <h6 class="mb-0" style="font-weight: bold;"><i class="far fa-envelope"></i> <?php echo $array11[$key]["sujet"]; ?></h6>

                                                                        <div class="d-flex flex-row mt-1 text-black-50 date-time">

                                                                            <div style="font-size: 15px;"><?php echo $array11[$key]["message"]; ?></div><br>




                                                                        </div>


                                                                        <?php if ($array11[$key]["fichier"] != "") {
                                                                            $file = $array11[$key]["fichier"];   ?>


                                                                            Fichier:

                                                                            <a style="font-size: 12px;color:#366532" href="<?php echo $file; ?>" download> <?php echo $array11[$key]["nomfichier"]; ?>
                                                                            </a></span>


                                                                            </span>


                                                                        <?php } ?>
                                                                    </div>
                                                                    <input type="hidden" value="<?php echo $array11[$key]["id"];  ?>" name="in">

                                                                </li>



                                                            </ul>
                                                        </div>
                                                    </div>
                                                    

                                                </form>
                                        <?php }
                                        }else{
                                            ?>
                                            <p>Aucun message</p>
                                            
                                            <?php
                                        }
                                        ?>






                            
                        </ul>

                        <?php } else { ?>
                            <ul class="messages" >
                                <div class="tableFixHead" style="background-color: white;">


                                    <h1 style="float: left;font-size:20px;font-weight:700"> <i class="fa fa-envelope"></i> Messages Reçus</h1>

                                    <input type="search" onkeyup="Search('input11','search11')" class="search" id="input11" style="float:right" placeholder="Chercher un message ...">

                                    <br><br>
                                    <hr>

                                </div>


                                <?php 
                                    $array11 = runQuery("SELECT * from message where recepteur like '$nom' ");
                                    if (!empty($array11)) {
                                        foreach ($array11 as $key => $value) { ?>
                                        <form action="DeleteMessage" method="POST">
                                            {{ csrf_field() }}

                                            <div class="container mt-5 search11" style="zoom: 0.8;">
                                                <div class="d-flex justify-content-between align-items-center activity">
                                                    <div><i class="fa fa-clock"></i><span class="ml-2"><?php echo $array11[$key]["date"]; ?></span></div>
                                                    <div class="icons"> <button name="deleteMsg" onclick="return confirm('Vous êtes sur de supprimer ce message ?'); " type="submit" style=""> <i class="fa fa-trash"></i></button><a style="" href="?nom=<?php echo $array11[$key]["emetteur"] ?>" onclick="openForm()">
                                                            <i class="fa fa-reply" aria-hidden="true"> </i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <ul class="list list-inline">
                                                        <li class="d-flex justify-content-between">

                                                            <div class="ml-2">
                                                                <p style="font-size:20px;margin-left:0;color:#05324f"><i class="far fa-user"></i> <?php echo $array11[$key]["emetteur1"]; ?></p> <br>
                                                                <h6 class="mb-0" style="font-weight: bold;"><i class="far fa-envelope"></i> <?php echo $array11[$key]["sujet"]; ?></h6>

                                                                <div class="d-flex flex-row mt-1 text-black-50 date-time">

                                                                    <div style="font-size: 15px;"><?php echo $array11[$key]["message"]; ?></div><br>




                                                                </div>


                                                                <?php if ($array11[$key]["fichier"] != "") {
                                                                    $file = $array11[$key]["fichier"];   ?>


                                                                    Fichier:

                                                                    <a style="font-size: 12px;color:#366532" href="<?php echo $file; ?>" download> <?php echo $array11[$key]["nomfichier"]; ?>
                                                                    </a></span>


                                                                    </span>


                                                                <?php } ?>
                                                            </div>
                                                            <input type="hidden" value="<?php echo $array11[$key]["id"];  ?>" name="IDmessage">

                                                        </li>



                                                    </ul>
                                                </div>
                                            </div>

 
                                        </form>
                                        <?php
                                       ?>
                                <?php                                      }
                                    } ?>

                                    <p>Aucun message</p>


                            <?php } ?>


                            <script>
                                function Search(input, data) {
                                    var input = document.getElementById(input);
                                    var filter = input.value.toLowerCase();
                                    var element = document.getElementsByClassName(data);


                                    for (i = 0; i < element.length; i++) {

                                        if (element[i].innerText.toLowerCase().includes(filter)) {
                                            element[i].style.display = "inline-block";

                                        } else {
                                            element[i].style.display = "none";

                                        }
                                    }
                                }
                            </script>
    </body>
<?php  } else {?>
    @include("Error");
<?php
} ?>

    </html>
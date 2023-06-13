<?php
if (!Session::get('type')) {  // si le type n'existe pas?>

	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ProTask | Se connecter</title>
		<link rel="stylesheet" href="CSS/login.css">
		<link rel="icon" href="CSS/Image/logo3.png" />
		<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
		<script src="js/jquery.js" type="text/javascript"></script>
		    <meta name="csrf_token" content="{{ csrf_token() }}">



	</head>
	<style>
		body,
		html {
			height: 100%;
			font-family: Montserrat-Regular, sans-serif;
			animation: fadein 0.5s;


		}

		@keyframes fadein {
			from {
				opacity: 0;

			}

			to {
				opacity: 1;

			}
		}

		body:before {
			content: '';
			position: fixed;
			width: 100vw;
			height: 100vh;
			background-image: url("CSS/Image/back6.jpg");
			background-repeat: no-repeat;
			background-size: 100%;
			background-attachment: fixed;
			background-position: center;
			z-index: -9;
		}

		/*---------------------------------------------*/
		a {
			font-family: Montserrat-Regular;
			font-size: 14px;
			line-height: 1.7;
			color: #666666;
			margin: 0px;
			transition: all 0.4s;
			-webkit-transition: all 0.4s;
			-o-transition: all 0.4s;
			-moz-transition: all 0.4s;
		}

		a:focus {
			outline: none !important;
		}

		a:hover {
			text-decoration: none;
			color: #57b846;
		}

		/*---------------------------------------------*/
		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			margin: 0px;
		}

		p {
			font-family: Montserrat-Regular;
			font-size: 14px;
			line-height: 1.7;
			color: #666666;
			margin: 0px;
		}

		ul,
		li {
			margin: 0px;
			list-style-type: none;
		}


		/*---------------------------------------------*/
		input {
			outline: none;
			border: none;
		}

		textarea {
			outline: none;
			border: none;
		}

		textarea:focus,
		input:focus {
			border-color: transparent !important;
		}

		input::-webkit-input-placeholder {
			color: #999999;
		}

		input:-moz-placeholder {
			color: #999999;
		}

		input::-moz-placeholder {
			color: #999999;
		}

		input:-ms-input-placeholder {
			color: #999999;
		}

		textarea::-webkit-input-placeholder {
			color: #999999;
		}

		textarea:-moz-placeholder {
			color: #999999;
		}

		textarea::-moz-placeholder {
			color: #999999;
		}

		textarea:-ms-input-placeholder {
			color: #999999;
		}

		/*---------------------------------------------*/
		button {
			outline: none !important;
			border: none;
			background: transparent;
		}

		button:hover {
			cursor: pointer;
		}

		iframe {
			border: none !important;
		}




		/*//////////////////////////////////////////////////////////////////
[ Contact 1 ]*/

		.contact1 {
			width: 100%;
			min-height: 100%;
			padding: 15px;

			background: rgba(0, 0, 0, 0.3);
			/*background-image: url("CSS/Image/back9.jpg");
      background-repeat: no-repeat;
      background-size: 100% 100%;
      background-attachment: fixed; */
			display: -webkit-box;
			display: -webkit-flex;
			display: -moz-box;
			display: -ms-flexbox;
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;

		}

		.container-contact1 {
			width: 700px;
			height: 400px;
			overflow: hidden;
			background-color: rgba(255, 255, 255, 0.5);


			display: flex;
			justify-content: space-between;
			align-items: center;
			-webkit-box-shadow: -1px 7px 24px 2px rgba(0, 0, 0, 0.5);
			box-shadow: -1px 7px 24px 2px rgba(0, 0, 0, 0.5);


		}

		/*------------------------------------------------------------------
[  ]*/
		.contact1-pic {
			width: 100px;


		}

		.contact1-pic img {
			width: 300px;
		}


		/*------------------------------------------------------------------
[  ]*/
		.contact1-form {
			width: 390px;
			padding: 50px;
			background-color: transparent;

		}

		.contact1-form-title {
			display: block;
			font-family: Montserrat-ExtraBold;
			font-size: 24px;
			color: #333333;
			line-height: 1.2;
			text-align: center;
			padding-bottom: 44px;
		}

		input.input1 {
			height: 50px;
			border-radius: 25px;
			padding: 0 30px;
		}

		input.input1+.shadow-input1 {
			border-radius: 25px;
		}

		textarea.input1 {
			min-height: 150px;
			border-radius: 25px;
			padding: 12px 30px;
		}

		textarea.input1+.shadow-input1 {
			border-radius: 25px;
		}

		/*---------------------------------------------*/
		.wrap-input1 {
			position: relative;
			width: 100%;
			z-index: 1;
			margin-bottom: 20px;
		}

		.input1 {
			display: block;
			width: 100%;
			background: #e6e6e6;
			font-family: Montserrat-Bold;
			font-size: 15px;
			line-height: 1.5;
			color: #666666;
		}

		.shadow-input1 {
			content: '';
			display: block;
			position: absolute;
			bottom: 0;
			left: 0;
			z-index: -1;
			width: 100%;
			height: 100%;
			box-shadow: 0px 0px 0px 0px;
			color: rgba(87, 184, 70, 0.5);
		}

		.input1:focus+.shadow-input1 {
			-webkit-animation: anim-shadow 0.5s ease-in-out forwards;
			animation: anim-shadow 0.5s ease-in-out forwards;
		}

		@-webkit-keyframes anim-shadow {
			to {
				box-shadow: 0px 0px 80px 30px;
				opacity: 0;
			}
		}

		@keyframes anim-shadow {
			to {
				box-shadow: 0px 0px 80px 30px;
				opacity: 0;
			}
		}

		/*---------------------------------------------*/
		.container-contact1-form-btn {
			display: -webkit-box;
			display: -webkit-flex;
			display: -moz-box;
			display: -ms-flexbox;
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
		}

		.contact1-form-btn {
			min-width: 193px;
			height: 50px;
			border-radius: 25px;
			background: #57b846;
			font-family: Montserrat-Bold;
			font-size: 15px;
			line-height: 1.5;
			color: #fff;
			display: -webkit-box;
			display: -webkit-flex;
			display: -moz-box;
			display: -ms-flexbox;
			display: flex;
			justify-content: center;
			align-items: center;
			padding: 0 25px;

			-webkit-transition: all 0.4s;
			-o-transition: all 0.4s;
			-moz-transition: all 0.4s;
			transition: all 0.4s;
		}

		.contact1-form-btn i {
			margin-left: 7px;

			-webkit-transition: all 0.4s;
			-o-transition: all 0.4s;
			-moz-transition: all 0.4s;
			transition: all 0.4s;
		}

		.contact1-form-btn:hover {
			background: #333333;
		}

		.contact1-form-btn:hover i {
			-webkit-transform: translateX(10px);
			-moz-transform: translateX(10px);
			-ms-transform: translateX(10px);
			-o-transform: translateX(10px);
			transform: translateX(10px);
		}




		/*------------------------------------------------------------------
[ Responsive ]*/

		@media (max-width: 1200px) {
			.contact1-pic {
				width: 33.5%;
			}

			.contact1-form {
				width: 44%;
			}
		}

		@media (max-width: 992px) {
			.container-contact1 {
				padding: 90px 80px 88px 90px;
			}

			.contact1-pic {
				width: 35%;
			}

			.contact1-form {
				width: 55%;
			}
		}

		@media (max-width: 768px) {
			.container-contact1 {
				padding: 90px 80px 88px 80px;
			}

			.contact1-pic {
				display: none;
			}

			.contact1-form {
				width: 100%;
			}
		}

		@media (max-width: 576px) {
			.container-contact1 {
				padding: 90px 15px 88px 15px;
			}
		}

		#hideMe {
			text-align: center;
			position: relative;
		}
	</style>

	<body>
		<div id="hideMe">





		</div>
		<div class="contact1">
			<p style="position:absolute;top:0;text-align:center;right:0"> <img width="140px" height="140px" src="CSS/Image/cnrps1.png" alt=""></p>

			<div class="container-contact1">

				<div class="contact1-pic js-tilt" data-tilt>
					<img src="CSS/Image/logo4.png" alt="IMG">
				</div>
				<style>
					.notValid {
						border: 1px solid red;
					}
				</style>


				<form class="contact1-form validate-form" id="connexion" method="POST" action="Userlog">
{{csrf_field()}}
					<span class="login100-form-title">
						Se Connecter
					</span>


					<div class="wrap-input100 validate-input">
						<input class="input100" type="number" oninput="maxLengthCheck(this)" name="identifiant" placeholder="Identifiant" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">

						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input id="mdpp" pattern="[^'\x22]+" title="Saisir le mot de passe" class="input100" type="password" name="mdp" placeholder="Mot de passe" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">

						</span>
					</div>
					<P id="text" style="display: none;text-align: center;">La touche de majusucule est activée !</P>
					<script>
						jQuery(function($) {
							document.querySelector("#mdpp").addEventListener('keyup', checkCapsLock);
							document.querySelector("#mdpp").addEventListener('mousedown', checkCapsLock);

							function checkCapsLock(e) {
								var txt = document.getElementById("text");

								var caps_lock_on = e.getModifierState('CapsLock');

								if (caps_lock_on == true) {

									txt.style.display = "block";
								} else {
									txt.style.display = "none";
								}


							}
						})
					</script>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" id="conn">
							Connexion
						</button>

					</div>
					<div style="text-align: center;margin-top:15px;">
						<a id="Open" style="font-size: 15px;font-weight: bold;cursor: pointer;font-family: Montserrat-Bold;">Mot de passe oublié?</a>
						<br>

						<?php if (isset($_GET["Session_Expired"])) { ?>
							<a style="font-size: 14px;font-family: Montserrat-Bold;color:red">Session expirée! Veuillez se reconnecter !</a>


						<?php } ?>
						<div id="hideMe" style="font-size: 16px;">

							<?php
							if (isset($_GET["ErreurID"])) {
							?>
								<a style="font-family: Montserrat-Bold;color:red">Utilisateur non trouvé !</a>

							<?php } elseif (isset($_GET["ErreurMDP"])) {
							?>
								<a style="font-family: Montserrat-Bold;color:red">Mot de passe non valid !</a>


							<?php } elseif (isset($_GET["LogIN"])) { ?>
								<a style="font-family: Montserrat-Bold;color:red">Vous devez se connecter !</a>


							<?php } elseif (isset($_GET["Done"])) {  ?>
								<a style="font-family: Montserrat-Bold;color:limegreen">Demande envoyée! Veuillez contactez votre chef centre</a>


							<?php  } elseif (isset($_GET["DoneCHEF"])) {  ?>
								<a style="font-family: Montserrat-Bold;color:limegreen">Mot de passe récupérée! Veuillez vérifier votre email.</a>


							<?php  }elseif (isset($_GET["Connexion"])) { ?>
								<a style="font-family: Montserrat-Bold;color:red">Vous devez être connecté à l'internet  !</a>


							<?php } elseif(Session::has("ErreurDeServeur")) {?>
								<a style="font-family: Montserrat-Bold;color:red"><?php echo Session::get("ErreurDeServeur") ?></a>

							<?php }elseif(Session::has("ErreurMeth")) {?>
								<a style="font-family: Montserrat-Bold;color:red"><?php echo Session::get("ErreurMeth") ?></a>

							<?php } ?> 
						</div>

					</div>
				</form>
			</div>

		</div>




		<div id="myModal" class="modal" style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">

			<!-- Modal content -->
			<div class="modal-content1" style="margin-top:100px">
				<span class="close">&times;</span>
				<div class="user">
					<header class="user__header">
						<h1 class="user__title">Récuperer votre mot de passe</h1>

					</header>
					<br><br>
					

					<form class="form" method="POST" action="PasswordRecovery">
						{{@csrf_field()}}

						<br>
						<div class="">
							<label for="" style="color:#000">Votre identifiant:</label>
							<br><br>
							<input oninput="maxLengthCheck(this)" name="id" class="form__input" type="number" min="1" placeholder="identifiant" required>

						</div>
						<br><br>
						<button class="btn10" name="recuperer" type="submit">Envoyer Demande</button>
					</form>
				</div>

			</div>
		</div>

		<?php

		 ?>

	</body>
	<script>
		var modal = document.getElementById("myModal");

		// Get the button that opens the modal
		var btn = document.getElementById("Open");

		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];

		// When the user clicks the button, open the modal 
		btn.onclick = function() {
			modal.style.display = "block";
		}

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
			modal.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	</script>

	<script>
		function maxLengthCheck(object) {
			if (object.value.length > object.maxLength) {
				object.value = object.value.slice(0, 10)


			}
		}
	</script>
	<script type="text/Javascript">
		function preback() {
                window.history.forward();
            }
            setTimeout("preback()", 0);
            window.onunload = function() {
                null
            };
        </script>
	<script>
		history.pushState(null, null, location.href);
		window.onpopstate = function() {
			history.go(1);
		};
	</script>

	</html>


<?php 

} else {
return redirect()->to('Accueil')->send();

} ?>
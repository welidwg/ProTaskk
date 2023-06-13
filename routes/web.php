<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});


// Fonctions d'utilisateur
Route::get("/Logout", "UserController@Logout");
Route::post('/Userlog', 'UserController@Auth'); //check
Route::post('/AddAccount', 'UserController@AddAccount'); //check
Route::post('/DeleteAccount', 'UserController@DeleteAccount'); //check
Route::post('/EditAccount', 'UserController@EditAccount'); //check
Route::post('/PasswordRecovery', 'UserController@PasswordRecovery'); // check


// Fonctions de gestion de parametre
Route::get("/NotifNumber", "ParametreController@NumberNotif");
Route::get("/NotificationItems", "ParametreController@Notification_Items");
Route::post("/DeleteNotif", "ParametreController@DeleteNotif"); //check
Route::get("/ViderNotif", "ParametreController@ViderNotif"); //check
Route::post("/MessageSend", "ParametreController@MessageSend"); // check
Route::get("/Messages", "ParametreController@Messages"); //check
Route::post("/DeleteMessage", "ParametreController@DeleteMessage"); //check
Route::post("/DeleteMessageEnv", "ParametreController@DeleteMessageEnv"); //check
Route::post("/AjouterDemande", "ParametreController@AjouterDemande"); //check
Route::post("/AccepterDemande", "ParametreController@AccepterDemande"); //
Route::post("/UpdateDate", "ParametreController@UpdateDate"); //check
Route::get("/Session", "ParametreController@Session");




// fonction tache
Route::post("/AjouterTache", "TaskController@AjouterTache"); //check
Route::post("/ModifierTache", "TaskController@ModifierTache"); //check
Route::get("/SupprimerTache", "TaskController@SupprimerTache"); //check
Route::get("/Connected", "TaskController@Connected"); // check
Route::get("/StatsCHEF", "TaskController@StatsCHEF"); //check
Route::get("/Calendar", "TaskController@Calendar"); //check
Route::get("/ConsulterTache", "TaskController@ConsulterTache"); //check
Route::post("/AffecterTache", "TaskController@AffecterTache"); //check
Route::post("/ReAffect", "TaskController@ReAffect");
Route::post("/MiseAjour", "TaskController@MiseAjour"); //check
Route::post("/PasserTache", "TaskController@PasserTache"); // check
Route::get("/Rejete", "TaskController@Rejete"); //check
Route::get("/CommencerTache", "TaskController@CommencerTache"); // check






//fonction trop precu
Route::get("/ProcessControl", "TropPercuController@ProcessControl"); //Check
Route::post("/EditFolder", "TropPercuController@EditFolder"); //check
Route::get("/DateCorres", "TropPercuController@DateCorres"); //check
Route::post("/AjoutRecu", "TropPercuController@AjoutRecu"); //check
Route::post("/Process", "TropPercuController@Process"); //check
Route::get("/CHECK", "TropPercuController@VerifierExistance"); //check


















// Routage des pages lahné kol me taaml page thot url
// teha o fi ema page o tamllha fonction fi (pagesController.php) besh trajalk l view



Route::get('/index', 'PagesController@login');
Route::get("/Accueil", "PagesController@home");
Route::get("/Accounts", "PagesController@Accounts");
Route::get("/nav", "PagesController@Nav");
Route::get("/Stats", "PagesController@StatsTP");
Route::get("/Notifications", "PagesController@Notifications");
Route::get("/Tache", "PagesController@tache");
Route::get("/Inbox", "PagesController@Inbox");
Route::get("/StatUser", "PagesController@StatUser");
Route::get("/DossiersRefuses", "PagesController@DossiersRefuses");
Route::get("/ListeDossier", "PagesController@ListeDossier");
Route::get("/Controle", "PagesController@Controle");
Route::get("/Error", "PagesController@Error");
Route::get("/NotFound", "PagesController@NotFound");
Route::get("/ConsulterDetail", "PagesController@ConsulterDetail");
Route::get("/Consulter", "PagesController@Consulter");
Route::get("/ImprimerEtat", "PagesController@ImprimerEtat");
Route::get("/ImprimerCarteSuivi", "PagesController@ImprimerCarteSuivi");
Route::get("/ModifierDossier", "PagesController@ModifierDossier");
Route::get("/AjouterDossier", "PagesController@AjouterDossier");

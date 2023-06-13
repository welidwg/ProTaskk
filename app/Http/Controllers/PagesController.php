<?php

namespace App\Http\Controllers;


class PagesController extends Controller
{
    //
    function login()
    {

        return view("index");
    }
    function Home()
    {



        return view("Accueil");
    }

    function Nav()
    {



        return view("GestionDeParametre.nav");
    }

    function StatsTP()
    {
        return view("TropPercu.Statistiques");
    }
    function Accounts()
    {
        return view("GestionDeParametre.ListeDesComptes");
    }

    function Notifications()
    {
        return view("GestionDeParametre.notification");
    }

    function tache()
    {
        return view("GestionDeTaches.tache");
    }
    function inbox()
    {
        return view("GestionDeParametre.inbox");
    }

    function StatUser()
    {

        return view("TropPercu.StatUser");
    }


    function DossiersRefuses()
    {
        return view("TropPercu.DossiersRefuses");
    }

    function ListeDossier()
    {
        return view("TropPercu.ListeDossier");
    }

    function Controle()
    {
        return view("TropPercu.Controle");
    }

    function Error()
    {
        return view("Error");
    }

    function ConsulterDetail()
    {
        return view("TropPercu.ConsulterDetail");
    }

    function Consulter()
    {
        return view("TropPercu.Consulter");
    }

    function ImprimerEtat()
    {
        return view("TropPercu.ImprimerEtat");
    }

    function ImprimerCarteSuivi()
    {
        return view("TropPercu.ImprimerCarteSuivi");
    }
    function ModifierDossier()
    {
        return view("TropPercu.ModifierDossier");
    }

    function AjouterDossier()
    {
        return view("TropPercu.AjouterDossier");
    }
    function NotFound(){
                return view("404");

    }

    


}

<?php


namespace epicerie\controlers;


use epicerie\models\User;
use epicerie\views\VuePersonne;

class ControleurPersonne
{

    public function __construct(){
    }


    public function afficherToutLeMonde(){

        $pers = User::get();
        $vue = new VuePersonne($pers);
        $vue->render(VuePersonne::AFFICHER_TOUT_MONDE);
    }

    public function afficherUser($id){
        $pers = User::where('id', '=', $id)->first();
        $vue = new VuePersonne($pers);
        $vue->render(VuePersonne::AFFICHER_PERS);

    }

}
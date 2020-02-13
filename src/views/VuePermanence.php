<?php

namespace epicerie\views;

use Slim\Slim;

class VuePermanence {

    public $arr;

    public function __construct($a)
    {
        $this->arr = $a;
    }

    private function afficherCréationBesoin(){
        $html="";

        //FORMULAIRE
        $html .="<form method=\"post\">";
        $html .= '<input type="text" name="role" required placeholder="Role">';
        $html .= '<input type="text" name="creneau" required placeholder="Créneau">';
        $html .= '<button type=submit name="valider">Envoyer</button>';

        $html.="</form>";


        return $html;
    }

    public function render($selecteur)
    {
        $app = Slim::getInstance();
        $content = "";
        switch ($selecteur) {
            case 1:
            {
                $content = $this->afficherCréationBesoin();
                break;
            }
        }
        $html = "contenu à créer (Marius/valentin) + ".$content." + contenu à créer (Marius/valentin)";
        echo $html;
    }

}
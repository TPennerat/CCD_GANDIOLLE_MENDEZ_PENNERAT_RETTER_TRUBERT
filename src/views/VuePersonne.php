<?php


namespace epicerie\views;


use Slim\Slim;

class VuePersonne
{
    const AFFICHER_TOUT_MONDE = 1;
    const AFFICHER_PERS = 2;
    private $personnes;


    public function __construct($pers){
        $this->personnes = $pers;
    }

    public function afficherUsers(){
        $app = Slim::getInstance();
        $path = $app->request()->getRootUri();

        $res = "";
        foreach ($this->personnes as $pers){
            $url = $app->urlFor('afficher1User', ['id'=>$pers->id]);
            $res .= "<a href=$url> 
                            <h2>$pers->nom</h2><br>
                     </a>
                  
                    <img src=$path/web/img/$pers->urlimage <br>";
        }

        return $res;
    }

    public function afficher1User(){
        $app = Slim::getInstance();
        $path = $app->request()->getRootUri();
        $res = "<h2>{$this->personnes->nom}</h2><br>
              <img src=$path/web/img/{$this->personnes->urlimage}";
        return $res;
    }


    public function render($selecteur)
    {
        $app = Slim::getInstance();
        $content = "";
        switch ($selecteur) {
            case self::AFFICHER_TOUT_MONDE:
                $content = $this->afficherUsers();
                break;
            case self::AFFICHER_PERS:
                $content = $this->afficher1User();
                break;
        }
        $html = VuePermanence::getHeader($app) . $content . VuePermanence::getFooter($app);
        echo $html;
    }
}
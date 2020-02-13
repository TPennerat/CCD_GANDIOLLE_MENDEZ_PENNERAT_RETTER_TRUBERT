<?php

namespace epicerie\views;

use Slim\Slim;
use \epicerie\models\User as User;

class VueBesoins
{

    public $arr;

    public function __construct($a)
    {
        $this->arr = $a;
    }

    public function render($selecteur)
    {
        $app = Slim::getInstance();
        $content = "";
        switch ($selecteur) {
            case 1:
            {
                $content = $this->afficherToutesLesPermanences($app);
                break;
            }

        }
        $html = VuePermanence::getHeader($app, "Besoins") . $content . VuePermanence::getFooter($app);
        echo $html;
    }

    public static function changeSem($sem)
    {
        switch ($sem) {
            case 1 :
                return "A";
                break;
            case 2:
                return "B";
                break;
            case 3:
                return "C";
                break;
            case 4:
                return "D";
                break;

        }
        return 'A';
    }

    public function adapt()
    {
        $user = User::where("id","=",$_SESSION["id_connect"])->first();
        $app = Slim::getInstance();


        $coin ="";
        $html = "";
        $content = "";
        $ancienJour = 0;
        $compJour = 0;
        $passageUnique = true;
        $ex = explode('/', Slim::getInstance()->request->getPath());
        $sem = $ex[count($ex) - 1];
        foreach ($this->arr as $key) {
            if ($user->droit !=1) {
                $coin = <<<END
                <a href="$app->urlFor('supprimerBesoin', [id=>$key->id]);">
                <p style="font-weight:bold;font-size:1rem;color: white"><i class="pull-right fa fa-times"></i></p>
                </a>
                <a href="$app->urlFor('modifierBesoin', [id=>$key->id]);">
               <p style="font-weight:bold;font-size:1rem;color: white"><i class="pull-right fa fa-pencil-square-o"></i></p>
</a>
END;
            }
            if ($key->creneau->semaine == $sem) {
                $role = $key->role->label;
                $jour = $key->jour;
                if ($passageUnique) {
                    $passageUnique = false;
                    $ancienJour = $jour;
                }
                if ($key->jour !== $ancienJour) {
                    $j = $this->jour($ancienJour);
                    $html .= <<<END
<div class="col" style="padding:5px"><h3 class="text-center h4">$j</h3>
$content</div>
END;
                    $content = "";
                    $compJour = 0;
                    $ancienJour = $jour;
                }
                switch ($key->role->id) {
                    case 1:
                        $class = "c1";
                        break;
                    case 2:
                        $class = "c2";
                        break;
                    case 3:
                        $class = "c3";
                        break;
                    case 4:
                        $class = "c4";
                        break;
                    case 5:
                        $class = "c5";
                        break;
                    case 6:
                        $class = "c6";
                        break;
                }
                $deb = $key->creneau->hDeb . ":00";
                $fin = $key->creneau->hFin . ":00";
                $inscription = Slim::getInstance()->urlFor('inscrBes',["id"=>$key->id]);
                $content .= <<<END
<<<<<<< HEAD
<div id=$key->id class="overview-item overview-item--$class" style="padding:20px;margin-bottom:10px">
                <p style="font-weight:bold;font-size:1rem;color: white"><i class="pull-right fa fa-times"></i></p>
                <p style="font-weight:bold;font-size:1rem;color: white"><i class="pull-right fa fa-pencil-square-o"></i></p>
=======
<div class="overview-item overview-item--$class" style="padding:20px;margin-bottom:10px">
                $coin
>>>>>>> 43f2c4a22d7c99bccba920d70af9bf01215fba5e
                <div class="overview__inner">
                  <div class="peutEtreSupprime2 overview-box clearfix" style="width:auto">
                    <div class="text">
                      <h2 style="font-size:1.2rem">Permanence</h2>
                      <h2 style="font-size:1rem;font-weight:bold">$role</h2>
                      <span style="font-size:1rem">de $deb à $fin</span>
                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <button type="button" style="margin-top:15px" class="btn btn-block btn-info btn-sm"><a href="$inscription" style="color: inherit"><i class="fas fa-sign-in-alt"></i>&nbsp; S'inscrire</button></a>
                </div>
                </div>
END;

                $compJour++;
            }
        }
        $j = $this->jour($ancienJour);
        $html .= <<<END
<div class="col" style="padding:5px"><h3 class="text-center h4">$j</h3>
$content</div>
END;
        return $html;
    }

    public function jour($num)
    {
        $res = "";
        switch ($num) {
            case 1:
                $res .= "Lundi";
                break;
            case 2:
                $res .= "Mardi";
                break;
            case 3:
                $res .= "Mercredi";
                break;
            case 4:
                $res .= "Jeudi";
                break;
            case 5:
                $res .= "Vendredi";
                break;
            case 6:
                $res .= "Samedi";
                break;
            case 7:
                $res .= "Dimanche";
                break;
        }
        return $res;
    }

    private function afficherToutesLesPermanences($app)
    {
        $adapt = $this->adapt();
        $ex = explode('/', $app->request->getPath());
        $sem = $ex[count($ex) - 1];
        $creerBesoin = $app->urlFor('creerbes');
        $user = User::where("id","=",$_SESSION["id_connect"])->first();
        $ad="";
        $coin ="";
        if ($user->droit !=1) {
            $ad=<<<END
<div class="col-md-12" style="margin-left:20px;margin-bottom:20px">
          <a href="$creerBesoin"><button type="button" class="btn btn-outline-primary btn-lg">Creer un besoin</button></a>
        </div>
END;
            $coin = <<<END

END;
        }
        return <<<END

<!-- MAIN CONTENT-->
<div class="main-content">
  <div class="section__content section__content--p30" style="min-width:900px;padding:10px;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 text-center"><h2 class="h1" style="font-weight:bold">Besoins de la semaine $sem</h2></div>
        $ad
$adapt
      </div>
      <div class="w-100"></div>
    </div>
  </div>
</div>
<script type="text/javascript" src="$path/js/supprimer2.js"> </script>

<!-- END MAIN CONTENT-->
<!-- END PAGE CONTAINER-->

END;
    }


}

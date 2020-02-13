<?php
namespace epicerie\views;

use DateInterval;
use DateTime;
use Exception;
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
        $html = VuePermanence::getHeader($app,"Besoins") . $content . VuePermanence::getFooter($app);
        echo $html;
    }

    public static function changeSem($sem) {
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
        $html = "";
        $content = "";
        $ancienJour=0;
        $compJour = 0;
        $passageUnique = true;
        $ex=explode('/',Slim::getInstance()->request->getPath());
        $sem = $ex[count($ex)-1];

        foreach ($this->arr as $key) {
            if ($key->creneau->semaine == $sem ) {
                $role = $key->role->label;
                $jour = $key->creneau->jour;
                if ($passageUnique) {
                    $passageUnique = false;
                    $ancienJour = $jour;
                }
                $deb = $key->creneau->hDeb . ":00";
                $fin = $key->creneau->hFin . ":00";

                if ($compJour !== 0) {
                    $jour = "";
                }

                $content .= <<<END
<div class="overview-item overview-item--c1"style="padding:20px;margin-bottom:10px">
                <p style="font-weight:bold;font-size:1rem;color: white"><i class="pull-right fa fa-times"></i></p>
                <p style="font-weight:bold;font-size:1rem;color: white"><i class="pull-right fa fa-pencil-square-o"></i></p>
                <div class="overview__inner">
                  <div class="overview-box clearfix" style="width:auto">
                    <div class="text">
                      <h2 style="font-size:1.2rem">Permanence</h2>
                      <h2 style="font-size:1rem;font-weight:bold">$role</h2>
                      <span style="font-size:1rem">de $deb à $fin</span>
                    </div>
                  </div>
                </div>
                </div>
                <div class="text-center">
                  <button type="button" style="margin-top:15px" class="btn btn-block btn-info btn-sm"><i class="fas fa-sign-in-alt"></i>&nbsp; S'inscrire</button>
                </div>

END;
var_dump($content);
                $compJour++;
                if ($jour !== $ancienJour) {
                    $j = $this->jour($ancienJour);
                    $html .= <<<END
                    <div class="col" style="padding:5px"><h3 class="text-center h4">$j</h3>
                      <div class="col-12" style="padding:0px">
                       
$content

</div>
</div>
END;
                    $content = "";
                    $compJour = 0;
                }
            }
        }

        return $html;
    }

    private function afficherToutesLesPermanences($app)
    {
        $path = $app->urlFor('racine') . "/Bootstrap";
        $adapt = $this->adapt();
        $ex=explode('/',$app->request->getPath());
        $sem = $ex[count($ex)-1];
        $sem1=$app->urlFor("aff",["sem"=>"A"]);
        $sem2=$app->urlFor("aff",["sem"=>"B"]);
        $sem3=$app->urlFor("aff",["sem"=>"C"]);
        $sem4=$app->urlFor("aff",["sem"=>"D"]);
        $admin="";
        $racine = $app->urlFor('racine');
        $img="";
        $alt="";

        $deco=$app->urlFor('deco');
        $inscription=$app->urlFor('besoin');
        return <<<END

<!-- MAIN CONTENT-->
<div class="main-content">
  <div class="section__content section__content--p30" style="min-width:900px;padding:10px;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 text-center"><h2 class="h1" style="font-weight:bold">Besoins de la semaine $sem</h2></div>
        <div class="col-md-12" style="margin-left:20px;margin-bottom:20px">
          <a href="$inscription"><button type="button" class="btn btn-outline-primary btn-lg">Creer un besoin</button></a>
        </div>
$adapt
      </div>
      <div class="w-100"></div>
    </div>
  </div>
</div>
<!-- END MAIN CONTENT-->
<!-- END PAGE CONTAINER-->

END;
    }


}

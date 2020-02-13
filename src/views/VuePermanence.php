<?php

namespace epicerie\views;

use DateInterval;
use DateTime;
use Exception;
use Slim\Slim;
use \epicerie\models\User as User;

class VuePermanence
{

    public $arr;

    public function __construct($a)
    {
        $this->arr = $a;
    }

    public static function getHeader($app,$page)
    {

      $path = $app->urlFor('racine') . "/Bootstrap";
      $ex=explode('/',$app->request->getPath());
      $sem = $ex[count($ex)-1];
      $sem1=$app->urlFor("aff",["sem"=>"A"]);
      $sem2=$app->urlFor("aff",["sem"=>"B"]);
      $sem3=$app->urlFor("aff",["sem"=>"C"]);
      $sem4=$app->urlFor("aff",["sem"=>"D"]);
        $sem1bes=$app->urlFor("besoin",["sem"=>"A"]);
        $sem2bes=$app->urlFor("besoin",["sem"=>"B"]);
        $sem3bes=$app->urlFor("besoin",["sem"=>"C"]);
        $sem4bes=$app->urlFor("besoin",["sem"=>"D"]);
        $sem1cre=$app->urlFor("creneau",["sem"=>"A"]);
        $sem2cre=$app->urlFor("creneau",["sem"=>"B"]);
        $sem3cre=$app->urlFor("creneau",["sem"=>"C"]);
        $sem4cre=$app->urlFor("creneau",["sem"=>"D"]);
      $admin="";
      $racine = $app->urlFor('racine');
      $img="";
      $alt="";
      $gestionCompte ="";

      $deco=$app->urlFor('deco');
      $inscription=$app->urlFor('besoin');
      $creercompte=$app->urlFor('creerC');
      $modifcompte=$app->urlFor('modifierCompte');
      $compte=$app->urlFor('afficher1User',["id"=>$_SESSION["id_connect"]]);

        $user = User::where("id","=",$_SESSION["id_connect"])->first();

        if ($user->droit !=1) {
            $admin = <<<END
        <li>
                                          <a href="map.html">
                                            <i class="far fa-calendar-alt"></i>Planning général</a> <!--Que pour administrateur-->
                                          </li>
                                          <li>
                                            <a href="$creercompte">
                                              <i class="fas fa-pencil-alt"></i>Créer un compte</a> <!--Que pour administrateur-->
                                            </li>
END;
            $gestionCompte = <<<END

      <div class="account-dropdown__body">
        <div class="account-dropdown__item">
          <a href="$compte">
            <i class="zmdi zmdi-account"></i>Compte</a>
          </div>
          <div class="account-dropdown__item">
            <a href="$modifcompte">
              <i class="zmdi zmdi-settings"></i>Paramètres</a>
            </div>
            <div class="account-dropdown__footer">
              <a href="$deco">
                <i class="zmdi zmdi-power"></i>Se déconnecter</a>
              </div>
            </div>
          </div>
        </div>
      </div>
END;


}else{ $gestionCompte = <<<END

      <div class="account-dropdown__body">

          <div class="account-dropdown__item">

            <div class="account-dropdown__footer">
              <a href="$deco">
                <i class="zmdi zmdi-power"></i>Se déconnecter</a>
            </div>
        </div>
      </div>
END;

        }
            $img=$app->urlFor('racine').'/web/img/'.$user->urlimage;
            $alt=$user->nom;

        $deco=$app->urlFor('deco');

        $creerCompte=$app->urlFor('creerCompte');
        $modifCompte=$app->urlFor('modifierCompte');
        $graphique=$app->urlFor('graphique');
        $users = $app->urlFor('afficherUsers');
        $res = <<<END
      <!DOCTYPE html>
      <html lang="en">

      <head>
          <!-- Required meta tags-->
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
          <meta name="description" content="au theme template">
          <meta name="author" content="Hau Nguyen">
          <meta name="keywords" content="au theme template">

          <!-- Title Page-->
          <title>CoBoard</title>
          <link rel="icon" type="image/png" href="$path/images/icon/logo_fav.png">

          <!-- Fontfaces CSS-->
          <link href="$path/css/font-face.css" rel="stylesheet" media="all">
          <link href="$path/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
          <link href="$path/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
          <link href="$path/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

          <!-- Bootstrap CSS-->
          <link href="$path/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

          <!-- Vendor CSS-->
          <link href="$path/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
          <link href="$path/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
          <link href="$path/vendor/wow/animate.css" rel="stylesheet" media="all">
          <link href="$path/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
          <link href="$path/vendor/slick/slick.css" rel="stylesheet" media="all">
          <link href="$path/vendor/select2/select2.min.css" rel="stylesheet" media="all">
          <link href="$path/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

          <!-- Main CSS-->
          <link href="$path/css/theme.css" rel="stylesheet" media="all">

      </head>

      <body class="animsition">
  <div class="page-wrapper">
  <!-- HEADER MOBILE-->
  <header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
      <div class="container-fluid">
        <div class="header-mobile-inner">
          <a class="logo" href="$racine">
            <img class="col-5"src="$path/images/icon/logo.png" alt="CoolAdmin" />
          </a>
          <button class="hamburger hamburger--slider" type="button">
            <span class="hamburger-box">
              <span class="hamburger-inner"></span>
            </span>
          </button>
        </div>
      </div>
    </div>
    <nav class="navbar-mobile">
      <div class="container-fluid">
        <ul class="navbar-mobile__list list-unstyled">
          <li class="has-sub">
            <a class="js-arrow" href="#">
              <i class="fas fa-tasks"></i>Planning personnel</a>
              <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                <li>
                  <a href="$sem1">Semaine A</a>
                </li>
                <li>
                  <a href="$sem2">Semaine B</a>
                </li>
                <li>
                  <a href="$sem3">Semaine C</a>
                </li>
                <li>
                  <a href="$sem4">Semaine D</a>
                </li>
              </ul>
            </li>
              <li>
                <a href="$graphique">
                  <i class="fas fa-chart-bar"></i>Graphique</a>
                </li>
                <li class="has-sub">
                  <a class="js-arrow" href="#">
                    <i class="fas fa-heart"></i>Besoins</a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                      <li>
                        <a href="$sem1">Semaine A</a>
                      </li>
                      <li>
                        <a href="$sem2">Semaine B</a>
                      </li>
                      <li>
                        <a href="$sem3">Semaine C</a>
                      </li>
                      <li>
                        <a href="$sem4">Semaine D</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <a href="$users">
                      <i class="fa fa-users"></i>Utilisateurs</a>
                    </li>
                    <li class="has-sub">
                      <a class="js-arrow" href="#">
                        <i class="fas fa-clock"></i>Créneaux</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                          <li>
                                            <a href="$sem1cre">Semaine A</a>
                                          </li>
                                          <li>
                                            <a href="$sem2cre">Semaine B</a>
                                          </li>
                                          <li>
                                            <a href="$sem3cre">Semaine C</a>
                                          </li>
                                          <li>
                                            <a href="$sem4cre">Semaine D</a>
                                          </li>
                        </ul>
                      </li>
                      $admin

                        </ul>
                      </div>
                    </nav>
                  </header>
                  <!-- END HEADER MOBILE-->

                    <!-- MENU SIDEBAR-->
                    <aside class="menu-sidebar d-none d-lg-block">
                      <div class="logo">
                        <a href="$racine">
                          <img src="$path/images/icon/logo.png" alt="Cool Admin" />
                        </a>
                      </div>
                      <div class="menu-sidebar__content js-scrollbar1">
                        <nav class="navbar-sidebar">
                          <ul class="list-unstyled navbar__list">
                            <li class="has-sub">
                              <a class="js-arrow" href="#">
                                <i class="fas fa-tasks"></i>Planning personnel</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                  <li>
                                    <a href="$sem1">Semaine A</a>
                                  </li>
                                  <li>
                                    <a href="$sem2">Semaine B</a>
                                  </li>
                                  <li>
                                    <a href="$sem3">Semaine C</a>
                                  </li>
                                  <li>
                                    <a href="$sem4">Semaine D</a>
                                  </li>
                                </ul>
                              </li>
                              <li>
                                <a href="$graphique">
                                  <i class="fa fa-chart-bar"></i>Graphique</a>
                                </li>
                                  <li class="has-sub">
                                    <a class="js-arrow" href="#">
                                      <i class="fa fa-heart"></i>Besoins</a>
                                      <ul class="list-unstyled navbar__sub-list js-sub-list">
                                        <li>
                                    <a href="$sem1bes">Semaine A</a>
                                  </li>
                                  <li>
                                    <a href="$sem2bes">Semaine B</a>
                                  </li>
                                  <li>
                                    <a href="$sem3bes">Semaine C</a>
                                  </li>
                                  <li>
                                    <a href="$sem4bes">Semaine D</a>
                                  </li>
                                      </ul>
                                    </li>
                                  <li>
                                    <a href="$users">
                                      <i class="fa fa-users"></i>Utilisateurs</a>
                                    </li>
                                    <li class="has-sub">
                                      <a class="js-arrow" href="#">
                                        <i class="fas fa-clock"></i>Créneaux</a>
                                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                                          <li>
                                            <a href="$sem1cre">Semaine A</a>
                                          </li>
                                          <li>
                                            <a href="$sem2cre">Semaine B</a>
                                          </li>
                                          <li>
                                            <a href="$sem3cre">Semaine C</a>
                                          </li>
                                          <li>
                                            <a href="$sem4cre">Semaine D</a>
                                          </li>
                                        </ul>
                                      </li>
                                      $admin
                                        <li>
                                        <a href="https://www.grandeepiceriegenerale.fr" target="_blank">
                                        <i class="fa fa-mouse-pointer"></i>Visitez notre site </a>
                                        </li>
                                          </ul>
                                        </nav>
                                      </div>
                                    </aside>
                                    <!-- END MENU SIDEBAR-->

                                      <!-- PAGE CONTAINER-->
                                      <div class="page-container">
                                        <!-- HEADER DESKTOP-->
                                        <header class="header-desktop">
                                          <div class="section__content section__content--p30">
                                            <div class="container-fluid">
                                              <div class="header-wrap">
                                                <h2 class="title-1">$page</h2>
                                                <!--<form class="form-header" action="" method="POST">
                                                <input class="au-input au-input--xl" type="text" name="search" placeholder="Recherche" />
                                                <button class="au-btn--submit" type="submit">
                                                <i class="zmdi zmdi-search"></i>
                                              </button>
                                            </form>-->
                                            <!--Barre de recherche-->
                                            <div class="header-button">
                                              <div class="noti-wrap">
                                                <!--<div class="noti__item js-item-menu">
                                                <i class="zmdi zmdi-comment-more"></i>
                                                <span class="quantity">6</span>
                                                <div class="mess-dropdown js-dropdown">
                                                <div class="mess__title">
                                                <p>You have 2 news message</p>
                                              </div>
                                              <div class="mess__item">
                                              <div class="image img-cir img-40">
                                              <img src="$path/images/icon/avatar-06.jpg" alt="Michelle Moreno" />
                                            </div>
                                            <div class="content">
                                            <h6>Michelle Moreno</h6>
                                            <p>Have sent a photo</p>
                                            <span class="time">3 min ago</span>
                                          </div>
                                        </div>
                                        <div class="mess__item">
                                        <div class="image img-cir img-40">
                                        <img src="$path/images/icon/avatar-04.jpg" alt="Diane Myers" />
                                      </div>
                                      <div class="content">
                                      <h6>Diane Myers</h6>
                                      <p>You are now connected on message</p>
                                      <span class="time">Yesterday</span>
                                    </div>
                                  </div>
                                  <div class="mess__footer">
                                  <a href="#">View all messages</a>
                                </div>
                              </div>
                            </div>
                            <div class="noti__item js-item-menu">
                            <i class="zmdi zmdi-email"></i>
                            <span class="quantity">1</span>
                            <div class="email-dropdown js-dropdown">
                            <div class="email__title">
                            <p>You have 3 New Emails</p>
                          </div>
                          <div class="email__item">
                          <div class="image img-cir img-40">
                          <img src="$path/images/icon/avatar-06.jpg" alt="Cynthia Harvey" />
                        </div>
                        <div class="content">
                        <p>Meeting about new dashboard...</p>
                        <span>Cynthia Harvey, 3 min ago</span>
                      </div>
                    </div>
                    <div class="email__item">
                    <div class="image img-cir img-40">
                    <img src="$path/images/icon/avatar-05.jpg" alt="Cynthia Harvey" />
                  </div>
                  <div class="content">
                  <p>Meeting about new dashboard...</p>
                  <span>Cynthia Harvey, Yesterday</span>
                </div>
              </div>
              <div class="email__item">
              <div class="image img-cir img-40">
              <img src="$path/images/icon/avatar-04.jpg" alt="Cynthia Harvey" />
            </div>
            <div class="content">
            <p>Meeting about new dashboard...</p>
            <span>Cynthia Harvey, April 12,,2018</span>
          </div>
        </div>
        <div class="email__footer">
        <a href="#">See all emails</a>
      </div>
    </div>
  </div>
  <div class="noti__item js-item-menu">
  <i class="zmdi zmdi-notifications"></i>
  <span class="quantity">3</span>
  <div class="notifi-dropdown js-dropdown">
  <div class="notifi__title">
  <p>You have 3 Notifications</p>
</div>
<div class="notifi__item">
<div class="bg-c1 img-cir img-40">
<i class="zmdi zmdi-email-open"></i>
</div>
<div class="content">
<p>You got a email notification</p>
<span class="date">April 12, 2018 06:50</span>
</div>
</div>
<div class="notifi__item">
<div class="bg-c2 img-cir img-40">
<i class="zmdi zmdi-account-box"></i>
</div>
<div class="content">
<p>Your account has been blocked</p>
<span class="date">April 12, 2018 06:50</span>
</div>
</div>
<div class="notifi__item">
<div class="bg-c3 img-cir img-40">
<i class="zmdi zmdi-file-text"></i>
</div>
<div class="content">
<p>You got a new file</p>
<span class="date">April 12, 2018 06:50</span>
</div>
</div>
<div class="notifi__footer">
<a href="#">All notifications</a>
</div>
</div>
</div>-->
<!--Notification-->
</div>

<div class="account-wrap">
  <div class="account-item clearfix js-item-menu">
    <div class="image">
      <img src="$img" alt="$alt" />
    </div>
    <div class="content">
      <a class="js-acc-btn" href="#">$alt</a>
    </div>
    <div class="account-dropdown js-dropdown">
      <div class="info clearfix">
        <div class="image">
          <a href="#">
            <img src="$img" alt="$alt" />
          </a>
        </div>
        <div class="content">
          <h5 class="name">
            <a href="#">$alt</a>
          </h5>
        </div>
      </div>


       $gestionCompte
    </div>
  </div>
</div>
</header>
<!-- HEADER DESKTOP-->

END;
        return $res;

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
            if ($key->creneau->semaine == $sem) {
                $jour = $key->creneau->jour;
                if ($passageUnique) {
                    $passageUnique = false;
                    $ancienJour = $jour;
                }
                if ($key->creneau->jour !== $ancienJour) {
                    $j = $this->jour($ancienJour);
                    $html .= <<<END
<div class="col" style="padding:5px"><h3 class="text-center h4">$j</h3>
$content</div>
END;
                    $content = "";
                    $compJour = 0;
                    $ancienJour = $jour;
                }


                $deb = $key->creneau->hDeb . ":00";
                $fin = $key->creneau->hFin . ":00";
                $role = $key->role->label;
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
                $content .= <<<END
<div class="col-12" style="padding:0px">
            <div class="overview-item overview-item--$class" style="padding:20px;margin-bottom:10px">
              <p style="font-weight:bold;font-size:1rem;color: white"><i class="pull-right fa fa-times"></i></p>
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

    public static function getFooter($app)
    {


        $path = $app->urlFor('racine') . "/Bootstrap";
        return <<<END
      <!-- Jquery JS-->
      <script src="$path/vendor/jquery-3.2.1.min.js"></script>
      <!-- Bootstrap JS-->
      <script src="$path/vendor/bootstrap-4.1/popper.min.js"></script>
      <script src="$path/vendor/bootstrap-4.1/bootstrap.min.js"></script>
      <!-- Vendor JS       -->
      <script src="$path/vendor/slick/slick.min.js">
      </script>
      <script src="$path/vendor/wow/wow.min.js"></script>
      <script src="$path/vendor/animsition/animsition.min.js"></script>
      <script src="$path/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
      </script>
      <script src="$path/vendor/counter-up/jquery.waypoints.min.js"></script>
      <script src="$path/vendor/counter-up/jquery.counterup.min.js">
      </script>
      <script src="$path/vendor/circle-progress/circle-progress.min.js"></script>
      <script src="$path/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
      <script src="$path/vendor/chartjs/Chart.bundle.min.js"></script>
      <script src="$path/vendor/select2/select2.min.js">
      </script>

      <!-- Main JS-->
      <script src="$path/js/main.js"></script>

  </body>

  </html>
END;
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

    private function afficherMesPermanences($app)
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
        $inscription=$app->urlFor('besoin',["sem"=>$sem]);$inscription=$app->urlFor('besoin',["sem"=>$sem]);
        return <<<END

<!-- MAIN CONTENT-->
<div class="main-content">
  <div class="section__content section__content--p30" style="min-width:900px;padding:10px;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 text-center"><h2 class="h1" style="font-weight:bold">Planning personnel de la semaine $sem</h2></div>
        <div class="col-md-12" style="margin-left:20px;margin-bottom:20px">
          <a href="$inscription"><button type="button" class="btn btn-outline-primary btn-lg">S'inscrire à une permanence</button></a>
        </div>
$adapt
      </div>
      <div class="w-100"></div>
    </div>
  </div>
</div>
<!-- END MAIN CONTENT-->
<!-- END PAGE CONTAINER-->
</div>

</div>

END;
    }

    private function afficherCreationBesoin($app)
    {

        $html = "";

        $creneaux = $this->arr[0];
        $roles = $this->arr[1];

        $contentCre = "";
        $contentRoles = "";

        foreach ($creneaux as $cre) {
            $date = $this->calc_date("2020-02-10",$cre->jour,$cre->semaine,$cre->cycle);
            $contentCre .= "<option value=\"$cre->id\"> $date->jour_no/$date->mois_no De : $cre->hDeb h à $cre->hFin h </option>";
        }

        $html.='<label for="cren">Choisir créneau : </label><select>'.$contentCre.'</select><br>';

        foreach ($roles as $role) {
            $contentRoles .= "<option value=\"$role->id\"> $role->label </option>";
        }

        $html.='<label for="role">Choisir role : </label><select>'.$contentRoles.'</select>';

        $path = $app->urlFor('creerBesoin');

        $html.="<form action=$path  id=\"carform\"><input type=\"submit\"></form>";

        return $html;
    }

    function calc_date($ancre, $semaine, $jour, $cycle = 0)
    {
        // On vérifie les paramètres...
        if ((gettype($cycle) !== 'integer') || ($cycle < 0))
            throw new Exception('calc_date : mauvais numéro de cycle');

        if ((gettype($semaine) !== 'string') || (strlen($semaine) != 1) ||
            (ord($semaine) - ord('A') < 0) || (ord($semaine) - ord('A') > 3))
            throw new Exception('calc_date : le n° de semaine doit être entre A et D (inclus)');

        if ((gettype($jour) !== 'integer') || ($jour < 1) || ($jour > 7))
            throw new Exception('calc_date : le n° de jour doit être entre 1 et 7 (inclus)');

        // On calcule le jour recherché (décalage entier par rapport
        // à la date de départ -- « l'ancre »)
        $nb_jours = $cycle * 28 + (ord($semaine) - ord('A')) * 7 + $jour - 1;
        $date_init = new DateTime($ancre);
        $date_res = $date_init->add(new DateInterval('P' . $nb_jours . 'D'))->format('U');

        // Attention, distinguo Windows/reste du monde (Windows, WinNT, Win32)
        $format_jour_no = (preg_match('#win[dn3]#', PHP_OS))? '%#d' : '%e';

        // Génération du résultat
        return (object) [
            'jour_no' => strftime($format_jour_no, $date_res),
            'jour_nom_court' => strftime('%a', $date_res),
            'jour_nom' => strftime('%A', $date_res),
            'mois_no' => strftime('%m', $date_res),
            'mois_nom_court' => strftime('%b', $date_res),
            'mois_nom' => strftime('%B', $date_res),
            'annee_no' => strftime('%Y', $date_res),
            'annee_no_court' => strftime('%y', $date_res)
        ];
    }


    public function render($selecteur)
    {
        $app = Slim::getInstance();
        $content = "";
        switch ($selecteur) {
            case 1:
            {
                $content = $this->afficherCreationBesoin($app);
                break;
            }
            case 2:
            {
                $content = $this->afficherMesPermanences($app);
                break;
            }
        }
        $html = self::getHeader($app,'Planning Personnel') . $content . self::getFooter($app);
        echo $html;
    }


}

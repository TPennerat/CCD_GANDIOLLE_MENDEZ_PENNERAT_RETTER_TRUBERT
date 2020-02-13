<?php

namespace epicerie\views;

use DateInterval;
use DateTime;
use Exception;
use Slim\Slim;

class VuePermanence
{

    public $arr;

    public function __construct($a)
    {
        $this->arr = $a;
    }

    public static function getHeader($app)
    {

        $path = $app->urlFor('racine') . "/Bootstrap";


        return <<<END
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
          <title>COBOARD</title>

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
END;

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
        $jour=0;
        $passageUnique = true;
        $passageUnique2 = true;
        foreach ($this->arr as $key) {
            $role = $key->role->label;
            $jour = $key->creneau->jour;
            if ($passageUnique) {
                $passageUnique=false;
                $ancienJour=$jour;
            }
            $deb = $key->creneau->hDeb . ":00";
            $fin = $key->creneau->hFin . ":00";
            $class = "c1";
            if ($compJour === 1) {
                $class = "c2";
                $jour = "";
            } elseif ($compJour === 2) {
                $class = "c3";
                $jour = "";
            } elseif ($compJour === 3) {
                $class = "c4";
                $jour = "";
            } elseif ($compJour === 4) {
                $class = "c5";
                $jour = "";
            } elseif ($compJour === 5) {
                $class = "c6";
                $jour = "";
                $compJour = 0;
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
            if ($jour!==$ancienJour) {
                if ($passageUnique2) {
                    $j = $this->jour($ancienJour);
                    $passageUnique2 = false;
                } else {
                    $j = $this->jour($jour);

                }
                $html.=<<<END
<div class="col" style="padding:5px"><h3 class="text-center h4">$j</h3>
$content</div>
END;
                $content="";
                $compJour=0;
            }
        }

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

    private function afficherMesPermanences($app)
    {
        $path = $app->urlFor('racine') . "/Bootstrap";
        $adapt = $this->adapt();
        return <<<END
      <body class="animsition">
  <div class="page-wrapper">
    <!-- HEADER MOBILE-->
    <header class="header-mobile d-block d-lg-none">
      <div class="header-mobile__bar">
        <div class="container-fluid">
          <div class="header-mobile-inner">
            <a class="logo" href="index.html">
              <img class="col-5"src="images/icon/logo.png" alt="CoolAdmin" />
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
            <li>
              <a href="calendar.html">
                <i class="fas fa-calendar-alt"></i>Planning personnel</a>
              </li>
            <li class="has-sub">
              <a class="js-arrow" href="#">
                <i class="fas fa-tachometer-alt"></i>Semaines</a>
                <p>erreur<p>
                <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                  <li>
                    <a href="index.html">Semaine 1</a>
                  </li>
                  <li>
                    <a href="index2.html">Semaine 2</a>
                  </li>
                  <li>
                    <a href="index3.html">Semaine 3</a>
                  </li>
                  <li>
                    <a href="index4.html">Semaine 4</a>
                  </li>
                </ul>
              </li>
              <li>
                <a href="chart.html">
                  <i class="fas fa-chart-bar"></i>Graphique</a>
                </li>
                <li>
                  <a href="table.html">
                    <i class="fas fa-table"></i>Besoins</a>
                  </li>
                  <li>
                    <a href="form.html">
                      <i class="far fa-check-square"></i>Utilisateurs</a>
                    </li>
                    <li>
                      <a href="calendar.html">
                        <i class="fas fa-calendar-alt"></i>Créneaux</a>
                      </li>
                      <li>
                        <a href="map.html">
                          <i class="fas fa-map-marker-alt"></i>Planning général</a> <!--Que pour administrateur-->
                        </li>
                        <li>
                          <a href="map.html">
                            <i class="fas fa-map-marker-alt"></i>Créer un compte</a> <!--Que pour administrateur-->
                          </li>

                            </ul>
                          </div>
                        </nav>
                      </header>
                      <!-- END HEADER MOBILE-->

                      <!-- MENU SIDEBAR-->
                      <aside class="menu-sidebar d-none d-lg-block">
                        <div class="logo">
                          <a href="#">
                            <img src="images/icon/logo.png" alt="Cool Admin" />
                          </a>
                        </div>
                        <div class="menu-sidebar__content js-scrollbar1">
                          <nav class="navbar-sidebar">
                            <ul class="list-unstyled navbar__list">
                              <li>
                                <a href="calendar.html">
                                  <i class="fas fa-calendar-alt"></i>Planning personnel</a>
                                </li>
                              <li class="active has-sub">
                                <a class="js-arrow" href="#">
                                  <i class="fas fa-tachometer-alt"></i>Cycles</a>
                                  <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                      <a href="index.html">Cycle 1</a>
                                    </li>
                                    <li>
                                      <a href="index2.html">Cycle 2</a>
                                    </li>
                                    <li>
                                      <a href="index3.html">Cycle 3</a>
                                    </li>
                                    <li>
                                      <a href="index4.html">Cycle 4</a>
                                    </li>
                                  </ul>
                                </li>
                                <li>
                                  <a href="chart.html">
                                    <i class="fas fa-chart-bar"></i>Graphique</a>
                                  </li>
                                  <li>
                                    <a href="table.html">
                                      <i class="fas fa-table"></i>Besoins</a>
                                    </li>
                                    <li>
                                      <a href="form.html">
                                        <i class="far fa-check-square"></i>Utilisateurs</a>
                                      </li>
                                      <li>
                                        <a href="calendar.html">
                                          <i class="fas fa-calendar-alt"></i>Créneaux</a>
                                        </li>
                                        <li>
                                          <a href="map.html">
                                            <i class="fas fa-map-marker-alt"></i>Planning général</a> <!--Que pour administrateur-->
                                          </li>
                                          <li>
                                            <a href="map.html">
                                              <i class="fas fa-map-marker-alt"></i>Créer un compte</a> <!--Que pour administrateur-->
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
                                                <h2 class="title-1">Planning personnel</h2>
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
                                              <img src="images/icon/avatar-06.jpg" alt="Michelle Moreno" />
                                            </div>
                                            <div class="content">
                                            <h6>Michelle Moreno</h6>
                                            <p>Have sent a photo</p>
                                            <span class="time">3 min ago</span>
                                          </div>
                                        </div>
                                        <div class="mess__item">
                                        <div class="image img-cir img-40">
                                        <img src="images/icon/avatar-04.jpg" alt="Diane Myers" />
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
                          <img src="images/icon/avatar-06.jpg" alt="Cynthia Harvey" />
                        </div>
                        <div class="content">
                        <p>Meeting about new dashboard...</p>
                        <span>Cynthia Harvey, 3 min ago</span>
                      </div>
                    </div>
                    <div class="email__item">
                    <div class="image img-cir img-40">
                    <img src="images/icon/avatar-05.jpg" alt="Cynthia Harvey" />
                  </div>
                  <div class="content">
                  <p>Meeting about new dashboard...</p>
                  <span>Cynthia Harvey, Yesterday</span>
                </div>
              </div>
              <div class="email__item">
              <div class="image img-cir img-40">
              <img src="images/icon/avatar-04.jpg" alt="Cynthia Harvey" />
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
      <img src="images/icon/avatar-01.jpg" alt="John Doe" />
    </div>
    <div class="content">
      <a class="js-acc-btn" href="#">john doe</a>
    </div>
    <div class="account-dropdown js-dropdown">
      <div class="info clearfix">
        <div class="image">
          <a href="#">
            <img src="images/icon/avatar-01.jpg" alt="John Doe" />
          </a>
        </div>
        <div class="content">
          <h5 class="name">
            <a href="#">john doe</a>
          </h5>
          <span class="email">johndoe@example.com</span>
        </div>
      </div>
      <div class="account-dropdown__body">
        <div class="account-dropdown__item">
          <a href="#">
            <i class="zmdi zmdi-account"></i>Compte</a>
          </div>
          <div class="account-dropdown__item">
            <a href="#">
              <i class="zmdi zmdi-settings"></i>Paramètres</a>
            </div>
            <div class="account-dropdown__footer">
              <a href="#">
                <i class="zmdi zmdi-power"></i>Se déconnecter</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</header>
<!-- HEADER DESKTOP-->

<!-- MAIN CONTENT-->
<div class="main-content">
  <div class="section__content section__content--p30" style="min-width:900px;padding:10px;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12" style="margin-bottom:20px">
          <button type="button" class="btn btn-outline-primary btn-lg">S'inscrire à une permanence</button>
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

    private function afficherCréationBesoin($app)
    {

        $creneaux = $this->arr[0];
        $roles = $this->arr[1];

        $contentCre = "";
        $contentRoles = "";

        foreach ($creneaux as $cre) {
            $contentCre .= "<option value=\"$cre->id\"> Jour : $cre->jour </option>";
        }

        foreach ($roles as $role) {
            $contentRoles .= "<option value=\"$role->id\"> $role->nomRole </option>";
        }

        $path = $app->urlFor('creerBesoin');
    }


    public function render($selecteur)
    {
        $app = Slim::getInstance();
        $content = "";
        switch ($selecteur) {
            case 1:
            {
                $content = $this->afficherCréationBesoin($app);
                break;
            }
            case 2:
            {
                $content = $this->afficherMesPermanences($app);
                break;
            }
        }
        $html = self::getHeader($app) . $content . self::getFooter($app);
        echo $html;
    }

}

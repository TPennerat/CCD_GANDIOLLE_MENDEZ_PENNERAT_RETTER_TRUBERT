<?php

namespace epicerie\views;

class VueComptes {


  public static function getHeader($app) {

    $path =  $app->urlFor('racine') + "/Bootstrap";

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
        <title>Login</title>

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

  public static function getFooter($app) {

    $path = $app->urlFor('racine') + "/Bootstrap";

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

  public function renderConnexion($app,$erreur) {

    $html = self::getHeader($app) . <<<END

    <body class="animsition">
        <div class="page-wrapper">
            <div class="page-content--bge5">
                <div class="container">
                    <div class="login-wrap">
                        <div class="login-content">
                            <div class="login-logo">
                                <a href="#">
                                    <img src="images/icon/logo.png" alt="CoolAdmin">
                                </a>
                            </div>
                            <div class="login-form">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label>Adresse Email</label>
                                        <input class="au-input au-input--full" type="email" name="email" placeholder="Votre email">
                                    </div>
                                    <div class="form-group">
                                        <label>Mot de passe</label>
                                        <input class="au-input au-input--full" type="password" name="password" placeholder="Votre mot de passe">
                                    </div>
                                    <div class="login-checkbox">
                                    </div>
                                    <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Valider</button>
                                  </form>
                                <div class="register-link">
                                    <p>
                                        Vous n'avez pas encore de compte ?
                                        <a href="#">S'enregistrer Ici</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

END;

    $html = $html . self::getFooter($app);

    echo $html;

  }

}

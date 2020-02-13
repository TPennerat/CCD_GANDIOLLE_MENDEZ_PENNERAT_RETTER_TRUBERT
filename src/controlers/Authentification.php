<?php

namespace epicerie\models;

use \epicerie\models\User as User;

class Authentification
{

    public static function createUser($login, $password)
    {

        if (User::where('nom', '=', $login)->first() != null) {
            throw new \Exception("Un utilisateur a deja ce login");
        }

        if (strlen($password) < 7) {
            throw new \Exception("Le mot de passe doit faire au moins 8 caractères");
        }

        if (strlen($login) > 15) {
            throw new \Exception("Le login doit faire moins de 16 caractères");
        } else if (strlen($login) < 4) {
            throw new \Exception("Le login doit faire au moins 4 caractères");
        }

        $u = new User();
        $u->username = $login;
        $u->hash = password_hash($password, PASSWORD_DEFAULT,
            ['cost' => 12]);
        $u->save();

        self::loadProfile($u->username);
    }

    public static function seConnecter($login, $password)
    {

        $u = User::where('login', '=', $login)->first();

        if ($u == null) {
            throw new \Exception("Utilisateur inexistant");
        }

        if (password_verify($password, $u->hash)) {
            self::loadProfile($login);
        } else {
            throw new \Exception("Mauvais mot de passe");
        }

    }

    private static function loadProfile($login)
    {

        $_SESSION['id_connect'] = User::where('login', '=', $login)->first()->id;

    }

}

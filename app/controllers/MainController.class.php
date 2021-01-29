<?php

namespace app\controllers;

use core\App;
use core\SessionUtils;
use core\Message;
use core\Utils;
use core\ParamUtils;
use core\Validator;

class MainController
{
    private $user;

    function __construct()
    {
        $this->user = SessionUtils::load('user', true);     // uzytkownik z sesji
    }

    public function action_main()
    {
        $role = $this->user['role'];

        $menus = [
            'users_menu' => [
                'show' => $role == ADMIN, // tylko admin moze dodac/zobaczyc uzytkownikow
                'text' => 'Zarządzaj użytkownikami',
                'url' => App::getConf()->app_url . '/users',
            ],
            'logout' => [
                'show' => true,
                'text' => 'Wyloguj się',
                'url' => App::getConf()->app_url . '/logout',
            ],
        ];


        App::getSmarty()->assign("menus", $menus);
        App::getSmarty()->assign("user", $this->user);

        App::getSmarty()->display("main.tpl");
    }

}

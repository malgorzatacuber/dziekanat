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

    private function get_all_statements() {
        try {
            return App::getDB()->select('statement', [
                'statement.message',
            ]);
        } catch (\PDOException $e) { // jesli wystapi jakis blad, powiedzmy o tym uzytkownikowi
            Utils::addErrorMessage("Błąd połączenia z bazą danych <br />");
        }
        return null; // jesli bedzie blad - zwroc null
    }

    public function action_main()
    {
        $role = $this->user['role'];

        $menus = [
            'marks_menu' => [
                'show' => $role == PROWADZACY, // tylko prowadzacy moze sprawdzic oceny uczniow / dodac nowe
                'text' => 'Oceny',  // tekst jaki sie pojawi
                'url' => App::getConf()->app_url . '/marks', // adres na ktory zostaniemy przekierowani po kliknieciu w menu
            ],
            'my_marks_menu' => [
                'show' => $role == UCZEN, // tylko uczen moze sprawdzic swoje oceny
                'text' => 'Moje oceny',
                'url' => App::getConf()->app_url . '/mymarks',
            ],
            'users_menu' => [
                'show' => $role == ADMIN, // tylko admin moze dodac/zobaczyc uzytkownikow
                'text' => 'Zarządzaj użytkownikami',
                'url' => App::getConf()->app_url . '/users',
            ],
            'statements_menu' => [
                'show' => $role == ADMIN || $role == DZIEKANAT, // tylko admin/dziekanat moze dodac komunikaty
                'text' => 'Zarządzaj komunikatami',
                'url' => App::getConf()->app_url . '/statements',
            ],
            'logout' => [
                'show' => true,
                'text' => 'Wyloguj się',
                'url' => App::getConf()->app_url . '/logout',
            ],
        ];

        $statements = $this->get_all_statements();

        App::getSmarty()->assign("menus", $menus);
        App::getSmarty()->assign("user", $this->user);
        App::getSmarty()->assign("statements", $statements);
        App::getSmarty()->display("main.tpl");
    }

}

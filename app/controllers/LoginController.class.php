<?php

namespace app\controllers;

use core\App;
use core\SessionUtils;
use core\Message;
use core\Utils;
use core\ParamUtils;
use core\Validator;

class LoginController
{
    private $user;  // uzytkownik z sesji
    private $login_user = []; // dane uzytkownika z logowania (z forumlarza na stronie)

    function __construct()
    {
        $this->user = SessionUtils::load('user', true); // sprawdzmy czy uzytkownik jest w sesji

        if ($this->user) { // jesli jest
            SessionUtils::remove('user'); // skoro chce sie zalogowac to go wyrzucamy z sesji
        }

        $this->login_user['login'] = ParamUtils::getFromRequest("login"); // wez z wyslanego formularza login
        $this->login_user['password'] = ParamUtils::getFromRequest("password"); // wez z formularza wyslanego haslo
    }

    public function validate()
    {
        $v = new Validator();    // tworzymy walidator
        $v->validate($this->login_user['login'], [ // sprawdzanie loginu (walidacja)
            'trim' => true,     // usuwa biale znaki np. spacje na poczatku/na koncu
            'required' => true, // jest wymagane
            'min_length' => 3,  // minimalna dlugosc
            'max_length' => 32, // maksymalna dlugosc
            'required_message' => 'Login jest wymagany', // co ma sie pokazac uzytkownikowi jak nie bedzie nic podane
            'validator_message' => "Login powinien składać się z 3-32 znaków" // co ma sie pokazac uzytkownikowi jak bedzie wpisane, ale niepoprawnie
        ]);

        $v->validate($this->login_user['password'], [ // sprawdzanie hasla
            'trim' => false, // nie przycinaj bialych znakow (np. spacji), bo ktos moze miec po prostu haslo ze spacja na poczatku/na koncu
            'required' => true,
            'min_length' => 4,
            'max_length' => 32,
            'required_message' => 'Hasło jest wymagane',
            'validator_message' => "Hasło powinno składać się z 4-32 znaków"
        ]);

        return !App::getMessages()->isError(); // jesli walidator zwrocil jakis blad - zwracamy falsz, jesli nie - prawde (ze dobrze zwalidowalo)
    }

    private function login_user()
    {
        try {
            $this->user = App::getDB()->get("user", [ // z tabeli user wyciagamy id, name, surname, login, password
                'user.id',
                'user.name',
                'user.surname',
                'user.login',
                'user.password',
                'user.role',
            ], [ // warunek jaki musi byc spelniony (WHERE login = login_podany_przez_uzytkownika AND password = haslo_podane_przez_uzytkownika)
                'login' => $this->login_user['login'],
                'password' => $this->login_user['password']
            ]);

            if (empty($this->user)) { // jesli nie znalezlismy uzytkownika z takim loginem i haslem
                Utils::addErrorMessage("Nieprawidłowy login lub hasło"); // wyswietl taki komunikat uzytkownikowi
            } else {
                SessionUtils::store('user', $this->user); // a jak zostal znaleizony, to zapiszmy go w sesji
            }
        } catch (\PDOException $e) { // jesli wystapi jakis blad, powiedzmy o tym uzytkownikowi
            Utils::addErrorMessage("Błąd połączenia z bazą danych <br />");
        }
    }

    public function action_login()
    {
        if (isset($_POST['login']) && $this->validate()) {
            $this->login_user();
            header("Location: " . App::getConf()->app_url . "/main");
        }

        App::getSmarty()->assign("login_url", App::getConf()->app_url . "/login");
        App::getSmarty()->display("login.tpl");
    }

    public function action_logout()
    {
        SessionUtils::remove('user');
        header("Location: " . App::getConf()->app_url . "/home");
    }

}

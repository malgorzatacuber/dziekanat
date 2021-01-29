<?php

namespace app\controllers;

use core\App;
use core\SessionUtils;
use core\Message;
use core\Utils;
use core\ParamUtils;
use core\Validator;

class UsersController
{
    private $user;  // uzytkownik z sesji
    private $new_user_data = []; // dane uzytkownika z logowania (z forumlarza na stronie)

    function __construct()
    {
        $this->user = SessionUtils::load('user', true); // wez uzytkownika z sesji

        $this->new_user_data['name'] = ParamUtils::getFromRequest("name");
        $this->new_user_data['surname'] = ParamUtils::getFromRequest("surname");
        $this->new_user_data['login'] = ParamUtils::getFromRequest("login");
        $this->new_user_data['password'] = ParamUtils::getFromRequest("password");
        $this->new_user_data['role'] = ParamUtils::getFromRequest("role");
    }

    public function validate()
    {
        $v = new Validator();    // tworzymy walidator

        $v->validate($this->new_user_data['name'], [
            'trim' => true,
            'required' => true,
            'min_length' => 2,
            'max_length' => 32,
            'required_message' => 'Imię jest wymagane',
            'validator_message' => "Imię powinno składać się z 2-32 znaków"
        ]);

        $v->validate($this->new_user_data['surname'], [
            'trim' => true,
            'required' => true,
            'min_length' => 2,
            'max_length' => 32,
            'required_message' => 'Nazwisko jest wymagane',
            'validator_message' => "Nazwisko powininno składać się z 2-32 znaków"
        ]);

        $v->validate($this->new_user_data['login'], [
            'trim' => true,
            'required' => true,
            'min_length' => 3,
            'max_length' => 32,
            'required_message' => 'Login jest wymagany',
            'validator_message' => "Login powinien składać się z 3-32 znaków"
        ]);

        $v->validate($this->new_user_data['role'], [
            'trim' => true,
            'required' => true,
            'min_length' => 3,
            'max_length' => 32,
            'required_message' => 'Rola jest wymagana',
            'validator_message' => "Rola powinna składać się z 3-32 znaków"
        ]);

        $v->validate($this->new_user_data['password'], [
            'trim' => false,
            'required' => true,
            'min_length' => 4,
            'max_length' => 32,
            'required_message' => 'Hasło jest wymagane',
            'validator_message' => "Hasło powinno składać się z 4-32 znaków"
        ]);

        return !App::getMessages()->isError(); // jesli walidator zwrocil jakis blad - zwracamy falsz, jesli nie - prawde (ze dobrze zwalidowalo)
    }

    private function get_all_users() {
        try {
            return App::getDB()->select('user', [
                'user.id',
                'user.name',
                'user.surname',
                'user.login',
                'user.role',
            ]);
        } catch (\PDOException $e) { // jesli wystapi jakis blad, powiedzmy o tym uzytkownikowi
            Utils::addErrorMessage("Błąd połączenia z bazą danych <br />");
        }
        return null; // jesli bedzie blad - zwroc null
    }

    private function register_user()
    {
        try {
            App::getDB()->insert('user', $this->new_user_data);
        } catch (\PDOException $e) { // jesli wystapi jakis blad, powiedzmy o tym uzytkownikowi
            Utils::addErrorMessage("Błąd połączenia z bazą danych <br />");
        }
    }

    public function action_users()
    {
        // Jesli uzytkownik nie jest zalogowany LUB jesli rola uzytkownika to nie ADMIN poinformuj go o braku uprawnien do stworzenia (rejestracji) uzytkownika
        if ($this->user == null || $this->user['role'] != ADMIN) {
            App::getSmarty()->display("forbidden.tpl");
        }

        // Jesli jest zdefiniowane jakies pole w formularzu rejestracji (np. name jak ponizej) i formularz przeszedl walidacje (patrz: metoda validate) - zarejestruj uzytkownika
        if (isset($_POST['name']) && $this->validate()) {
            $this->register_user();
            Utils::addInfoMessage('Pomyślnie dodano użytkownika');
        }

        // pobierz liste wszystkich zarejestrowanych uzytkownikow
        $users = $this->get_all_users();

        App::getSmarty()->assign("register_url", App::getConf()->app_url . "/users");
        App::getSmarty()->assign("users", $users);

        App::getSmarty()->display("users.tpl");
    }
}

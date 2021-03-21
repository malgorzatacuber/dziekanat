<?php

namespace app\controllers;

use core\App;
use core\SessionUtils;
use core\Message;
use core\Utils;
use core\ParamUtils;
use core\Validator;

class MyMarksController
{
    private $user;  // uzytkownik z sesji

    function __construct()
    {
        $this->user = SessionUtils::load('user', true); // wez uzytkownika z sesji
    }

    private function get_all_marks()
    {
        try {
            return App::getDB()->select('mark', [
                "[>]user" => ["teacher_id" => "id"],
            ], [
                'mark.id',
                'mark.mark',
                'mark.added_at',
                'user.name',
                'user.surname',
            ], [
                'mark.student_id' => $this->user['id'],
            ]);
        } catch (\PDOException $e) { // jesli wystapi jakis blad, powiedzmy o tym uzytkownikowi
            Utils::addErrorMessage("Błąd połączenia z bazą danych <br />");
        }
        return null; // jesli bedzie blad - zwroc null
    }

    public function action_mymarks()
    {
        if ($this->user == null || $this->user['role'] != UCZEN) {
            App::getSmarty()->display("forbidden.tpl");
        }

        $marks = $this->get_all_marks();

        App::getSmarty()->assign("marks", $marks);
        App::getSmarty()->display("my_marks.tpl");
    }
}

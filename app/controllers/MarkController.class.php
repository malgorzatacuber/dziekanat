<?php

namespace app\controllers;

use core\App;
use core\SessionUtils;
use core\Message;
use core\Utils;
use core\ParamUtils;
use core\Validator;

class MarkController
{
    private $user;  // uzytkownik z sesji
    private $new_mark_data = []; // dane nwej oceny (z forumlarza na stronie)

    function __construct()
    {
        $this->user = SessionUtils::load('user', true); // wez uzytkownika z sesji

        $this->new_mark_data['mark'] = ParamUtils::getFromRequest("mark");
        $this->new_mark_data['teacher_id'] = $this->user['id'];
        $this->new_mark_data['student_id'] = ParamUtils::getFromRequest("student_id");
    }

    public function validate()
    {
        $v = new Validator();    // tworzymy walidator

        $v->validate($this->new_mark_data['mark'], [
            'required' => true,
            'numeric' => true,
            'min' => 2,
            'max' => 5,
            'required_message' => 'Ocena jest wymagana',
            'validator_message' => "Ocena powinna byc wartoscia 2-5",
        ]);

        $v->validate($this->new_mark_data['student_id'], [
            'trim' => true,
            'required' => true,
            'required_message' => 'ID studenta jest wymagane',
        ]);

        return !App::getMessages()->isError(); // jesli walidator zwrocil jakis blad - zwracamy falsz, jesli nie - prawde (ze dobrze zwalidowalo)
    }

    private function get_all_marks()
    {
        try {
            return App::getDB()->select('mark', [
                "[>]user" => ["student_id" => "id"],
            ], [
                'mark.id',
                'mark.mark',
                'mark.added_at',
                'user.name',
                'user.surname',
            ]);
        } catch (\PDOException $e) { // jesli wystapi jakis blad, powiedzmy o tym uzytkownikowi
            Utils::addErrorMessage("Błąd połączenia z bazą danych <br />");
        }
        return null; // jesli bedzie blad - zwroc null
    }

    private function get_all_students()
    {
        try {
            return App::getDB()->select('user', [
                'user.id',
                'user.name',
                'user.surname',
            ], [
                'user.role' => UCZEN
            ]);
        } catch (\PDOException $e) { // jesli wystapi jakis blad, powiedzmy o tym uzytkownikowi
            Utils::addErrorMessage("Błąd połączenia z bazą danych <br />");
        }
        return null; // jesli bedzie blad - zwroc null
    }

    private function save_mark()
    {
        try {
            App::getDB()->insert('mark', $this->new_mark_data);
        } catch (\PDOException $e) { // jesli wystapi jakis blad, powiedzmy o tym uzytkownikowi
            Utils::addErrorMessage("Błąd połączenia z bazą danych <br />");
        }
    }

    public function action_marks()
    {
        if ($this->user == null || $this->user['role'] != PROWADZACY) {
            App::getSmarty()->display("forbidden.tpl");
        }

        if (isset($_POST['mark']) && $this->validate()) {
            $this->save_mark();
            Utils::addInfoMessage('Pomyślnie dodano ocenę');
        }

        $marks = $this->get_all_marks();
        $students = $this->get_all_students();

        App::getSmarty()->assign("marks_url", App::getConf()->app_url . "/marks");
        App::getSmarty()->assign("marks", $marks);
        App::getSmarty()->assign("students", $students);
        App::getSmarty()->display("marks.tpl");
    }
}

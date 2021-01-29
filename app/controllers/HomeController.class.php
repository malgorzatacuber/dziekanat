<?php

namespace app\controllers;

use core\App;
use core\SessionUtils;
use core\Message;
use core\Utils;

class HomeController {
    private $user;

    function __construct() {
        $this->user = SessionUtils::load('user', true);
    }
    
    public function action_home() {
        App::getSmarty()->assign("user", $this->user);
        App::getSmarty()->assign("login_url", App::getConf()->app_url."/login");

        App::getSmarty()->display("home.tpl");
    }
    
}

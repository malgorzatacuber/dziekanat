<?php

use core\App;
use core\Utils;
require_once 'consts.php';

App::getRouter()->setDefaultRoute('home'); #default action

Utils::addRoute('home', 'HomeController');
Utils::addRoute('login', 'LoginController');
Utils::addRoute('logout', 'LoginController');
Utils::addRoute('main', 'MainController');
Utils::addRoute('marks', 'MarkController');
Utils::addRoute('users', 'UsersController');
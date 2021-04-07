<?php

use core\App;
use core\Utils;
require_once 'consts.php';

App::getRouter()->setDefaultRoute('home'); #default action
//App::getRouter()->setLoginRoute('login'); #action to forward if no permissions

Utils::addRoute('home', 'HomeController');
Utils::addRoute('login', 'LoginController');
Utils::addRoute('logout', 'LoginController');
Utils::addRoute('main', 'MainController');
Utils::addRoute('users', 'UsersController');
Utils::addRoute('marks', 'MarkController');
Utils::addRoute('mymarks', 'MyMarksController');
Utils::addRoute('statements', 'StatementsController');
//Utils::addRoute('action_name', 'controller_class_name');
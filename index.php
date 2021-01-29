<?php
require_once 'init.php';
require_once 'consts.php';

use core\App;
header("Location: ". App::getConf()->app_url);
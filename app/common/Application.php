<?php

include "../config/Configuration.php";
include "../controller/Controller.php";

class Application {

  public static function run() {
    Configuration::init();
    Controller::init();
  }
}

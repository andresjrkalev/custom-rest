<?php

include "../config/Configuration.php";
include "../controller/BaseController.php";

class Application {

  public static function run() {
    Configuration::init();
    BaseController::init();
  }
}

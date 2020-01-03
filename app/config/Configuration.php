<?php

class Configuration {

  public static function init() {
    $methods = get_class_methods($this);
    
    foreach ($methods as $method) {
      if ($method != __FUNCTION__) {
        $reflectionMethod = new ReflectionMethod($this, $method);
        $parameters = $reflectionMethod->getParameters();

        if (count($parameters) == 0) {
            $this->$method();
        }
      }
    }
  }
  
  public function setErrorHandler() {
    ini_set(CONFIGURATION_DISPLAY_ERRORS, false);
    error_reporting(E_ALL);
    ini_set(CONFIGURATION_ERROR_LOG, LOCATION_LOGS);
    set_error_handler(array($this, FUNCTION_HANDLE_ERROR));
  }

public function handleError($number, $description, $file, $line) {
  $message = $this->formatter->formatString(PATTERN_LOG, $number, $description, $file, $line);
  error_log($message);
}

public function setUpProperties() {
  $environment = ENVIRONMENT_PRODUCTION;

  if (preg_match(REGEX_LOCALHOST, $_SERVER[HTTP_HOST])) {
    $environment = ENVIRONMENT_DEVELOPMENT;
  }
  $file = $this->formatter->formatString(PATTERN_FILE_INI, $environment);
      $ini = parse_ini_file($file, false, INI_SCANNER_RAW);
      define(CONSTANT_PROPERTIES, $ini);
  }
}

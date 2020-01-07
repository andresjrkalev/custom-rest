<?php

class Configuration {

  public static function init() {
    $methods = get_class_methods($this);
    
    foreach ($methods as $method) {
      if ($method != __FUNCTION__) {
        $reflectionMethod = new ReflectionMethod($this, $method);
        $parameters = $reflectionMethod->getParameters();

        if (count($parameters) == 0) {
          $value = $this->$method();
          
          if (isset($value)) {
            $type = get_class($value);
            $key = lcfirst($type);
            $GLOBALS[$key] = $value;
            extract($GLOBALS);
          }
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
    $message = FormatUtil::formatString(PATTERN_LOG, $number, $description, $file, $line);
    error_log($message);
  }

  public function setUpProperties() {
    $environment = ENVIRONMENT_PRODUCTION;

    if (preg_match(REGEX_LOCALHOST, $_SERVER[HTTP_HOST])) {
      $environment = ENVIRONMENT_DEVELOPMENT;
    }
    $file = FormatUtil::formatString(PATTERN_FILE_INI, $environment);
    $ini = parse_ini_file($file, false, INI_SCANNER_RAW);
    define(CONSTANT_PROPERTIES, $ini);
  }
  
  public function authenticate() {
    $path = $_SERVER[REQUEST_URI];
    $headers = apache_request_headers();
    $headerAuthorization = $headers[HEADER_AUTHORIZATION];
    
    if (!preg_match(REGEX_STARTS_WITH_API_VERSION, $path)) {
      exit(STATUS_CODE_NOT_FOUND);
    } elseif (isset($headerAuthorization)) {
      $token = str_replace(PREFIX_AUTHORIZATION, STRING_EMPTY, $headerAuthorization);
      
      if (TokenUtil::validate($token)) {
        return;
      }
    } elseif ($_POST && preg_match(REGEX_ENDS_WITH_AUTHENTICATE, $path)) {
      $token = TokenUtil::create($_POST);
      exit($token);
    }
    exit(STATUS_CODE_NOT_ALLOWED);
  }
  
  public function dataSource() {
    return new Repository();
  }
}

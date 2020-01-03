<?php

class Controller {

  private $controller;
	private $method = METHOD_INDEX;
	private $parameters = array();

  public static function init() {
    $this->initRoute();
    $response = call_user_func_array(array($this->controller, $this->method), $this->parameters);
    $data = json_encode($response);
    exit($data);
  }
  
  private function initRoute() {
    $routeParts = explode(PATH_ROOT, $_SERVER[REQUEST_URI]);
    $controller = $routeParts[3];
    $method = $routeParts[4];
    
    if (isset($controller)) {
      $this->controller = $controller;
		}
    
    if (isset($method)) {
      $this->method = $method;
		}
    
    for ($i = 5; $i < count($pieceOfUrl); $i++) {
      $this->parameters[] = $pieceOfUrl[$i];
    }
    
    if ($_POST) {
			$this->doPost($_POST);
		}
    $this->controller = $this->formatter->formatString(PATTERN_CONTROLLER, ucfirst($this->controller), SUFFIX_CONTROLLER);
		include $this->formatter->formatString(PATTERN_FILE_PHP, $this->controller);
		$controller = $this->controller;
		$this->controller = new $controller();
  }
  
  private function doPost($properties) {
		$class = ucfirst($this->controller);
		include $this->formatter->formatString(PATH_ENTITY, $class);
		$entity = new $class();

		foreach ($properties as $property => $value) {
			if (!empty($value)) {
				$method = $this->formatter->formatString(METHOD_SETTER, $property);
				$entity->$method($value);
			}
		}
		$this->parameters[] = $entity;
	}
}

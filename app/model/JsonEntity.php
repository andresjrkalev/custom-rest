<?php

class JsonEntity implements JsonSerializable {

  public function jsonSerialize() {
    $reflectionClass = new ReflectionClass($this);
    return $reflectionClass->getProperties();
  }
}

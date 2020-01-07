<?php

class Entity extends JsonEntity {

  private $id;
  private $created;
  private $createdBy;
  private $updated;
  private $updatedBy;
  private $deleted;
  private $deletedBy;
  
  public function __call($name, $arguments) {
    
  }
}

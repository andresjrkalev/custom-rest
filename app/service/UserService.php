<?php

class UserService extends BaseService {

  public function __construct() {
    parent::__construct();
  }

  public function findById($id) {
    return $repository->findById($id);
  }
}

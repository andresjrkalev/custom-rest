<?php

class UserService {

  public function findByUsername($username) {
    $criteria = new Criteria(User::class);
    $criteria->equals(PROPERTY_USERNAME, $username);
    return $repository->findByCriteria($criteria);
  }
}

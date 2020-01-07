<?php

class Repository {

  public function __construct() {
    $dataSource = FormatUtil::formatString(DATA_SOURCE, PROPERTIES[DATABASE_DRIVER], PROPERTIES[DATABASE_HOST], PROPERTIES[DATABASE_NAME]);
    $this->connection = new PDO($dataSource, PROPERTIES[DATABASE_USERNAME], PROPERTIES[DATABASE_PASSWORD]);
  }
  
  private function createStatement($query, $values) {
    $statement = $this->connection->prepare($query);
    $statement->execute($values);
    return $statement;
  }
  
  private function closeConnection() {
    if ($this->closeConnection) {
      $this->connection = null;
    }
  }
  
  public function findByCriteria($criteria) {
    $query = FormatUtil::formatString(QUERY_SELECT_CRITERIA, $criteria->getTable(), $criteria);
    $statement = $this->createStatement($query, $criteria->getValues());
    return $statement->fetchAll(PDO::FETCH_CLASS, $criteria->getModel());
  }
}

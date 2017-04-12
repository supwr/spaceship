<?php

namespace Services;
use PDO;

class User
{

  private $pdo;

  public function __construct()
  {

  }

  public function setPdo($pdo)
  {
    $this->pdo = $pdo;
  }

  public function getUser(int $id)
  {
      $q = $this->pdo->prepare("select id, name, lastname from user where id = :id");
      $q->execute(array("id" => $id));

      $user = $q->fetchAll(PDO::FETCH_ASSOC);

      return $user;
  }

  public function addUser()
  {

  }

}


?>

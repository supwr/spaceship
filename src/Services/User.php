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

  public function addUser(array $user)
  {
    $field = "";
    $value = "";

    extract($user);

    $q = $this->pdo->prepare("insert into user(nome, lastname) values (:name, :lastname)");
    $q->execute(
      array(
        "name" => $name,
        "lastname" => $lastname
      )
    );

  }

}


?>

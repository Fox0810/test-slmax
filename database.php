<?php

/**
* Автор: Каралкина Ольга
*
* Утилита для работы с базой данных
*/


class Database
{
    // указываем параметры подключения к базе данных
    private $host = "localhost";
    private $db_name = "people";
    private $username = "root";
    private $password = "";
    public $conn;

    // получение соединения с базой данных
    public function getConnection()
    {
      $this->conn = null;

      try {
          $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
      } catch(PDOException $exception) {
          echo "Ошибка соединения: " . $exception->getMessage();
         
      }
      return $this->conn;
    }
}
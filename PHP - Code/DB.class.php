<?php

class DB extends PDO
{
  //Ansluter till databasen. 
  public function __construct($dbname = "dash_main")
  {
    try 
    {
      parent::__construct("mysql:host=localhost:6603;dbname=$dbname;charset=utf8","dashhub", "phprest");
    }   
    catch (Exception $e) 
    {
      echo "<pre>" . print_r($e, 1) . "</pre>";
    }
  }
}
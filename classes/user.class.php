<?php
  
  abstract class User {
    private $username, $id, $firstname, $lastname;
   
    public function __construct ($id) {
            $res = DB::query(
               "SELECT username, firstname, lastname
               FROM user
               WHERE id = '$id'" 
            );

            $this->username   = $this->mysqli->real_escape_string($username);
            $this->id         = $this->mysqli->real_escape_string($id);
            $this->firstname  = $this->mysqli->real_escape_string($firstname);
            $this->lastname   = $this->mysqli->real_escape_string($lastname);
    }

    function __get($x) {
      return $this->$x;
    } 

    function __isset($x) {
      return isset($this->$x);
    }
  }

<?php
function db_connect()
{
  $result = new mysqli("localhost", "root", "a123456", "forum");
  $result->set_charset("utf8");
  if(!$result)
  {
    echo "Can not connect to database.";
    return false;
  }
  
  return $result;
}
?>
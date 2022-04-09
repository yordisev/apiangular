<?php 
//  const BASE_URL = "http://localhost/htmlvuejsplantilla/";
 const DB_HOST = "localhost";
 const DB_NAME = "apifunciones";
 const DB_USER = "root";
 const DB_PASSWORD = "";
 const DB_CHARSET = "utf8";

 $mysqli = new mysqli("localhost", "root", "", "apifunciones");
 if ($mysqli->connect_errno) {
     printf("Falló la conexión: %s\n", $mysqli->connect_error);
     exit();
 } else {
     return $mysqli;
 }

?>
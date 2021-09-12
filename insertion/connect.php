<?php
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "noname";


   try{
     $dsn = "mysql:host=".$dbHost.";dbname=".$dbName ;
     $pdo=new PDO($dsn,$dbUser,$dbPassword );
     echo "DB connection reussi";

   }
   catch(PDOException $e){
      echo "DB connectionfailed".$e->getMessage();
   }





?>
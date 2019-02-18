<?php
    require_once 'db/db_settings.php';
    $db = @mysqli_connect($server,$user,$password,$database) or die('We are having some error with the Server.Please try later');
    $passwd = sha1('abc#123');
    $query = "insert into users(email,password,role,name,question,answer,active) values('ndhagarra@gmail.com','$passwd','admin','Nagendra Dhagarra','Favourite Movie','Matrix',1)";
    mysqli_query($db, $query);
    $passwd = sha1('xyz#123');
    $query = "insert into users(email,password,role,name,question,answer,active) values('phpddn@gmail.com','$passwd','member','Akshat Sharma','Favourite Movie','Intersteller',1)";
    mysqli_query($db, $query);
?>

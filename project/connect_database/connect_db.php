<?php
$host = "localhost";
$user ="postgres";
$pass = "postgres";	
$db = "postgres";
$db_connection = pg_connect("host=$host port=5432 dbname=$db user=$user password=$pass") or die ("could not connect to Server\n");      
?>
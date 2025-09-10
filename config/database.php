<?php

    //config connection con supabase
    /*
    $host     = "aws-0-us-east-2.pooler.supabase.com";
    $port     = "6543";
    $dbname   = "postgres";
    $user     = "postgres.gufrflzvgqpetckchnav";
    $password = "unicesmag@";
    */    
    
    $host     = "localhost";
    $port     = "5432";
    $dbname   = "proyecto_iei";
    $user     = "postgres";
    $password = "unicesmag";

    //Create connection 
    $conn = pg_connect("
        host=$host
        port=$port
        dbname=$dbname
        user=$user
        password=$password
    ");

    if(!$conn){
       // die("Connection error: " . pg_last_error());
    }else{
        //echo "Success connection";
    }
    pg_close();


?>
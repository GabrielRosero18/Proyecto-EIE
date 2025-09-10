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

    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    if (!$conn) {
        die("Connection error: " . pg_last_error());
    }

    // Captura de variables del formulario
    $nombre = $_POST['nombre'];
    $edad   = $_POST['edad'];
    $genero = $_POST['genero'];
    $email  = $_POST['email'];
    $idioma_preferido = $_POST['idioma_preferido'];
    $frecuencia_uso = $_POST['frecuencia_uso_facebook'];
    $usuario_facebook = $_POST['usuario_facebook'];

    // Inserción en la tabla usuarios
    $query = "INSERT INTO usuarios 
    (nombre, edad, genero, email, idioma_preferido, frecuencia_uso_facebook, usuario_facebook) 
    VALUES (
    '$nombre', 
    $edad, 
    '$genero', 
    '$email', 
    '$idioma_preferido', 
    '$frecuencia_uso', 
    '$usuario_facebook'
    )";
    $result = pg_query($conn, $query);

    if ($result) {
        echo "Usuario registrado correctamente";
    } else {
        echo "Error al registrar usuario: " . pg_last_error($conn);
    }

    pg_close($conn);
?>
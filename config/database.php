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

// Conectar a la base de datos
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
    die("Error de conexión: " . pg_last_error());
}

// Validar que se recibieron todos los campos obligatorios
if (
    isset($_POST['nombre'], $_POST['edad'], $_POST['genero'], $_POST['email'], 
          $_POST['idioma_preferido'], $_POST['frecuencia_uso_facebook'])
) {
    // Escapar los datos para evitar inyección SQL
    $nombre = pg_escape_string($conn, $_POST['nombre']);
    $edad = is_numeric($_POST['edad']) ? intval($_POST['edad']) : null;
    $genero = pg_escape_string($conn, $_POST['genero']);
    $email = pg_escape_string($conn, $_POST['email']);
    $idioma_preferido = pg_escape_string($conn, $_POST['idioma_preferido']);
    $frecuencia_uso = pg_escape_string($conn, $_POST['frecuencia_uso_facebook']);
    $usuario_facebook = isset($_POST['usuario_facebook']) ? pg_escape_string($conn, $_POST['usuario_facebook']) : null;
    
    // Validación mínima
    if ($edad === null) {
        die("Edad inválida");
    }
    
    // Construir la consulta SQL de inserción
    $query = "INSERT INTO usuarios (
                nombre, edad, genero, email, idioma_preferido, frecuencia_uso_facebook, usuario_facebook
              ) VALUES (
                '$nombre', $edad, '$genero', '$email', '$idioma_preferido', '$frecuencia_uso', ";
    $query .= $usuario_facebook !== null && $usuario_facebook !== ''
        ? "'$usuario_facebook'"
        : "NULL";
    $query .= ")";
    
    // Ejecutar la consulta
    $result = pg_query($conn, $query);
    
    if ($result) {
        echo "Usuario registrado correctamente.";
    } else {
        echo "Error al registrar usuario: " . pg_last_error($conn);
    }
} else {
    echo "Faltan datos obligatorios para el registro.";
}

pg_close($conn);
?>
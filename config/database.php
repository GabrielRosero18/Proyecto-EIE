<?php

    //config connection con supabase
    /*
    $host     = "aws-0-us-east-2.pooler.supabase.com";
    $port     = "6543";
    $dbname   = "postgres";
    $user     = "postgres.gufrflzvgqpetckchnav";
    $password = "unicesmag@";
    */    
    
    var_dump($_POST);
    exit;

    $host     = "localhost";
    $port     = "5432";
    $dbname   = "proyecto_eie";
    $user     = "postgres";
    $password = "unicesmag";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    if (!$conn) {
        die("Error de conexión: " . pg_last_error());
    }

    echo '<pre>'; print_r($_POST); echo '</pre>';

    if (
        isset(
            $_POST['nombre'], $_POST['edad'], $_POST['genero'], $_POST['email'],
            $_POST['idioma_preferido'], $_POST['frecuencia_uso_facebook'],
            $_POST['contraseña'], $_POST['confirmar_contraseña']
        )
    ) {
        $nombre   = pg_escape_string($conn, $_POST['nombre']);
        $edad     = is_numeric($_POST['edad']) ? intval($_POST['edad']) : null;
        $genero   = pg_escape_string($conn, $_POST['genero']);
        $email    = pg_escape_string($conn, $_POST['email']);
        $idioma   = pg_escape_string($conn, $_POST['idioma_preferido']);
        $frecuencia = pg_escape_string($conn, $_POST['frecuencia_uso_facebook']);
        $usuario_fb = isset($_POST['usuario_facebook']) ? pg_escape_string($conn, $_POST['usuario_facebook']) : null;
        $contraseña = $_POST['contraseña'];
        $confirmar  = $_POST['confirmar_contraseña'];

    if ($edad === null) {
        die("Edad inválida");
    }
    if ($contraseña !== $confirmar) {
        die("Las contraseñas no coinciden");
    }
    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    $query = "INSERT INTO usuarios (
        nombre, edad, genero, email, idioma_preferido, frecuencia_uso_facebook, usuario_facebook, contraseña
    ) VALUES (
        '$nombre', $edad, '$genero', '$email', '$idioma', '$frecuencia', ";
        $query .= ($usuario_fb !== null && $usuario_fb !== "") ? "'$usuario_fb'" : "NULL";
        $query .= ", '$contraseña_hash')";

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
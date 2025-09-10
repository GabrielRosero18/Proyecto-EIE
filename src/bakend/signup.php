<?php
include('../../config/database.php');

$nombre = $_POST['nombre'];
$edad = $_POST['edad'];
$genero = $_POST['genero'];
$email = $_POST['email'];
$idioma = $_POST['idioma_preferido'];
$frecuencia_facebook = $_POST['frecuencia_uso_facebook'];
$usuario_facebook = $_POST['usuario_facebook'] ?? null;
$passw = $_POST['contraseña'];
$confirm_passw = $_POST['confirmar_contraseña'];

if ($passw !== $confirm_passw) {
    echo "Las contraseñas no coinciden.";
    exit();
}

$enc_pass = sha1($passw);

$sql_email_exist = "
    SELECT COUNT(email) as total 
    FROM users 
    WHERE email = '$email' 
    LIMIT 1";

$res = pg_query($conn, $sql_email_exist);

if ($res) {
    $row = pg_fetch_assoc($res);
    if ($row['total'] > 0) {
        echo "El email ya está registrado.";
    } else {
        $sql = "INSERT INTO users (firstname, age, gender, email, preferred_language, facebook_frequency, facebook_user, password) 
                VALUES ('$nombre', $edad, '$genero', '$email', '$idioma', '$frecuencia_facebook', ".($usuario_facebook ? "'$usuario_facebook'" : "NULL").", '$enc_pass')";
        
        $res = pg_query($conn, $sql);
        
        if ($res) {
            echo "<script>alert('Usuario creado. Ir a login.');</script>";
            header('Refresh:0; URL=http://localhost/proyecto_eie/src/login.html');
        } else {
            echo "Error al crear usuario.";
        }
    }
}
?>

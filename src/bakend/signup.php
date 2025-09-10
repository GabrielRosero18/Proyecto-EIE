<?php
include('../../config/database.php');

// Verificar que se envió el formulario por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener datos con saneamiento básico
    $nombre = trim($_POST['nombre'] ?? '');
    $edad = intval($_POST['edad'] ?? 0);
    $genero = trim($_POST['genero'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $idioma = trim($_POST['idioma_preferido'] ?? '');
    $frecuencia_facebook = trim($_POST['frecuencia_uso_facebook'] ?? '');
    $usuario_facebook = trim($_POST['usuario_facebook'] ?? null);
    $passw = $_POST['password'] ?? '';
    $confirm_passw = $_POST['confirm_password'] ?? '';

    // Validaciones básicas
    if ($nombre === '' || $edad <= 0 || $genero === '' || $email === '' || $idioma === '' || $frecuencia_facebook === '' || $passw === '' || $confirm_passw === '') {
        echo "Por favor, complete todos los campos obligatorios.";
        exit;
    }

    if ($passw !== $confirm_passw) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Encriptar contraseña (sha1 es poco seguro, mejor usar password_hash en un proyecto real)
    $enc_pass = sha1($passw);

    // Verificar si el email ya existe - consulta preparada
    $query_check = 'SELECT COUNT(*) AS total FROM users WHERE email = $1 LIMIT 1';
    $result_check = pg_prepare($conn, "check_email", $query_check);
    $result_check = pg_execute($conn, "check_email", array($email));

    if ($result_check) {
        $row = pg_fetch_assoc($result_check);
        if ($row['total'] > 0) {
            echo "El email ya está registrado.";
            exit;
        }
    } else {
        echo "Error en la consulta de verificación.";
        exit;
    }

    // Insertar usuario - consulta preparada con parámetros
    $query_insert = 'INSERT INTO users (firstname, age, gender, email, preferred_language, facebook_frequency, facebook_user, password) 
                     VALUES ($1, $2, $3, $4, $5, $6, $7, $8)';
    $result_insert = pg_prepare($conn, "insert_user", $query_insert);

    $fb_user_param = $usuario_facebook !== '' ? $usuario_facebook : null;

    $result_insert = pg_execute($conn, "insert_user", array($nombre, $edad, $genero, $email, $idioma, $frecuencia_facebook, $fb_user_param, $enc_pass));

    if ($result_insert) {
        // Usar redirección HTTP después de enviar encabezados
        header('Location: /login.html');
        exit;
    } else {
        echo "Error al crear el usuario.";
        exit;
    }

} else {
    echo "Método inválido.";
    exit;
}
?>
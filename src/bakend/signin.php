<?php
include('../../config/database.php');
session_start();

// Si ya hay sesión iniciada, redirigir al home
if (isset($_SESSION['user_id'])) {
    header('Location: http://localhost/proyecto_eie/src/index.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y sanitizar valores de formulario
    $email = trim($_POST['e_mail'] ?? '');
    $passw = $_POST['p_sswd'] ?? '';

    if ($email === '' || $passw === '') {
        $message = 'Por favor, complete todos los campos.';
    } else {
        $enc_pass = sha1($passw); // Considera cambiar a password_hash en producción

        // Consulta preparada para evitar inyección SQL
        $query = 'SELECT id, firstname, lastname FROM users WHERE email = $1 AND password = $2 AND status = TRUE LIMIT 1';
        $result = pg_prepare($conn, "login_query", $query);
        $result = pg_execute($conn, "login_query", array($email, $enc_pass));

        if ($result && pg_num_rows($result) == 1) {
            $row = pg_fetch_assoc($result);
            // Guardar datos en sesión
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['lastname'] = $row['lastname'];

            // Redirigir a página principal
            header('Location: http://localhost/proyecto_eie/src/index.php');
            exit();
        } else {
            $message = 'Correo o contraseña incorrectos.';
        }
    }
}

// Incluir HTML de la vista login (login.view.php), donde puedes mostrar $message si hay error
include('login.view.php');
?>

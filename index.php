<?php

session_start();  // Asegúrate de que la sesión se inicia correctamente
include 'includes/header.php';

// Verifica si se está enviando el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar el token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] != $_SESSION['csrf_token']) {
        die("Token CSRF no válido");
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Suponiendo que tienes una clase $auth para manejar el login
    if ($auth->login($email, $password)) {
        $role = $auth->getUserRole();
        if ($role == 'admin') {
            header("Location: views/admin/dashboard.php");
            exit();  // Añadido exit() para evitar que se ejecute código después de la redirección
        } else {
            header("Location: views/user/dashboard.php");
            exit();
        }
    } else {
        echo "Login fallido!";
    }
} else {
    // Generar un nuevo token CSRF cuando se carga la página de login
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Login</span>
                        <form method="POST" >
                            
                            <div class="input-field">
                                <input id="email" type="email" class="validate" name="email" required>
                                <label for="email">Email</label>
                            </div>
                            <div class="input-field">
                                <input id="password" type="password" class="validate" name="password" required>
                                <label for="password">Password</label>
                            </div>
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <button class="btn waves-effect waves-light" type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>

<?php

class Auth {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    private function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); 
    }

    public function login($email, $password) {
        $user = $this->getUserByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['Id_user'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role']; 
            return true;
        }
        return false;
    }

    public function getUserRole() {
        return $_SESSION['role'] ?? null; 
    }

    public function logout() {
        session_unset(); // Elimina todas las variables de sesión
        session_destroy(); // Destruye la sesión
        header("Location: login.php"); // Redirige al login después de cerrar sesión
        exit();
    }


    public function isLoggedIn() {
        return isset($_SESSION['user']);
    }

}
?>
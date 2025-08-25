<?php
session_start();
include 'config.php';

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Redirect if not logged in
function checkAuth() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

// Login function
function login($username, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && $password === $user['password']) { // Plain text comparison
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        return true;
    }
    
    return false;
}
?>
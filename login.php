<?php
$host = 'localhost';
$db   = 'ma_base_de_donnees';
$user = 'mon_utilisateur';
$pass = 'mon_mot_de_passe';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // L'utilisateur est connecté
    session_start();
    $_SESSION['user_id'] = $user['id'];
    header('Location: dashboard.php');
} else {
    // Échec de la connexion
    header('Location: index.php');
}
?>

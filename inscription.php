<?php
session_start();
if (isset($_SESSION['user_id'])) {
    echo 'Vous êtes connecté en tant que ' . $_SESSION['user_id'];
} else {
    echo 'Vous n\'êtes pas connecté';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = '176.31.132.185';
    $db   = 'ohetkg_dashboar_db';
    $user = 'ohetkg_dashboar_db';
    $pass = '3-t2_UfA1s*Q0Iu!';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    $stmt->execute([$username, $password]);

    header('Location: dashboard.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="signup-container">
        <h2>Inscription</h2>
        <form action="inscription.php" method="post">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" value="S'inscrire">
        </form>
    </div>
</body>
</html>

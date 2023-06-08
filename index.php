<?php
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

try {
    $pdo = new PDO($dsn, $user, $pass, $opt);
    $connectionStatus = '<p style="color: green;">Connected to the database successfully!</p>';
} catch (PDOException $e) {
    $connectionStatus = '<p style="color: red;">Failed to connect to the database.</p>';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mon Interface</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <?php echo $connectionStatus; ?>
        <!-- Rest of your login form goes here -->
    </div>
</body>
</html>

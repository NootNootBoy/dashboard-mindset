<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Bienvenue <?php $_SESSION['user_id']?></h2>
        <!-- Rest of your dashboard content goes here -->
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Mon Interface</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" value="Se connecter">
        </form>
    </div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = $_GET['token'];

    $user = "ohetkg_dashboar_db";
    $pass = "3-t2_UfA1s*Q0Iu!";
    $pdo = new PDO('mysql:host=176.31.132.185;dbname=ohetkg_dashboar_db', $user, $pass);
    // Vérifier si le jeton est dans la base de données
    $stmt = $pdo->prepare('SELECT * FROM password_resets WHERE token = ?');
    $stmt->execute([$token]);
    $reset = $stmt->fetch();

    if ($reset) {
        // Le jeton est valide, afficher le formulaire de réinitialisation du mot de passe
        echo '
            <form action="reset_password.php" method="post">
                <input type="hidden" name="token" value="' . $token . '">
                <input type="password" name="password" placeholder="Entrez votre nouveau mot de passe" required>
                <input type="submit" value="Réinitialiser le mot de passe">
            </form>
        ';
    } else {
        // Le jeton n'est pas valide ou a expiré
        echo 'Le lien de réinitialisation du mot de passe n\'est pas valide ou a expiré.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Récupérer l'adresse e-mail à partir du jeton
    $stmt = $pdo->prepare('SELECT * FROM password_resets WHERE token = ?');
    $stmt->execute([$token]);
    $reset = $stmt->fetch();

    if ($reset) {
        $email = $reset['email'];

        // Mettre à jour le mot de passe de l'utilisateur
        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE email = ?');
        $stmt->execute([$password, $email]);

        // Supprimer le jeton de réinitialisation du mot de passe
        $stmt = $pdo->prepare('DELETE FROM password_resets WHERE token = ?');
        $stmt->execute([$token]);

        echo 'Votre mot de passe a été réinitialisé avec succès.';
    } else {
        // Le jeton n'est pas valide ou a expiré
        echo 'Le lien de réinitialisation du mot de passe n\'est pas valide ou a expiré.';
    }
}
?>

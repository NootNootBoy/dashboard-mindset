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
            <div class="container-xxl">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner py-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="app-brand justify-content-center">
                                <a href="index.html" class="app-brand-link gap-2">
                                    <span class="app-brand-logo demo">
                                        <div class="d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <img src="assets/img/favicon/logo--mindset_black.png" class="img-thumbnail" alt="...">
                                        </div>
                                    </span>
                                </a>
                            </div>
                            <h4 class="mb-2">Changer de mot de passe</h4>
                            <form id="formChangePassword" class="mb-3" action="reset_password.php" method="POST">
                            <input type="hidden" name="token" value="' . $token . '">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Nouveau mot de passe</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your new password" />
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your new password" />
                                </div>
                                    </div>
                                    <div id="passwordError" style="display: none; color: red;">Les mots de passe ne correspondent pas.</div>
                                    <button type="submit" class="btn btn-primary d-grid w-100">Changer le mot de passe</button>
                                </form>
                                <div class="text-center">
                                    <a href="index.html" class="d-flex align-items-center justify-content-center">
                                        <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                        Page de connexion
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

<script>
        document.getElementById('formChangePassword').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                event.preventDefault();
                document.getElementById('passwordError').style.display = 'block';
            } else {
                document.getElementById('passwordError').style.display = 'none';
            }
        });
    </script>

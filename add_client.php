<?php
session_start();

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$societe = $_POST['societe'];
$siret = $_POST['siret'];
$email = $_POST['email'];
$temps_engagement = $_POST['temps_engagement'];
$date_signature = $_POST['date_signature'];
$adresse = $_POST['adresse'];
$ville = $_POST['ville'];
$code_postal = $_POST['code_postal'];
$pays = $_POST['pays'];
$commercial_id = $_POST['commercial_id'];

$stmt = $pdo->prepare('INSERT INTO clients (nom, prenom, societe, siret, email, temps_engagement, date_signature, adresse, ville, code_postal, pays, commercial_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
$stmt->execute([$nom, $prenom, $societe, $siret, $email, $temps_engagement, $date_signature, $adresse, $ville, $code_postal, $pays, $commercial_id]);

$client_id = $pdo->lastInsertId();

$options = $_POST['options'];
foreach ($options as $option_id) {
  $stmt = $pdo->prepare('INSERT INTO client_options (client_id, option_id) VALUES (?, ?)');
  $stmt->execute([$client_id, $option_id]);
}

if ($stmt->rowCount() > 0) {
    // L'insertion a réussi
    $_SESSION['success_message'] = 'Le client a été ajouté avec succès.';
} else {
    // L'insertion a échoué
    $_SESSION['error_message'] = 'Une erreur est survenue lors de l\'ajout du client.';
}

header('Location: dashboard.php');
exit;
?>

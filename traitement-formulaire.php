<?php
/**
 * Mon Webmaster à Bordeaux — Traitement du formulaire de contact natif PHP (O2Switch)
 */

// Sécurité : accepter uniquement les requêtes POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.html');
    exit;
}

// Récupération et nettoyage des données soumises
$prenom    = htmlspecialchars(strip_tags(trim($_POST['prenom'] ?? '')), ENT_QUOTES, 'UTF-8');
$nom       = htmlspecialchars(strip_tags(trim($_POST['nom'] ?? '')), ENT_QUOTES, 'UTF-8');
$email     = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$telephone = htmlspecialchars(strip_tags(trim($_POST['telephone'] ?? '')), ENT_QUOTES, 'UTF-8');
$projet    = htmlspecialchars(strip_tags(trim($_POST['projet'] ?? '')), ENT_QUOTES, 'UTF-8');
$message   = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')), ENT_QUOTES, 'UTF-8');
$rgpd      = isset($_POST['rgpd']) ? 'Oui' : 'Non';

// Validation minimale des champs obligatoires
if (empty($prenom) || empty($nom) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message) || $rgpd !== 'Oui') {
    header('Location: contact.html?erreur=1');
    exit;
}

// Configuration de l'email
$destinataire = 'contact@mon-webmaster-bordeaux.fr';
$sujet        = 'Nouveau message depuis le site Bordeaux — ' . $prenom . ' ' . $nom;

// Construction du corps du message
$corps  = "Nouveau message reçu depuis le site Mon Webmaster à Bordeaux :\n\n";
$corps .= "Prénom & Nom : " . $prenom . " " . $nom . "\n";
$corps .= "Email        : " . $email . "\n";
$corps .= "Téléphone    : " . ($telephone !== '' ? $telephone : 'Non renseigné') . "\n";
$corps .= "Type projet  : " . ($projet !== '' ? $projet : 'Non spécifié') . "\n";
$corps .= "Accord RGPD  : " . $rgpd . "\n\n";
$corps .= "Message :\n";
$corps .= "--------------------------------------------------\n";
$corps .= $message . "\n";
$corps .= "--------------------------------------------------\n";

// En-têtes du mail conformes RFC
$entetes  = "From: contact@mon-webmaster-bordeaux.fr\r\n";
$entetes .= "Reply-To: " . $email . "\r\n";
$entetes .= "Content-Type: text/plain; charset=UTF-8\r\n";
$entetes .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// Envoi via la fonction mail() native d'O2Switch
$ok = @mail($destinataire, $sujet, $corps, $entetes);

// Redirection vers contact.html avec statut URL
if ($ok) {
    header('Location: contact.html?merci=1');
} else {
    header('Location: contact.html?erreur=1');
}
exit;
?>

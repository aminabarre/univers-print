<?php
session_start();

// Supprimer toutes les variables de session
$_SESSION = [];

// Détruire la session
session_unset();
session_destroy();

// Rediriger avec un petit message
session_start();
$_SESSION['logout_message'] = "Vous avez été déconnecté avec succès.";

header("Location: login.php");
exit;
?>

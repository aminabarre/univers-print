<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Univers Print</title>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/univers_print/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container">
    <a class="navbar-brand" href="/univers_print/index.php">Univers Print</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navb">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navb">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="/univers_print/index.php">Accueil</a></li>
        <li class="nav-item"><a class="nav-link" href="/univers_print/products.php">Produits</a></li>
        <li class="nav-item"><a class="nav-link" href="/univers_print/devis.php">Demande de devis</a></li>
        <li class="nav-item"><a class="nav-link" href="/univers_print/cart.php">Commandes</a></li>
        <?php if(!isset($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="/univers_print/register.php">Inscription</a></li>
          <li class="nav-item"><a class="nav-link" href="/univers_print/login.php">Connexion</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="#">Bonjour, <?= htmlspecialchars($_SESSION['user']['nom']) ?></a></li>
          <?php if($_SESSION['user']['role'] === 'admin'): ?>
            <li class="nav-item"><a class="nav-link" href="/univers_print/admin.php">Admin</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="/univers_print/logout.php">Déconnexion</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">

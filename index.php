<?php
require 'includes/db.php';
require 'includes/header.php';
?>

<div class="container my-5">
  <div class="text-center mb-5">
    <h1 class="fw-bold text-primary">Bienvenue chez <span class="text-dark">Univers Print</span></h1>
    <p class="lead text-muted">Atelier d'impression numérique à Dakar — Rapide • Qualité • Service client</p>
    <hr class="w-25 mx-auto">
  </div>

  <div class="row align-items-center">
    <div class="col-md-6 mb-4 mb-md-0">
      <h4 class="text-secondary">Nos services</h4>
      <ul class="list-group list-group-flush mb-4">
        <li class="list-group-item">🧢 Textile : t-shirts, casquettes...</li>
        <li class="list-group-item">📄 Supports papiers : flyers, cartes de visite...</li>
        <li class="list-group-item">🎁 Objets personnalisés : sacs, gourdes...</li>
        <li class="list-group-item">📢 Grand format : bâches, panneaux...</li>
      </ul>
      <a class="btn btn-primary me-2" href="products.php">Voir les produits</a>
      <a class="btn btn-outline-success" href="devis.php">Demander un devis</a>
    </div>

    <div class="col-md-6 text-center">
      <img src="assets/images/logo.jpg" alt="Exemples" class="img-fluid rounded shadow-lg" style="max-height: 350px; object-fit: cover;">
    </div>
  </div>
</div>

<style>
  body {
    background-color: #f8f9fa;
  }
  .list-group-item {
    border: none;
    font-size: 1.05rem;
  }
</style>

<?php require 'includes/footer.php'; ?>

<?php
require 'includes/db.php';
require 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM products ORDER BY date_ajout DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
  <h2 class="text-center text-primary mb-4">Nos Produits</h2>
  <div class="row">
    <?php foreach($products as $p): ?>
      <div class="col-md-4 col-lg-3 mb-4">
        <div class="card h-100 shadow-sm border-0">

          <?php if(!empty($p['image'])): ?>
            <!-- ✅ Affiche l'image stockée en BLOB -->
            <img src="data:image/jpg;base64,<?= base64_encode($p['image']) ?>" 
                 class="card-img-top" 
                 style="height: 200px; object-fit: cover;" 
                 alt="<?= htmlspecialchars($p['nom']) ?>">
          <?php else: ?>
            <!-- ✅ Image par défaut si pas de photo -->
            <img src="assets/images/default-product.png" 
                 class="card-img-top" 
                 style="height: 200px; object-fit: cover;" 
                 alt="Image par défaut">
          <?php endif; ?>

          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($p['nom']) ?></h5>
            <p class="card-text text-muted">
              <?= nl2br(htmlspecialchars(substr($p['description'], 0, 80))) ?>...
            </p>
            <p class="mt-auto fw-bold text-success">
              <?= number_format($p['prix'], 0, ',', ' ') ?> XOF
            </p>
            <a href="product.php?id=<?= $p['id'] ?>" class="btn btn-outline-primary btn-sm">
              Voir le produit
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php require 'includes/footer.php'; ?>

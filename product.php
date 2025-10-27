<?php
require 'includes/db.php';
require 'includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "<div class='container my-5'><div class='alert alert-danger text-center'>Produit introuvable.</div></div>";
    require 'includes/footer.php';
    exit;
}

// ✅ Traitement commande simple
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user'])) {
        echo "<div class='container my-4'><div class='alert alert-warning text-center'>Veuillez vous connecter pour commander.</div></div>";
    } else {
        $quantite = max(1, (int)$_POST['quantite']);
        $user_id = $_SESSION['user']['id'];
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, product_id, quantite) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $product['id'], $quantite]);
        echo "<div class='container my-4'><div class='alert alert-success text-center'>Commande enregistrée avec succès 💚</div></div>";
    }
}
?>

<div class="container my-5">
  <div class="row g-4 align-items-center">
    
    <!-- ✅ Image du produit -->
    <div class="col-md-6 text-center">
      <?php if (!empty($product['image'])): ?>
        <img src="data:image/jpg;base64,<?= base64_encode($product['image']) ?>" 
             class="img-fluid rounded shadow-sm" 
             alt="<?= htmlspecialchars($product['nom']) ?>"
             style="max-height: 400px; object-fit: cover;">
      <?php else: ?>
        <img src="assets/images/default-product.png" 
             class="img-fluid rounded shadow-sm" 
             alt="Image par défaut"
             style="max-height: 400px; object-fit: cover;">
      <?php endif; ?>
    </div>

    <!-- ✅ Détails du produit -->
    <div class="col-md-6">
      <h2 class="text-primary mb-3"><?= htmlspecialchars($product['nom']) ?></h2>
      <p class="text-muted"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
      <h4 class="text-success fw-bold mt-4"><?= number_format($product['prix'], 0, ',', ' ') ?> XOF</h4>

      <!-- ✅ Formulaire de commande -->
      <form method="post" class="mt-4">
        <div class="mb-3">
          <label class="form-label fw-semibold">Quantité</label>
          <input type="number" name="quantite" value="1" class="form-control w-50" min="1">
        </div>
        <button class="btn btn-success px-4" type="submit">
          <i class="bi bi-cart-plus"></i> Commander
        </button>
        <a href="products.php" class="btn btn-outline-secondary ms-2">← Retour aux produits</a>
      </form>
    </div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>

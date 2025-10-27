<?php
require 'includes/db.php';
require 'includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo "<div class='alert alert-danger mt-4 text-center'>🚫 Accès refusé. Seuls les administrateurs peuvent accéder à cette page.</div>";
    require 'includes/footer.php';
    exit;
}

// -------------------
//  TRAITEMENTS CRUD
// -------------------
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ajout produit
    if (isset($_POST['add_product'])) {
        $nom = trim($_POST['nom']);
        $type = trim($_POST['type']);
        $desc = trim($_POST['description']);
        $prix = (float)$_POST['prix'];

        if ($nom && $type && $desc && $prix > 0) {
            $stmt = $pdo->prepare("INSERT INTO products (nom, type, description, prix) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $type, $desc, $prix]);
            $success = "✅ Produit ajouté avec succès.";
        } else {
            $error = "⚠️ Veuillez remplir tous les champs correctement.";
        }
    }

    // Suppression produit
    if (isset($_POST['delete_product'])) {
        $id = (int)$_POST['product_id'];
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $success = "🗑️ Produit supprimé avec succès.";
    }
}

// -------------------
//  RÉCUPÉRATION DES PRODUITS
// -------------------
$stmt = $pdo->query("SELECT * FROM products ORDER BY date_ajout DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
  <h2 class="text-center text-primary mb-4 fw-bold">
    <i class="bi bi-gear-fill"></i> Panneau d’administration
  </h2>

  <!-- Messages -->
  <?php if ($success): ?>
    <div class="alert alert-success text-center"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>
  <?php if ($error): ?>
    <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <!-- Formulaire d’ajout de produit -->
  <div class="card shadow-sm mb-4 border-0">
    <div class="card-body">
      <h5 class="card-title mb-3 text-secondary"><i class="bi bi-plus-circle"></i> Ajouter un produit</h5>
      <form method="post">
        <div class="row g-3 align-items-end">
          <div class="col-md-3">
            <label class="form-label">Nom</label>
            <input name="nom" class="form-control" placeholder="Ex : Flyers A5">
          </div>
          <div class="col-md-2">
            <label class="form-label">Type</label>
            <input name="type" class="form-control" placeholder="Ex : Impression">
          </div>
          <div class="col-md-4">
            <label class="form-label">Description</label>
            <input name="description" class="form-control" placeholder="Ex : Flyers publicitaires couleur">
          </div>
          <div class="col-md-2">
            <label class="form-label">Prix (XOF)</label>
            <input name="prix" type="number" step="0.01" class="form-control" placeholder="Ex : 2000">
          </div>
          <div class="col-md-1 d-grid">
            <button name="add_product" class="btn btn-success">Ajouter</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Liste des produits -->
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h5 class="card-title mb-3 text-secondary"><i class="bi bi-box-seam"></i> Liste des produits</h5>
      <?php if (empty($products)): ?>
        <div class="alert alert-info text-center">Aucun produit ajouté pour le moment.</div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Type</th>
                <th>Description</th>
                <th>Prix (XOF)</th>
                <th>Date d’ajout</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $p): ?>
                <tr>
                  <td><?= $p['id'] ?></td>
                  <td><?= htmlspecialchars($p['nom']) ?></td>
                  <td><?= htmlspecialchars($p['type']) ?></td>
                  <td><?= htmlspecialchars(substr($p['description'], 0, 60)) ?>...</td>
                  <td class="fw-bold text-success"><?= number_format($p['prix'], 0, ',', ' ') ?></td>
                  <td><?= date('d/m/Y', strtotime($p['date_ajout'])) ?></td>
                  <td>
                    <form method="post" class="d-inline">
                      <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                      <button name="delete_product" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce produit ?')">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>

<?php
require 'includes/db.php';
require 'includes/header.php';

// Vérifier la connexion de l'utilisateur
if(!isset($_SESSION['user'])){
    echo "<div class='alert alert-warning text-center mt-4'>
            <strong>⚠️ Veuillez vous connecter</strong> pour voir vos commandes.
          </div>";
    require 'includes/footer.php';
    exit;
}

$user_id = $_SESSION['user']['id'];

// Récupérer les commandes de l'utilisateur
$stmt = $pdo->prepare("
    SELECT o.*, p.nom AS product_name, p.prix 
    FROM orders o 
    JOIN products p ON o.product_id = p.id 
    WHERE o.user_id = ?
    ORDER BY o.date_commande DESC
");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
  <h2 class="mb-4 text-center text-primary fw-bold">🛒 Mes commandes</h2>

  <?php if(empty($orders)): ?>
    <div class="alert alert-info text-center shadow-sm">
      Vous n'avez pas encore de commandes.
      <br><a href="index.php" class="btn btn-sm btn-outline-primary mt-2">Voir les produits</a>
    </div>
  <?php else: ?>
    <div class="table-responsive shadow-sm rounded-3">
      <table class="table table-hover align-middle">
        <thead class="table-primary">
          <tr>
            <th>#</th>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix</th>
            <th>Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($orders as $o): ?>
          <tr>
            <td><?= $o['id'] ?></td>
            <td><?= htmlspecialchars($o['product_name']) ?></td>
            <td><?= $o['quantite'] ?></td>
            <td><?= number_format($o['prix'], 0, ',', ' ') ?> FCFA</td>
            <td><?= date('d/m/Y H:i', strtotime($o['date_commande'])) ?></td>
            <td>
              <?php if($o['status'] === 'En attente'): ?>
                <span class="badge bg-warning text-dark"><?= htmlspecialchars($o['status']) ?></span>
              <?php elseif($o['status'] === 'Livré'): ?>
                <span class="badge bg-success"><?= htmlspecialchars($o['status']) ?></span>
              <?php else: ?>
                <span class="badge bg-secondary"><?= htmlspecialchars($o['status']) ?></span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php require 'includes/footer.php'; ?>

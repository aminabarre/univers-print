<?php
require 'includes/db.php';
require 'includes/header.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $details = trim($_POST['details'] ?? '');

    if ($nom === '' || $email === '' || $details === '') {
        $error = "Veuillez remplir tous les champs.";
    } else {
        $user_id = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
        $stmt = $pdo->prepare("INSERT INTO devis (user_id, produit_details) VALUES (?, ?)");
        $stmt->execute([$user_id, $details]);
        $success = "✅ Votre demande de devis a bien été envoyée ! Nous vous contacterons sous peu.";
    }
}
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">

          <h2 class="text-center text-primary mb-4">
            <i class="bi bi-envelope-paper"></i> Demande de devis
          </h2>

          <!-- ✅ Messages de succès / erreur -->
          <?php if(!empty($error)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>

          <?php if($success): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($success) ?></div>
          <?php endif; ?>

          <!-- ✅ Formulaire -->
          <form method="post" class="needs-validation" novalidate>
            <div class="mb-3">
              <label class="form-label fw-semibold">Nom complet</label>
              <input type="text" name="nom" class="form-control rounded-pill" 
                     placeholder="Ex : Amina Barre"
                     value="<?= htmlspecialchars($_POST['nom'] ?? ($_SESSION['user']['nom'] ?? '')) ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Adresse e-mail</label>
              <input type="email" name="email" class="form-control rounded-pill"
                     placeholder="Ex : barreamina56@gmail.com"
                     value="<?= htmlspecialchars($_POST['email'] ?? ($_SESSION['user']['email'] ?? '')) ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Détails du produit / personnalisation</label>
              <textarea name="details" class="form-control rounded-4" rows="5" 
                        placeholder="Décrivez le type d’impression, la quantité, la taille, etc." required><?= htmlspecialchars($_POST['details'] ?? '') ?></textarea>
            </div>

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary rounded-pill py-2">
                <i class="bi bi-send"></i> Envoyer la demande
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>

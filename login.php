<?php
require 'includes/db.php';
require 'includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = "⚠️ Veuillez remplir tous les champs.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            // Connexion réussie
            $_SESSION['user'] = [
                'id' => $user['id'],
                'nom' => $user['nom'],
                'email' => $user['email'],
                'role' => $user['role']
            ];

            // Redirection selon le rôle
            if ($user['role'] === 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            $error = "❌ Email ou mot de passe incorrect.";
        }
    }
}
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
          <h2 class="text-center text-primary fw-bold mb-4">🔐 Connexion</h2>

          <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>
<?php if (!empty($_SESSION['logout_message'])): ?>
  <div class="alert alert-info text-center">
    <?= htmlspecialchars($_SESSION['logout_message']); ?>
  </div>
  <?php unset($_SESSION['logout_message']); ?>
<?php endif; ?>

          <form method="post" novalidate>
            <div class="mb-3">
              <label class="form-label">Adresse email</label>
              <input type="email" name="email" class="form-control" 
                     placeholder="exemple@mail.com"
                     value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Mot de passe</label>
              <input type="password" name="password" class="form-control" 
                     placeholder="••••••••" required>
            </div>

            <button class="btn btn-primary w-100 mt-3" type="submit">
              Se connecter
            </button>

            <p class="text-center mt-3">
              Pas encore de compte ? 
              <a href="register.php" class="text-decoration-none text-primary fw-semibold">S’inscrire</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
